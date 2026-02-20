<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\StokModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Use Eager Loading as requested
        $join = StokModel::with(['loker', 'order'])->get();
        
        $loker = DB::table('tbl_loker')->orderBy('nama_loker', 'ASC')->get();
        $tanggal = date('Y-m-d');
        
        return view('admin.stok.crud.index', compact('join', 'loker', 'tanggal'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $join = DB::table('tbl_stok')
        ->leftJoin('tbl_loker', 'tbl_loker.nama_loker', '=', 'tbl_stok.nama_loker')
        ->leftJoin('tbl_orderan', 'tbl_orderan.id', '=', 'tbl_stok.orderan_id')
        ->select(
            'tbl_stok.*', 
            'tbl_loker.id_loker', 
            'tbl_orderan.no_po',
            'tbl_orderan.id as order_id'
        )
        ->where('tbl_stok.id', '=', $id)
        ->get();

        if ($join->isEmpty()) {
            Alert::error('Gagal', 'Data Stok Tidak Ditemukan');
            return redirect('/stok');
        }

        return view('admin.stok.crud.show_stok', compact('join'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_stok($nama_loker)
    {
        $data = StokModel::find($nama_loker);
        $join = DB::table('tbl_stok')
        ->join('tbl_loker', 'tbl_loker.nama_loker', '=', 'tbl_stok.nama_loker')
        ->select('tbl_stok.id', 'tbl_stok.nama_loker', 'tbl_stok.nama_vendor', 'tbl_stok.nama_barang', 'tbl_stok.warna', 'tbl_stok.bahan', 'tbl_stok.size', 'tbl_stok.qty', 'tbl_stok.tgl_pemeriksaan', 'tbl_stok.pemeriksa', 'tbl_stok.update_terakhir_stok')
        ->where('tbl_stok.nama_loker', '=', $nama_loker)
        ->get();
        // dd($join[0]->nama_loker);
        return view('admin.stok.crud.print_stok', compact('data', 'join'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatusSiapKirim($id)
    {
        $stok = StokModel::find($id);
        if (!$stok) {
            Alert::error('Gagal', 'Data Stok Tidak Ditemukan');
            return redirect()->back();
        }

        // Update stock status to "Selesai Dikirim"
        $stok->status = 'Selesai Dikirim';
        $stok->save();

        // Check if ALL stock items from this order are now shipped
        if ($stok->orderan_id) {
            $order = \App\OrderModel::find($stok->orderan_id);
            if ($order) {
                $remainingStock = StokModel::where('orderan_id', $stok->orderan_id)
                    ->where('status', 'Di Loker')
                    ->count();
                
                // If all items from this order are shipped, update order status
                if ($remainingStock == 0) {
                    // If order is in "Produksi Selesai" status, move to "Siap Kirim"
                    if ($order->status == \App\OrderModel::STATUS_PRODUKSI_SELESAI) {
                        $order->status = \App\OrderModel::STATUS_SIAP_KIRIM;
                        $order->save();
                    }
                    // If already "Siap Kirim", move to "Selesai Dikirim"
                    elseif ($order->status == \App\OrderModel::STATUS_SIAP_KIRIM) {
                        $order->status = \App\OrderModel::STATUS_SELESAI_DIKIRIM;
                        $order->save();
                    }
                }
            }
        }

        Alert::success('Berhasil', 'Barang Berhasil Dikirim');
        return redirect()->back();
    }

    public function store_loker(Request $request)
    {
        $request->validate([
            'id_loker' => 'required|unique:tbl_loker,id_loker',
            'nama_loker' => 'required|unique:tbl_loker,nama_loker'
        ]);

        \App\LokerModel::create([
            'id_loker' => $request->id_loker,
            'nama_loker' => $request->nama_loker
        ]);

        Alert::success('Berhasil', 'Loker Baru Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function destroy_loker($id)
    {
        $loker = \App\LokerModel::find($id);
        if (!$loker) {
            Alert::error('Gagal', 'Loker Tidak Ditemukan');
            return redirect()->back();
        }

        // Check if locker is empty
        $count = StokModel::where('nama_loker', $loker->nama_loker)->count();
        if ($count > 0) {
            Alert::error('Gagal', 'Loker tidak bisa dihapus karena masih berisi barang!');
            return redirect()->back();
        }

        $loker->delete();
        Alert::success('Berhasil', 'Loker Berhasil Dihapus');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $data = StokModel::find($id);
        if (!$data) {
            Alert::error('Gagal', 'Data Stok Tidak Ditemukan');
            return redirect()->back();
        }
        $data->delete();
        Alert::success('Berhasil', 'Stok Barang Berhasil Di Hapus');
        return redirect()->back();
    }
}
