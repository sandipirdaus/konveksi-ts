@extends('layout.master')


@section('judul', 'Halaman Utama')

@section('konten')
<div class="row">
    <div class="col-lg-2 col-md-6 col-12">
      <div class="small-box bg-dark">
          <div class="inner">
            <?php 
            use App\OrderModel;
            use App\StokModel; 
              $hitung_orderan = OrderModel::count();
              $belum_produksi = OrderModel::where('status', OrderModel::STATUS_BELUM_DIPROSES)->count();
              $proses_produksi = OrderModel::where('status', OrderModel::STATUS_PROSES_PRODUKSI)->count();
              $orderan_stok = OrderModel::where('status', OrderModel::STATUS_STOK_BARANG)->count();
              $siap_dikirim = OrderModel::where('status', OrderModel::STATUS_SIAP_KIRIM)->count();
              $selesai_dikirim = OrderModel::where('status', OrderModel::STATUS_SELESAI_DIKIRIM)->count();
              ?>
            <h3>{{$hitung_orderan}}</h3>
              <p>Total Orderan</p>
         </div>
          <div class="icon">
            <i class="fas fa-cart-plus"></i>
        </div>
         <a href="/lihat_orderan" class="small-box-footer"> Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
     </div>
    <div class="col-lg-2 col-md-6 col-12">
      <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$belum_produksi}}</h3>
              <p>Belum Diproses </p>
         </div>
          <div class="icon">
            <i class="fas fa-clock"></i>
        </div>
         <a href="/orderan/belum_proses" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
     </div>
    <div class="col-lg-2 col-md-6 col-12">
      <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$proses_produksi}}</h3>
              <p>Proses Produksi </p>
         </div>
          <div class="icon">
            <i class="	fas fa-cut"></i>
        </div>
         <a href="/on_proses" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
     </div>
    <div class="col-lg-2 col-md-6 col-12">
      <div class="small-box bg-secondary">
          <div class="inner">
            <h3>{{$orderan_stok}}</h3>
              <p>Stok Barang</p>
         </div>
          <div class="icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
         <a href="/stok_barang" class="small-box-footer"> Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
     </div>
    <div class="col-lg-2 col-md-6 col-12">
      <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{$siap_dikirim}}</h3>
              <p>Siap Dikirim </p>
         </div>
          <div class="icon">
            <i class="fas fa-truck"></i>
        </div>
         <a href="/siap_kirim" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
     </div>
    <div class="col-lg-2 col-md-6 col-12">
      <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$selesai_dikirim}}</h3>
              <p>Selesai Dikirim</p>
         </div>
          <div class="icon">
            <i class="fas fa-check"></i>
        </div>
         <a href="/orderan_selesai" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
     </div>
   </div>
     
@endsection
