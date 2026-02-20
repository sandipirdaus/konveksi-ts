@extends('layout.master')

@section('judul', 'Invoice')

@section('konten')
<style>
    @media print {
        @page {
            margin: 0;
            size: auto;
        }
        body {
            margin: 1.5cm;
            background: #fff;
        }
        .main-footer, .main-header, .sidebar, .no-print {
            display: none !important;
        }
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="invoice p-3 mb-3">
            <!-- Header Row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <img src="/assets/dist/img/logo-1.png" style="width: 190px; border-radius: 8px">
                  <small class="float-right">Tanggal: <b>{{Carbon\Carbon::now()->format('d/M/Y')}}</b></small>
                </h4>
              </div>
            </div>

            <!-- Info Row -->
            <div class="row invoice-info mt-4">
              <div class="col-sm-4 invoice-col">
                Dari:
                <address>
                  <strong>CV. TS CLOTHING MARKET</strong><br>
                  Jatimulya, Kec. Kasokandel,<br>
                  Kabupaten Majalengka, Jawa Barat 45453<br>
                  Tlp: +62 822-1417-7228 <br>
                  Email: tsclothingmarket@gmail.com
                </address>
              </div>

              <div class="col-sm-4 invoice-col">
                Kepada Yth:
                <address>
                  <strong>{{$data->nama_vendor}}</strong><br>
                  {{$data->alamat}}<br>
                  Tlp: {{$data->no_hp}}<br>
                </address>
              </div>

              <div class="col-sm-4 invoice-col">
                 <b>Invoice No: {{$no_invoice}}</b><br>
                 <br>
                 <b>No. PO:</b> {{$data->no_po}}<br>
                 <b>Pesanan a/n:</b> {{$data->pesanan_untuk}}<br>
                 <b>Tgl Order:</b> {{Carbon\Carbon::parse($data->tgl_order)->format('d/M/Y')}}<br>
              </div>
            </div>

            <!-- Table Row -->
            <div class="row mt-4">
              <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                      <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text-center" width="20%">Jenis Orderan</th>
                        <th class="text-center" width="20%">Spesifikasi</th>
                        <th class="text-center" width="15%">Harga Satuan</th>
                        <th class="text-center" width="25%">Rincian Qty</th>
                        <th class="text-center" width="15%">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($invoice_items as $index => $item)
                      <tr>
                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                        <td class="align-middle">
                            <strong>{{ $item['jenis'] }}</strong>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">Bahan:</small><br>
                            <strong>{{ $item['bahan'] }}</strong><br>
                            <small class="text-muted">Warna:</small><br>
                            <strong>{{ $item['warna'] }}</strong>
                        </td>
                        <td class="text-center align-middle">
                            Rp. {{ number_format($item['harga_satuan'], 0, ',', '.') }}
                        </td>
                        <td class="align-middle">
                            <!-- Normal Sizes -->
                            @if($item['normal_sizes']->count() > 0)
                                <div class="mb-2">
                                    <span class="badge badge-secondary">Normal Size:</span>
                                    <ul class="list-unstyled mb-0 small">
                                    @foreach($item['normal_sizes'] as $ns)
                                        <li class="d-inline-block mr-2">
                                            <strong>{{ $ns->size }}:</strong> {{ $ns->qty }} pcs
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Extra Sizes -->
                            @if(count($item['extra_sizes']) > 0)
                                <div class="mt-1">
                                    <span class="badge badge-warning">Extra Size (+):</span>
                                    <ul class="list-unstyled mb-0 small text-danger">
                                    @foreach($item['extra_sizes'] as $es)
                                        <li>
                                            <strong>{{ $es['size'] }}:</strong> {{ $es['qty'] }} pcs 
                                            <span class="text-muted">(+{{ number_format($es['price'], 0, ',', '.') }})</span>
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="border-top mt-1 pt-1 font-weight-bold text-center">
                                Total: {{ $item['qty_total'] }} PCS
                            </div>
                        </td>
                        <td class="text-right align-middle">
                             <div>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                             @if($item['extra_cost_total'] > 0)
                                <small class="text-danger">+ Extra: Rp. {{ number_format($item['extra_cost_total'], 0, ',', '.') }}</small>
                             @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
              </div>
            </div>

            <!-- Payment Summary -->
            <div class="row">
              <div class="col-7">
                  <p class="lead text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    <strong>Keterangan Transfer:</strong><br>
                    Bank : MANDIRI <br>
                    A/N : HILMAN NUR HIDAYAT<br>
                    No. Rek : 5780-5515-8897
                  </p>
                  @if(!empty($catatan))
                    <div class="alert alert-light border mt-3">
                        <strong>Catatan:</strong>
                        <ul class="mb-0 pl-3">
                            @foreach($catatan as $cat)
                                @if(!empty($cat)) <li>{{ $cat }}</li> @endif
                            @endforeach
                        </ul>
                    </div>
                  @endif
              </div>
              <div class="col-5">
                <p class="lead">Ringkasan Pembayaran</p>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Subtotal Pesanan:</th>
                      <td class="text-right">Rp. {{ number_format($grand_total_price, 0, ',', '.') }}</td>
                    </tr>
                    @if($total_extra_size_cost > 0)
                    <tr>
                      <th class="text-danger">Total Extra Size (+):</th>
                      <td class="text-right text-danger">Rp. {{ number_format($total_extra_size_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="bg-light">
                        <th>Total Nilai Order:</th>
                        <td class="text-right font-weight-bold">Rp. {{ number_format($grand_total_price + $total_extra_size_cost, 0, ',', '.') }}</td>
                    </tr>
                    
                    @php 
                        $grand_total = $grand_total_price + $total_extra_size_cost;
                        $dp_val = $data->dp ?? 0;
                        $sisa = $grand_total - $dp_val;
                    @endphp

                    @if($dp_val > 0 || strtoupper($data->sistem_dp) == 'YA')
                    <tr>
                      <th>Pembayaran DP:</th>
                      <td class="text-right">Rp. {{ number_format($dp_val, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                      <th class="text-success" style="font-size: 1.2rem">Sisa Tagihan:</th>
                      <td class="text-right text-success font-weight-bold" style="font-size: 1.2rem">Rp. {{ number_format($sisa, 0, ',', '.') }}</td>
                    </tr>
                    @else
                    <tr>
                      <th class="text-success" style="font-size: 1.2rem">Total Tagihan:</th>
                      <td class="text-right text-success font-weight-bold" style="font-size: 1.2rem">Rp. {{ number_format($grand_total, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                  </table>
                </div>
              </div>
            </div>

            <!-- Print Button -->
            <div class="row no-print mt-4">
              <div class="col-12">
                <button onclick="window.print()" class="btn btn-info float-right"><i class="fas fa-print"></i> Cetak Invoice</button>
                <button onclick="window.close()" class="btn btn-default float-right mr-2">Tutup</button>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
  window.addEventListener("load", window.print());
</script>
@endsection
