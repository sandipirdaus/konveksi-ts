
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>TS.CLOTHING MARKET</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,700,800" rel="stylesheet">
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">


    <link rel="stylesheet" href="/asset_login/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="/asset_login/css/animate.css">

    <link rel="stylesheet" href="/asset_login/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/asset_login/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/asset_login/css/magnific-popup.css">

    <link rel="stylesheet" href="/asset_login/css/aos.css">

    <link rel="stylesheet" href="/asset_login/css/ionicons.min.css">


    <link rel="stylesheet" href="/asset_login/css/flaticon.css">
    <link rel="stylesheet" href="/asset_login/css/icomoon.css">
    <link rel="stylesheet" href="/asset_login/css/style.css">

  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
  <div class="container">
  <div class="d-flex align-items-center gap-2">

    <!-- Logo -->
    <img src="/asset_login/images/logo-1.png"
         alt="Logo"
         class="logo-navbar">

    <!-- Teks -->
    <span class="navbar-brand text-white mb-0">
      TS.CLOTHING MARKET
    </span>

  </div>
</div>

  </nav>
    <!-- END nav -->

    <!-- <div class="js-fullheight"> -->
   <div id="vanta-bg" class="hero-wrap js-fullheight" style="zoom: 100%">
      <div class="container">
    @include('sweetalert::alert')
    @yield('konten')

    <div class="row justify-content-center align-items-center text-center" style="min-height:100vh;">
      <div class="col-md-6">

        <span class="title-small">APLIKASI INTERNAL</span>
        <span class="title-small">KONVEKSI</span>

        <h1 class="subtitle">
          TS.CLOTHING MARKET
        </h1>

        <a href="#login" data-toggle="modal" class="btn btn-primary px-5 py-3">
          <i class="fas fa-sign-in-alt"></i> Silahkan Login
        </a>

      </div>
    </div>
  </div>
</div>


    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="zoom: 85%">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Form Login </h5>
                    </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login.submit') }}">
                                            @csrf

                                            <div class="form-group row">
                                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                                <div class="col-md-8">
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukan Email..">

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukan Password" id="pass" maxlength="16">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text click-eye" onclick="togglePasswordLogin()" style="cursor: pointer;">
                                                                <i class="fas fa-eye-slash" id="eye-icon-login"></i>
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

                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-2">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        {{ __('Login') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



  <script src="/asset_login/js/jquery.min.js"></script>
  <script src="/asset_login/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="/asset_login/js/popper.min.js"></script>
  <script src="/asset_login/js/bootstrap.min.js"></script>
  <script src="/asset_login/js/jquery.easing.1.3.js"></script>
  <script src="/asset_login/js/jquery.waypoints.min.js"></script>
  <script src="/asset_login/js/jquery.stellar.min.js"></script>
  <script src="/asset_login/js/owl.carousel.min.js"></script>
  <script src="/asset_login/js/jquery.magnific-popup.min.js"></script>
  <script src="/asset_login/js/aos.js"></script>
  <script src="/asset_login/js/jquery.animateNumber.min.js"></script>
  <script src="/asset_login/js/bootstrap-datepicker.js"></script>
  <script src="/asset_login/js/jquery.timepicker.min.js"></script>
{{-- <script src="/asset_login/js/particles.min.js"></script> --}}
{{-- <script src="/asset_login/js/particles.js"></script> --}}
  <script src="/asset_login/js/scrollax.min.js"></script>

  <script src="/asset_login/js/google-map.js"></script>
  <script src="/asset_login/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>

<script>
  VANTA.NET({
    el: "#vanta-bg",
    mouseControls: true,
    touchControls: true,
    gyroControls: false,
    minHeight: 200.00,
    minWidth: 200.00,
    scale: 1.00,
    scaleMobile: 1.00
  });
</script>

@if($errors->any())
<script>
    $(document).ready(function(){
        $('#login').modal('show');
    });
</script>
@endif

<script>
  function togglePasswordLogin() {
      var passwordField = document.getElementById("pass");
      var eyeIcon = document.getElementById("eye-icon-login");
      if (passwordField.type === "password") {
          passwordField.type = "text";
          eyeIcon.classList.remove("fa-eye-slash");
          eyeIcon.classList.add("fa-eye");
      } else {
          passwordField.type = "password";
          eyeIcon.classList.remove("fa-eye");
          eyeIcon.classList.add("fa-eye-slash");
      }
  }
</script>


  </body>
</html>
