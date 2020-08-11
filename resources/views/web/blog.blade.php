@extends('layouts.web')

@section('main')
<section class="py-4 section-news-headline bg-accent">
    <div class="container">
        <div class="row">
            @foreach( $populer as $data)
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="card border-0 card-news-headline">
                    <img src="{{ asset('img/'.$data->gambar.'') }}" alt="{{ $data->judul }}" class="card-img w-100 object-fit-cover" height="425">
                    <a href="{{ url('blog/'.$data->kategori.'/'.$data->slug.'') }}" class="card-img-overlay d-flex align-items-end">
                        <div class="info">
                            <h4>{{ $data->judul }}</h4>
                            <div class="meta"><small>{{ $data->penulis }}, {{ Sistem::time_since($data->created_at) }}</small></div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            <div class="col-lg-5 mb-4 mb-lg-0">
                @foreach( $baru as $data)
                <div class="card border-0 card-news-headline mb-4">
                    <img src="{{ asset('img/'.$data->gambar.'') }}" alt="{{ $data->judul }}" class="card-img w-100 object-fit-cover" height="200">
                    <a href="{{ url('blog/'.$data->kategori.'/'.$data->slug.'') }}" class="card-img-overlay d-flex align-items-end">
                        <div class="info">
                            <h4>{{ $data->judul }}</h4>
                            <div class="meta"><small>{{ $data->penulis }}, {{ Sistem::time_since($data->created_at) }}</small></div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h4 class="font-weight-bold">ARTIKEL TERBARU</h4>
                <hr/>
                @isset($blog)
                @foreach($blog as $data)
                <div class="media media-news mb-4 flex-column flex-lg-row">
                <img src="{{ asset('img/'.$data->gambar.'')}}" alt="{{ $data->judul }}" class="mr-lg-3 object-fit-cover col col-lg-4 p-0 mb-2 mb-lg-0" width="250" height="150">
                    <div class="media-body">
                        <h5 class="m-0"><a href="{{ url('blog/'.$data->kategori.'/'.$data->slug.'') }}" class="text-reset">{{ $data->judul }}</a></h5>
                        <div class="meta text-muted mb-3"><small>By {{ $data->penulis }}, {{ Sistem::tgl_indo_timestamp($data->created_at) }}</small></div>
                        <div class="desc">
                            {!! Str::limit($data->konten,300) !!}
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $blog->links() }}
                @endisset
                @isset($blogkategori)
                @foreach($blogkategori as $data)
                <div class="media media-news mb-4 flex-column flex-lg-row">
                <img src="{{ asset('img/'.$data->gambar.'')}}" alt="{{ $data->judul }}" class="mr-lg-3 object-fit-cover col col-lg-4 p-0 mb-2 mb-lg-0" width="250" height="150">
                    <div class="media-body">
                        <h5 class="m-0"><a href="{{ url('blog/'.$data->kategori.'/'.$data->slug.'') }}" class="text-reset">{{ $data->judul }}</a></h5>
                        <div class="meta text-muted mb-3"><small>By {{ $data->penulis }}, {{ Sistem::tgl_indo_timestamp($data->created_at) }}</small></div>
                        <div class="desc">
                            {!! Str::limit($data->konten,300) !!}
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $blogkategori->links() }}
                @endisset
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
                    @foreach( $populerside as $data)
                    <div class="media media-news mb-2">
                        <img src="{{ asset('img/'.$data->gambar.'')}}" alt="{{ $data->judul }}" class="mr-3 object-fit-cover" width="80" height="80">
                        <div class="media-body">
                            <h6 class="m-0"><a href="{{ url('blog/'.$data->kategori.'/'.$data->slug.'') }}" class="text-reset">{{ $data->judul }}</a></h6>
                            <div class="meta text-muted mb-3"><small>By {{ $data->penulis }}, {{ Sistem::tgl_indo_timestamp($data->created_at) }}</small></div>
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