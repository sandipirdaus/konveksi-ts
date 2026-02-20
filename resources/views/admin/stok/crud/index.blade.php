@extends('layout.master')
@section('judul', 'Halaman Stok Barang')

@section('konten')

<div class="card">
      <div class="card-header bg-dark">
            <h3 class="card-title">LIST LOKER STOK BARANG </h3>
            <div class="card-tools">
                @if(Auth::user()->role == 'owner')
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#daftar_loker"><i class="fas fa-list"> Daftar Loker</i></button>
                @endif
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tambah_data"><i class="fas fa-plus"> Tambah Stok</i></button>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah_loker"><i class="fas fa-plus"> Tambah Loker</i></button>
            </div>
      </div>

    <!-- Modal Tambah Stok -->
    <div class="modal fade" id="tambah_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-body text-left">
            <div class="row">
                  <div class="col-md-12">
                      <div class="card card-default">
                          <div class="card-header bg-info">
                            <h3 class="card-title">FORM INPUT STOK BARANG</h3>
                          </div>
                          <div class="card-body">
                            <form action="/input_master_stok" method="POST">
                              {{ csrf_field() }}
                              <input type="text" class="form-control" value="{{$tanggal}}" name="tgl_pemeriksaan" hidden>
                              <div class="kolom_asli">
                                <div class="row">
                                      <div class="col-md-12">
                                            <div class="form-group row">
                                                  <label for="inputEmail3" class="col-sm-2 col-form-label">Pilih Loker</label>
                                                  <div class="col-sm-10">
                                                  <select class="form-control select2 @error('loker_id.0') is-invalid @enderror" name="loker_id[]">
                                                        <option disabled {{ old('loker_id.0') ? '' : 'selected' }}>Silahkan Pilih..</option>
                                                        @foreach ($loker as $l)
                                                        <option value="{{$l->id}}" {{ old('loker_id.0') == $l->id ? 'selected' : '' }}>{{$l->nama_loker}}</option>
                                                        @endforeach
                                                        </select>
                                                        @error('loker_id.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                  </div>
                                                  </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                                  <div class="col-md-6">
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Vendor</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control @error('nama_vendor.0') is-invalid @enderror" placeholder="Nama Vendor.." name="nama_vendor[]" value="{{ old('nama_vendor.0') }}">
                                                        @error('nama_vendor.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Barang</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control @error('nama_barang.0') is-invalid @enderror" placeholder="Nama Barang.." name="nama_barang[]" value="{{ old('nama_barang.0') }}">
                                                        @error('nama_barang.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">QTY</label>
                                                        <div class="col-sm-10">
                                                        <input type="number" class="form-control @error('qty.0') is-invalid @enderror" placeholder="Pcs .." name="qty[]" value="{{ old('qty.0') }}">
                                                        @error('qty.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Warna</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control @error('warna.0') is-invalid @enderror" placeholder="Silahkan Di isi .." name="warna[]" value="{{ old('warna.0') }}">
                                                        @error('warna.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Bahan</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control @error('bahan.0') is-invalid @enderror" placeholder="Silahkan Di isi .." name="bahan[]" value="{{ old('bahan.0') }}">
                                                        @error('bahan.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Size</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control @error('size.0') is-invalid @enderror" placeholder="Silahkan Di isi .." name="size[]" value="{{ old('size.0') }}">
                                                        @error('size.0')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        </div>
                                                  </div>
                                            </div>
                                      </div>
                                </div>

                          <div class="kolom_copy" style="display: none;">
                                <hr>
                                <center><span class="badge badge-pill badge-warning"><h5>Form Tambah Barang</h5></span></center>
                                <hr>
                                            <div class="row">
                                                  <div class="col-md-12">
                                            <div class="form-group row">
                                                  <label for="inputEmail3" class="col-sm-2 col-form-label">Pilih Loker</label>
                                                  <div class="col-sm-10">
                                                  <select class="form-control" name="loker_id[]" disabled>
                                                        <option selected="selected">Silahkan Pilih..</option>
                                                        @foreach ($loker as $l)
                                                        <option value="{{$l->id}}">{{$l->nama_loker}}</option>
                                                        @endforeach
                                                        </select>
                                                  </div>
                                                  </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                                  <div class="col-md-6">
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Vendor</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="Nama Vendor.." name="nama_vendor[]" disabled>
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Barang</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="Nama Barang.." name="nama_barang[]" disabled>
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">QTY</label>
                                                        <div class="col-sm-10">
                                                        <input type="number" class="form-control" placeholder="Pcs .." name="qty[]" disabled>
                                                        </div>
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Warna</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="Silahkan Di isi .." name="warna[]" disabled>
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Bahan</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="Silahkan Di isi .." name="bahan[]" disabled>
                                                        </div>
                                                  </div>
                                                  <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Size</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="Silahkan Di isi .." name="size[]" disabled>
                                                        </div>
                                                  </div>
                                            </div>
                                      </div>
                                      <a href="javascript:void(0)" class="btn btn-danger btn-xl" id="BtnHapus"><i class="fa fa-trash"> Hapus</a></i>
                                       <hr>
                                </div>
                                       <a href="javascript:void(0)" class="btn btn-info btn-xl BtnTambah"><i class="fa fa-plus"> Tambah Baris</a></i>
                                       <hr>
                                      </div>
                                   </div>
                                </div>
                          </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" style="border-radius: 15px" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-xl" style="border-radius: 15px"><i class="fa fa-save"> Simpan</i></button>
                      </div>
                   </form>
                </div>
            </div>
      </div>
    </div>

    <!-- Modal Tambah Loker -->
    <div class="modal fade" id="tambah_loker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Tambah Loker Baru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="/simpan_loker" method="POST">
            {{ csrf_field() }}
            <div class="modal-body text-left">
              <div class="form-group">
                <label>ID Loker (Contoh: L10)</label>
                <input type="text" name="id_loker" class="form-control" placeholder="ID Loker.." required>
              </div>
              <div class="form-group">
                <label>Nama Loker (Contoh: Loker 10)</label>
                <input type="text" name="nama_loker" class="form-control" placeholder="Nama Loker.." required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Simpan Loker</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Daftar Loker -->
    <div class="modal fade" id="daftar_loker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title font-weight-bold">DAFTAR MASTER LOKER</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-left p-0">
            <table class="table table-striped table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">ID Loker</th>
                  <th class="text-center">Nama Loker</th>
                  <th class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($loker as $l)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td class="text-center"><span class="badge badge-dark">{{ $l->id_loker }}</span></td>
                  <td class="text-center font-weight-bold text-info">{{ $l->nama_loker }}</td>
                  <td class="text-center">
                    @if(Auth::user()->role == 'owner')
                    <a href="/hapus_loker/{{ $l->id }}" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"> Hapus</i></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
      
<div class="row ml-2 mt-4 mr-2">
      @if($join->isEmpty())
          <div class="col-md-12">
            <div class="alert alert-warning text-center">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Data Stok Kosong</h5>
                Belum ada data stok barang yang tersedia. Silakan input data di menu Master Data Stok.
            </div>
          </div>
      @else
      @foreach ($join as $item)          
      <div class="col-lg-3 col-md-6 col-12">
            @php
              $box_class = 'bg-secondary';
              if ($item->id_loker == 'L1') $box_class = 'bg-warning';
              elseif ($item->id_loker == 'L2') $box_class = 'bg-info';
              elseif ($item->id_loker == 'L3') $box_class = 'bg-dark';
              elseif ($item->id_loker == 'L4') $box_class = 'bg-danger';
              elseif ($item->id_loker == 'L5') $box_class = 'bg-primary';
            @endphp
            <div class="small-box {{ $box_class }}" style="position: relative;">
              @if(Auth::user()->role == 'owner')
              <a href="/hapus_stok_dashboard/{{ $item->id }}" 
                 class="text-white delete-stok-btn btn-delete" 
                 style="position: absolute; right: 10px; top: 10px; z-index: 10; opacity: 0.7;"
                 title="Hapus Stok">
                  <i class="fas fa-trash-alt"></i>
              </a>
              @endif
              <div class="inner">
                <h3>{{ $item->qty }} <small>Pcs</small></h3>
                <p class="mb-1 font-weight-bold">{{ $item->nama_vendor }}</p>
                <p class="text-bold mb-0" style="font-size: 1.1rem;">{{ $item->nama_barang }}</p>
                <p class="small mb-1">{{ $item->size }}, {{ $item->warna }}</p>
                <div class="mt-2 text-white-50">
                    <i class="fas fa-map-marker-alt"></i> <strong>Loker:</strong> {{ $item->loker->nama_loker ?? ($item->nama_loker ?? 'Belum ada loker') }}
                    <div class="small mt-1">
                        <i class="fas fa-sticky-note mr-1"></i> 
                        <strong>Catatan:</strong> {{ $item->order->catatan_stok ?? ($item->catatan ?? '-') }}
                        @if($item->order && $item->order->status_pembayaran)
                            <span class="badge {{ $item->order->status_pembayaran == 'lunas' ? 'badge-success' : 'badge-danger' }} ml-1" style="font-size: 0.6rem;">
                                {{ $item->order->status_pembayaran == 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
                            </span>
                        @endif
                    </div>
                </div>
              </div>
              <div class="icon">
                <i class="fas fa-boxes"></i>
              </div>
              <a href="/show_stok/{{ $item->id }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right ml-1"></i>
              </a>
            </div>
        </div>
      @endforeach
      @endif
    </div>
</div>


@endsection