@extends('layout.master')

@section('judul', 'Detail Stok Barang')

@section('konten')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-dark d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fas fa-boxes mr-2"></i> LIST DAFTAR STOK BARANG: 
                    <span class="badge badge-warning ml-2 font-weight-bold" style="font-size: 1rem;">{{$join[0]->nama_loker ?? 'Bukan Loker Resmi'}}</span>
                </h3>
                <div class="card-tools ml-auto">
                    <a href="javascript:window.history.go(-1);" class="btn btn-outline-light btn-sm rounded-pill px-3 mr-2"><i class="fa fa-arrow-left"></i> Kembali</a>  
                    @if(Auth::user()->role == 'owner')
                    <a href="/print_stok/{{$join[0]->nama_loker}}" class="btn btn-info btn-sm rounded-pill px-3 mr-2"><i class="fas fa-print"></i> Print</a>
                    @endif
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus text-white"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="mytable" class="table table-hover table-striped table-bordered">
                    <thead class="bg-light">
                        <tr class="text-uppercase small font-weight-bold">
                            <th class="text-center align-middle" width="50">No.</th>
                            <th class="text-center align-middle">No. PO</th>
                            <th class="text-center align-middle">Vendor</th>
                            <th class="text-center align-middle bg-info-light">Jenis Orderan</th>
                            <th class="text-center align-middle bg-info-light">Bahan & Warna</th>
                            <th class="text-center align-middle bg-info-light">Size & Qty</th>
                            <th class="text-center align-middle">Status</th>
                            <th class="text-center align-middle">Update Terakhir</th>
                            <th class="text-center align-middle" width="120">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($join as $item)                
                        <tr>
                            <td class="text-center align-middle font-weight-bold">{{$loop->iteration}}</td>
                            <td class="text-center align-middle">
                                @if($item->no_po)
                                    <a href="/lihat_orderan/detail/{{$item->order_id}}" class="badge badge-primary px-3 py-2" title="Lihat Detail Pesanan">
                                        <i class="fas fa-search-plus mr-1"></i> {{$item->no_po}}
                                    </a>
                                @else
                                    <span class="text-muted small">Tanpa PO</span>
                                @endif
                            </td>
                            <td class="text-center align-middle font-weight-bold text-dark">{{$item->nama_vendor}}</td>
                            <td class="text-center align-middle">
                                <div class="badge badge-info px-3 py-1" style="font-size: 0.9rem;">{{$item->nama_barang}}</div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="small text-muted font-weight-bold uppercase-text">Bahan:</div>
                                <div class="font-weight-bold mb-1">{{$item->bahan}}</div>
                                <div class="small text-muted font-weight-bold uppercase-text">Warna:</div>
                                <div class="font-weight-bold">{{$item->warna}}</div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge badge-dark mb-1" style="font-size: 0.85rem;">Size: {{ strtoupper($item->size) }}</span>
                                    <span class="h5 mb-0 font-weight-bold text-success">{{$item->qty}} <small>Pcs</small></span>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->status == 'Selesai Dikirim')
                                    <span class="badge badge-pill badge-success px-3"><i class="fas fa-check-circle mr-1"></i> Selesai Dikirim</span>
                                @else
                                    <span class="badge badge-pill badge-warning px-3 shadow-sm"><i class="fas fa-warehouse mr-1 text-dark"></i> Di Loker</span>
                                @endif
                            </td>
                            <td class="text-center align-middle small text-secondary">
                                <div><i class="far fa-clock mr-1"></i> {{ $item->update_terakhir_stok ? Carbon\Carbon::parse($item->update_terakhir_stok)->format('d/M/Y') : '-' }}</div>
                                <div class="mt-1 font-weight-bold"><i class="far fa-user mr-1"></i> {{$item->pemeriksa}}</div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <a href="/edit_stok/{{$item->id}}" class="btn btn-info btn-sm shadow-sm" title="Edit Stok"><i class="fas fa-edit"></i></a>
                                    @if ($item->status != 'Selesai Dikirim')
                                    <a href="/siap_kirim_stok/{{$item->id}}" class="btn btn-success btn-sm shadow-sm ml-1" title="Tandai Siap Kirim"><i class="fas fa-truck"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<style>
    .bg-info-light { background-color: #f0f7ff; }
    .uppercase-text { text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.65rem; }
    #mytable th { border-top: none; }
    .table-hover tbody tr:hover { background-color: #fdfdfe; transition: background-color 0.2s ease; }
</style>
@endsection