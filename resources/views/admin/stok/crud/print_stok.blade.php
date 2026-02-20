@extends('layout.master')
@section('judul', 'Print Stok Barang')
@section('konten')

<div class="row">
      <div class="col-md-12">
          <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                  <div class="col-6">
                  </div>
                  <div class="col-4">
                  </div>
                  <div class="col-2">
                    <button onclick="window.print()"rel="noopener" target="_blank" class="btn btn-info btn-block btn-sm"><i class="fas fa-print"></i> Print</button>
                  </div>
                </div>
                <br>
                  <h4>
                    <img src="/assets/dist/img/AdminLTELogo.png" style="width: 190px; border-radius: 8px text-center">
                 <b> STOK BARANG {{$join[0]->nama_loker}} </b>
                    <small class="float-right">Tanggal Update: <b>{{ $join[0]->update_terakhir_stok ? Carbon\Carbon::parse($join[0]->update_terakhir_stok)->format('d-M-Y H:i') : '-' }}</b></small><br>
                    <small class="float-right">Pemeriksa: <b>{{$join[0]->pemeriksa}}</b></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center">No.</th>
                          <th class="text-center">Nama Vendor</th>
                          <th class="text-center">Nama Barang</th>
                          <th class="text-center">Bahan</th>
                          <th class="text-center">Warna</th>
                          <th class="text-center">Size</th>
                          <th class="text-center">Qty</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($join as $item)
                            <tr>
                              <td class="text-center">{{$loop->iteration}}</td>
                              <td class="text-center">{{$item->nama_vendor}}</td>
                              <td class="text-center">{{$item->nama_barang}}</td>
                              <td class="text-center">{{$item->bahan}}</td>
                              <td class="text-center">{{$item->warna}}</td>
                              <td class="text-center">{{$item->size}}</td>
                              <td class="text-center"><?php echo $item->qty." "."Pcs" ?></td>
                            </tr>
                        @endforeach
                  </table>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
      </div>

@endsection
