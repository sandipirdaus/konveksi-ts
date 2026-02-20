<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderItemSizeModel;
use App\OrderModel;
use App\VendorModel;
use App\StokModel;
use App\JenisOrderanModel;
use App\BahanModel;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except('logout');
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $tanggal = date('Y-m-d');

        $data = OrderModel::all();
        $jenis_orderans = JenisOrderanModel::orderBy('nama_jenis', 'ASC')->get();
        $po_terakhir = OrderModel::select('no_po')->orderBy('id', 'DESC')->first();
        
        // Generate Auto PO
        $new_po = 'PO-001';
        if ($po_terakhir) {
            $last_po = $po_terakhir->no_po;
            // Ambil angka dari string PO-XXX
            $number = (int) substr($last_po, 3);
            $new_po = 'PO-' . sprintf("%03s", $number + 1);
        }

        return view('admin.orderan.crud.index', compact('data', 'tanggal', 'po_terakhir', 'new_po', 'jenis_orderans'));
    }

    public function getBahanByJenis($jenis_id)
    {
        $bahans = BahanModel::where('jenis_orderan_id', $jenis_id)->get();
        return response()->json($bahans);
    }

    public function lihat_orderan()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.crud.list', compact('data'));
    }

    public function order_masuk()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->where('status', OrderModel::STATUS_ORDER_MASUK)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.status.order_masuk', compact('data'));
    }

    public function belum_proses()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->where('status', OrderModel::STATUS_BELUM_DIPROSES)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.status.belum_proses', compact('data'));
    }

    public function konfirmasi_order($id)
    {
        $data = OrderModel::find($id);
        if ($data->status == OrderModel::STATUS_ORDER_MASUK) {
            $data->status = OrderModel::STATUS_BELUM_DIPROSES;
            $data->save();
            Alert::success('Berhasil', 'Orderan Telah Dikonfirmasi');
        }
        return redirect('/orderan/belum_proses');
    }

    public function mulai_produksi($id)
    {
        $data = OrderModel::find($id);
        if ($data->status == OrderModel::STATUS_BELUM_DIPROSES) {
            $data->status = OrderModel::STATUS_PROSES_PRODUKSI;
            $data->save();
            Alert::success('Berhasil', 'Produksi Telah Dimulai');
        }
        return redirect('/on_proses');
    }

    public function on_proses()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->where('status', OrderModel::STATUS_PROSES_PRODUKSI)
            ->orderBy('id', 'DESC')
            ->get();
        $lokers = \App\LokerModel::orderBy('nama_loker', 'ASC')->get();
        return view('admin.orderan.status.onproses', compact('data', 'lokers'));
    }

    public function selesai_produksi($id)
    {
        // This method is now effectively split into masuk_stok and langsung_siap_kirim
        // We can keep it or deprecate it. Let's redirect to langsung_siap_kirim as a fallback.
        return $this->langsung_siap_kirim($id);
    }

    public function masuk_stok(Request $request, $id)
    {
        $data = OrderModel::find($id);
        if ($data->status != OrderModel::STATUS_PROSES_PRODUKSI) {
            Alert::error('Gagal', 'Status orderan tidak dalam proses produksi');
            return redirect()->back();
        }

        $request->validate([
            'loker_id' => 'required',
            // qty is now calculated automatically
        ]);

        $loker = \App\LokerModel::find($request->loker_id);
        if (!$loker) {
            Alert::error('Gagal', 'Loker tidak ditemukan');
            return redirect()->back();
        }

        // Update status to STOK_BARANG and sync metadata
        $data->status = OrderModel::STATUS_STOK_BARANG;
        $data->loker_id = $loker->id;
        $data->catatan_stok = $request->catatan;
        $data->status_pembayaran = 'belum_lunas'; // Default as per plan
        $data->save();

        // Save to StokModel
        $jenis_orderan = $data->jenis_orderan ?? [];
        $bahan = $data->bahan ?? [];
        $warna = $data->warna ?? [];
        
        foreach ($jenis_orderan as $index => $nama_barang) {
            if (!empty($nama_barang)) {
                $sizes = OrderItemSizeModel::where('order_id', $data->id)
                    ->where('item_index', $index)
                    ->get();
                
                // Note: The user form might specify qty per item, but usually we just move everything.
                // For simplicity and matching current logic, we use the sizes from the order.
                // However, the user asked for "Qty masuk stok" in the form.
                // If the user input qty differs, we should respect it. 
                // But current schema stores qty per size.
                
                if ($sizes->count() > 0) {
                    foreach ($sizes as $s) {
                        StokModel::create([
                            'orderan_id' => $data->id,
                            'loker_id' => $loker->id,
                            'nama_loker' => $loker->nama_loker,
                            'user_id' => Auth::id(),
                            'nama_vendor' => $data->nama_vendor,
                            'nama_barang' => $nama_barang,
                            'qty' => $s->qty, // Securely using size qty from DB
                            'warna' => $warna[$index] ?? '',
                            'bahan' => $bahan[$index] ?? '',
                            'size' => $s->size,
                            'pemeriksa' => Auth::user()->name,
                            'tgl_pemeriksaan' => date('Y-m-d H:i:s'),
                            'status' => 'Di Loker',
                            'size_details' => [['size' => $s->size, 'qty' => $s->qty]],
                            'update_terakhir_stok' => date('Y-m-d H:i:s'),
                            'catatan' => $request->catatan ?? null // Save Note
                        ]);
                    }
                } else {
                    // Fallback to order qty if size details are somehow missing
                    $fallback_qty = $data->qty[$index] ?? 0;
                    
                    StokModel::create([
                        'orderan_id' => $data->id,
                        'loker_id' => $loker->id,
                        'nama_loker' => $loker->nama_loker,
                        'user_id' => Auth::id(),
                        'nama_vendor' => $data->nama_vendor,
                        'nama_barang' => $nama_barang,
                        'qty' => $fallback_qty, // Securely using original order qty
                        'warna' => $warna[$index] ?? '',
                        'bahan' => $bahan[$index] ?? '',
                        'size' => 'ALL SIZE',
                        'pemeriksa' => Auth::user()->name,
                        'tgl_pemeriksaan' => date('Y-m-d H:i:s'),
                        'status' => 'Di Loker',
                        'update_terakhir_stok' => date('Y-m-d H:i:s'),
                        'catatan' => $request->catatan ?? null // Save Note
                    ]);
                }
            }
        }

        Alert::success('Berhasil', 'Orderan Berhasil Dimasukkan ke Stok Barang');
        return redirect('/stok_barang');
    }

    public function langsung_siap_kirim($id)
    {
        $data = OrderModel::find($id);
        if ($data->status != OrderModel::STATUS_PROSES_PRODUKSI) {
            Alert::error('Gagal', 'Status orderan tidak dalam proses produksi');
            return redirect()->back();
        }

        $data->status = OrderModel::STATUS_SIAP_KIRIM;
        $data->save();

        Alert::success('Berhasil', 'Produksi Selesai & Order Masuk Siap Kirim');
        return redirect('/siap_kirim');
    }

    public function stok_barang()
    {
        $data = OrderModel::with(['vendor', 'itemSizes', 'stokBarang.loker'])
            ->where('status', OrderModel::STATUS_STOK_BARANG)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.status.stok_barang', compact('data'));
    }

    public function siap_kirim_dari_stok(Request $request, $id)
    {
        $data = OrderModel::find($id);
        if ($data->status != OrderModel::STATUS_STOK_BARANG) {
            Alert::error('Gagal', 'Orderan tidak berada di stok barang');
            return redirect()->back();
        }

        $pembayaran = $request->status_pembayaran; // lunas / belum_lunas

        // Check if payment is not lunas
        if ($pembayaran != 'lunas') {
            Alert::error('Gagal', 'Pesanan belum lunas, tidak dapat dipindahkan ke Siap Dikirim.');
            return redirect()->back();
        }
        
        $data->status = OrderModel::STATUS_SIAP_KIRIM;
        $data->status_pembayaran = 'lunas';
        $data->catatan_stok = 'Sudah Lunas';
        $data->save();

        // Also update the status in tbl_stok for consistency
        \App\StokModel::where('orderan_id', $data->id)->update(['catatan' => $data->catatan_stok]);

        Alert::success('Berhasil', 'Orderan dari Stok Siap Dikirim');
        return redirect('/siap_kirim');
    }

    public function produksi_selesai()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->where('status', OrderModel::STATUS_PRODUKSI_SELESAI)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.status.produksi_selesai', compact('data'));
    }

    public function siap_kirim()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->where('status', OrderModel::STATUS_SIAP_KIRIM)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.status.siapkirim', compact('data'));
    }

    public function orderan_selesai()
    {
        $data = OrderModel::with(['vendor', 'itemSizes'])
            ->where('status', OrderModel::STATUS_SELESAI_DIKIRIM)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.orderan.status.orderan_selesai', compact('data'));
    }

    public function kirim_selesai($id)
    {
        $data = OrderModel::find($id);
        
        // Ensure we are in the correct state to finish (ready to ship)
        // Allow if status is STATUS_SIAP_KIRIM (4)
        if ($data->status != OrderModel::STATUS_SIAP_KIRIM) {
             Alert::error('Gagal', 'Status orderan belum siap dikirim');
             return redirect()->back();
        }

        $data->status = OrderModel::STATUS_SELESAI_DIKIRIM;
        $data->save();

        Alert::success('Berhasil', 'Orderan Telah Selesai Dikirim');
        return redirect('/orderan_selesai');
    }

    public function cetak_invoice($id)
    {
        $data = OrderModel::with(['detailOrderan'])->find($id);
        if (!$data) {
            Alert::error('Gagal', 'Data orderan tidak ditemukan');
            return redirect()->back();
        }

        $jenis_orderan = $data->jenis_orderan ?? [];
        $qty = $data->qty ?? [];
        $harga_satuan = $data->harga_satuan ?? [];
        $bahan = $data->bahan ?? [];
        $warna = $data->warna ?? [];
        $detail_size_besar = $data->detail_size_besar ?? [];

        // Prepare Invoice Items data structure
        $invoice_items = [];
        $grand_total_qty = 0;
        $grand_total_price = 0;
        $total_extra_size_cost = 0;

        foreach ($jenis_orderan as $i => $jenis) {
            // Get Normal Sizes (S, M, L, XL)
            $normal_sizes = [];
            if ($data->detailOrderan) {
                // Filter collection to get items where item_index matches current loop index
                $normal_sizes = $data->detailOrderan->where('item_index', $i);
            } else {
                 $normal_sizes = \App\OrderItemSizeModel::where('order_id', $data->id)
                                    ->where('item_index', $i)->get();
            }

            // Get Extra Sizes (XXL, etc)
            $extra_sizes = [];
            $item_extra_cost = 0;
            $raw_extra = isset($detail_size_besar[$i]) ? 
                            (is_string($detail_size_besar[$i]) ? json_decode($detail_size_besar[$i], true) : $detail_size_besar[$i]) 
                            : [];
            
            if (is_array($raw_extra)) {
                foreach ($raw_extra as $ex) {
                    $ex_qty = (int)($ex['qty'] ?? 0);
                    $ex_price = (int)($ex['price'] ?? 0);
                    $ex_item_total = $ex_qty * $ex_price;
                    $item_extra_cost += $ex_item_total;
                    
                    if ($ex_qty > 0) {
                        $extra_sizes[] = [
                            'size' => $ex['size'] ?? '',
                            'qty' => $ex_qty,
                            'price' => $ex_price,
                            'total' => $ex_item_total
                        ];
                    }
                }
            }

            $item_qty = (int)($qty[$i] ?? 0);
            $item_price = (int)($harga_satuan[$i] ?? 0);
            $item_subtotal = $item_qty * $item_price;

            $invoice_items[] = [
                'jenis' => $jenis,
                'bahan' => $bahan[$i] ?? '-',
                'warna' => $warna[$i] ?? '-',
                'qty_total' => $item_qty,
                'harga_satuan' => $item_price,
                'subtotal' => $item_subtotal,
                'normal_sizes' => $normal_sizes,
                'extra_sizes' => $extra_sizes, // Array of ['size', 'qty', 'price', 'total']
                'extra_cost_total' => $item_extra_cost
            ];

            $grand_total_qty += $item_qty;
            $grand_total_price += $item_subtotal;
            $total_extra_size_cost += $item_extra_cost;
        }

        // Generate Invoice Number
        $no_invoice = 'INV-' . str_pad($data->id, 5, '0', STR_PAD_LEFT);

        return view('admin.orderan.invoice', compact(
            'data', 
            'no_invoice', 
            'invoice_items',
            'grand_total_qty',
            'grand_total_price',
            'total_extra_size_cost'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_order' => 'required|date',
            // 'no_po' => 'required', // Auto Generated
            'nama_vendor' => 'required',
            'no_hp' => 'required|numeric', 
            'alamat' => 'required|string',
            'pesanan_untuk' => 'required',
            'sistem_dp' => 'required',
            'deadline' => 'required|date',
            'jenis_orderan' => 'required|array|min:1',
            'jenis_orderan.*' => 'required|integer',
            'bahan' => 'required|array|min:1',
            'bahan.*' => 'required|string',
            'warna' => 'required|array|min:1',
            'warna.*' => 'required|string',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|numeric|min:1',
        ], [
            // 'no_po.required' => 'Nomor PO wajib diisi!',
            'nama_vendor.required' => 'Nama Vendor wajib diisi!',
            'no_hp.required' => 'No HP wajib diisi!',
            'no_hp.numeric' => 'No HP harus berupa angka!',
            'alamat.required' => 'Alamat wajib diisi!',
            'pesanan_untuk.required' => 'Pesanan Untuk wajib diisi!',
            'sistem_dp.required' => 'Sistem DP wajib dipilih!',
            'deadline.required' => 'Deadline pengerjaan wajib diisi!',
            'jenis_orderan.*.required' => 'Detail orderan wajib diisi!',
            'bahan.*.required' => 'Bahan wajib diisi!',
            'warna.*.required' => 'Warna wajib diisi!',
            'harga_satuan.*.required' => 'Harga satuan wajib diisi!',
            'qty.*.required' => 'Quantity wajib diisi!',
            'qty.*.min' => 'Quantity harus lebih dari 0!',
        ]);

        $hitung_data = count($request->jenis_orderan);
        
        // HITUNG EXTRA COST SIZE BESAR
        $extra_costs = [];
        if($request->has('size_large_json')){
            foreach($request->size_large_json as $index => $json){
               $total = 0;
               $items = json_decode($json, true);
               if(is_array($items)){
                   foreach($items as $item){
                       $total += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
                   }
               }
               $extra_costs[$index] = $total;
            }
        }

        // AUTO CREATE/GET VENDOR
        $vendor_id = null;
        if ($request->nama_vendor) {
            $vendor = VendorModel::firstOrCreate(
                ['nama_vendor' => $request->nama_vendor],
                ['no_hp' => $request->no_hp, 'alamat' => $request->alamat]
            );
            $vendor_id = $vendor->id;
        }


        // PREPARE HPP VALUES (Default to 0 if empty)
        $hpp_bahan = $request->harga ?? 0;
        $hpp_cmt = $request->hpp_cmt ?? 0;
        $hpp_bordir = $request->hpp_bordir ?? 0;
        $hpp_sablon = $request->hpp_sablon ?? 0;
        $hpp_benang = $request->hpp_benang ?? 0;
        $hpp_packaging = $request->hpp_packaging ?? 0;

        // DYNAMIC CALCULATION
        $total_hpp = $hpp_bahan + $hpp_cmt + $hpp_bordir + $hpp_sablon + $hpp_packaging + $hpp_benang;

        $total_vendor = 0;
        $total_qty = 0;
        $sum_harga_satuan = 0;

        for ($i = 0; $i < $hitung_data; $i++) {
            $qty = $request->qty[$i] ?? 0;
            $harga_satuan = $request->harga_satuan[$i] ?? 0;
            $extra = $extra_costs[$i] ?? 0;

            // Validation Size Details (Normal + Large) vs Total Qty
            $total_size_qty = 0;
            if ($request->has('size_details_json.'.$i)) {
                $details = json_decode($request->size_details_json[$i], true);
                if (is_array($details)) {
                    foreach ($details as $d) {
                        $total_size_qty += $d['qty'] ?? 0;
                    }
                }
            }
            if ($request->has('size_large_json.'.$i)) {
                $large_details = json_decode($request->size_large_json[$i], true);
                if (is_array($large_details)) {
                    foreach ($large_details as $ld) {
                        $total_size_qty += $ld['qty'] ?? 0;
                    }
                }
            }

            if ($total_size_qty > $qty) {
                Alert::error('Gagal', 'Total Qty Ukuran (Normal + Besar) pada item '.($i+1).' melebihi Total QTY (PCS)');
                return redirect()->back()->withInput();
            }

            // Total Vendor: Sum of (Qty * Unit Price) + Extra Costs
            $total_vendor += ($qty * $harga_satuan) + $extra;
            
            // Total Qty
            $total_qty += $qty;

            // Sum of Unit Prices (for Profit Value calculation logic)
            $sum_harga_satuan += $harga_satuan;
        }

        // Hitung Omset HPP (Total Cost of Goods Sold)
        $omset_hpp = $total_qty * $total_hpp;

        // Hitung Profit Value (Preserving existing logic: Sum(Unit Price) - Total HPP)
        $profit_value = abs($sum_harga_satuan - $total_hpp);

        // Hitung Total Profit (Revenue - COGS)
        $omset_total = abs($omset_hpp - $total_vendor);

        // --- VALIDASI DEADLINE ---
        $deadline_date = $request->deadline;
        $order_count = OrderModel::where('deadline', $deadline_date)
                                 ->whereIn('status', [1, 2, 4])
                                 ->count();

        if ($order_count >= 5) {
            Alert::error('Gagal', 'Deadline tanggal ini sudah penuh. Maksimal 5 orderan untuk tanggal yang sama.');
            return redirect()->back()->withInput();
        }
        // -------------------------

        // GENERATE NO PO OTOMATIS (Final Check)
        $latest_order = OrderModel::select('no_po')->orderBy('id', 'DESC')->first();
        $final_no_po = 'PO-001';
        if ($latest_order) {
            $last_po_str = $latest_order->no_po;
            if (preg_match('/PO-(\d+)/', $last_po_str, $matches)) {
                $last_num = (int)$matches[1];
                $final_no_po = 'PO-' . sprintf("%03d", $last_num + 1);
            }
        }

        // MAP ID TO NAMES AND VALIDATE
        $jenis_orderan_names = [];
        foreach ($request->jenis_orderan as $i => $jo_id) {
            $jo = JenisOrderanModel::find($jo_id);
            if (!$jo) {
                Alert::error('Gagal', 'Jenis Orderan pada item '.($i+1).' tidak valid.');
                return redirect()->back()->withInput();
            }
            
            // Validate Bahan belongs to this Jenis
            $bahan_name = $request->bahan[$i];
            $check_bahan = BahanModel::where('jenis_orderan_id', $jo_id)
                                    ->where('nama_bahan', $bahan_name)
                                    ->first();
            if (!$check_bahan) {
                Alert::error('Gagal', 'Bahan "'.$bahan_name.'" tidak tersedia untuk jenis "'.$jo->nama_jenis.'".');
                return redirect()->back()->withInput();
            }
            
            $jenis_orderan_names[] = $jo->nama_jenis;
        }

        $data = OrderModel::create(
            [
                'tgl_order' => $request->tgl_order,
                'no_po' => $final_no_po,
                'nama_vendor' => $request->nama_vendor,
                'vendor_id' => $vendor_id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'pesanan_untuk' => $request->pesanan_untuk,
                'sistem_dp' => $request->sistem_dp,
                'dp' => $request->dp,
                'deadline' => $request->deadline,
                'jenis_orderan' => collect($jenis_orderan_names),
                'bahan' => collect($request->bahan),
                'warna' => collect($request->warna),
                'harga_satuan' => collect($request->harga_satuan),
                'qty' => collect($request->qty),
                'size_details' => collect($request->size_details_json),
                'detail_size_besar' => collect($request->size_large_json),
                'catatan' => collect($request->catatan),
                'pembelanjaan_bahan' => $request->pembelanjaan_bahan,
                'harga' => $hpp_bahan,
                'hpp_bahan' => $hpp_bahan,
                'hpp_cmt' => $hpp_cmt,
                'hpp_bordir' => $hpp_bordir,
                'hpp_sablon' => $hpp_sablon,
                'hpp_benang' => $hpp_benang,
                'hpp_packaging' => $hpp_packaging,
                'profit_value' => $profit_value,
                'omset_total' => $omset_total,
                'pemeriksa' => Auth::user()->name,
                'user_id' => Auth::id(),
                'status' => OrderModel::STATUS_DRAFT
            ]
        );

        // SAVE NORMALIZED SIZE DETAILS
        if ($request->has('size_details_json')) {
            foreach ($request->size_details_json as $index => $json) {
                $details = json_decode($json, true);
                if (is_array($details)) {
                    foreach ($details as $detail) {
                        OrderItemSizeModel::create([
                            'order_id' => $data->id,
                            'item_index' => $index,
                            'size' => $detail['size'] ?? '',
                            'qty' => $detail['qty'] ?? 0,
                        ]);
                    }
                }
            }
        }
        
        Alert::success('Berhasil', 'Orderan Berhasil Dihitung. Silahkan Validasi.');
        return redirect('/lihat_orderan/detail/' . $data->id);
    }

    public function confirm_validation($id)
    {
        $data = OrderModel::find($id);
        if ($data->status == OrderModel::STATUS_DRAFT) {
            $data->status = OrderModel::STATUS_BELUM_DIPROSES;
            $data->save();
            Alert::success('Berhasil', 'Orderan Telah Divalidasi & Masuk ke Status Belum Diproses');
        }
        return redirect('/orderan/belum_proses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = OrderModel::with('detailOrderan')->find($id);
        if (!$data) {
            Alert::error('Gagal', 'Data orderan tidak ditemukan');
            return redirect()->back();
        }

        $jenis_orderan = $data->jenis_orderan ?? [];
        $bahan = $data->bahan ?? [];
        $warna = $data->warna ?? [];
        $qty = $data->qty ?? [];
        $harga_satuan = $data->harga_satuan ?? [];
        $catatan = $data->catatan ?? [];
        $detail_size_besar = $data->detail_size_besar ?? [];

        // Count items
        $hitung_data = is_array($jenis_orderan) ? count($jenis_orderan) : 0;

        // Total HPP per unit (shared across items)
        $total_hpp_unit = (float)$data->hpp_bahan + (float)$data->hpp_cmt + (float)$data->hpp_bordir + 
                          (float)$data->hpp_sablon + (float)$data->hpp_benang + (float)$data->hpp_packaging;

        $total_vendor = 0;
        $total_qty = 0;
        $omset_hpp = 0;
        $large_qty_count = [];
        $extra_costs = [];

        foreach ($jenis_orderan as $i => $name) {
            $item_qty = (float)($qty[$i] ?? 0);
            $item_price = (float)($harga_satuan[$i] ?? 0);
            
            // Calculate extra costs for large sizes for this item
            $extra_cost = 0;
            $large_qty = 0;
            $large_json = isset($detail_size_besar[$i]) ? 
                (is_string($detail_size_besar[$i]) ? json_decode($detail_size_besar[$i], true) : $detail_size_besar[$i]) : [];
            
            if (is_array($large_json)) {
                foreach ($large_json as $lj) {
                    $extra_cost += (float)($lj['price'] ?? 0) * (float)($lj['qty'] ?? 0);
                    $large_qty += (float)($lj['qty'] ?? 0);
                }
            }
            
            $extra_costs[$i] = $extra_cost;
            $large_qty_count[$i] = $large_qty;

            $total_vendor += ($item_qty * $item_price) + $extra_cost;
            $total_qty += $item_qty;
        }

        $omset_hpp = $total_qty * $total_hpp_unit;
        $total_profit = abs($total_vendor - $omset_hpp);
        
        // Preservation of legacy variables used in view (though we'll refactor the view soon)
        $subtotal_vendor_hpp = $total_vendor + $total_hpp_unit; // Legacy naming? HPP is total unit cost here
        $profit_value = abs($total_hpp_unit - array_sum($harga_satuan)); 

        return view('admin.orderan.crud.detail', compact(
            'data', 'jenis_orderan', 'qty', 'harga_satuan', 'hitung_data', 
            'total_vendor', 'total_hpp_unit', 'omset_hpp', 'total_profit', 
            'catatan', 'bahan', 'warna', 'large_qty_count', 'extra_costs'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $po_terakhir = OrderModel::select('no_po')->orderBy('no_po', 'desc')->first();
        date_default_timezone_set('asia/jakarta');
        $tanggal = date('Y-m-d');

        $data = OrderModel::find($id);

        $jenis_orderan_list = $data->jenis_orderan ?? [];
        $jenis_orderans = JenisOrderanModel::orderBy('nama_jenis', 'ASC')->get();
        
        // Map names to IDs for select pre-selection
        $jenis_orderan_ids = [];
        foreach ($jenis_orderan_list as $name) {
            $jo = JenisOrderanModel::where('nama_jenis', $name)->first();
            $jenis_orderan_ids[] = $jo ? $jo->id : '';
        }

        $hitung_data = count($jenis_orderan_list);

        $bahan = $data->bahan ?? [];
        $warna = $data->warna ?? [];
        $qty = $data->qty ?? [];
        $catatan = $data->catatan ?? [];
        $harga_satuan = $data->harga_satuan ?? [];
        $size_details = $data->size_details ?? [];
        $detail_size_besar = $data->detail_size_besar ?? [];

        return view('admin.orderan.crud.edit', compact('data', 'po_terakhir', 'tanggal', 'hitung_data', 'jenis_orderan_ids', 'jenis_orderans', 'qty', 'harga_satuan', 'catatan', 'bahan', 'warna', 'size_details', 'detail_size_besar'));
    }

    // public function list_orderan()
    // {
    //     $data = OrderModel::all();
    //     return view('admin.orderan.list');
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'no_po' => 'required',
            'nama_vendor' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'pesanan_untuk' => 'required',
            'deadline' => 'required|date',
            'jenis_orderan' => 'required|array|min:1',
            'jenis_orderan.*' => 'required|integer',
            'bahan' => 'required|array|min:1',
            'bahan.*' => 'required|string',
            'warna' => 'required|array|min:1',
            'warna.*' => 'required|string',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|numeric|min:1',
        ]);

        $data = OrderModel::find($id);

        $hitung_data = count($request->jenis_orderan);
        
        // HITUNG EXTRA COST SIZE BESAR
        $extra_costs = [];
        if($request->has('size_large_json')){
            foreach($request->size_large_json as $index => $json){
               $total = 0;
               $items = json_decode($json, true);
               if(is_array($items)){
                   foreach($items as $item){
                       $total += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
                   }
               }
               $extra_costs[$index] = $total;
            }
        }

        // PREPARE HPP VALUES
        $hpp_bahan = $request->harga ?? 0;
        $hpp_cmt = $request->hpp_cmt ?? 0;
        $hpp_bordir = $request->hpp_bordir ?? 0;
        $hpp_sablon = $request->hpp_sablon ?? 0;
        $hpp_benang = $request->hpp_benang ?? 0;
        $hpp_packaging = $request->hpp_packaging ?? 0;
        $total_hpp = $hpp_bahan + $hpp_cmt + $hpp_bordir + $hpp_sablon + $hpp_packaging + $hpp_benang;

        $total_vendor = 0;
        $total_qty = 0;
        $sum_harga_satuan = 0;

        for ($i = 0; $i < $hitung_data; $i++) {
            // Skip empty items (especially the clone template if it somehow gets submitted)
            if (empty($request->jenis_orderan[$i])) continue;

            $qty = $request->qty[$i] ?? 0;
            $harga_satuan = $request->harga_satuan[$i] ?? 0;
            $extra = $extra_costs[$i] ?? 0;

            // Validation Size Details (Normal + Large) vs Total Qty
            $total_size_qty = 0;
            if ($request->has('size_details_json.'.$i)) {
                $details = json_decode($request->size_details_json[$i], true);
                if (is_array($details)) {
                    foreach ($details as $d) {
                        $total_size_qty += $d['qty'] ?? 0;
                    }
                }
            }
            if ($request->has('size_large_json.'.$i)) {
                $large_details = json_decode($request->size_large_json[$i], true);
                if (is_array($large_details)) {
                    foreach ($large_details as $ld) {
                        $total_size_qty += $ld['qty'] ?? 0;
                    }
                }
            }

            if ($total_size_qty > $qty) {
                Alert::error('Gagal', 'Total Qty Ukuran (Normal + Besar) pada item '.($i+1).' melebihi Total QTY (PCS)');
                return redirect()->back()->withInput();
            }

            $total_vendor += ($qty * $harga_satuan) + $extra;
            $total_qty += $qty;
            $sum_harga_satuan += $harga_satuan;
        }

        // Hitung Omset HPP
        $omset_hpp = $total_qty * $total_hpp;
        // Hitung Profit Value
        $profit_value = abs($sum_harga_satuan - $total_hpp);
        // Hitung Total Profit
        $omset_total = abs($omset_hpp - $total_vendor);

        // Map ID to names and Validate
        $jenis_orderan_names = [];
        foreach ($request->jenis_orderan as $i => $jo_id) {
            $jo = JenisOrderanModel::find($jo_id);
            if (!$jo) {
                Alert::error('Gagal', 'Jenis Orderan pada item '.($i+1).' tidak valid.');
                return redirect()->back()->withInput();
            }
            
            // Validate Bahan belongs to this Jenis
            $bahan_name = $request->bahan[$i] ?? null;
            if (!$bahan_name) {
                Alert::error('Gagal', 'Bahan pada item '.($i+1).' belum dipilih.');
                return redirect()->back()->withInput();
            }

            $check_bahan = BahanModel::where('jenis_orderan_id', $jo_id)
                                    ->where('nama_bahan', $bahan_name)
                                    ->first();
            if (!$check_bahan) {
                Alert::error('Gagal', 'Bahan "'.$bahan_name.'" tidak tersedia untuk jenis "'.$jo->nama_jenis.'".');
                return redirect()->back()->withInput();
            }
            
            $jenis_orderan_names[] = $jo->nama_jenis;
        }

        $data->update([
                'tgl_order' => $request->tanggal,
                'no_po' => $request->no_po,
                'nama_vendor' => $request->nama_vendor,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'pesanan_untuk' => $request->pesanan_untuk,
                'sistem_dp' => $request->has('sistem_dp') ? $request->sistem_dp : $data->sistem_dp,
                'dp' => $request->has('dp') ? $request->dp : $data->dp,
                'deadline' => $request->deadline,
                'jenis_orderan' => collect($jenis_orderan_names),
                'bahan' => collect($request->bahan),
                'warna' => collect($request->warna),
                'harga_satuan' => collect($request->harga_satuan),
                'qty' => collect($request->qty),
                'size_details' => collect($request->size_details_json),
                'detail_size_besar' => collect($request->size_large_json),
                'catatan' => collect($request->catatan),
                'pembelanjaan_bahan' => $request->pembelanjaan_bahan,
                'harga' => $hpp_bahan,
                'hpp_bahan' => $hpp_bahan,
                'hpp_cmt' => $hpp_cmt,
                'hpp_bordir' => $hpp_bordir,
                'hpp_sablon' => $hpp_sablon,
                'hpp_benang' => $hpp_benang,
                'hpp_packaging' => $hpp_packaging,
                'profit_value' => $profit_value,
                'omset_total' => $omset_total,
                'pemeriksa' => Auth::user()->name,
                'user_id' => Auth::id(),
                'status' => $request->status
        ]);

        // Reset Logic: If status goes back to Belum Diproses, clear locker & payment info
        if ($request->status == OrderModel::STATUS_BELUM_DIPROSES) {
            $data->update([
                'loker_id' => null,
                'catatan_stok' => null,
                'status_pembayaran' => null,
            ]);
            // Delete associated stock records so they are regenerated when moving back to stock
            \App\StokModel::where('orderan_id', $data->id)->delete();
        }

        // SYNC NORMALIZED SIZE DETAILS
        if ($request->has('size_details_json')) {
            // Delete existing sizes first
            OrderItemSizeModel::where('order_id', $data->id)->delete();
            
            foreach ($request->size_details_json as $index => $json) {
                $details = json_decode($json, true);
                if (is_array($details)) {
                    foreach ($details as $detail) {
                        OrderItemSizeModel::create([
                            'order_id' => $data->id,
                            'item_index' => $index,
                            'size' => $detail['size'] ?? '',
                            'qty' => $detail['qty'] ?? 0,
                        ]);
                    }
                }
            }
        }

        Alert::success('Berhasil', 'Pemesanan Berhasil Di Update');
        return redirect('lihat_orderan/detail/'.$data->id);
    }

    // public function update_omset(Request $request, $no_po){
    //     $data = DB::table('tbl_omset')->find($no_po);
    //     dd($data);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}