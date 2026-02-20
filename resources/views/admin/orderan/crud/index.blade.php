@extends('layout.master')

@section('judul', 'Input Orderan')

@section('konten')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header bg-info">
              <h3 class="card-title">FORM INPUT ORDERAN</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="/input_orderan" method="POST">
                {{ csrf_field() }}   

                
                <input type="text" class="form-control" value="{{$tanggal}}" name="tgl_order" hidden>
              <div class="row">
                <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label>NO.PO Terakhir</label>
                            @if($po_terakhir != NULL)
                            <input type="text" class="form-control" value="{{$po_terakhir->no_po}}" disabled>
                            @else
                            <input type="text" class="form-control" value="Belum Ada" disabled>
                            @endif
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label>NO.PO</label>
                            <input type="text" class="form-control" name="no_po" value="{{ $new_po }}" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label>Nama Vendor</label>
                            <input type="text" class="form-control @error('nama_vendor') is-invalid @enderror" placeholder="Silahkan Di isi.." name="nama_vendor" value="{{ old('nama_vendor') }}">
                            @error('nama_vendor') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label>No. HP</label>
                            <input type="number" class="form-control @error('no_hp') is-invalid @enderror" placeholder="Silahkan Di isi.." name="no_hp" value="{{ old('no_hp') }}">
                            @error('no_hp') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" placeholder="Silahkan Di isi.." name="alamat" value="{{ old('alamat') }}">
                            @error('alamat') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label>Pesanan Untuk</label>
                            <input type="text" class="form-control @error('pesanan_untuk') is-invalid @enderror" placeholder="Silahkan Di isi.." name="pesanan_untuk" value="{{ old('pesanan_untuk') }}">
                            @error('pesanan_untuk') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                             <label>SISTEM DP</label>
                             <select class="form-control @error('sistem_dp') is-invalid @enderror" id="sistem_dp" name="sistem_dp">
                                <option selected="selected" disabled>Silahkan Pilih..</option>
                                <option value="YA" {{ old('sistem_dp') == 'YA' ? 'selected' : '' }}>YA</option>
                                <option value="TIDAK" {{ old('sistem_dp') == 'TIDAK' ? 'selected' : '' }}>TIDAK</option>
                              </select>
                              @error('sistem_dp') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                        <div class="col-md-4 col-12" id="total_dp">
                          <div class="form-group">
                             <label>TOTAL DP</label>
                             <input type="number" class="form-control @error('dp') is-invalid @enderror" placeholder="Masukan Nominal DP.." name="dp" value="{{ old('dp') }}">
                             @error('dp') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                             <label>Deadline Pengerjaan</label>
                             <input type="date" class="form-control @error('deadline') is-invalid @enderror" placeholder="Masukan Tanggal.." name="deadline" value="{{ old('deadline') }}">
                             @error('deadline') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                        </div>
                      </div>
                      <hr>

                    </div>
                    </div>
                    <h4 class="text-center">Detail Orderan</h4>
                    <div class="kolom_asli">
                      @php
                        $rows = old('jenis_orderan') ? count(old('jenis_orderan')) : 1;
                      @endphp

                      @for ($i = 0; $i < $rows; $i++)
                      <div class="item-row mt-4">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Jenis Orderan</label>
                                    <select name="jenis_orderan[]" class="form-control jenis-orderan-select @error('jenis_orderan.'.$i) is-invalid @enderror">
                                        <option value="" selected disabled>Pilih Jenis..</option>
                                        @foreach($jenis_orderans as $jo)
                                            <option value="{{ $jo->id }}" {{ old('jenis_orderan.'.$i) == $jo->id ? 'selected' : '' }}>{{ $jo->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger small">*Contoh: T-Shirt, PDH, Jaket</span>
                                    @error('jenis_orderan.'.$i) <br><span class="text-danger">Jenis orderan wajib diisi!</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Bahan</label>
                                    <div class="input-group">
                                        <select class="form-control bahan-select @error('bahan.'.$i) is-invalid @enderror" name="bahan[]">
                                            <option value="" selected disabled>Pilih Bahan..</option>
                                            {{-- Dynamic via JavaScript --}}
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger btn-delete-bahan" title="Hapus Bahan"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                    @error('bahan.'.$i) <span class="text-danger">Bahan wajib diisi!</span> @enderror
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Warna</label>
                                    <input type="text" class="form-control @error('warna.'.$i) is-invalid @enderror" placeholder="Masukan Detail Warna.." name="warna[]" value="{{ old('warna.'.$i) }}">
                                    @error('warna.'.$i) <span class="text-danger">Warna wajib diisi!</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Harga Satuan</label>
                                    <input type="number" class="form-control @error('harga_satuan.'.$i) is-invalid @enderror" placeholder="Masukan Harga.." name="harga_satuan[]" value="{{ old('harga_satuan.'.$i) }}">
                                    @error('harga_satuan.'.$i) <span class="text-danger">Harga satuan wajib diisi!</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>QTY (Pcs)</label>
                                    <input type="text" class="form-control @error('qty.'.$i) is-invalid @enderror" placeholder="Satuan Pcs.." name="qty[]" value="{{ old('qty.'.$i) }}">
                                    @error('qty.'.$i) <span class="text-danger">Qty Barang wajib diisi!</span> @enderror
                                </div>
                            </div>
                          </div> 

                              <!-- Harga Khusus Size Besar Section -->
                              <div class="form-group large-size-section">
                                <label>Size Besar</label>
                                <div class="card p-2 bg-light">
                                  <div class="table-responsive">
                                     <table class="table table-sm table-bordered table-large-sizes mb-2" style="background: white">
                                       <thead>
                                         <tr>
                                           <th>Size</th>
                                           <th>Tambahan Harga</th>
                                           <th>Qty</th>
                                           <th width="50">Aksi</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                          @php
                                            $json_val = old('size_large_json.'.$i, '[]');
                                            $decoded_sizes = json_decode($json_val, true);
                                            $sizes = is_array($decoded_sizes) ? $decoded_sizes : [];
                                          @endphp

                                          @foreach($sizes as $size)
                                            <tr>
                                                <td>
                                                    <select class="form-control form-control-sm size-select">
                                                        @foreach(['XXL','3XL','4XL','5XL','6XL','ALL SIZE'] as $opt)
                                                            <option value="{{ $opt }}" {{ isset($size['size']) && $size['size'] == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control form-control-sm price-input" value="{{ $size['price'] ?? 0 }}" placeholder="Rp"></td>
                                                <td><input type="number" class="form-control form-control-sm qty-input" value="{{ $size['qty'] ?? 0 }}" placeholder="Qty"></td>
                                                <td><button type="button" class="btn btn-xs btn-danger btn-remove-size"><i class="fas fa-trash"></i></button></td>
                                            </tr>
                                          @endforeach
                                       </tbody>
                                     </table>
                                  </div>
                                  <button type="button" class="btn btn-xs btn-outline-primary btn-add-size" style="width: 150px"><i class="fas fa-plus"></i> Tambah Size XXL</button>
                                  <input type="hidden" name="size_large_json[]" class="size-large-json" value="{{ old('size_large_json.'.$i, '[]') }}">
                                </div>
                              </div>
                              <!-- End Section -->
                               <!-- Detail Ukuran Section -->
                               <div class="form-group size-details-section">
                                 <label>Detail Ukuran (Size & Qty)</label>
                                 <div class="card p-2 bg-light">
                                   <div class="table-responsive">
                                      <table class="table table-sm table-bordered table-size-details mb-2" style="background: white">
                                        <thead>
                                          <tr>
                                            <th>Ukuran</th>
                                            <th>Jumlah (Qty)</th>
                                            <th width="50">Aksi</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                           @php
                                             $size_details_val = old('size_details_json.'.$i, '[]');
                                             $decoded_size_details = json_decode($size_details_val, true);
                                             $size_details = is_array($decoded_size_details) ? $decoded_size_details : [];
                                           @endphp

                                           @foreach($size_details as $sd)
                                             <tr>
                                                 <td>
                                                     <select class="form-control form-control-sm size-name-input">
                                                         <option value="S" {{ ($sd['size'] ?? '') == 'S' ? 'selected' : '' }}>S</option>
                                                         <option value="M" {{ ($sd['size'] ?? '') == 'M' ? 'selected' : '' }}>M</option>
                                                         <option value="L" {{ ($sd['size'] ?? '') == 'L' ? 'selected' : '' }}>L</option>
                                                         <option value="XL" {{ ($sd['size'] ?? '') == 'XL' ? 'selected' : '' }}>XL</option>
                                                     </select>
                                                 </td>
                                                 <td><input type="number" class="form-control form-control-sm size-qty-input" value="{{ $sd['qty'] ?? 0 }}" placeholder="Qty"></td>
                                                 <td><button type="button" class="btn btn-xs btn-danger btn-remove-size-detail"><i class="fas fa-trash"></i></button></td>
                                             </tr>
                                           @endforeach
                                        </tbody>
                                      </table>
                                   </div>
                                   <div class="row align-items-center mb-2">
                                       <div class="col-md-6">
                                           <button type="button" class="btn btn-xs btn-outline-primary btn-add-size-detail" style="width: 150px"><i class="fas fa-plus"></i> Tambah Ukuran</button>
                                       </div>
                                       <div class="col-md-6 text-right">
                                           <div class="size-summary p-2 border rounded bg-white small">
                                               Total PCS: <span class="summary-total text-bold">0</span> | 
                                               Terpakai: <span class="summary-used text-primary text-bold">0</span> | 
                                               Sisa: <span class="summary-remaining text-success text-bold">0</span>
                                           </div>
                                       </div>
                                   </div>
                                   <input type="hidden" name="size_details_json[]" class="size-details-json-input" value="{{ old('size_details_json.'.$i, '[]') }}">
                                 </div>
                               </div>
                               <!-- End Section -->
                            </div>
                           </div>
                           @if($i > 0)
                            <a href="javascript:void(0)" class="btn btn-danger btn-xl" onclick="this.closest('.row').remove()"><i class="fa fa-trash"> Hapus</i></a>
                            <hr>
                           @endif
                           @endfor
                           
                         <a href="javascript:void(0)" class="btn btn-info btn-xl BtnTambah"><i class="fa fa-plus"> Tambah</a></i>
                         <hr>
                         </div>
       
                            {{-- BATASAN --}}
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Pembelanjaan Bahan</label>
                                    <select class="form-control" name="pembelanjaan_bahan" id="pembelanjaan_bahan">
                                      <option selected disabled>Silahkan Pilih..</option>
                                      <option value="kilo" {{ old('pembelanjaan_bahan') == 'kilo' ? 'selected' : '' }}>Kilo</option>
                                      <option value="yard" {{ old('pembelanjaan_bahan') == 'yard' ? 'selected' : '' }}>Yard</option>
                                      <option value="roll" {{ old('pembelanjaan_bahan') == 'roll' ? 'selected' : '' }}>Roll/Gulungan</option>
                                    </select>
                                    <small id="pembelanjaan_bahan_info" class="text-info font-weight-bold mt-2 display-block"></small>
                                  </div> 
                                  <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Rp.</label>
                                    <div class="col-sm-6">
                                      <input type="number" class="form-control" placeholder="Masukan Harga.." name="harga" value="{{ old('harga') }}">
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <h4 class="text-center"><strong><u>HPP</u></strong></h4>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">CMT</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_cmt" value="{{ old('hpp_cmt') }}">
                                  </div>
                                </div>
                                    <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Bordir</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_bordir" value="{{ old('hpp_bordir') }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Sablon</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_sablon" value="{{ old('hpp_sablon') }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Benang Jahit</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_benang" value="{{ old('hpp_benang') }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Packaging</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_packaging" value="{{ old('hpp_packaging') }}">
                                  </div>
                                </div>
                              </div>
                            </div>                          
                        <div class="row">
                          <div class="col-md-6">
                            
                          </div>
                          <div class="col-md-2">
                          </div>
                          <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-block btn-xl"><i class="fa fa-calculator"> Hitung Orderan</i></button>                           
                          </div>
                        </div>
                      </form>
                      
                            <div id="item-template" style="display: none">
                               <div class="item-row mt-4">
                                  <div class="col-md-12">
                                   <div class="row">
                                     <div class="col-md-6 col-12">
                                         <div class="form-group">
                                             <label>Jenis Orderan</label>
                                             <select name="jenis_orderan[]" class="form-control jenis-orderan-select">
                                                 <option value="" selected disabled>Pilih Jenis..</option>
                                                 @foreach($jenis_orderans as $jo)
                                                     <option value="{{ $jo->id }}">{{ $jo->nama_jenis }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-md-6 col-12">
                                         <div class="form-group">
                                             <label>Bahan</label>
                                             <div class="input-group">
                                                 <select class="form-control bahan-select" name="bahan[]">
                                                     <option value="" selected disabled>Pilih Bahan..</option>
                                                 </select>
                                                 <div class="input-group-append">
                                                     <button type="button" class="btn btn-outline-danger btn-delete-bahan" title="Hapus Bahan"><i class="fas fa-trash"></i></button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                   </div>
                                   <div class="row">
                                     <div class="col-md-4 col-12">
                                         <div class="form-group">
                                             <label>Warna</label>
                                             <input type="text" class="form-control" placeholder="Masukan Detail Warna.." name="warna[]">
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-12">
                                         <div class="form-group">
                                             <label>Harga Satuan</label>
                                             <input type="number" class="form-control" placeholder="Masukan Harga.." name="harga_satuan[]">
                                         </div>
                                     </div>
                                     <div class="col-md-4 col-12">
                                         <div class="form-group">
                                             <label>QTY (Pcs)</label>
                                             <input type="text" class="form-control" placeholder="Satuan Pcs.." name="qty[]">
                                         </div>
                                     </div>
                                   </div>

                                   <!-- Harga Khusus Size Besar Section -->
                                   <div class="form-group large-size-section">
                                     <label>Size Besar</label>
                                     <div class="card p-2 bg-light">
                                       <div class="table-responsive">
                                          <table class="table table-sm table-bordered table-large-sizes mb-2" style="background: white">
                                            <thead>
                                              <tr>
                                                <th>Size</th>
                                                <th>Tambahan Harga</th>
                                                <th>Qty</th>
                                                <th width="50">Aksi</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          </table>
                                       </div>
                                       <button type="button" class="btn btn-xs btn-outline-primary btn-add-size" style="width: 150px"><i class="fas fa-plus"></i> Tambah Size XXL</button>
                                       <input type="hidden" name="size_large_json[]" class="size-large-json" value="[]">
                                     </div>
                                   </div>
                                  <!-- End Section --> 
                                   <!-- Detail Ukuran Section -->
                                   <div class="form-group size-details-section">
                                     <label>Detail Ukuran (Size & Qty)</label>
                                     <div class="card p-2 bg-light">
                                       <div class="table-responsive">
                                          <table class="table table-sm table-bordered table-size-details mb-2" style="background: white">
                                            <thead>
                                              <tr>
                                                <th>Ukuran</th>
                                                <th>Jumlah (Qty)</th>
                                                <th width="50">Aksi</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          </table>
                                       </div>
                                       <div class="row align-items-center mb-2">
                                           <div class="col-md-6">
                                               <button type="button" class="btn btn-xs btn-outline-primary btn-add-size-detail" style="width: 150px"><i class="fas fa-plus"></i> Tambah Ukuran</button>
                                           </div>
                                           <div class="col-md-6 text-right">
                                               <div class="size-summary p-2 border rounded bg-white small">
                                                   Total PCS: <span class="summary-total text-bold">0</span> | 
                                                   Terpakai: <span class="summary-used text-primary text-bold">0</span> | 
                                                   Sisa: <span class="summary-remaining text-success text-bold">0</span>
                                               </div>
                                           </div>
                                       </div>
                                       <input type="hidden" name="size_details_json[]" class="size-details-json-input" value="[]">
                                     </div>
                                   </div>
                                   <!-- End Section --> 

                                   <a href="javascript:void(0)" class="btn btn-danger btn-xl btn-remove-row"><i class="fa fa-trash"> Hapus Item</i></a>
                                   <hr>
                                  </div>
                               </div>
                            </div>
                     </div>




    

<!-- Modal Tambah Bahan -->
<div class="modal fade" id="modalTambahBahan" tabindex="-1" role="dialog" aria-labelledby="modalTambahBahanLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalTambahBahanLabel">Tambah Bahan Baru</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formTambahBahan">
          <div class="form-group">
            <label>Jenis Orderan</label>
            <input type="text" class="form-control" id="modal_jenis_orderan_nama" readonly>
            <input type="hidden" id="modal_jenis_orderan_id" name="jenis_orderan_id">
          </div>
          <div class="form-group">
             <label>Nama Bahan <span class="text-danger">*</span></label>
             <input type="text" class="form-control" name="nama_bahan" id="modal_nama_bahan" placeholder="Contoh: Combed 30s" required>
          </div>
          <div class="form-group">
             <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
             <input type="number" class="form-control" name="harga_satuan" id="modal_harga_satuan" placeholder="0" required min="1">
          </div>

          <div class="alert alert-danger d-none" id="modalError"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSimpanBahan">Simpan</button>
      </div>
    </div>
  </div>
</div>
    
@endsection

@section('scripts')
<script type="text/javascript">
    var userRole = "{{ Auth::user()->role ?? '' }}";

    // LOGIC TAMBAH/HAPUS ITEM
    $(document).ready(function() {
        $('.BtnTambah').on('click', function() {
            var clone = $('#item-template .item-row').clone();
            $('.kolom_asli').append(clone);
        });

        $(document).on('click', '.btn-remove-row', function() {
            Swal.fire({
                title: 'Hapus Item?',
                text: "Data item ini akan dihapus dari form",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('.item-row').remove();
                }
            });
        });

        // LOGIC DYNAMIC BAHAN
        function loadBahan(jenis_id, bahanSelect, selectedBahan = null) {
            if (jenis_id) {
                bahanSelect.html('<option value="" selected disabled>Loading...</option>');
                $.ajax({
                    url: "{{ url('/api/bahan') }}/" + jenis_id,
                    type: 'GET',
                    success: function(data) {
                        bahanSelect.html('<option value="" selected disabled>Pilih Bahan..</option>');
                        $.each(data, function(key, value) {
                            var selected = (selectedBahan == value.nama_bahan) ? 'selected' : '';
                            // Handle potential missing harga_size_besar property gracefully
                            var largePrice = value.harga_size_besar ? value.harga_size_besar : 0;
                            bahanSelect.append('<option value="' + value.nama_bahan + '" ' + selected + ' data-price="' + value.harga_satuan + '" data-large-price="' + largePrice + '">' + value.nama_bahan + '</option>');
                        });
                        
                        // Add "Tambah Bahan" option if Owner
                        if(userRole === 'owner') {
                             bahanSelect.append('<option value="ADD_NEW_BAHAN" class="font-weight-bold text-primary">+ Tambah Bahan Baru</option>');
                        }

                        // Trigger change to update prices if any bahan was selected
                        if (selectedBahan) {
                            bahanSelect.trigger('change');
                        }
                        // Refresh Select2 if it exists
                        if (bahanSelect.hasClass('select2-hidden-accessible')) {
                            bahanSelect.trigger('change.select2');
                        }
                    }
                });
            } else {
                bahanSelect.html('<option value="" selected disabled>Pilih Bahan..</option>');
            }
        }

        $(document).on('change', '.jenis-orderan-select', function() {
            var jenis_id = $(this).val();
            var bahanSelect = $(this).closest('.item-row').find('.bahan-select');
            loadBahan(jenis_id, bahanSelect);
        });

        // Handle old values on page load
        $('.jenis-orderan-select').each(function(index) {
            var jenis_id = $(this).val();
            var bahanSelect = $(this).closest('.item-row').find('.bahan-select');
            var oldBahan = @json(old('bahan'));
            var selectedBahan = (oldBahan && oldBahan[index]) ? oldBahan[index] : null;
            
            if (jenis_id) {
                loadBahan(jenis_id, bahanSelect, selectedBahan);
            }
        });
    });

// LOGIC SIZE BESAR
    $(document).on('click', '.btn-add-size', function() {
        var section = $(this).closest('.large-size-section');
        var tbody = section.find('tbody');
        var defaultPrice = section.data('default-price') || 0;
        
        var row = `
            <tr>
                <td>
                    <select class="form-control form-control-sm size-select">
                        <option value="XXL">XXL</option>
                        <option value="3XL">3XL</option>
                        <option value="4XL">4XL</option>
                        <option value="5XL">5XL</option>
                        <option value="6XL">6XL</option>
                        <option value="ALL SIZE">ALL SIZE</option>
                    </select>
                </td>
                <td><input type="number" class="form-control form-control-sm price-input" value="${defaultPrice}" placeholder="Rp"></td>
                <td><input type="number" class="form-control form-control-sm qty-input" value="0" placeholder="Qty"></td>
                <td><button type="button" class="btn btn-xs btn-danger btn-remove-size"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        tbody.append(row);
        updateSizeJson(section);
    });

    $(document).on('change', '.bahan-select', function() {
        var option = $(this).find(':selected');
        var price = option.data('price');
        var largePrice = option.data('large-price');
        
        // Find the main container for this detail row.
        // Structure: .row mt-4 > .col-md-12 > .form-group...
        // The select is in .col-sm-10 inside a .form-group inside .col-md-12
        var mainContainer = $(this).closest('.col-md-12');
        
        // Update Harga Satuan
        if(price !== undefined) {
             mainContainer.find('input[name="harga_satuan[]"]').val(price);
        }

        // Update Large Size Logic
        var largeSizeSection = mainContainer.find('.large-size-section');
        
        // Store default large price for new rows
        if(largePrice !== undefined) {
            largeSizeSection.data('default-price', largePrice);
            
            // Update existing large size rows prices
            largeSizeSection.find('.price-input').val(largePrice);
            updateSizeJson(largeSizeSection);
        }
    });

    $(document).on('click', '.btn-remove-size', function() {
        var section = $(this).closest('.large-size-section');
        $(this).closest('tr').remove();
        updateSizeJson(section);
    });

    $(document).on('change keyup', '.size-select, .price-input, .qty-input', function() {
        updateSizeJson($(this).closest('.large-size-section'));
    });

    function updateSizeJson(section) {
        var data = [];
        section.find('tbody tr').each(function() {
            var size = $(this).find('.size-select').val();
            var price = $(this).find('.price-input').val();
            var qty = $(this).find('.qty-input').val();
            if(size) {
                data.push({size: size, price: price, qty: qty});
            }
        });
        section.find('.size-large-json').val(JSON.stringify(data));

        // TRIGGER summary update in the main section
        var mainContainer = section.closest('.col-md-12, .item-row');
        var sizeDetailsSection = mainContainer.find('.size-details-section');
        if(sizeDetailsSection.length > 0) {
            updateSizeDetailsJson(sizeDetailsSection);
        }
    }

    // LOGIC SIZE DETAILS (GENERAL)
    $(document).on('click', '.btn-add-size-detail', function() {
        var section = $(this).closest('.size-details-section');
        var tbody = section.find('tbody');
        
        var row = `
            <tr>
                <td>
                    <select class="form-control form-control-sm size-name-input">
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </td>
                <td><input type="number" class="form-control form-control-sm size-qty-input" value="0" placeholder="Qty"></td>
                <td><button type="button" class="btn btn-xs btn-danger btn-remove-size-detail"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        tbody.append(row);
        updateSizeDetailsJson(section);
    });

    $(document).on('click', '.btn-remove-size-detail', function() {
        var section = $(this).closest('.size-details-section');
        $(this).closest('tr').remove();
        updateSizeDetailsJson(section);
    });

    $(document).on('change keyup', '.size-name-input, .size-qty-input, input[name="qty[]"]', function() {
        var section = $(this).closest('.size-details-section');
        if (section.length === 0) {
            // If main QTY changed, update all summaries
            $('.size-details-section').each(function() {
                updateSizeDetailsJson($(this));
            });
        } else {
            updateSizeDetailsJson(section);
        }
    });

    function updateSizeDetailsJson(section) {
        var container = section.closest('.col-md-12, .item-row');
        var totalInput = container.find('input[name="qty[]"]');
        var totalPcs = parseInt(totalInput.val()) || 0;
        
        var data = [];
        var usedPcs = 0;
        
        // Sum Normal Sizes
        section.find('tbody tr').each(function() {
            var size = $(this).find('.size-name-input').val();
            var qty = parseInt($(this).find('.size-qty-input').val()) || 0;
            if(size) {
                data.push({size: size, qty: qty});
                usedPcs += qty;
            }
        });

        // ALSO Sum Large Sizes from sibling section
        var largeSection = container.find('.large-size-section');
        largeSection.find('tbody tr').each(function() {
            var qty = parseInt($(this).find('.qty-input').val()) || 0;
            usedPcs += qty;
        });

        var remaining = totalPcs - usedPcs;
        
        // Update Summary UI
        var summary = section.find('.size-summary');
        summary.find('.summary-total').text(totalPcs);
        summary.find('.summary-used').text(usedPcs);
        summary.find('.summary-remaining').text(remaining);

        // Validation Display
        if (remaining < 0) {
            summary.find('.summary-remaining').removeClass('text-success').addClass('text-danger');
            summary.addClass('border-danger bg-light-danger');
            // Optional: Block submit button if any section has error
            $('button[type="submit"]').prop('disabled', true).addClass('btn-secondary').removeClass('btn-success');
        } else {
            summary.find('.summary-remaining').removeClass('text-danger').addClass('text-success');
            summary.removeClass('border-danger bg-light-danger');
            
            // Check if ANY summary still has error before enabling submit
            var hasError = false;
            $('.size-summary').each(function() {
                var used = parseInt($(this).find('.summary-used').text()) || 0;
                var total = parseInt($(this).find('.summary-total').text()) || 0;
                if (used > total) hasError = true;
            });
            if (!hasError) {
                $('button[type="submit"]').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
            }
        }

        section.find('.size-details-json-input').val(JSON.stringify(data));
    }

    // Initialize summaries on load
    $(document).ready(function() {
        $('.size-details-section').each(function() {
            updateSizeDetailsJson($(this));
        });
    });

    // LOGIC PEMBELANJAAN BAHAN AUTOMATION
    $(document).ready(function() {
        var hppDefaults = @json(config('konveksi.hpp_defaults'));

        // Check if value is selected on load (e.g. after validation error) and update label
        var currentSelected = $('#pembelanjaan_bahan').val();
        if(currentSelected && hppDefaults[currentSelected] && hppDefaults[currentSelected].label) {
            $('#pembelanjaan_bahan_info').text(hppDefaults[currentSelected].label);
        }

        $('#pembelanjaan_bahan').on('change', function() {
            var selected = $(this).val();
            var defaults = hppDefaults[selected];

            // Reset or Set values
            if (defaults) {
                $('input[name="hpp_cmt"]').val(defaults.cmt);
                $('input[name="hpp_bordir"]').val(defaults.bordir);
                $('input[name="hpp_sablon"]').val(defaults.sablon);
                $('input[name="hpp_benang"]').val(defaults.benang);
                $('input[name="hpp_packaging"]').val(defaults.packaging);
                
                // Set harga bahan if available
                if (defaults.harga_bahan !== undefined) {
                    $('input[name="harga"]').val(defaults.harga_bahan);
                }

                // Update Label
                if (defaults.label) {
                    $('#pembelanjaan_bahan_info').text(defaults.label);
                } else {
                    $('#pembelanjaan_bahan_info').text('');
                }
            } else {
                // If "Silahkan Pilih.." or unknown, maybe clear or leave as is?
                // User requirement: "Jika dropdown diubah, HPP akan ter-update ulang". 
                // If invalid selection, maybe don't clear to avoid accidental data loss? 
                // But user didn't ask to clear. safely do nothing or show nothing.
                $('#pembelanjaan_bahan_info').text('');
            }
        });
    });

    // LOGIC TAMBAH BAHAN BARU VIA MODAL
    $(document).on('change', '.bahan-select', function() {
        var selectedVal = $(this).val();
        if(selectedVal === 'ADD_NEW_BAHAN') {
            var jenisId = $(this).closest('.item-row').find('.jenis-orderan-select').val();
            var jenisNama = $(this).closest('.item-row').find('.jenis-orderan-select option:selected').text();
            
            if(!jenisId) {
               Swal.fire('Peringatan', 'Pilih Jenis Orderan terlebih dahulu!', 'warning');
               $(this).val(''); // Reset
               return;
            }

            // Set Modal Data
            $('#modal_jenis_orderan_id').val(jenisId);
            $('#modal_jenis_orderan_nama').val(jenisNama);
            $('#formTambahBahan')[0].reset(); 
            // Re-set the readonly value incase reset cleared it
            $('#modal_jenis_orderan_nama').val(jenisNama);
            $('#modalError').addClass('d-none').text('');
            
            // Keep reference to the select that triggered this
            $('#modalTambahBahan').data('trigger-select', $(this));
            
            $('#modalTambahBahan').modal('show');
            
            // Reset select to empty/previous to avoid showing "ADD_NEW_BAHAN" as selected value visually if cancelled
            $(this).val(''); 
        }
    });

    $('#btnSimpanBahan').click(function() {
         var btn = $(this);
         var data = {
             jenis_orderan_id: $('#modal_jenis_orderan_id').val(),
             nama_bahan: $('#modal_nama_bahan').val(),
             harga_satuan: $('#modal_harga_satuan').val(),
             _token: '{{ csrf_token() }}'
         };

         // Client validation
         if(!data.nama_bahan || !data.harga_satuan) {
             $('#modalError').removeClass('d-none').text('Nama Bahan dan Harga Satuan wajib diisi!');
             return;
         }
         
         btn.prop('disabled', true).text('Menyimpan...');

         $.ajax({
             url: "{{ url('/master-bahan/store-ajax') }}",
             type: "POST",
             data: data,
             success: function(response) {
                 btn.prop('disabled', false).text('Simpan');
                 
                 if(response.status === 'success') {
                     $('#modalTambahBahan').modal('hide');
                     
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                     });
                     
                     // Helper: Append Option Dynamically
                     var newBahan = response.data;
                     var largePrice = newBahan.harga_size_besar ? newBahan.harga_size_besar : 0;
                     var optionHtml = '<option value="' + newBahan.nama_bahan + '" data-price="' + newBahan.harga_satuan + '" data-large-price="' + largePrice + '">' + newBahan.nama_bahan + '</option>';

                     // Refresh ALL bahan selects that have the SAME jenis_orderan_id
                     var jenisId = data.jenis_orderan_id;
                     var triggeringSelect = $('#modalTambahBahan').data('trigger-select');
                     
                     $('.jenis-orderan-select').each(function() {
                         if($(this).val() == jenisId) {
                             var targetSelect = $(this).closest('.item-row').find('.bahan-select');

                             // Check if option already exists to be safe
                             if (targetSelect.find("option[value='" + newBahan.nama_bahan + "']").length === 0) {
                                 // Append BEFORE "ADD_NEW_BAHAN" option if it exists
                                 var addNewOption = targetSelect.find('option[value="ADD_NEW_BAHAN"]');
                                 if(addNewOption.length > 0) {
                                     $(optionHtml).insertBefore(addNewOption);
                                 } else {
                                     targetSelect.append(optionHtml);
                                 }
                             }
                             
                             // If this is the triggering row, auto-select the NEW bahan
                             if (targetSelect[0] === triggeringSelect[0]) {
                                 targetSelect.val(newBahan.nama_bahan).trigger('change');
                             }
                         }
                     });
                     
                 }
             },
             error: function(xhr) {
                 btn.prop('disabled', false).text('Simpan');
                 var msg = 'Terjadi kesalahan';
                 if(xhr.responseJSON) {
                     if(xhr.responseJSON.message) {
                         msg = xhr.responseJSON.message;
                     } else if(xhr.responseJSON.errors) {
                         // Extract first error
                         var errors = xhr.responseJSON.errors;
                         msg = Object.values(errors)[0][0];
                     }
                 }
                 // Stay on modal request
                 $('#modalError').removeClass('d-none').text(msg);
             }
         });
    });

    // LOGIC HAPUS BAHAN
    $(document).on('click', '.btn-delete-bahan', function() {
        var inputGroup = $(this).closest('.input-group');
        var select = inputGroup.find('.bahan-select');
        var namaBahan = select.val();
        var jenisId = $(this).closest('.item-row').find('.jenis-orderan-select').val();

        if(!namaBahan || namaBahan === 'ADD_NEW_BAHAN') {
            Swal.fire('Info', 'Pilih bahan yang ingin dihapus terlebih dahulu', 'info');
            return;
        }

        Swal.fire({
            title: 'Hapus Bahan?',
            text: "Anda akan menghapus bahan: " + namaBahan + ". Pastikan bahan ini tidak digunakan di orderan lain.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                 Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: "{{ url('/master-bahan/delete-ajax') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        nama_bahan: namaBahan,
                        jenis_orderan_id: jenisId
                    },
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('Berhasil!', response.message, 'success');
                            
                            // Remove option from ALL selects of same type
                            $('.jenis-orderan-select').each(function() {
                                if($(this).val() == jenisId) {
                                    var targetSelect = $(this).closest('.item-row').find('.bahan-select');
                                    // Remove the option from the DOM
                                    targetSelect.find('option').filter(function() {
                                        return $(this).val() == namaBahan; 
                                    }).remove();
                                    
                                    // If it was selected, reset
                                    if(targetSelect.val() == null || targetSelect.val() == namaBahan) {
                                        targetSelect.val('').trigger('change');
                                    }
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                         var msg = 'Terjadi kesalahan sistem';
                         if(xhr.responseJSON && xhr.responseJSON.message) {
                             msg = xhr.responseJSON.message;
                         }
                         Swal.fire('Gagal!', msg, 'error');
                    }
                });
            }
        });
    });
</script>
@endsection