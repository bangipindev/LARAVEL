<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@yield('title')
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<link href="{{ asset('img/'.$favicon.'') }} " rel="shortcut icon" >
		<link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('vendor/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" media="screen" />
		@isset($css) {!! $css !!} @endisset	
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	</head>
	<body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url('/appmaster') }}" class="site_title"><img src="{{ asset('img/'.$favicon.'') }}"> <span>{{ $situs }}</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="{{ asset('img/avatar.png') }}" alt="profile" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                               <span>Hallo,</span>
                               <h2>{{ Auth::user()->name }} </h2>
                            </div>
                        </div>
                        <br />
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>Home</h3>
                                <ul class="nav side-menu">
                                    <li><a href="{{ url('appmaster/home')}}"><i class="fa fa-home"></i>{{ __('Home') }}</a></li>
                                    <li><a href="{{ url('appmaster/menu')}}"><i class="fa fa-list"></i>{{ __('Menu') }} </a></li>
                                    <li><a><i class="fa fa-maxcdn"></i> {{ __('Modul') }} <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ url('appmaster/sliders') }}">{{ __('Slider') }} </a></li>
                                            <li><a href="{{ url('appmaster/modul') }}">{{ __('Modul') }} </a></li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-building-o"></i>{{ __('Jobs') }} <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ url('appmaster/jobskategori') }}">{{ __('Kategori Pekerjaan') }} </a></li>
                                            <li><a href="{{ url('appmaster/pekerjaan') }}">{{ __('Pekerjaan') }} </a></li>
                                            <li><a href="{{ url('appmaster/pendidikan') }}">{{ __('Pendidikan') }} </a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ url('appmaster/pages')}}"><i class="fa fa-th"></i>{{ __('Halaman') }}</a></li>
                                    <li><a><i class="fa fa-windows"></i>{{ __('Halaman Statis') }}<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ url('appmaster/linkhome') }}">{{ __('Home') }}</a></li>
                                            <li><a href="{{ url('appmaster/linkfeatures') }}">{{ __('Fitur') }}</a></li>
                                            <li><a href="{{ url('appmaster/abouts') }}">{{ __('Tentang Kami') }}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ url('appmaster/categories') }}"><i class="fa fa-book"></i>{{ __('Kategori') }}</a></li>
                                    <li><a href="{{ url('appmaster/articles') }}"><i class="fa fa-bold"></i>{{ __('Blog') }}</a></li>
                                    <li><a href="{{ url('appmaster/comments') }}"><i class="fa fa-comments-o"></i>{{ __('Komentar') }} @if(!empty(Applib::totalKomentar()))
                                        <span class="badge badge-danger">{{ Applib::totalKomentar() }}</span> @endif
                                    <li><a href="{{ url('appmaster/tags') }}"><i class="fa fa-tag"></i>{{ __('Tag') }} </a></li>
                                    <li><a href="{{ url('/ckfinder/ckfinder.html') }}" class="fancy"><i class="fa fa-camera"></i>{{ __('Media') }} </a></li>
                                    <li><a href="{{ url('appmaster/gallery') }}"><i class="fa fa-image"></i>{{ __('Galeri') }} </a></li>
                                    <li><a href="{{ url('appmaster/testimoni') }}"><i class="fa fa-comments-o"></i>{{ __('Testimoni') }} </a></li>
                                    <li><a href="{{ url('appmaster/maps') }}"><i class="fa fa-map-marker"></i>{{ __('Maps') }} </a></li>
                                    <li><a href="{{ url('appmaster/fanpage') }}"><i class="fa fa-facebook"></i>{{ __('Fanpage FB') }} </a></li>
                                    <li><a><i class="fa fa-gears"></i>{{ __('Sistem') }}<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ url('appmaster/config') }}">Pengaturan</a></li>
                                            <li><a href="{{ url('appmaster/config/logo') }}">{{ __('Logo') }}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ url('appmaster/user') }}"><i class="fa fa-users"></i>{{ __('Pengguna') }} </a></li>
                                    <li><a href="{{ url('appmaster/visitor') }}"><i class="fa fa-line-chart"></i>{{ __('Visitor') }} </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-footer hidden-small">
                            <a href="{{ url('appmaster/config') }}" data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a href="{{ url('/') }}" data-toggle="tooltip" data-placement="top" title="lihat website">
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
              
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('img/avatar.png') }}" alt="">{{ Auth::user()->name }} 
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="{{ url('appmaster/user') }}"> Profile</a></li>
                                    <li>
                                        <a href="{{ url('appmaster/config') }}">
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> {{ __('Logout') }}</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
              
                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    @empty(Applib::totalInbox())
                                        <i class="fa fa-envelope-o"></i>
                                    @else
                                        <i class="fa fa-envelope"></i>
                                    @endempty
                                    @if(!empty(Applib::totalInbox()))
                                        <span class="badge badge-green">{{ Applib::totalInbox() }} </span> 
                                    @endif
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    @foreach(Applib::listInbox() as $inb)
                                    <li>
                                        <a href="{{ url('appmaster/inbox') }}" data-messageid="{{ $inb->id }}">
                                            <span class="image"><img src="{{ asset('img/avatar.png') }}" alt="Profile Image" /></span>
                                            <span>
                                                <span>{{ $inb->nama }} </span>
                                                <span class="time">{{ Sistem::time_since($inb->created_at) }}</span>
                                            </span>
                                            <span class="message">
                                                {{ Str::limit($inb->pesan,30) }}
                                            </span>
                                        </a>
                                    </li>
                                    @endforeach
                                    <li>
                                        <div class="text-center">
                                            <a href="{{ url('appmaster/inbox')}}">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a href="{{ url('/') }}" title="Lihat Website" target="_blank" class="dropdown-toggle" data-hover="dropdown"  aria-expanded="false">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="right_col" role="main">
                <div class="clearfix"></div>
                @if (session('SUCCESSMSG'))
                    <div role="alert" class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                        <strong>Sukses!</strong>
                        {{ session('SUCCESSMSG') }}
                    </div>
                @endif
                @if (session('GAGALMSG'))
                    <div role="alert" class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                        {{ session('GAGALMSG') }}
                    </div>
                @endif
            
                @yield('section')
        
                <div class="clearfix"></div>   
            </div>
            
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
    
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendor/fancybox/source/jquery.fancybox.js') }}" type="text/javascript" ></script>
        @isset($js) {!! $js !!} @endisset
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('vendor/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/server.js') }}" type="text/javascript"></script>
        @isset($script) {!! $script !!} @endisset              
    </body>
</html>
  











		