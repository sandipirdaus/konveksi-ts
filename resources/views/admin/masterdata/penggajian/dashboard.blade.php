@extends('layout.master')

@section('judul', 'Pembayaran Gaji Karyawan')

@section('konten')
<div class="container">
   <div class="card">
      <div class="card-header bg-dark">
            <center><h3 class="card-title">INPUT PEMBAYARAN GAJI KARYAWAN</h3></center>
      </div>
<div class="row ml-2 mt-4 mr-2">
      <div class="col-md-6 col-sm-2">
        <div class="small-box bg-info">
            <div class="inner">
                  <h3>Potong</h3>
              <p>Jasa Pemotongan</p>
           </div>
            <div class="icon">
              <i class="fas fa-cut"></i>
          </div>
           <a href="/penggajian/add_potong" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>
      <div class="col-md-6 col-sm-2">
        <div class="small-box bg-primary">
            <div class="inner">
                  <h3>Jahit</h3>
              <p>Jasa Penjahit</p>
           </div>
            <div class="icon">
              <i class="fas fa-tshirt"></i>
          </div>
           <a href="/penggajian/add_jahit" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>

       <!-- Sablon Card -->
       <div class="col-md-6 col-sm-2">
        <div class="small-box bg-lightblue">
            <div class="inner">
                  <h3>Sablon</h3>
              <p>Jasa Sablon</p>
           </div>
            <div class="icon">
              <i class="fas fa-fill-drip"></i>
          </div>
           <a href="/penggajian/add_sablon" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>

       <!-- Packaging Card -->
       <div class="col-md-6 col-sm-2">
        <div class="small-box bg-warning">
            <div class="inner">
                  <h3>Packaging</h3>
              <p>Jasa Packaging</p>
           </div>
            <div class="icon">
              <i class="fas fa-box-open"></i>
          </div>
           <a href="/penggajian/add_packaging" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>

      </div>
      </div>
   <div class="card">
      <div class="card-header bg-dark">
            <center><h3 class="card-title">HISTORY GAJI KARYAWAN</h3></center>
      </div>
<div class="row ml-2 mt-4 mr-2">
      <div class="col-md-4 col-sm-2">
        <div class="small-box bg-success">
            <div class="inner">
                  <h4>Sudah Dibayar</h4>
              <p>{{$sudah_di_bayar}} Orang </p>
           </div>
            <div class="icon">
              <i class="far fa-smile"></i>
          </div>
           <a href="/penggajian/masterdata/sudah_di_bayar" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>
      <div class="col-md-4 col-sm-2">
        <div class="small-box bg-danger">
            <div class="inner">
                  <h4>Belum Dibayar </h4>
              <p>{{$belum_di_bayar}} Orang</p>
           </div>
            <div class="icon">
              <i class="far fa-frown"></i>
          </div>
           <a href="/penggajian/masterdata/belum_di_bayar" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>
      <div class="col-md-4 col-sm-2">
        <div class="small-box bg-dark">
            <div class="inner">
                  <h4>Total Pembayaran </h4>
              <p>{{$all_list}} orang</p>
           </div>
            <div class="icon">
              <i class="fas fa-clipboard-list"></i>
          </div>
           <a href="/penggajian/masterdata/all_list" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>
      </div>
      </div>
      </div>
@endsection