@extends('layout.master')

@section('judul', 'Produksi Selesai')

@section('konten')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-check-circle"> DAFTAR ORDERAN PRODUKSI SELESAI (Barang di Loker)</i></h3>
      </div>
      <!-- ./card-header -->
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center">NO.</th>
              <th class="text-center">No. PO</th>
              <th class="text-center">Vendor</th>
              <th class="text-center">Tanggal Pemesanan</th>
              <th class="text-center">Deadline</th>
              <th class="text-center">Status</th>
              <th class="text-center">Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($data as $item)                  
            <tr data-widget="expandable-table" aria-expanded="false">
              <td class="text-center">{{$loop->iteration}}</td>
              <td class="text-center">{{$item->no_po}}</td>
              <td class="text-center">{{$item->nama_vendor}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($item->tgl_order)->format('d-M-Y')}}</td>
              <td class="text-center"><span class="badge badge-danger">{{Carbon\Carbon::parse($item->deadline)->format('d-M-Y')}}</span></td>
              <td class="text-center"><span class="badge badge-info">Produksi Selesai</span></td>
              <td class="text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                    Opsi
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/lihat_orderan/detail/{{$item->id}}"><i class="fas fa-eye mr-2"></i> Detail</a>
                    <a class="dropdown-item" href="/stok"><i class="fas fa-box mr-2 text-info"></i> Lihat Stok Loker</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="expandable-body">
              <td colspan="7">
                <div class="row m-0">
                  <div class="col-12 p-0">
                    @include('admin.orderan.status.parts.item_detail', ['item' => $item])
                  </div>
                  <div class="col-12 p-3 pt-0">
                    <div class="alert alert-info mb-0">
                      <i class="fas fa-info-circle mr-2"></i>
                      <strong>Barang sudah di loker.</strong> Karyawan dapat klik "Siap Kirim" di Dashboard untuk mengirim barang.
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada orderan yang sudah selesai produksi</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
</div>

@endsection
