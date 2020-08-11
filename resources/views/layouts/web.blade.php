<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="{{ $meta_deskripsi }}" >
    <meta name="keywords" content="{{ $meta_keyword }}" >
    <meta name="author" content="{{ $author }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
    <meta name="google-site-verification" content="nw5qPqvtOiBWyzpqqKOLXPz9weT-jVO6gHma3O-QmsA" />
	<meta name="msvalidate.01" content="E68776339F03619AAE6963DC1CF2D432" />
    <title>@if(!empty($slogan)){{ Str::limit(ucwords($title).' - '.$slogan,70) }} @else {{ ucwords($title) }} @endif</title>
    <link rel="shortcut icon" href="{{ asset('img/'.$favicon.'') }}">
  
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('web/plugins/feather-icons/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('web/plugins/font-awesome/css/font-awesome.min.css') }}">
    @isset($jobdetailcss) <link rel="stylesheet" href="{{ asset('web/css/jssocials.css') }}"> <link rel="stylesheet" href="{{ asset('web/css/jssocials-theme-classic.css') }}"> @endisset
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="{{ asset('web/js/popper.min.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/app.js') }}"></script>
</head>
<body>
    <script data-ad-client="ca-pub-2393340186290964" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-59HDWWG"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!--class="hero-area"-->
<nav class="navbar navbar-expand-sm navbar-light bg-white" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ $website }}">
            <img src="{{ asset('img/'.$logo.'') }}" alt="{{ $situs }}">
        </a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navigation">
            <i class="feather-menu"></i>
        </button>
        <div class="collapse navbar-collapse flex-column flex-md-row flex-md-wrap flex-lg-nowrap" id="navigation">
            <div class="col col-md-12 col-lg mt-4 mt-lg-0">
            <form action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control border-0 bg-light" name="keyjob" placeholder="Cari Lowongan">
                    <div class="input-group-append">
                        <button class="btn btn-action"  id="cariloker"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            </div>
            @php $public_menu = Applib::WebMenu(1); @endphp
            @if($public_menu)
            <ul class="navbar-nav mt-2 mt-lg-0 ml-lg-auto text-nowrap">
                <li class="nav-item active"><a class="nav-link" href="{{ $website }}">Home</a></li>
                @foreach($public_menu as $menu)
                <li class="nav-item">
                    @if($menu->role == 0)
                        <a class="nav-link" href="{{ $website.'/'.$menu['link'] }}">{{ $menu['label'] }}</a>
                    @else
                        <a  class="nav-link" href="{{ $menu['link'] }}">{{ $menu['label'] }}</a>
                    @endif
                    @if( $menu['child'] )</li>
                    <ul class="submenu">
                        @foreach( $menu['child'] as $child )
                        <li class="nav-item"><a class="nav-link" href="{{ $child['link'] }}" title="">{{ $child['label'] }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
                @endif
            </ul>
            <a href="https://api.whatsapp.com/send?phone=6282323742900&text=Hay%20halokerja.id,%20Saya%20mau%20memasang%20iklan%20lowongan%20kerja%20bagaimana%20prosedurnya?" class="btn btn-accent ml-lg-4 py-2 px-4 shadow col col-md-auto mt-4 mt-lg-0 ml-0 ml-md-auto">Pasang Lowongan <i class="feather-arrow-right"></i></a>
        </div>
    </div>
</nav> 

@yield('main')

<footer class="py-5">
  <div class="container">
      <div class="row">
          <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
          <div class="mb-4"><img src="{{ asset('img/'.$logo.'') }}" alt="{{ $situs }}" class="img-fluid" width="150"></div>
              <p>
                {{ $deskripsi_web }}
              </p>
          </div>
          <div class="col-md-5 col-lg-5 mb-4 mb-lg-0">
              <h5 class="mb-3 font-weight-bold">Tentang Kami</h5>
              <div class="row">
                  <div class="col-lg-auto pr-lg-5">
                    @php $about_menu = Applib::WebMenu(2); @endphp
                    @if($about_menu)
                    <ul class="nav flex-column">
                        @foreach($about_menu as $menu)
                        <li class="nav-item"> @if($menu->role == 0)<a href="{{ $website.'/'.$menu['link'] }}" class="nav-link px-0 py-1" > {{ $menu['label'] }}</a>@else <a href="{{ $website.'/'.$menu['link'] }}" class="nav-link px-0 py-1" > {{ $menu['label'] }}</a> @endif</li>
                        @endforeach
                    </ul>
                    @endif
                  </div>
                  <div class="col-lg-auto pr-lg-5">
                        @php $link_menu=Applib::WebMenu(3); @endphp
                        @if($link_menu)
                        <ul class="nav flex-column">
                            @foreach($link_menu as $menu)
                            <li class="nav-item"> @if($menu->role == 0)<a href="{{ $website.'/'.$menu['link'] }}" class="nav-link px-0 py-1" > {{ $menu['label'] }}</a>@else <a href="{{ $website.'/'.$menu['link'] }}" class="nav-link px-0 py-1" > {{ $menu['label'] }}</a> @endif</li>
                            @endforeach
                        </ul>
                        @endif
                  </div>
              </div>
          </div>
          <div class="col-md-3 col-lg-3 mb-4 mb-lg-0">
              <h5 class="mb-3 font-weight-bold">Kunjungi Kami</h5>
              <ul class="nav">
              <li class="nav-item"><a href="https://facebook.com/{{ $facebook }}" target="_blank" class="nav-link px-0 pr-3"><img src="{{ asset('web/images/social/facebook.svg') }}" alt="{{ $facebook }}" width="32"></a></li>
                  <li class="nav-item"><a href="https://instagram.com/{{ $instagram }}" target="_blank" class="nav-link px-0 pr-3"><img src="{{ asset('web/images/social/instagram.svg') }}" alt="{{ $instagram }}" width="32"></a></li>
                  <li class="nav-item"><a href="https://linkedin.com/in/{{ $linkedin }}" target="_blank" class="nav-link px-0 pr-3"><img src="{{ asset('web/images/social/linkedin.svg') }}" alt="{{ $linkedin }}" width="32"></a></li>
              </ul>
          </div>
      </div>
      <div class="mt-5 text-center text-muted">
          Copyright &copy; {{ date('Y') }}. {{ $situs }}. All Rights Reserved
      </div>
  </div>
</footer>
<section id="fixed-form-container">
    <div class="button">
        <i class="ion-social-whatsapp-outline" aria-hidden="true"></i>
            Pasang Lowongan
    </div>
    <div class="body">
        <ul class="list-group text-left">
            <a href="https://api.whatsapp.com/send?phone=6282323742900&text=Halokerja.id - Saya ingin memasang iklan lowongan kerja">
                <li class="list-group-item" style="display:flex">
                    <div style="width:15%;padding-right:10px">
                        <img src="{{ asset('web/images/background/icon-interview.svg') }}" style="border-radius: 50%;width:50%;" alt="whatsapp"/>
                    </div>
                    <div>
                        <span style="color:red;display:block">Customer Service</span>
                        <span class="text-dark" style="color:black"><strong>Admin</strong></span>
                    </div>
                </li>
            </a>
        </ul>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('web/js/jquery-waypoints.min.js') }}"></script>
<script src="{{ asset('web/js/jquery-counterup.min.js') }}"></script>
@isset($jskontak) <script src="{{ asset('web/js/sweetalert2.min.js') }}"></script><script src="{{ asset('web/js/kontak.js') }}"></script> @endisset
@isset($jobdetailjs) <script src="{{ asset('web/js/jssocials.js') }}"></script><script src="{{ asset('web/js/jobdetail.js') }}"></script> @endisset
<script>
  $(function(){
      $('#intro-slider').slick({
          slidesToShow:1,
          infinite:true,
          arrows:false,
          dots:true,
          pauseOnHover:true,
          autoplay:true,
          autoplaySpeed:8000,
          prevArrow:'<button type="button" class="btn-slick-nav slick-prev"><i class="feather-arrow-left"></i></button>',
          nextArrow:'<button type="button" class="btn-slick-nav slick-next"><i class="feather-arrow-right"></i></button>'
      });
      $('.row-lowongan-kota').slick({
          slidesToShow:5,
          infinite:true,
          arrows:false,
          dots:true,
          pauseOnHover:true,
          autoplay:true,
          autoplaySpeed:8000,
          prevArrow:'<button type="button" class="btn-slick-nav slick-prev"><i class="feather-arrow-left"></i></button>',
          nextArrow:'<button type="button" class="btn-slick-nav slick-next"><i class="feather-arrow-right"></i></button>',
          responsive: [
              {
                  breakpoint: 769,
                  settings: {
                      slidesToShow:3
                  }
              },
              {
                  breakpoint: 480,
                  settings: {
                      slidesToShow:1
                  }
              }
          ]
      });

      $(window).on('scroll',function(){
        var y = $(window).scrollTop() /5;
        $('#intro-slider').css({'transform':'translateY('+y+'px)'})
      });
      
      $("[data-counter='counterup']").counterUp({
        delay: 20,
        time: 1000
      });
      $("#fixed-form-container .body").hide();
        $("#fixed-form-container .button").click(function () {
            $(this).next("#fixed-form-container div").slideToggle(400);
            $(this).toggleClass("expanded");
        });
        
        
  });
</script>

</body>
</html>