<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\StokModel;
use App\OrderModel;
use App\GajiKaryawanModel;
use App\User;
use App\VendorModel;
use App\BahanModel;
use Illuminate\Support\Facades\Hash;

class MasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function master_stok()
    {

        $tanggal = date('Y-m-d');
        // dd($tanggal);

        $data = DB::table('tbl_stok')->orderBy('nama_loker', 'ASC')->get();
        $loker = DB::table('tbl_loker')->orderBy('nama_loker', 'ASC')->get();

        return view('admin.masterdata.stok.index', compact('data', 'loker', 'tanggal'));
    }

    public function input_master_stok(Request $request)
    {
        $request->validate([
            'loker_id.*' => 'required',
            'nama_vendor.*' => 'required',
            'nama_barang.*' => 'required',
            'qty.*' => 'required|numeric|min:1',
            'warna.*' => 'required',
            'bahan.*' => 'required',
            'size.*' => 'required',
        ], [
            'loker_id.*.required' => 'Loker wajib dipilih!',
            'nama_vendor.*.required' => 'Vendor wajib diisi!',
            'nama_barang.*.required' => 'Nama Barang wajib diisi!',
            'qty.*.required' => 'Qty wajib diisi!',
            'warna.*.required' => 'Warna wajib diisi!',
            'bahan.*.required' => 'Bahan wajib diisi!',
            'size.*.required' => 'Size wajib diisi!',
        ]);

        $nama_vendor = $request->nama_vendor;

        for ($i=0; $i < count($nama_vendor); $i++) {
            if(!empty($nama_vendor[$i])){
                $loker = \App\LokerModel::find($request->loker_id[$i]);
                $data = StokModel::create([
                'loker_id' => $loker->id ?? null,
                'nama_loker' => $loker->nama_loker ?? 'Loker Terhapus',
                'nama_vendor' => $request->nama_vendor[$i],
                'nama_barang' => $request->nama_barang[$i],
                'qty' => $request->qty[$i],
                'warna' => $request->warna[$i],
                'bahan' => $request->bahan[$i],
                'size' => $request->size[$i],
                'pemeriksa' => Auth::user()->name,
                'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                'update_terakhir_stok' => \Carbon\Carbon::now()
            ]);
        }
    }
    Alert::success('Berhasil', 'Stok Barang Berhasil Di Buat');
        return redirect()->back();
    }

    public function show_stok($nama_loker)
    {
        $data = StokModel::find($nama_loker);
        // dd($data);

        $join = DB::table('tbl_stok')
        ->join('tbl_loker', 'tbl_loker.nama_loker', '=', 'tbl_stok.nama_loker')
        ->select('tbl_stok.id', 'tbl_stok.nama_loker', 'tbl_stok.nama_vendor', 'tbl_stok.nama_barang', 'tbl_stok.warna', 'tbl_stok.bahan', 'tbl_stok.size', 'tbl_stok.qty', 'tbl_stok.tgl_pemeriksaan', 'tbl_stok.update_terakhir_stok')
        ->where('tbl_stok.nama_loker', '=', $nama_loker)
        ->get();
        // dd($join[0]->nama_loker);

        return view('admin.masterdata.stok.show_stok', compact('data', 'join'));
    }

    public function edit_stok($id)
    {
        date_default_timezone_set('asia/jakarta');
        $tanggal = date('Y-m-d');

        $data = StokModel::find($id);
        // dd($data);

        $loker = DB::table('tbl_loker')->get();


        return view('admin.masterdata.stok.edit', compact('data', 'tanggal', 'loker'));
    }


    public function update_stok(Request $request, $id)
    {
        $data = StokModel::find($id);
        $loker = \App\LokerModel::find($request->loker_id);

        $result =  StokModel::where('id', $id)->update([
        'loker_id' => $loker->id ?? null,
        'nama_loker' => $loker->nama_loker ?? 'Loker Terhapus',
        'nama_vendor' => $request->nama_vendor,
        'nama_barang' => $request->nama_barang,
        'qty' => $request->qty,
        'warna' => $request->warna,
        'bahan' => $request->bahan,
        'size' => $request->size,
        'catatan' => $request->catatan,
        'pemeriksa' => Auth::user()->name,
        'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
        'update_terakhir_stok' => \Carbon\Carbon::now()
        ]);
        Alert::success('Berhasil', 'Stok Berhasil Di Update');
        return redirect('/master_stok');
    }

    public function destroy_stok($id)
    {
            $data = StokModel::find($id);
            $data->delete();
            Alert::success('Berhasil', 'Stok Barang Berhasil Di Hapus');
            return redirect('/master_stok');
    }

    public function master_gaji()
    {
        $belum_di_bayar = GajiKaryawanModel::where('keterangan', 'belum_di_bayar')->count();
        $sudah_di_bayar = GajiKaryawanModel::where('keterangan', 'sudah_di_bayar')->count();
        $all_list = GajiKaryawanModel::count();
        return view('admin.masterdata.penggajian.dashboard', compact('belum_di_bayar', 'sudah_di_bayar', 'all_list'));

    }

    public function sudah_di_bayar()
    {
        $data = GajiKaryawanModel::where('keterangan', 'sudah_di_bayar')->orderBy('id', 'DESC')->get();

        return view('admin.masterdata.penggajian.history.sudah_di_bayar', compact('data'));
    }

    public function belum_di_bayar()
    {
        $data = GajiKaryawanModel::where('keterangan', 'belum_di_bayar')->orderBy('id', 'DESC')->get();

        return view('admin.masterdata.penggajian.history.belum_di_bayar', compact('data'));
    }

    public function all_list()
    {
        $data = GajiKaryawanModel::all();
        // dd($data);
        return view('admin.masterdata.penggajian.history.all_list', compact('data'));
    }

    public function edit_pembayaran($id)
    {
        $data = GajiKaryawanModel::find($id);
        $vendor = OrderModel::select('nama_vendor')
                    ->distinct()
                    ->orderBy('nama_vendor', 'ASC')
                    ->get();

        $tanggal = date('Y-m-d');

        return view('admin.masterdata.penggajian.history.edit', compact('data', 'tanggal', 'vendor'));
    }

    public function update_pembayaran(Request $request, $id)
    {
        $data = GajiKaryawanModel::find($id);

        GajiKaryawanModel::where('id', $id)->update([
            'deskripsi' => $request->deskripsi,
            'qty_barang' => $request->qty_barang,
            'nama_pekerja' => $request->nama_pekerja,
            'harga_jasa' => $request->harga_jasa,
            'qty_pekerjaan' => $request->qty_pekerjaan,
            'total' => $request->harga_jasa,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'vendor' => $request->vendor, // Name from input
            'vendor_id' => VendorModel::where('nama_vendor', $request->vendor)->value('id'), // Lookup ID or null
            'update_terakhir' => ($request->keterangan == 'sudah_di_bayar' && $data->keterangan != 'sudah_di_bayar') ? \Carbon\Carbon::now() : $data->update_terakhir,
        ]);
        Alert::success('Berhasil', 'Data Berhasil Di Update');
        return redirect('/penggajian/masterdata/all_list');
    }

    public function destroy_pembayaran($id)
    {
            $data = GajiKaryawanModel::find($id);
            $data->delete();
            Alert::success('Berhasil', 'Data Berhasil Di Hapus');
            return redirect('/penggajian/masterdata/all_list');
    }


    public function add_potong()
    {
        $tanggal = date('Y-m-d');

        $vendor = OrderModel::select('nama_vendor')
                    ->distinct()
                    ->orderBy('nama_vendor', 'ASC')
                    ->get();
        // dd($status_vendor);

        return view('admin.masterdata.penggajian.potong.add', compact('tanggal', 'vendor'));
    }

    public function store_potong(Request $request)
    {
    // ✅ 1) VALIDASI DI SINI (PALING ATAS)
     // Validasi manual (opsi 2)
    $request->validate([
        'vendor' => 'required',
        'jenis_pekerjaan' => 'required',
        'deskripsi.*' => 'required',
        'qty_barang.*' => 'required|numeric|min:1',
        'nama_pekerja.*' => 'required',
        'harga_jasa.*' => 'required|numeric|min:0',
        'qty_pekerjaan.*' => 'required|numeric|min:1',
        'keterangan.*' => 'required'
    ], [
        'vendor.required' => 'Vendor wajib dipilih!',
        'jenis_pekerjaan.required' => 'Jenis Pekerjaan wajib dipilih!',
        'deskripsi.*.required' => 'Deskripsi wajib diisi!',
        'qty_barang.*.required' => 'Qty Barang wajib diisi!',
        'nama_pekerja.*.required' => 'Nama Pekerja wajib diisi!',
        'harga_jasa.*.required' => 'Harga Jasa wajib diisi!',
        'qty_pekerjaan.*.required' => 'Qty Pekerjaan wajib diisi!',
        'keterangan.*.required' => 'Keterangan wajib diisi!'
    ]);

    $deskripsi = $request->deskripsi;
    $vendor_name = $request->vendor; 
    $vendor_id = VendorModel::where('nama_vendor', $request->vendor)->value('id');

    for ($i=0; $i < count($deskripsi); $i++) {
        if(!empty($deskripsi[$i])){
            $data = GajiKaryawanModel::create([
            'deskripsi' => $request->deskripsi[$i],
            'qty_barang' => $request->qty_barang[$i],
            'nama_pekerja' => $request->nama_pekerja[$i],
            'harga_jasa' => $request->harga_jasa[$i],
            'qty_pekerjaan' => $request->qty_pekerjaan[$i],
            'total' => $request->harga_jasa[$i] * $request->qty_pekerjaan[$i] ,
            'keterangan' => $request->keterangan[$i],
            'tanggal' => $request->tanggal,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'vendor' => $vendor_name,
            'vendor_id' => $vendor_id,
            'update_terakhir' => \Carbon\Carbon::now(),
        ]);
        }
    }

    Alert::success('Berhasil', 'Pembayaran Berhasil Di Buat');
    return redirect('/penggajian/dashboard');
}

    public function add_jahit()
    {
        $tanggal = date('Y-m-d');

        $vendor = OrderModel::select('nama_vendor')
                    ->distinct()
                    ->orderBy('nama_vendor', 'ASC')
                    ->get();
        // dd($status_vendor);

        return view('admin.masterdata.penggajian.jahit.add', compact('tanggal', 'vendor'));
    }

    public function store_jahit(Request $request)
    {
        $request->validate([
          'vendor' => 'required',
          'jenis_pekerjaan' => 'required',
          'deskripsi.*' => 'required',
          'qty_barang.*' => 'required|numeric|min:1',
          'nama_pekerja.*' => 'required',
          'harga_jasa.*' => 'required|numeric|min:0',
          'qty_pekerjaan.*' => 'required|numeric|min:1',
          'keterangan.*' => 'required'
      ], [
          'vendor.required' => 'Vendor wajib dipilih!',
          'jenis_pekerjaan.required' => 'Jenis Pekerjaan wajib dipilih!',
          'deskripsi.*.required' => 'Deskripsi wajib diisi!',
          'qty_barang.*.required' => 'Qty Barang wajib diisi!',
          'nama_pekerja.*.required' => 'Nama Pekerja wajib diisi!',
          'harga_jasa.*.required' => 'Harga Jasa wajib diisi!',
          'qty_pekerjaan.*.required' => 'Qty Pekerjaan wajib diisi!',
          'keterangan.*.required' => 'Keterangan wajib diisi!'
      ]);

        $deskripsi = $request->deskripsi;
        $vendor_name = $request->vendor; // Name from input
        $vendor_id = VendorModel::where('nama_vendor', $request->vendor)->value('id');

            for ($i=0; $i < count($deskripsi); $i++) {
                if(!empty($deskripsi[$i])){
                    $data = GajiKaryawanModel::create([
                    'deskripsi' => $request->deskripsi[$i],
                    'qty_barang' => $request->qty_barang[$i],
                    'nama_pekerja' => $request->nama_pekerja[$i],
                    'harga_jasa' => $request->harga_jasa[$i],
                    'qty_pekerjaan' => $request->qty_pekerjaan[$i],
                    'total' => $request->harga_jasa[$i] * $request->qty_pekerjaan[$i] ,
                    'keterangan' => $request->keterangan[$i],
                    'tanggal' => $request->tanggal,
                    'jenis_pekerjaan' => $request->jenis_pekerjaan,
                    'vendor' => $vendor_name,
                    'vendor_id' => $vendor_id,
                    'update_terakhir' => \Carbon\Carbon::now(),
                ]);
            }
        }

        Alert::success('Berhasil', 'Pembayaran Berhasil Di Buat');
        return redirect('/penggajian/dashboard');
    }

    public function add_sablon()
    {
        $tanggal = date('Y-m-d');

        $vendor = OrderModel::select('nama_vendor')
                    ->distinct()
                    ->orderBy('nama_vendor', 'ASC')
                    ->get();

        return view('admin.masterdata.penggajian.sablon.add', compact('tanggal', 'vendor'));
    }

    public function store_sablon(Request $request)
    {
        $request->validate([
          'vendor' => 'required',
          'jenis_pekerjaan' => 'required',
          'deskripsi.*' => 'required',
          'qty_barang.*' => 'required|numeric|min:1',
          'nama_pekerja.*' => 'required',
          'harga_jasa.*' => 'required|numeric|min:0',
          'qty_pekerjaan.*' => 'required|numeric|min:1',
          'keterangan.*' => 'required'
      ], [
          'vendor.required' => 'Vendor wajib dipilih!',
          'jenis_pekerjaan.required' => 'Jenis Pekerjaan wajib dipilih!',
          'deskripsi.*.required' => 'Deskripsi wajib diisi!',
          'qty_barang.*.required' => 'Qty Barang wajib diisi!',
          'nama_pekerja.*.required' => 'Nama Pekerja wajib diisi!',
          'harga_jasa.*.required' => 'Harga Jasa wajib diisi!',
          'qty_pekerjaan.*.required' => 'Qty Pekerjaan wajib diisi!',
          'keterangan.*.required' => 'Keterangan wajib diisi!'
      ]);

        $deskripsi = $request->deskripsi;
        $vendor_name = $request->vendor; // Name from input
        $vendor_id = VendorModel::where('nama_vendor', $request->vendor)->value('id');

            for ($i=0; $i < count($deskripsi); $i++) {
                if(!empty($deskripsi[$i])){
                    $data = GajiKaryawanModel::create([
                    'deskripsi' => $request->deskripsi[$i],
                    'qty_barang' => $request->qty_barang[$i],
                    'nama_pekerja' => $request->nama_pekerja[$i],
                    'harga_jasa' => $request->harga_jasa[$i],
                    'qty_pekerjaan' => $request->qty_pekerjaan[$i],
                    'total' => $request->harga_jasa[$i] * $request->qty_pekerjaan[$i] ,
                    'keterangan' => $request->keterangan[$i],
                    'tanggal' => $request->tanggal,
                    'jenis_pekerjaan' => $request->jenis_pekerjaan,
                    'vendor' => $vendor_name,
                    'vendor_id' => $vendor_id,
                    'update_terakhir' => \Carbon\Carbon::now(),
                ]);
            }
        }

        Alert::success('Berhasil', 'Pembayaran Berhasil Di Buat');
        return redirect('/penggajian/dashboard');
    }

    public function add_packaging()
    {
        $tanggal = date('Y-m-d');

        $vendor = OrderModel::select('nama_vendor')
                    ->distinct()
                    ->orderBy('nama_vendor', 'ASC')
                    ->get();

        return view('admin.masterdata.penggajian.packaging.add', compact('tanggal', 'vendor'));
    }

    public function store_packaging(Request $request)
    {
         $request->validate([
          'vendor' => 'required',
          'jenis_pekerjaan' => 'required',
          'deskripsi.*' => 'required',
          'qty_barang.*' => 'required|numeric|min:1',
          'nama_pekerja.*' => 'required',
          'harga_jasa.*' => 'required|numeric|min:0',
          'qty_pekerjaan.*' => 'required|numeric|min:1',
          'keterangan.*' => 'required'
      ], [
          'vendor.required' => 'Vendor wajib dipilih!',
          'jenis_pekerjaan.required' => 'Jenis Pekerjaan wajib dipilih!',
          'deskripsi.*.required' => 'Deskripsi wajib diisi!',
          'qty_barang.*.required' => 'Qty Barang wajib diisi!',
          'nama_pekerja.*.required' => 'Nama Pekerja wajib diisi!',
          'harga_jasa.*.required' => 'Harga Jasa wajib diisi!',
          'qty_pekerjaan.*.required' => 'Qty Pekerjaan wajib diisi!',
          'keterangan.*.required' => 'Keterangan wajib diisi!'
      ]);

        $deskripsi = $request->deskripsi;
        $vendor_name = $request->vendor; // Name from input
        $vendor_id = VendorModel::where('nama_vendor', $request->vendor)->value('id');

            for ($i=0; $i < count($deskripsi); $i++) {
                if(!empty($deskripsi[$i])){
                    $data = GajiKaryawanModel::create([
                    'deskripsi' => $request->deskripsi[$i],
                    'qty_barang' => $request->qty_barang[$i],
                    'nama_pekerja' => $request->nama_pekerja[$i],
                    'harga_jasa' => $request->harga_jasa[$i],
                    'qty_pekerjaan' => $request->qty_pekerjaan[$i],
                    'total' => $request->harga_jasa[$i] * $request->qty_pekerjaan[$i] ,
                    'keterangan' => $request->keterangan[$i],
                    'tanggal' => $request->tanggal,
                    'jenis_pekerjaan' => $request->jenis_pekerjaan,
                    'vendor' => $vendor_name,
                    'vendor_id' => $vendor_id,
                    'update_terakhir' => \Carbon\Carbon::now(),
                ]);
            }
        }

        Alert::success('Berhasil', 'Pembayaran Berhasil Di Buat');
        return redirect('/penggajian/dashboard');
    }

    public function ubah_status_pembayaran($id){
        $data = GajiKaryawanModel::find($id);
        GajiKaryawanModel::where('id', $id)->update([
            'keterangan' => 'sudah_di_bayar',
            'update_terakhir' => \Carbon\Carbon::now()
        ]);
        Alert::success('Berhasil', 'Pembayaran Atas Nama'.' '.$data->nama_pekerja.' '. 'Berhasil');
        return redirect()->back();
    }

    public function master_orderan(){
        $data = OrderModel::all();
        return view('admin.masterdata.orderan.index', compact('data'));
    }

    public function destroy_orderan($id)
    {
            $data = OrderModel::find($id);
            // dd($data);
            $data->delete();
            Alert::success('Berhasil', 'Orderan Berhasil Di Hapus');
            return redirect('/master_orderan');
    }
    public function master_akun(){
        $data = User::all();
        return view('admin.masterdata.akun.index', compact('data'));
    }

    public function edit_akun($id){
        $data = User::find($id);
        // dd($data);
        return view('admin.masterdata.akun.edit', compact('data'));
    }

    public function update_akun(Request $request, $id){
        $data = User::find($id);

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:owner,karyawan',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|max:12|confirmed';
        }

        $messages = [
            'name.required' => 'Nama wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 12 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ];

        $request->validate($rules, $messages);
        
        // Update Profil
        $data->name = $request->name;
        $data->email = $request->email;
        $data->role = $request->role;

        // Update Foto
        if ($request->hasFile('foto')) {
            $request->file('foto')->move('foto_akun/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
        }

        // Update Password
        if ($request->filled('password')) {
            $data->password = Hash::make($request->password);
        }

        $data->save();

        Alert::success('Sukses', 'Data Akun Berhasil Di Update');
        return redirect('/master_akun');
    }



    public function add_akun(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:12|confirmed',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|in:owner,karyawan',
        ], [
            'name.required' => 'Nama wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 12 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'foto.required' => 'Foto wajib diunggah!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format foto harus JPEG, PNG, atau JPG!',
            'foto.max' => 'Ukuran foto maksimal 2MB!',
            'role.required' => 'Role wajib dipilih!',
        ]);

         $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'foto' => '',
        ]);

        if ($request->hasFile('foto')) {
            $filename = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('foto_akun/', $filename);
            $data->foto = $filename;
            $data->save();
        }

        Alert::success('Sukses', 'Akun Berhasil Di Simpan');
        return redirect('/master_akun');
    }

    public function destroy_akun($id)
    {
            $data = User::find($id);
            // dd($data);
            $data->delete();
            Alert::success('Berhasil', 'Akun Berhasil Di Hapus');
            return redirect('/master_akun');
    }
    public function getVendorTotalQty(Request $request)
    {
        $vendorName = $request->query('vendor');
        
        if (!$vendorName) {
            return response()->json(['total_qty' => 0]);
        }

        // Status valid: 2=Proses Produksi, 3=Produksi Selesai, 4=Siap Kirim, 5=Selesai Dikirim
        $orders = \App\OrderModel::where('nama_vendor', $vendorName)
                    ->whereIn('status', [2, 3, 4, 5]) 
                    ->get();
        
        $totalQty = 0;
        
        foreach ($orders as $order) {
            // qty is cast to array in model, but verify to be safe
            $qtys = $order->qty; 
            if (is_array($qtys)) {
                foreach($qtys as $q) {
                    $totalQty += (int)$q;
                }
            } elseif (is_numeric($qtys)) {
                $totalQty += (int)$qtys;
            }
        }
        
        return response()->json(['total_qty' => $totalQty]);
    }

    public function store_bahan_ajax(Request $request)
    {
        // 1. Strict Validation First
        $validator = \Validator::make($request->all(), [
            'jenis_orderan_id' => 'required|exists:tbl_jenis_orderan,id',
            'nama_bahan' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal'
            ], 422);
        }

        // 2. Check for Duplicate
        $exists = BahanModel::where('jenis_orderan_id', $request->jenis_orderan_id)
                            ->where('nama_bahan', $request->nama_bahan)
                            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bahan sudah tersedia'
            ], 422);
        }

        try {
            $bahan = BahanModel::create([
                'jenis_orderan_id' => $request->jenis_orderan_id,
                'nama_bahan' => $request->nama_bahan,
                'harga_satuan' => $request->harga_satuan,
                'keterangan' => null
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $bahan,
                'message' => 'Bahan berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy_bahan_ajax(Request $request)
    {
        $nama_bahan = $request->nama_bahan;
        $jenis_orderan_id = $request->jenis_orderan_id;

        if (!$nama_bahan || !$jenis_orderan_id) {
             return response()->json(['status' => 'error', 'message' => 'Data tidak lengkap'], 400);
        }

        // 1. Check if used in tbl_orderan
        // Since 'bahan' column is JSON array like ["Bahan A", "Bahan B"], we check availability in string
        // Using "like" is simple but might match "Bahan A KW" when searching "Bahan A". 
        // Best approach for JSON array is JSON_CONTAINS (MySQL 5.7+) or LIKE with quotes.
        // Format storage: ["Cotton Combed 30s"]
        
        $isUsed = OrderModel::where('bahan', 'like', '%"'.$nama_bahan.'"%')->exists();

        if ($isUsed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal! Bahan ini sedang digunakan dalam data orderan.'
            ], 403);
        }

        try {
            // Delete from tbl_bahan
            $deleted = BahanModel::where('jenis_orderan_id', $jenis_orderan_id)
                                ->where('nama_bahan', $nama_bahan)
                                ->delete();

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Bahan berhasil dihapus'
                ]);
            } else {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Bahan tidak ditemukan di database'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
