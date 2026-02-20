@extends('layout.master')

@section('judul', 'Halaman Penggajian Karyawan')

@section('konten')
<div class="row">
      <div class="col-md-12">
            <div class="card">
                  <div class="card-header bg-dark">
                        Form Edit Pembayaran Gaji Karyawan 
                  </div>
                  <div class="card-body">
                    <form action="/penggajian/masterdata/edit_pembayaran/{{$data->id}}" method="POST">
                        @method('PATCH')
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
                              <select class="form-control" id="vendor" name="vendor">
                                    <option value="{{$data->vendor}}" selected>{{$data->vendor}}</option>
                                    <option disabled>Silahkan Pilih</option>
                                    @foreach ($vendor as $item)
                                    <option value="{{$item->nama_vendor}}">{{$item->nama_vendor}}</option>
                                    @endforeach
                              </select>                        
                            </div>
                          </div>
                          <div class="kolom_asli">
                            <div class="form-group row">
                              <label for="inputEmail3" class="col-sm-2 col-form-label">Jenis Pekerjaan</label>
                              <div class="col-sm-9">
                                  <select class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan">
                                      <option value="{{$data->jenis_pekerjaan}}">{{$data->jenis_pekerjaan}}</option>
                                      <option disabled>Silahkan Pilih</option>
                                      <option value="Potong">Potong</option>
                                      <option value="Jahit">Jahit</option>
                                    </select>                        
                                  </div>
                               </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="deskripsi" value="{{$data->deskripsi}}">
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">QTY</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" placeholder="Pcs.." name="qty_barang" value="{{$data->qty_barang}}">
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Pekerja</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" placeholder="Silahkan Di isi.." name="nama_pekerja" value="{{$data->nama_pekerja}}">
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Harga Jasa</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" placeholder="Silahkan Di isi.." name="harga_jasa" value="{{$data->harga_jasa}}">
                                    </div>
                                  </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">QTY Jasa</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" placeholder="Pcs.." name="qty_pekerjaan" value="{{$data->qty_pekerjaan}}">
                                    </div>
                                  </div>
                              <div class="form-group row">
                                 <label for="inputEmail3" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                    <select class="form-control" name="keterangan">
                                      <option value="{{$data->keterangan}}">{{$data->keterangan}}</option>
                                      <option disabled>Silahkan Pilih..</option>
                                      <option value="sudah_di_bayar">Sudah Dibayar</option>
                                      <option value="belum_di_bayar">Belum Dibayar</option>
                                    </select>                        
                                  </div>
                              </div>
                        </div>

                        <hr>

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