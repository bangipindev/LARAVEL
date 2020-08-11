@extends('layouts.web')

@section('main')
<section class="py-5 section-heading section-bg section-bg-overlay text-white">
    <img src="https://images.pexels.com/photos/302769/pexels-photo-302769.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="" class="bg">
    <div class="container py-lg-5">
        <h2 class="font-weight-bold text-center">{{ $title }}</h2>
    </div>
</section>
<section class="py-5 article">
    <div class="container">
       @isset($konten){!!$konten !!} @endisset
    </div>
</section>

<section class="py-5 section-about bg-action text-white section-bg">
    <img src="{{ asset('web/images/background/intro-bg.jpg') }}" alt="" class="bg">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="font-weight-bold">Alasan kenapa memilih Halokerja.id ?</h3>
            <h4 class="font-weight-light">Simple dan mudah untuk mencari pekerjaan di halokerja.id</h4>
        </div>
        <div class="row row-about text-center">
            <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                <div class="mb-4"><img src="{{ asset('web/images/background/icon-headhunter.svg') }}" alt="" height="80"></div>
                <h4 class="font-weight-bold">{{ $heading1 }}</h4>
                <p>
                    {{ $teks1 }}
                </p>
            </div>
            <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                <div class="mb-4"><img src="{{ asset('web/images/background/icon-apply.svg') }}" alt="" height="80"></div>
                <h4 class="font-weight-bold">{{ $heading2 }}</h4>
                <p>
                    {{ $teks2 }}
                </p>
            </div>
            <div class="col-md-4 col-lg-4 mb-4 mb-lg-0">
                <div class="mb-4"><img src="{{ asset('web/images/background/icon-interview.svg') }}" alt="" height="80"></div>
                <h4 class="font-weight-bold">{{ $heading3 }}</h4>
                <p>
                    {{ $teks3 }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection