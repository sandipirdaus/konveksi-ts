@extends('layout.master')

@section('judul', 'Orderan On Proses')

@section('konten')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="far fa-clipboard"> DAFTAR ORDERAN ON PROSES</i></h3>
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
            @foreach ($data as $item)                  
            <tr data-widget="expandable-table" aria-expanded="false">
              <td class="text-center">{{$loop->iteration}}</td>
              <td class="text-center">{{$item->no_po}}</td>
              <td class="text-center">{{$item->nama_vendor}}</td>
              <td class="text-center">{{Carbon\Carbon::parse($item->tgl_order)->format('d-M-Y')}}</td>
              <td class="text-center"><span class="badge badge-danger">{{Carbon\Carbon::parse($item->deadline)->format('d-M-Y')}}</span></td>
              <td class="text-center"><span class="badge badge-warning">Proses Produksi</span></td>
              <td class="text-center">
                <a href="/lihat_orderan/detail/{{$item->id}}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                <button type="button" class="btn btn-sm btn-primary btn-masuk-stok" 
                        data-id="{{$item->id}}" 
                        data-po="{{$item->no_po}}"
                        data-items="{{ json_encode($item->jenis_orderan) }}"
                        data-qtys="{{ json_encode($item->qty) }}">
                   <i class="fas fa-boxes"></i> Masuk Stok
                </button>
                <a href="/orderan/langsung_siap_kirim/{{$item->id}}" class="btn btn-sm btn-success btn-langsung-kirim" data-nama="{{$item->no_po}}">
                   <i class="fas fa-paper-plane"></i> Langsung Kirim
                </a>
              </td>
            </tr>
            <tr class="expandable-body">
              <td colspan="7">
                @include('admin.orderan.status.parts.item_detail', ['item' => $item])
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

<!-- Modal Masuk Stok -->
<div class="modal fade" id="modalMasukStok" tabindex="-1" role="dialog" aria-labelledby="modalMasukStokLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="formMasukStok" method="POST" action="">
        @csrf
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="modalMasukStokLabel">Masuk ke Stok Barang - <span id="modalNoPo"></span></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Pilih / Input Loker <span class="text-danger">*</span></label>
            <select name="loker_id" class="form-control select2" style="width: 100%;" required>
              <option value="">-- Pilih Loker --</option>
              @foreach($lokers as $loker)
                <option value="{{$loker->id}}">{{$loker->nama_loker}}</option>
              @endforeach
            </select>
          </div>
          <hr>
          <h6>Detail Barang & Qty:</h6>
          <div id="itemStokContainer">
            <!-- Items will be injected here by JS -->
          </div>
          <div class="form-group mt-3">
            <label>Catatan (Opsional)</label>
            <textarea name="catatan" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan ke Stok</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    // Tombol Masuk Stok
    $('.btn-masuk-stok').on('click', function() {
      var id = $(this).data('id');
      var po = $(this).data('po');
      var items = $(this).data('items'); // Array of names
      var qtys = $(this).data('qtys');   // Array of qtys

      $('#modalNoPo').text(po);
      $('#formMasukStok').attr('action', '/orderan/masuk_stok/' + id);
      
      var html = '';
      if (Array.isArray(items)) {
        items.forEach(function(item, index) {
          html += '<div class="row align-items-center mb-2">';
          html += '  <div class="col-md-8"><strong>' + item + '</strong></div>';
          html += '  <div class="col-md-4 text-right">';
          html += '    <span class="badge badge-info py-2 px-3" style="font-size: 1rem;">' + qtys[index] + ' Pcs</span>';
          html += '    <input type="hidden" name="qty[]" value="' + qtys[index] + '">';
          html += '  </div>';
          html += '</div>';
        });
      }
      $('#itemStokContainer').html(html);
      $('#modalMasukStok').modal('show');
    });

    // Tombol Langsung Kirim
    $(document).on('click', '.btn-langsung-kirim', function(e) {
      e.preventDefault();
      var link = $(this).attr('href');
      var nama = $(this).data('nama');

      Swal.fire({
        title: 'Langsung Siap Kirim?',
        text: "Orderan " + nama + " akan langsung dipindahkan ke Siap Dikirim tanpa masuk stok!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = link;
        }
      })
    });
  });
</script>
@endsection