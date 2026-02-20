@extends('layout.master')

@section('judul', 'Detail Orderan')

@section('konten')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header bg-info">
              <h3 class="card-title"><i class="fas fa-file-invoice mr-2"></i> FORM DETAIL ORDERAN: <strong>{{ $data->no_po }}</strong></h3>
              <div class="card-tools">
                <a href="javascript:window.history.go(-1);" class="btn btn-warning btn-sm" style="border-radius: 15px"><i class="fa fa-arrow-left"> Kembali</i></a>  
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <h5 class="border-bottom pb-2 mb-3 text-info font-weight-bold">Informasi Vendor & Customer</h5>
                  <table class="table table-sm table-borderless">
                    <tr>
                      <th width="150">Vendor</th>
                      <td>: {{ $data->nama_vendor }}</td>
                    </tr>
                    <tr>
                      <th>No. HP</th>
                      <td>: {{ $data->no_hp }}</td>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <td>: {{ $data->alamat }}</td>
                    </tr>
                    <tr>
                      <th>Pesanan Untuk</th>
                      <td>: {{ $data->pesanan_untuk }}</td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-6">
                  <h5 class="border-bottom pb-2 mb-3 text-info font-weight-bold">Informasi Pengiriman & Status</h5>
                  <table class="table table-sm table-borderless">
                    <tr>
                      <th width="150">Deadline</th>
                      <td>: <span class="badge badge-danger px-3 py-2" style="font-size: 0.9rem;">{{ Carbon\carbon::parse($data->deadline)->format('d-M-Y') }}</span></td>
                    </tr>
                    <tr>
                      <th>Sistem DP</th>
                      <td>: <span class="badge badge-dark">{{ strtoupper($data->sistem_dp) }}</span></td>
                    </tr>
                    <tr>
                      <th>Total DP</th>
                      <td>: <span class="badge badge-success">Rp. {{ number_format($data->dp, 0, ',', '.') }}</span></td>
                    </tr>
                    <tr>
                      <th>Status Order</th>
                      <td>: 
                        @if ($data->status == 0)
                        <span class="badge badge-secondary px-3 py-2" style="font-size: 0.9rem;">DRAFT / MENUNGGU VALIDASI</span>
                        @elseif ($data->status == 1)
                        <span class="badge badge-primary">Belum Di Proses</span>
                        @elseif($data->status == 2)
                        <span class="badge badge-warning">Proses Produksi</span>
                        @elseif($data->status == 4)
                        <span class="badge badge-success">Siap Kirim</span>
                        @elseif($data->status == 5)
                        <span class="badge badge-secondary">Selesai Dikirim</span>
                        @elseif($data->status == 6)
                        <span class="badge badge-primary">Di Stok Barang</span>
                        @endif
                      </td>
                    </tr>
                  </table>
                </div>
              </div>

              <hr class="my-4">

              <h4 class="text-center mb-4 font-weight-bold text-uppercase tracking-wider">Rincian Item Pesanan</h4>
              
              @include('admin.orderan.status.parts.item_detail', ['item' => $data])

              <hr class="my-5">

              <div class="row">
                <!-- Rincian Size Besar (Extra Charges) -->
                 <div class="col-md-12 mb-4">
                    <h4 class="text-center mb-4 font-weight-bold text-uppercase tracking-wider">Rincian Size Besar (Extra Charges)</h4>
                    <div class="card bg-light border-warning shadow-sm">
                        <div class="card-body p-4">
                            @php 
                                $has_extra = false;
                                $detail_size_besar = $data->detail_size_besar ?? [];
                            @endphp

                            @foreach($jenis_orderan as $i => $name)
                                 @php
                                    $large_json = isset($detail_size_besar[$i]) ? 
                                        (is_string($detail_size_besar[$i]) ? json_decode($detail_size_besar[$i], true) : $detail_size_besar[$i]) : [];
                                 @endphp

                                 @if( !empty($large_json) && is_array($large_json) )
                                     @php $has_extra = true; @endphp
                                     <h6 class="font-weight-bold text-info border-bottom pb-2"><i class="fas fa-tshirt"></i> {{ $name }}</h6>
                                     <ul class="list-unstyled mb-3 ml-3">
                                     @foreach($large_json as $lj)
                                        <li class="mb-1">
                                            <i class="fas fa-angle-right mr-2 text-warning"></i>
                                            <strong>{{ $lj['size'] }}</strong> : {{ $lj['qty'] }} pcs × Rp {{ number_format($lj['price'], 0, ',', '.') }} = 
                                            <span class="font-weight-bold">Rp {{ number_format(($lj['qty'] * $lj['price']), 0, ',', '.') }}</span>
                                        </li>
                                     @endforeach
                                     </ul>
                                 @endif
                            @endforeach

                            @if(!$has_extra)
                                <p class="text-center text-muted font-italic mb-0"><i class="fas fa-info-circle"></i> Tidak ada extra charges (Tidak ada size besar)</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Rincian Biaya (HPP) -->
                <div class="col-md-12 mb-4">
                  <h4 class="text-center mb-4 font-weight-bold text-uppercase tracking-wider">Rincian Biaya Produksi (HPP)</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered text-center shadow-sm">
                      <thead class="bg-dark text-white">
                        <tr>
                          <th>Bahan Dasar</th>
                          <th>HPP Bahan</th>
                          <th>HPP CMT</th>
                          <th>HPP Bordir</th>
                          <th>HPP Sablon</th>
                          <th>HPP Benang</th>
                          <th>HPP Packaging</th>
                          <th class="bg-primary">TOTAL HPP/PCS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><strong>{{ $data->pembelanjaan_bahan }}</strong></td>
                          <td>Rp. {{ number_format($data->hpp_bahan, 0, ',', '.') }}</td>
                          <td>Rp. {{ number_format($data->hpp_cmt, 0, ',', '.') }}</td>
                          <td>Rp. {{ number_format($data->hpp_bordir, 0, ',', '.') }}</td>
                          <td>Rp. {{ number_format($data->hpp_sablon, 0, ',', '.') }}</td>
                          <td>Rp. {{ number_format($data->hpp_benang, 0, ',', '.') }}</td>
                          <td>Rp. {{ number_format($data->hpp_packaging, 0, ',', '.') }}</td>
                          <td class="bg-light font-weight-bold text-primary">Rp. {{ number_format($total_hpp_unit, 0, ',', '.') }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Rincian Omset & Profit -->
                <div class="col-md-6 mx-auto mt-4">
                  <div class="card border-success shadow">
                    <div class="card-header bg-success py-2">
                       <h5 class="card-title mb-0 text-white font-weight-bold"><i class="fas fa-chart-line mr-2"></i> ANALISA OMSET & PROFIT</h5>
                    </div>
                    <div class="card-body p-0">
                      <table class="table mb-0">
                        <tr>
                          <th width="200" class="pl-3">Total Modal Produksi</th>
                          <td class="text-right pr-3 font-weight-bold">Rp. {{ number_format($omset_hpp, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                          <th class="pl-3">Total Pendapatan (Vendor)</th>
                          <td class="text-right pr-3 font-weight-bold">Rp. {{ number_format($total_vendor, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-light">
                          <th class="pl-3 text-success" style="font-size: 1.1rem">SUBTOTAL PROFIT</th>
                          <td class="text-right pr-3 text-success font-weight-bold" style="font-size: 1.1rem">Rp. {{ number_format($total_profit, 0, ',', '.') }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mt-5 mb-3">
                <div class="col-12 text-center border-top pt-4">
                  @if($data->status == 0)
                      <!-- Tombol Validation Mode -->
                      <a href="#modal_edit" data-toggle="modal" class="btn btn-outline-info btn-lg mx-2 px-5 shadow-sm"><i class="fas fa-edit mr-2"></i> Edit Data</a>
                      <a href="/orderan/confirm_validation/{{$data->id}}" class="btn btn-success btn-lg mx-2 px-5 shadow-sm"><i class="fas fa-check-circle mr-2"></i> OK (Lanjutkan)</a>
                  @else
                      <!-- Tombol Normal Mode -->
                      @if($data->status != 5)
                        <a href="#modal_edit" data-toggle="modal" class="btn btn-outline-info btn-lg mx-2 px-5 shadow-sm"><i class="fas fa-edit mr-2"></i> Edit Data</a>
                      @endif
                      
                      @if($data->status == 4 || $data->status == 5)
                        <a href="/orderan/cetak_invoice/{{$data->id}}" target="_blank" class="btn btn-success btn-lg mx-2 px-5 shadow-sm"><i class="fas fa-print mr-2"></i> Cetak Invoice</a>
                      @endif

                      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg mx-2 px-5 shadow-sm"> Kembali</a>
                  @endif
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-info">
        <div class="modal-header bg-info">
          <h4 class="modal-title font-weight-bold text-white"><i class="fas fa-question-circle mr-2"></i> Konfirmasi Edit</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center py-4">
          <p class="lead mb-0">Apakah Anda yakin ingin mengubah data orderan <strong>{{ $data->no_po }}</strong>?</p>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Tutup</button>
          <a href="/edit_orderan/{{$data->id}}" class="btn btn-success px-5 font-weight-bold"><i class="fas fa-check mr-2"></i> Ya, Edit</a>
        </div>
      </div>
    </div>
</div>

<style>
  .tracking-wider { letter-spacing: 0.1em; }
  .table th { vertical-align: middle; }
</style>
@endsection