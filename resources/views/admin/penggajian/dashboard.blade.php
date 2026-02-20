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
      </div>
      </div>
   <div class="card">
      <div class="card-header bg-dark">
            <center><h3 class="card-title">HISTORY GAJI KARYAWAN</h3></center>
      </div>
<div class="row ml-2 mt-4 mr-2">
      <div class="col-md-6 col-sm-2">
        <div class="small-box bg-success">
            <div class="inner">
                  <h3>Sudah Dibayar</h3>
              <p>{{$sudah_di_bayar}} orang</p>
           </div>
            <div class="icon">
              <i class="far fa-smile"></i>
          </div>
           <a href="/penggajian/add_potong" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>
      <div class="col-md-6 col-sm-2">
        <div class="small-box bg-danger">
            <div class="inner">
                  <h3>Belum Dibayar </h3>
              <p>{{$sudah_di_bayar}}</p>
           </div>
            <div class="icon">
              <i class="far fa-frown"></i>
          </div>
           <a href="/penggajian/add_jahit" class="small-box-footer"> Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
       </div>
      </div>
      </div>
      </div>
@endsection