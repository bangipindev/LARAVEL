@extends('layouts.web')

@section('main')
<section class="py-5 section-news">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0 article">
                <h2 class="m-0">{{ $titleblog }}</h2>
            <div class="meta text-muted mb-4"><small>By {{ $detail->penulis }}, {{ Sistem::konversitanggal($detail->created_at) }}</small></div>
            <img src="{{ asset('img/'.$detail->gambar.'') }}" alt="{{ $detail->judul }}">
                <br/><br/>
                {!! $detail->konten !!}
                <div class="mt-5">
                    <h5 class="font-weight-bold mb-4">Bagi Artikel Ini</h5>
                    <ul class="nav m-0">
                        <li class="nav-item"><a href="#" class="nav-link px-0 pr-3"><img src="{{ asset('web/images/social/facebook.svg') }}" alt="" width="32"></a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 pr-3"><img src="{{ asset('web/images/social/twitter.svg') }}" alt="" width="32"></a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-0 pr-3"><img src="{{ asset('web/images/social/whatsapp.svg') }}" alt="" width="32"></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="widget widget-search mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Artikel..">
                        <div class="input-group-append">
                            <button class="btn btn-accent"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <div class="widget widget-news mb-4">
                    <h5 class="font-weight-bold">ARTIKEL TERPOPULER</h5>
                    <hr/>
                    @foreach( $populer as $data)
                    <div class="media media-news mb-2">
                        <img src="{{ asset('img/'.$data->gambar.'')}}" alt="{{ $data->judul }}" class="mr-3 object-fit-cover" width="80" height="80">
                        <div class="media-body">
                            <h6 class="m-0"><a href="{{ url('blog/'.$data->kategori.'/'.$data->slug.'') }}" class="text-reset">{{ $data->judul }}</a></h6>
                            <div class="meta text-muted mb-3"><small>{{ $data->penulis }}, {{ Sistem::konversitanggal($data->created_at) }}</small></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 section-about bg-action text-white section-bg">
    <img src="{{ asset('web/images/background/intro-bg.jpg') }}" alt="" class="bg">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="font-weight-bold">Cari Pekerjaan Semudah di Halokerja.id</h3>
            <h4 class="font-weight-light">Cari pekerjaan, Lamar dan Tunggu hasilnya</h4>
        </div>
        <div class="row row-about text-center">
            <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                <div class="mb-4"><img src="{{ asset('web/images/background/icon-headhunter.svg') }}" alt="" height="80"></div>
                <h4 class="font-weight-bold">{{ $fitur1 }}</h4>
                <p>
                    {{ $desk1 }}
                </p>
            </div>
            <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                <div class="mb-4"><img src="{{ asset('web/images/background/icon-apply.svg') }}" alt="" height="80"></div>
                <h4 class="font-weight-bold">{{ $fitur2 }}</h4>
                <p>
                    {{ $desk2 }}
                </p>
            </div>
            <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                <div class="mb-4"><img src="{{ asset('web/images/background/icon-interview.svg') }}" alt="" height="80"></div>
                <h4 class="font-weight-bold">{{ $fitur3 }}</h4>
                <p>
                    {{ $desk3 }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection