@extends('layout.master')
@section('judul', 'Halaman Profile')

@section('konten')
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
          <!-- Profile Image -->
          <div class="card card-primary card-outline shadow-sm">
            <div class="card-header border-bottom-0">
              <h3 class="card-title">Informasi Profile</h3>
            </div>
            <div class="card-body box-profile pt-0">
              <div class="text-center mb-3">
                <img class="profile-user-img img-fluid img-circle border-3 border-primary"
                     src="{{asset('foto_akun/'.Auth::user()->foto)}}"
                     alt="User profile picture"
                     style="width: 120px; height: 120px; object-fit: cover;">
              </div>

              <h3 class="profile-username text-center font-weight-bold mb-4">{{Auth::user()->name}}</h3>

              <div class="px-3">
                <ul class="list-group list-group-unbordered mb-4">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-muted"><i class="fas fa-user-circle mr-2"></i>Nama Akun</span>
                    <span class="font-weight-bold text-dark">{{Auth::user()->name}}</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0">
                    <span class="text-muted"><i class="fas fa-envelope mr-2"></i>E-mail</span>
                    <span class="font-weight-bold text-dark">{{Auth::user()->email}}</span>
                  </li>
                </ul>

                <button href="#modal_edit" data-toggle="modal" class="btn btn-primary btn-block shadow-sm py-2">
                  <i class="far fa-edit mr-2"></i><b>Edit Akun</b>
                </button>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Form Edit Akun</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="/update_profile/{{Auth::user()->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')      
            <div class="modal-body">
                <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Nama</label>
                              <div class="col-sm-9">
                              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Silahkan Di isi.." name="name" value="{{old('name', Auth::user()->name)}}">
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
                              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Silahkan Di isi.." name="email" value="{{old('email', Auth::user()->email)}}">
                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                              </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Password</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                      <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin diubah (8-12 karakter).." name="password" id="password_profile" maxlength="12">
                                      <div class="input-group-append">
                                          <span class="input-group-text" onclick="togglePassword('password_profile', 'eye-icon-profile')" style="cursor: pointer;">
                                              <i class="fas fa-eye-slash" id="eye-icon-profile"></i>
                                          </span>
                                      </div>
                                      @error('password')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                                  <small class="text-muted">Gunakan 8-12 karakter</small>
                              </div>
                        </div>
                        <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Konfirmasi</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                      <input type="password" class="form-control" placeholder="Ulangi password baru.." name="password_confirmation" id="password_confirm_profile" maxlength="12">
                                      <div class="input-group-append">
                                          <span class="input-group-text" onclick="togglePassword('password_confirm_profile', 'eye-icon-confirm-profile')" style="cursor: pointer;">
                                              <i class="fas fa-eye-slash" id="eye-icon-confirm-profile"></i>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                        </div>
                        <hr>
                        <div class="form-group row justify-content-center">
                              <img class="profile-user-img img-fluid img-circle"
                              src="{{asset('foto_akun/'.Auth::user()->foto)}}"
                              alt="User profile picture">
                        </div>
                        <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Foto</label>
                              <div class="col-sm-9">
                              <input type="file" class="form-control" placeholder="Silahkan Di isi.." name="foto">
                              <span class="text-danger">*JPEG,PNG</span>
                              </div>
                        </div>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="border-radius: 13px" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" style="border-radius: 13px"><i class="fas fa-save"> Update</i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
@endsection