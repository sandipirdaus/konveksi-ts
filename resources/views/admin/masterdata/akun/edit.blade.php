@extends('layout.master')
@section('judul', 'Edit Halaman Akun')
@section('konten')
<div class="card">
   <div class="row">
      <div class="col-md-12">
            <form action="/master_akun/update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                  @method('PATCH')
                  @csrf
            <div class="card-header">
                  <h3 class="card-title">LIST DAFTAR AKUN</span></b></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Silahkan Di isi.." name="name" value="{{old('name', $data->name)}}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                  </div>
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">E-mail</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Silahkan Di isi.." name="email" value="{{old('email', $data->email)}}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                  </div>
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                        <select class="form-control @error('role') is-invalid @enderror" name="role">
                            <option value="owner" {{old('role', $data->role) == 'owner' ? 'selected' : ''}}>Owner</option>
                            <option value="karyawan" {{old('role', $data->role) == 'karyawan' ? 'selected' : ''}}>Karyawan</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                  </div>
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin diubah (8-12 karakter).." name="password" id="password_master_main" maxlength="12">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('password_master_main', 'eye-icon-master-main')" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash" id="eye-icon-master-main"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                  </div>
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Konfirmasi</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Ulangi password baru.." name="password_confirmation" id="password_confirm_edit" maxlength="12">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('password_confirm_edit', 'eye-icon-confirm-edit')" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash" id="eye-icon-confirm-edit"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                  </div>
                  <hr>
                  <div class="form-group row justify-content-center">
                        <img class="profile-user-img img-fluid img-circle"
                        src="{{asset('foto_akun/'.$data->foto)}}"
                        alt="User profile picture">
                  </div>
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                        <input type="file" class="form-control" placeholder="Silahkan Di isi.." name="foto">
                        <span class="text-danger">*JPEG,PNG</span>
                        </div>
                  </div>
                  <hr>
                  <a href="javascript:window.history.go(-1);" class="btn btn-outline-dark btn-sm" style="border-radius: 15px"><i class="fa fa-arrow-left"> Kembali</i></a>  
                  <button type="submit" class="btn btn-success btn-sm" style="border-radius: 13px"><i class="fas fa-save"> Update</i></button>
                </div>
              </form>
            </div>
      </div>
</div>


    
@endsection