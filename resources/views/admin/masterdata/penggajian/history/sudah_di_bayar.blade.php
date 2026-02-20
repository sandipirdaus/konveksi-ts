@extends('layout.master')
@section('judul', 'List Pembayaran Gaji')
@section('konten')
    
<div class="card">
      <div class="card-header">
        <h3 class="card-title">DAFTAR KARYAWAN YANG SUDAH DIBAYAR </h3>
        <div class="card-tools">
          <a href="javascript:window.history.go(-1);" class="btn btn-outline-dark btn-sm" style="border-radius: 15px"><i class="fa fa-arrow-left"> Kembali</i></a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="mytable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Nama Vendor</th>
            <th class="text-center">Nama Pekerja</th>
            <th class="text-center">Target</th>
            <th class="text-center">Penyelesaian</th>
            <th class="text-center" style="width: 10%">Harga Jasa</th>
            <th class="text-center" style="width: 10%">Total</th>
            <th class="text-center">Update Terakhir</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)                
          <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">{{$item->vendor}}</td>
            <td class="text-center">{{$item->nama_pekerja}}</td>
            <td class="text-center"><?php echo $item->qty_barang." "."Pcs"?></td>
            <td class="text-center"><?php echo $item->qty_pekerjaan." "."Pcs"?></td>
            <td class="text-center"><?php echo "Rp.".' '.number_format($item->harga_jasa)?></td>
            <td class="text-center"><?php echo "Rp.".' '.number_format($item->total)?></td>
            <td class="text-center">{{ $item->update_terakhir ? Carbon\Carbon::parse($item->update_terakhir)->format('d-M-Y H:i') : '-' }}</td>
          </tr>
          @endforeach
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</div>
    
@endsection