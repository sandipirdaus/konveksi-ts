@extends('layout.master')
@section('judul', 'History Pembayaran Gaji')
@section('konten')
    
<div class="card">
      <div class="card-header">
        <h3 class="card-title">HISTROY PEMBAYARAN GAJI KARYAWAN </h3>
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
            <th class="text-center">Jenis Pekerjaan</th>
            <th class="text-center">Target</th>
            <th class="text-center">Penyelesaian</th>
            <th class="text-center">Harga Jasa</th>
            <th class="text-center" style="width: 10%">Total</th>
            <th class="text-center">Status</th>
            <th class="text-center">Update Terakhir</th>
            <th class="text-center" style="width: 15%">Opsi</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)                
          <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-center">{{$item->vendor}}</td>
            <td class="text-center">{{$item->nama_pekerja}}</td>
            <td class="text-center">
              @if($item->jenis_pekerjaan == 'Jahit')
              <span class="badge badge-primary">Jahit</span>
              @elseif($item->jenis_pekerjaan == 'Potong')
              <span class="badge badge-dark">Potong</span>
              @elseif($item->jenis_pekerjaan == 'Sablon')
              <span class="badge badge-info">Sablon</span>
              @elseif($item->jenis_pekerjaan == 'Packaging')
              <span class="badge badge-warning">Packaging</span>
              @endif
            </td>
            <td class="text-center"><?php echo $item->qty_barang." "."Pcs"?></td>
            <td class="text-center"><?php echo $item->qty_pekerjaan." "."Pcs"?></td>
            <td class="text-center"><?php echo "Rp.".' '.number_format($item->harga_jasa)?></td>
            <td class="text-center"><?php echo "Rp.".' '.number_format($item->total)?></td>
            <td class="text-center">
              @if($item->keterangan == 'sudah_di_bayar')
              <span class="badge badge-pill badge-success">Sudah Dibayar</span>
              @else
              <span class="badge badge-pill badge-danger">Belum Dibayar</span>
              @endif
            </td>
            <td class="text-center">{{ $item->update_terakhir ? Carbon\Carbon::parse($item->update_terakhir)->format('d-M-Y H:i') : '-' }}</td>
            <td class="text-center">
              <a href="/penggajian/masterdata/edit_pembayaran/{{$item->id}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
              <a href="/penggajian/masterdata/hapus_pembayaran/{{$item->id}}" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>
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