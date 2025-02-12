<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <title>Datrux - Landing</title>
    <link rel="shortcut icon" href="{{asset('img/logo/basic_logo.png')}}" type="image/png">
    <link rel="stylesheet" href="{{asset('landing/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/LineIcons.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/nivo-lightbox.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/responsive.css')}}">
  </head>
  <body>
    <header id="home" class="hero-area">
      <div class="overlay">
        <span></span>
        <span></span>
      </div>
      <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbar">
        <div class="container">
          <a href="index.html" class="navbar-brand"><img src="{{asset('img/logo/logo_horizontal_ab.png')}}" alt="" width="20%" height="20%"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="lni-menu"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto w-100 justify-content-end">
            @if (Route::has('login'))
                @auth
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="{{ url('/home') }}">Inicio</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="btn btn-singin" href="{{ route('login') }}">Ingresar</a>
                </li>
                @endauth
            @endif
            </ul>
          </div>
        </div>
      </nav>
      <div class="container">
        <div class="row space-100">
          <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="contents">
              <h2 class="head-title">TU CRM</h2>
              <p>Datrux</p>
              <div class="header-button">
                <a href="{{ route('login') }}" class="btn btn-border-filled">Ingresar</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-xs-12 p-0">
            <div class="intro-img">
              <img src="{{asset('img/logo/logo_vertical_ab.png')}}" alt="" width="80%" height="80%">
            </div>
          </div>
        </div>
      </div>
    </header>

    <footer>
      <section id="footer-Content">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
              <div class="footer-logo">
               <img src="img/footer-logo.png" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="copyright">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="site-info text-center">
                  <p>Crafted by <a href="http://uideck.com" rel="nofollow">Pedro Siccha</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </footer>
    <a href="#" class="back-to-top">
      <i class="lni-chevron-up"></i>
    </a>
    <div id="preloader">
      <div class="loader" id="loader-1"></div>
    </div>
    <script src="{{asset('landing/js/jquery-min.js')}}"></script>
    <script src="{{asset('landing/js/popper.min.js')}}"></script>
    <script src="{{asset('landing/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('landing/js/owl.carousel.js')}}"></script>
    <script src="{{asset('landing/js/jquery.nav.js')}}"></script>
    <script src="{{asset('landing/js/scrolling-nav.js')}}"></script>
    <script src="{{asset('landing/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('landing/js/nivo-lightbox.js')}}"></script>
    <script src="{{asset('landing/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('landing/js/form-validator.min.js')}}"></script>
    <script src="{{asset('landing/js/contact-form-script.js')}}"></script>
    <script src="{{asset('landing/js/main.js')}}"></script>

  </body>
</html>
