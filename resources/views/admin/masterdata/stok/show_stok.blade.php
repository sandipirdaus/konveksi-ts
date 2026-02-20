@extends('layout.master')
@section('judul', 'Detail Stok Barang')
@section('konten')
    
<div class="card">
      <div class="card-header">
        <h3 class="card-title">LIST DAFTAR STOK BARANG <span class="badge badge-warning"><b>{{$join[0]->nama_loker}}</span></b></h3>
        <div class="card-tools">
          <a href="javascript:window.history.go(-1);" class="btn btn-outline-dark btn-sm" style="border-radius: 15px"><i class="fa fa-arrow-left"> Kembali</i></a>  
          <button onclick="window.print()"rel="noopener" target="_blank" class="btn btn-info btn-sm" style="border-radius: 15px"><i class="fas fa-print"></i> Print</button>
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
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Warna</th>
            <th class="text-center">Bahan</th>
            <th class="text-center">Size</th>
            <th class="text-center">QTY</th>
            <th class="text-center">Update Terakhir</th>
            <th class="text-center">Opsi</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($join as $item)                
          <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">{{$item->nama_vendor}}</td>
            <td class="text-center">{{$item->nama_barang}}</td>
            <td class="text-center">{{$item->warna}}</td>
            <td class="text-center">{{$item->bahan}}</td>
            <td class="text-center">{{$item->size}}</td>
            <td class="text-center"><?php echo $item->qty." "."Pcs"?></td>
            <td class="text-center">{{Carbon\Carbon::parse($item->tgl_pemeriksaan)->format('d-M-Y')}}</td>
            <td class="text-center">
              <a href="/edit_stok/{{$item->id}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="/hapus_stok/{{$item->id}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
            </td>
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