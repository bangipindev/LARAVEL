@extends('layouts.web')

@section('main')
<section class="py-5 section-heading section-bg">
    <img src="https://images.pexels.com/photos/1105766/pexels-photo-1105766.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="" class="bg col col-lg-6 p-0">
    <div class="container py-lg-5">
        <div class="row justify-content-end">
            <div class="col-lg-8">
                <div class="bg-white p-5 article">
                    <h2 class="font-weight-bold mb-4">KONTAK KAMI</h2>
                    <div class="media mb-3">
                        <div class="icon mr-3 btn btn-accent"><i class="fa fa-fw fa-map-marker"></i></div>
                        <div class="media-body">{{ $alamat }}</div>
                    </div>
                    <div class="media mb-3">
                        <div class="icon mr-3 btn btn-accent"><i class="fa fa-fw fa-envelope-o"></i></div>
                        <div class="media-body">Customer Support: <a href="mailto:{{ $email }}">info@halokerja.id</a></div>
                    </div>
                    <div class="media mb-3">
                        <div class="icon mr-3 btn btn-accent"><i class="fa fa-fw fa-phone"></i></div>
                        <div class="media-body">HP / WA Kantor: {{ $telp }}</div>
                    </div>
                    <h3 class="font-weight-bold mb-4">Hubungi Kami</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Subject" id="subjek" name="subjek" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <textarea id="pesan" name="pesan" cols="30" rows="5" class="form-control" placeholder="Pesan Anda"></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <button class="btn btn-accent py-3 px-5">Kirim Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 article">
    <div class="container">
        
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