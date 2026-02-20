@extends('layout.master')

@section('judul', 'Halaman Penggajian Karyawan')

@section('konten')
<div class="row">
      <div class="col-md-12">
            <div class="card">
                  <div class="card-header bg-dark">
                        Pembayaran Gaji Packaging
                  </div>
                  <div class="card-body">
                    <form action="/penggajian/add_packaging" method="POST">
                       {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-1 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{$tanggal}}" name="tanggal" readonly>
                        </div>
                      </div>
                      <hr>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Vendor</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('vendor') is-invalid @enderror" id="vendor" name="vendor">
                                    <option disabled {{ old('vendor') ? '' : 'selected' }}>Silahkan Pilih..</option>
                                    @foreach ($vendor as $item)
                                    <option value="{{$item->nama_vendor}}" {{ old('vendor') == $item->nama_vendor ? 'selected' : '' }}>{{$item->nama_vendor}}</option>
                                    @endforeach
                                </select>
                                @error('vendor')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                          </div>
                          <div class="kolom_asli">
                            <div class="form-group row">
                              <label for="inputEmail3" class="col-sm-2 col-form-label">Jenis Pekerjaan</label>
                              <div class="col-sm-9">
                                  <select class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan">
                                      <option value="Packaging" selected readonly>Packaging</option>
                                    </select>
                                  </div>
                               </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('deskripsi.0') is-invalid @enderror" placeholder="Silahkan di isi" name="deskripsi[]" value="{{ old('deskripsi.0') }}">
                                        @error('deskripsi.0')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">QTY</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control @error('qty_barang.0') is-invalid @enderror" placeholder="Pcs.." name="qty_barang[]" value="{{ old('qty_barang.0') }}" readonly>
                                      @error('qty_barang.0')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Pekerja</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control @error('nama_pekerja.0') is-invalid @enderror" placeholder="Silahkan di isi.." name="nama_pekerja[]" value="{{ old('nama_pekerja.0') }}">
                                      @error('nama_pekerja.0')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Harga Jasa</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control @error('harga_jasa.0') is-invalid @enderror" placeholder="Silahkan di isi.." name="harga_jasa[]" value="{{ old('harga_jasa.0') }}">
                                      @error('harga_jasa.0')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">QTY Jasa</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control @error('qty_pekerjaan.0') is-invalid @enderror" placeholder="Pcs.." name="qty_pekerjaan[]" value="{{ old('qty_pekerjaan.0') }}">
                                      @error('qty_pekerjaan.0')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                                    </div>
                                  </div>
                              <div class="form-group row">
                                 <label for="inputEmail3" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                    <select class="form-control @error('keterangan.0') is-invalid @enderror" name="keterangan[]">
                                      <option disabled {{ old('keterangan.0') ? '' : 'selected' }}>Silahkan Pilih..</option>
                                      <option value="sudah_di_bayar" {{ old('keterangan.0') == 'sudah_di_bayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                                      <option value="belum_di_bayar" {{ old('keterangan.0') == 'belum_di_bayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                    </select>
                                    @error('keterangan.0')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                  </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-sm-9">
                                    <a href="#" class="btn btn-success btn-sm BtnTambah"><i class="fas fa-plus"> Tambah</i></a>
                              </div>
                            </div>
                        </div>

                        <hr>

                              <div class="kolom_copy" style="display: none">
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="deskripsi[]" disabled>
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">QTY</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" placeholder="Pcs.." name="qty_barang[]" disabled readonly>
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Pekerja</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="nama_pekerja[]" disabled>
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Harga Jasa</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" placeholder="Silahkan Di isi.." name="harga_jasa[]" disabled>
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">QTY Jasa</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" placeholder="Pcs.." name="qty_pekerjaan[]" disabled>
                                    </div>
                                  </div>
                              <div class="form-group row">
                                 <label for="inputEmail3" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                    <select class="form-control" name="keterangan[]" disabled>
                                      <option selected="selected" disabled>Silahkan Pilih..</option>
                                      <option value="sudah_di_bayar">Sudah Dibayar</option>
                                      <option value="belum_di_bayar">Belum Dibayar</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-sm-9">
                                    <a href="#" class="btn btn-danger btn-sm" id="BtnHapus"><i class="fas fa-trash"> Hapus</i></a>
                              </div>
                              </div>
                        </div>

                        <hr>
                        <div class="row">
                          <div class="col-md-6 mb-2 mb-md-0">
                                <a href="javascript:window.history.go(-1);" class="btn btn-outline-dark btn-sm" style="border-radius: 15px"><i class="fa fa-arrow-left"> Kembali</i></a>
                          </div>
                          <div class="col-md-4">
                          </div>
                          <div class="col-md-2">
                            <button type="submit" class="btn btn-success btn-block btn-xl" style="border-radius: 15px"><i class="fa fa-save"> Simpan</i></button>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>



@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var currentQty = 0;

        function updateQty() {
            var vendorName = $('#vendor').val();
            if (vendorName) {
                $.ajax({
                    url: '/api/get-vendor-qty',
                    type: 'GET',
                    data: { vendor: vendorName },
                    success: function(response) {
                        currentQty = response.total_qty;
                        $('input[name="qty_barang[]"]').val(currentQty);
                    },
                    error: function() {
                        console.error('Failed to fetch vendor qty');
                    }
                });
            } else {
                currentQty = 0;
                $('input[name="qty_barang[]"]').val(0);
            }
        }

        $('#vendor').change(function() {
            updateQty();
        });

        if ($('#vendor').val()) {
            updateQty();
        }
        
        $('body').on('click', '.BtnTambah', function() {
            setTimeout(function() {
                var lastRow = $('body').find('.kolom_asli:last');
                lastRow.find('input[name="qty_barang[]"]').val(currentQty);
            }, 100);
        });
    });
</script>
@endsection
