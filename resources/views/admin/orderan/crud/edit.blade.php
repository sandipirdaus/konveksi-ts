@extends('layout.master')

@section('judul', 'Edit Pesanan')

@section('konten')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header bg-info">
              <h3 class="card-title">FORM EDIT PESANAN</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <form action="/edit_orderan/{{$data->id}}" method="POST">
                @method('PATCH')
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">NO.PO</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="no_po" value="{{$data->no_po}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tanggal Pemesanan</label>
                        <div class="col-sm-10">
                         <input type="date" class="form-control" placeholder="Silahkan Di isi.." name="tanggal" value="{{$data->tgl_order}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Vendor</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="nama_vendor" value="{{$data->nama_vendor}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">No. HP</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="no_hp" value="{{$data->no_hp}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="alamat" value="{{$data->alamat}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Pesanan Untuk</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="pesanan_untuk" value="{{$data->pesanan_untuk}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">SISTEM DP</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="sistem_dp" name="sistem_dp">
                                <option value="{{$data->sistem_dp}}">{{$data->sistem_dp}}</option>
                                <option value="YA">YA</option>
                                <option value="TIDAK">TIDAK</option>
                              </select>                        
                            </div>
                         </div>
                         <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Deadline Pengerjaan</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" placeholder="Masukan Tanggal.." name="deadline" value="{{$data->deadline}}"
                           >
                            </div>                       
                        </div>
                         <h4 class="text-center">TOTAL DP</h4>
                         <div class="row">
                             <div class="col-md-12">
                               <div class="form-group row">
                                 <label for="inputEmail3" class="col-sm-2 col-form-label">Rp.</label>
                                 @if ($data->dp != NULL)
                                 <div class="col-sm-10">
                                  <input type="number" class="form-control" value="{{($data->dp)}}" id="jumlah_dp" name="dp">
                                  @else     
                                    <div class="col-sm-10">
                                      <input type="number" class="form-control" value="0" id="jumlah_dp" name="dp">
                                       @endif
                                     </div>                       
                                   </div>
                                 </div>
                             </div>
                             <div class="form-group row">
                              <label for="inputEmail3" class="col-sm-2 col-form-label">Status Orderan</label>
                              <div class="col-sm-10">
                                  <select class="form-control" id="status" name="status">
                                      @if ($data->status == 0)
                                      <option value="{{$data->status}}">Belum Di Produksi</option>                                         
                                      @elseif ($data->status == 1)
                                      <option value="{{$data->status}}">Proses Produksi</option>
                                      @elseif ($data->status == 2)
                                      <option value="{{$data->status}}">Siap Dikirim</option>
                                      @elseif ($data->status == 3)
                                      <option value="{{$data->status}}">Selesai</option>
                                      @endif
                                      <option value="0">Belum Di Produksi</option>
                                      <option value="1">Proses Produksi</option>
                                      <option value="2">Siap Dikirim</option>
                                      <option value="3">Selesai</option>
                                    </select>                        
                                  </div>
                               </div> 
                          </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                          <h4 class="text-center"><b>Detail Orderan</b></h4>
                        </div>

                        <div id="container-orderan">
                            @foreach($jenis_orderan_ids as $x => $jo_id)
                                <div class="kolom_asli border-bottom mb-4 pb-4 px-3" style="background: #f8f9fa; border-radius: 10px;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="text-primary mb-0">Item #{{ $x + 1 }}</h4>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item"><i class="fas fa-trash"></i> Hapus Item</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Jenis Orderan</label>
                                                <div class="col-sm-9">
                                                    <select name="jenis_orderan[]" class="form-control jenis-orderan-select @error('jenis_orderan.'.$x) is-invalid @enderror">
                                                        <option value="" selected disabled>Pilih Jenis..</option>
                                                        @foreach($jenis_orderans as $jo)
                                                            <option value="{{ $jo->id }}" {{ old('jenis_orderan.'.$x, $jo_id) == $jo->id ? 'selected' : '' }}>{{ $jo->nama_jenis }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Bahan</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control bahan-select @error('bahan.'.$x) is-invalid @enderror" name="bahan[]" data-selected="{{ old('bahan.'.$x, $bahan[$x] ?? '') }}">
                                                        <option value="" selected disabled>Pilih Bahan..</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Warna</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control @error('warna.'.$x) is-invalid @enderror" name="warna[]" value="{{ old('warna.'.$x, $warna[$x] ?? '') }}">
                                                    @error('warna.'.$x) <span class="text-danger small">Bahan/Warna wajib diisi!</span> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Harga Satuan</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="harga_satuan[]" value="{{ $harga_satuan[$x] ?? 0 }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Total QTY</label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control total-qty-input @error('qty.'.$x) is-invalid @enderror" name="qty[]" value="{{ old('qty.'.$x, $qty[$x] ?? 0) }}">
                                                    @error('qty.'.$x) <span class="text-danger small">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-sm-2"><h4>Pcs</h4></div>
                                            </div>
                                        </div>

                                            <label class="text-info"><i class="fas fa-th-list"></i> Detail Ukuran</label>
                                            <table class="table table-sm table-bordered size-table">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Ukuran</th>
                                                        <th>Qty</th>
                                                        <th><button type="button" class="btn btn-xs btn-primary btn-add-size"><i class="fa fa-plus"></i></button></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $current_sizes = isset($size_details[$x]) ? (is_array($size_details[$x]) ? $size_details[$x] : json_decode($size_details[$x], true)) : [];
                                                    @endphp
                                                    @foreach($current_sizes as $sd)
                                                        <tr>
                                                            <td>
                                                                <select name="size_name[]" class="form-control form-control-sm size-name-input">
                                                                    <option value="S" {{ $sd['size'] == 'S' ? 'selected' : '' }}>S</option>
                                                                    <option value="M" {{ $sd['size'] == 'M' ? 'selected' : '' }}>M</option>
                                                                    <option value="L" {{ $sd['size'] == 'L' ? 'selected' : '' }}>L</option>
                                                                    <option value="XL" {{ $sd['size'] == 'XL' ? 'selected' : '' }}>XL</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="size_qty[]" class="form-control form-control-sm size-qty" value="{{ $sd['qty'] }}"></td>
                                                            <td><button type="button" class="btn btn-xs btn-danger btn-remove-size"><i class="fa fa-trash"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="size-summary p-2 mb-2 border rounded bg-white small">
                                                Total PCS: <span class="summary-total text-bold">0</span> | 
                                                Terpakai: <span class="summary-used text-primary text-bold">0</span> | 
                                                Sisa: <span class="summary-remaining text-success text-bold">0</span>
                                            </div>
                                            <input type="hidden" name="size_details_json[]" class="size-details-json" value="{{ isset($size_details[$x]) ? (is_array($size_details[$x]) ? json_encode($size_details[$x]) : $size_details[$x]) : '[]' }}">

                                            <div class="mt-3 p-2 border rounded" style="background: #fffbe6;">
                                                <label class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Size Besar (Extra Cost)</label>
                                                <table class="table table-sm table-bordered large-size-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Size (XXL/3L+)</th>
                                                            <th>Qty</th>
                                                            <th>Ekstra/Pcs</th>
                                                            <th><button type="button" class="btn btn-xs btn-warning btn-add-large-size"><i class="fa fa-plus text-white"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $current_large = isset($detail_size_besar[$x]) ? (is_array($detail_size_besar[$x]) ? $detail_size_besar[$x] : json_decode($detail_size_besar[$x], true)) : [];
                                                        @endphp
                                                        @forelse($current_large as $ld)
                                                            <tr>
                                                                <td><input type="text" name="large_size_name[]" class="form-control form-control-sm" value="{{ $ld['size'] }}"></td>
                                                                <td><input type="number" name="large_size_qty[]" class="form-control form-control-sm" value="{{ $ld['qty'] }}"></td>
                                                                <td><input type="number" name="large_size_price[]" class="form-control form-control-sm" value="{{ $ld['price'] }}"></td>
                                                                <td><button type="button" class="btn btn-xs btn-danger btn-remove-large-size"><i class="fa fa-trash"></i></button></td>
                                                            </tr>
                                                        @empty
                                                            <!-- No large sizes by default -->
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                <input type="hidden" name="size_large_json[]" class="size-large-json" value="{{ isset($detail_size_besar[$x]) ? (is_array($detail_size_besar[$x]) ? json_encode($detail_size_besar[$x]) : $detail_size_besar[$x]) : '[]' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="catatan[]" value="">
                                </div>
                            @endforeach
                        </div>
                        <div class="text-right mb-4">
                            <button type="button" class="btn btn-info" id="BtnTambahItem"><i class="fa fa-plus"></i> Tambah Item Lagi</button>
                        </div>

                    <hr>
                    

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Pembelanjaan Bahan</label>
                                    <select class="form-control" name="pembelanjaan_bahan" id="pembelanjaan_bahan">
                                      <option value="{{$data->pembelanjaan_bahan}}">{{$data->pembelanjaan_bahan}}</option>
                                      <option value="kilo">Kilo</option>
                                      <option value="yard">Yard</option>
                                      <option value="Eceran">Eceran</option>
                                      <option value="roll">Roll/Gulungan</option>
                                    </select>
                                    <small id="pembelanjaan_bahan_info" class="text-info font-weight-bold mt-2 display-block"></small>
                                  </div> 
                                  <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Rp.</label>
                                    <div class="col-sm-6">
                                      <input type="number" class="form-control" placeholder="Masukan Harga.." name="harga" value="{{$data->harga}}">
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <h4 class="text-center"><strong><u>HPP</u></strong></h4>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">CMT</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_cmt" value="{{$data->hpp_cmt}}">
                                  </div>
                                </div>
                                  <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Bordir</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_bordir" value="{{$data->hpp_bordir}}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Sablon</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_sablon" value="{{$data->hpp_sablon}}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Benang Jahit</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_benang" value="{{$data->hpp_benang}}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="" class="col-sm-2 col-form-label">Packaging</label>
                                  <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="Masukan Harga.." name="hpp_packaging" value="{{$data->hpp_packaging}}">
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
                                  <button type="submit" class="btn btn-success btn-block btn-xl" style="border-radius: 15px"><i class="fa fa-save"> Update Orderan</i></button>                           
                                </div>
                              </div>
                        </div>
                      </form>

                      {{-- TEMPLATE UNTUK TAMBAH ITEM BARU --}}
                      <div id="item-template" style="display: none">
                          <div class="kolom_asli border-top border-primary mt-4 pt-4 mb-4 pb-4 px-3" style="background: #eef2f7; border-radius: 10px;">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                  <h4 class="text-primary mb-0">Item Baru</h4>
                                  <button type="button" class="btn btn-sm btn-danger btn-remove-item"><i class="fas fa-trash"></i> Hapus Item</button>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Jenis Orderan</label>
                                          <div class="col-sm-9">
                                              <select name="jenis_orderan[]" class="form-control jenis-orderan-select">
                                                  <option value="" selected disabled>Pilih Jenis..</option>
                                                  @foreach($jenis_orderans as $jo)
                                                      <option value="{{ $jo->id }}">{{ $jo->nama_jenis }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Bahan</label>
                                          <div class="col-sm-9">
                                              <select class="form-control bahan-select" name="bahan[]">
                                                  <option value="" selected disabled>Pilih Bahan..</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Warna</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control" name="warna[]" placeholder="Contoh: Biru Dongker">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Harga Satuan</label>
                                          <div class="col-sm-9">
                                              <input type="number" class="form-control" name="harga_satuan[]" value="0">
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Total QTY</label>
                                          <div class="col-sm-7">
                                              <input type="number" class="form-control total-qty-input" name="qty[]" value="0">
                                          </div>
                                          <div class="col-sm-2"><h4>Pcs</h4></div>
                                      </div>
                                  </div>

                                  <div class="col-md-6">
                                      <label class="text-info"><i class="fas fa-th-list"></i> Detail Ukuran</label>
                                      <table class="table table-sm table-bordered size-table">
                                          <thead class="bg-light">
                                              <tr>
                                                  <th>Ukuran</th>
                                                  <th>Qty</th>
                                                  <th><button type="button" class="btn btn-xs btn-primary btn-add-size"><i class="fa fa-plus"></i></button></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                      </table>
                                      <div class="size-summary p-2 mb-2 border rounded bg-white small">
                                          Total PCS: <span class="summary-total text-bold">0</span> | 
                                          Terpakai: <span class="summary-used text-primary text-bold">0</span> | 
                                          Sisa: <span class="summary-remaining text-success text-bold">0</span>
                                      </div>
                                      <input type="hidden" name="size_details_json[]" class="size-details-json" value="[]">

                                      <div class="mt-3 p-2 border rounded" style="background: #fffbe6;">
                                          <label class="text-warning font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Size Besar (Extra Cost)</label>
                                          <table class="table table-sm table-bordered large-size-table">
                                              <thead>
                                                  <tr>
                                                      <th>Size</th>
                                                      <th>Qty</th>
                                                      <th>Ekstra</th>
                                                      <th><button type="button" class="btn btn-xs btn-warning btn-add-large-size"><i class="fa fa-plus text-white"></i></button></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                          </table>
                                          <input type="hidden" name="size_large_json[]" class="size-large-json" value="[]">
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" name="catatan[]" value="">
                          </div>
                      </div>
                      </div>
                    </div>
                  </div>
                  </div>
              </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const hppDefaults = @json(config('konveksi.hpp_defaults'));

        // Handle HPP Selection
        $('#pembelanjaan_bahan').on('change', function() {
            const selected = $(this).val();
            const defaults = hppDefaults[selected];

            if (defaults) {
                $('input[name="hpp_cmt"]').val(defaults.cmt);
                $('input[name="hpp_bordir"]').val(defaults.bordir);
                $('input[name="hpp_sablon"]').val(defaults.sablon);
                $('input[name="hpp_benang"]').val(defaults.benang);
                $('input[name="hpp_packaging"]').val(defaults.packaging);
                if (defaults.harga_bahan !== undefined) $('input[name="harga"]').val(defaults.harga_bahan);
                $('#pembelanjaan_bahan_info').text(defaults.label || '');
            }
        });

        // Function to update JSON and total QTY for a specific item container
        function updateItemData(container) {
            let totalInput = container.find('.total-qty-input');
            let totalPcs = parseInt(totalInput.val()) || 0;

            // Update Size Details JSON
            let sizeData = [];
            let usedPcs = 0;
            container.find('.size-table tbody tr').each(function() {
                let name = $(this).find('.size-name-input').val() || $(this).find('input[name="size_name[]"]').val();
                let qty = parseInt($(this).find('.size-qty').val()) || 0;
                if(name) {
                    sizeData.push({size: name, qty: qty});
                    usedPcs += qty;
                }
            });
            container.find('.size-details-json').val(JSON.stringify(sizeData));

            // ALSO Add Large Sizes to usedPcs
            let largeData = [];
            container.find('.large-size-table tbody tr').each(function() {
                let name = $(this).find('input[name="large_size_name[]"]').val();
                let qty = parseInt($(this).find('input[name="large_size_qty[]"]').val()) || 0;
                let price = parseInt($(this).find('input[name="large_size_price[]"]').val()) || 0;
                if(name) {
                    largeData.push({size: name, qty: qty, price: price});
                    usedPcs += qty; // Include large sizes in used count
                }
            });
            container.find('.size-large-json').val(JSON.stringify(largeData));

            // Update Summary UI
            let summary = container.find('.size-summary');
            let remaining = totalPcs - usedPcs;
            summary.find('.summary-total').text(totalPcs);
            summary.find('.summary-used').text(usedPcs);
            summary.find('.summary-remaining').text(remaining);

            // Validation Display
            if (remaining < 0) {
                summary.find('.summary-remaining').removeClass('text-success').addClass('text-danger');
                summary.addClass('border-danger bg-light-danger');
                $('button[type="submit"]').prop('disabled', true).addClass('btn-secondary').removeClass('btn-success');
            } else {
                summary.find('.summary-remaining').removeClass('text-danger').addClass('text-success');
                summary.removeClass('border-danger bg-light-danger');
                
                let hasError = false;
                $('.size-summary').each(function() {
                    let u = parseInt($(this).find('.summary-used').text()) || 0;
                    let t = parseInt($(this).find('.summary-total').text()) || 0;
                    if (u > t) hasError = true;
                });
                if (!hasError) {
                    $('button[type="submit"]').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
                }
            }
        }

        // Add/Remove Size Rows
        $(document).on('click', '.btn-add-size', function() {
            let tbody = $(this).closest('table').find('tbody');
            tbody.append(`
                <tr>
                    <td>
                        <select name="size_name[]" class="form-control form-control-sm size-name-input">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </td>
                    <td><input type="number" name="size_qty[]" class="form-control form-control-sm size-qty" value="0"></td>
                    <td><button type="button" class="btn btn-xs btn-danger btn-remove-size"><i class="fa fa-trash"></i></button></td>
                </tr>
            `);
        });

        $(document).on('click', '.btn-remove-size', function() {
            let container = $(this).closest('.kolom_asli');
            $(this).closest('tr').remove();
            updateItemData(container);
        });

        // Add/Remove Large Size Rows
        $(document).on('click', '.btn-add-large-size', function() {
            let tbody = $(this).closest('table').find('tbody');
            tbody.append(`
                <tr>
                    <td><input type="text" name="large_size_name[]" class="form-control form-control-sm" placeholder="XXL"></td>
                    <td><input type="number" name="large_size_qty[]" class="form-control form-control-sm" placeholder="0"></td>
                    <td><input type="number" name="large_size_price[]" class="form-control form-control-sm" placeholder="Extra"></td>
                    <td><button type="button" class="btn btn-xs btn-danger btn-remove-large-size"><i class="fa fa-trash"></i></button></td>
                </tr>
            `);
        });

        $(document).on('click', '.btn-remove-large-size', function() {
            let container = $(this).closest('.kolom_asli');
            $(this).closest('tr').remove();
            updateItemData(container);
        });

        // Auto update on input change
        $(document).on('input change', '.size-qty, .size-name-input, .total-qty-input, input[name="large_size_qty[]"], input[name="large_size_price[]"], input[name="large_size_name[]"]', function() {
            updateItemData($(this).closest('.kolom_asli'));
        });

        // Bahan Select logic
        $(document).on('change', '.bahan-select', function() {
            let option = $(this).find(':selected');
            let price = option.data('price');
            let container = $(this).closest('.kolom_asli');
            if(price !== undefined) container.find('input[name="harga_satuan[]"]').val(price);
        });

        // Add Item Logic
        $('#BtnTambahItem').on('click', function() {
            let clone = $('#item-template .kolom_asli').clone();
            $('#container-orderan').append(clone);
        });

        $(document).on('click', '.btn-remove-item', function() {
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
                    $(this).closest('.kolom_asli').remove();
                }
            });
        });

        // Initial update for all items (in case of loaded data)
        $('.kolom_asli').each(function() {
            updateItemData($(this));
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
                            bahanSelect.append('<option value="' + value.nama_bahan + '" ' + selected + ' data-price="' + value.harga_satuan + '" data-large-price="' + value.harga_size_besar + '">' + value.nama_bahan + '</option>');
                        });
                        
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
            var bahanSelect = $(this).closest('.kolom_asli').find('.bahan-select');
            loadBahan(jenis_id, bahanSelect);
        });

        // Trigger load for existing items
        $('.jenis-orderan-select').each(function() {
            var jenis_id = $(this).val();
            var bahanSelect = $(this).closest('.kolom_asli').find('.bahan-select');
            var selectedBahan = bahanSelect.data('selected');
            if (jenis_id) {
                loadBahan(jenis_id, bahanSelect, selectedBahan);
            }
        });
    });
</script>
@endsection