@extends('layout.master')

@section('judul', 'List Orderan')

@section('konten')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">LIST DAFTAR ORDERAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="mytable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NO.PO</th>
                  <th>Vendor</th>
                  <th>No.HP</th>
                  <th>Deadline</th>
                  <th>Status</th>
                  <th>Detail</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $order)                      
                <tr data-widget="expandable-table" aria-expanded="false">
                  <td>{{$loop->iteration}}</td>
                  <td>{{$order->no_po}}</td>
                  <td>{{$order->nama_vendor}}
                  </td>
                  <td>{{$order->no_hp}}</td>
                  <td>{{Carbon\Carbon::parse($order->deadline)->format('d-M-Y')}}</td>
                  <td>
                    @if ($order->status == 1)
                    <span class="badge badge-primary">Belum Di Proses</span>
                    @elseif($order->status == 2)
                    <span class="badge badge-warning">Proses Produksi</span>
                    @elseif($order->status == 4)
                    <span class="badge badge-success">Siap Kirim</span>
                    @elseif($order->status == 5)
                    <span class="badge badge-secondary">Selesai Dikirim</span>
                    @elseif($order->status == 6)
                    <span class="badge badge-primary">Di Stok Barang</span>
                    @else
                    <span class="badge badge-danger">Status Tidak Valid</span>
                    @endif
                  </td>
                  <td>
                      <a href="/lihat_orderan/detail/{{$order->id}}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                      
                      @if ($order->status == 1)
                      <a href="/orderan/mulai_produksi/{{$order->id}}" class="btn btn-success btn-sm">
                        Mulai Produksi <i class="fas fa-arrow-right"></i>
                      </a>
                      @elseif($order->status == 2)
                      <a href="/orderan/selesai_produksi/{{$order->id}}" class="btn btn-success btn-sm btn-selesai-produksi" data-nama="{{$order->no_po}}">
                        Selesai Produksi <i class="fas fa-arrow-right"></i>
                      </a>
                      @elseif($order->status == 4)
                      <a href="/orderan/cetak_invoice/{{$order->id}}" class="btn btn-secondary btn-sm" target="_blank" title="Cetak Invoice"><i class="fas fa-print"></i></a>
                      <a href="/orderan/kirim_selesai/{{$order->id}}" class="btn btn-success btn-sm">
                        Selesai Dikirim <i class="fas fa-arrow-right"></i>
                      </a>
                      @elseif($order->status == 6)
                      <a href="/orderan/siap_kirim_dari_stok/{{$order->id}}" class="btn btn-success btn-sm">
                        Siap Dikirim <i class="fas fa-truck"></i>
                      </a>
                      @endif
                  </td>
                </tr>
                <tr class="expandable-body">
                  <td colspan="7">
                    @include('admin.orderan.status.parts.item_detail', ['item' => $order])
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>
</div>



    
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).on('click', '.btn-selesai-produksi', function(e) {
    e.preventDefault();
    var link = $(this).attr('href');
    var nama = $(this).data('nama');

    Swal.fire({
      title: 'Yakin Produksi Selesai?',
      text: "Orderan " + nama + " akan dipindahkan ke Siap Dikirim? Pastikan stok sudah diinput ke Loker Stok!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Selesai!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = link;
      }
    })
  });
</script>
@endsection