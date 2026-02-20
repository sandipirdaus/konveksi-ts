@extends('layout.master')

@section('judul', 'MASTER ORDERAN')

@section('konten')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">LIST MASTER DAFTAR ORDERAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="mytable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NO.PO</th>
                  <th>Vendor</th>
                  <th>No.HP</th>
                  <th>Deadline</th>
                  <th>Status</th>
                  <th class="text-center">Detail</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $order)                      
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$order->no_po}}</td>
                  <td>{{$order->nama_vendor}}
                  </td>
                  <td>{{$order->no_hp}}</td>
                  <td>{{Carbon\Carbon::parse($order->deadline)->format('d-M-Y')}}</td>
                  <td>
                    @if ($order->status == 0)
                    <span class="badge badge-danger">Belum Di Produksi</span>
                    @elseif($order->status == 1)
                    <span class="badge badge-warning">Proses Produksi</span>
                    @elseif($order->status == 2)
                    <span class="badge badge-info">Siap Diantar</span>
                    @else
                    <span class="badge badge-success">Selesai Diantar</span>
                    @endif
                  </td>
                  <td>
                      <a href="/lihat_orderan/detail/{{$order->id}}" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"> Detail</i></a>
                      @if ($order->status == 0)
                      <a href="/orderan/mulai_produksi/{{$order->id}}" class="btn btn-outline-warning btn-sm "><i class="fas fa-dolly"> Mulai Produksi</i></a>
                      @elseif($order->status == 1)
                      <a href="/orderan/selesai_produksi/{{$order->id}}" class="btn btn-warning btn-sm"><i class="fas fa-check"> Selesai Produksi</i></a>
                      @elseif($order->status == 2)
                      <a href="/orderan/cetak_invoice/{{$order->id}}" class="btn btn-outline-success btn-sm "><i class="fas fa-truck"> Antar & Print Invocie</i></a>
                      @endif
                      <a href="/orderan/hapus_orderan/{{$order->id}}" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"> Hapus</i></a>
                  </td>
                </tr>             
                @endforeach
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>
</div>



    
@endsection