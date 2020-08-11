@extends('layouts.web')

@section('main')
    <section id="intro-slider">
        @foreach($slider_top as $data)
        <a href="#" class="slide">
        <img src="{{ asset('img/'.$data->gambar) }}" alt="{{ $data->gambar }}" class="w-100">
        </a>
        @endforeach
    </section>

    <section class="py-5 section-statistic bg-white position-relative">
        <div class="container">
            <div class="row row-statistic text-center">
                <div class="col-4">
                    <div class="icon mb-4"><img src="{{ asset('web/images/background/icon-follower.svg') }}" alt="" width="80"></div>
                    <h2 class="display-5" data-counter="counterup">219657</h2>
                    <h5 class="font-weight-light text-muted">Followers</h5>
                </div>
                <div class="col-4">
                    <div class="icon mb-4"><img src="{{ asset('web/images/background/icon-jobs.svg') }}" alt="" width="80"></div>
                    <h2 class="display-5" data-counter="counterup">{{ $totalpekerjaan }}</h2>
                    <h5 class="font-weight-light text-muted">Jobs</h5>
                </div>
                <div class="col-4">
                    <div class="icon mb-4"><img src="{{ asset('web/images/background/icon-visitor.svg') }}" alt="" width="80"></div>
                    <h2 class="display-5" data-counter="counterup">{{ $totaluser }}</h2>
                    <h5 class="font-weight-light text-muted">Visitors</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 section-list-lowongan">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="font-weight-bold">LOWONGAN KERJA <span class="text-action">TERBARU</span></h3>
                <h4 class="text-muted font-weight-light">Cari & Apply</h4>
            </div>
            <div class="row row-lowongan flex-nowrap flex-md-wrap overflow-auto">
                @foreach($jobs as $data)
                    @php
                    $toga 	= explode('-',$data->pendidikan);
                        if ($data->gaji == 0){
                            $gaji = "Gaji : Dirahasiakan";
                        }else{
                            $gaji = Sistem::format_rupiah($data->gaji);
                        }
                        if($data->label == 0){
                            $label = "Freelance";
                        }
                        else if($data->label == 1 ){
                            $label = "Full Time";
                        }
                        else if($data->label == 2 ){
                            $label= "Part Time";
                            }
                        else{
                            $label= "";
                        }
                    @endphp
                <div class="col-10 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            @empty($data->gambar)
                            <a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}"><img src="{{ asset('img/no-image.png') }}" alt="{{ $data->gambar }}" class="object-fit-contain w-100" height="150"></a>
                            @else
                            <a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}"><img src="{{ asset('img/'.$data->gambar.'') }}" alt="{{ $data->gambar }}" class="object-fit-contain w-100" height="150"></a>
                            @endempty
                            <h6><a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}" class="text-reset">{{ $data->pekerjaan }}</a></h6>
                            <div class="desc text-muted mb-4">
                                {{ $data->perusahaan }}
                            </div>
                            <div class="row row-detail mb-1 font-small">
                                <div class="col-auto pr-0"><i class="fa fa-fw fa-map-marker"></i></div>
                                <div class="col">{{ Applib::CariNamaKota($data->kota)}} {{ Applib::CariNamaProvinsi($data->provinsi) }}</div>
                            </div>
                            <div class="row row-detail mb-1 font-small">
                                <div class="col-auto pr-0"><i class="fa fa-fw fa-graduation-cap"></i></div>
                                <div class="col">{{ Applib::CariNamaPendidikan($data->pendidikan)}}</div>
                            </div>
                            <div class="mt-4">
                                <div class="badge bg-action text-white">{{ $label }}</div>
                                <div class="badge badge-secondary">{{ $gaji }}</div>
                            </div>
                        </div>
                        <div class="card-footer font-small text-muted">
                            Terakhir Update  {{ Sistem::time_since($data->created_at) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-5 text-center">
                <a href="{{ $website.'/loker' }}" class="btn btn-action py-3 px-4 shadow">Lihat Semua Lowongan</a>
            </div>
        </div>
    </section>

    <section class="py-5 section-list-lowongan">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="font-weight-bold">LOWONGAN KERJA <span class="text-accent">BERDASARKAN INDUSTRI</span></h3>
                <h4 class="text-muted font-weight-light">Lihat lowongan berdasarkan industri</h4>
            </div>

            <div class="row row-job-industry no-gutters">
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/desain-dan-seni' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-desain.svg') }}" alt="" width="30"></div>
                        <div class="title">Desain & Seni</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/perhotelan-dan-penginapan' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-penginapan.svg') }}" alt="" width="30"></div>
                        <div class="title">Perhotelan & Penginapan</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/kesehatan-dan-kebugaran' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-kesehatan.svg') }}" alt="" width="30"></div>
                        <div class="title">Kesehatan & Kebugaran</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/keuangan' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-keuangan.svg') }}" alt="" width="30"></div>
                        <div class="title">Keuangan</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/makanan-dan-minuman' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-makanan.svg') }}" alt="" width="30"></div>
                        <div class="title">Makanan & Minuman</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/manufaktur' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-manufaktur.svg') }}" alt="" width="30"></div>
                        <div class="title">Manufaktur</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/pendidikan-dan-pelatihan' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-pendidikan.svg') }}" alt="" width="30"></div>
                        <div class="title">Pendidikan & Pelatihan</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/sales-dan-marketing' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-sales.svg') }}" alt="" width="30"></div>
                        <div class="title">Sales/ Marketing</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/layanan-dan-keamanan' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-keamanan.svg') }}" alt="" width="30"></div>
                        <div class="title">Layanan & Keamanan</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/staf-kantor' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-staf.svg') }}" alt="" width="30"></div>
                        <div class="title">Staf</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/teknologi' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-technology.svg') }}" alt="" width="30"></div>
                        <div class="title">Teknologi</div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $website.'/loker/lain-lain' }}" class="d-flex item">
                        <div class="icon pr-3"><img src="{{ asset('web/images/icon/icon-lain.svg') }}" alt="" width="30"></div>
                        <div class="title">Lain-lain</div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 section-lowongan-kota">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="font-weight-bold">LOWONGAN TERBAIK DI KOTA ANDA</h3>
                <h4 class="text-muted font-weight-light">Peluang karir menarik menanti Anda di kota-kota ini</h4>
            </div>

            <div class="row row-lowongan-kota">
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/yogyakarta.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/jogja') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Yogyakarta</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/jakarta.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/jakarta') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Jakarta</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/surabaya.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/surabaya') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Surabaya</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/semarang.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/semarang') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Semarang</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/malang.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/malang') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Malang</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/palembang.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/palembang') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Palembang</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/ambon.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/ambon') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Ambon</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/manado.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/manado') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Manado</div>
                        </a>
                    </div>  
                </div>
                <div class="col">
                    <div class="card border-0 card-kota">
                        <img src="{{ asset('web/images/kota/pontianak.jpg') }}" alt="" class="object-fit-cover w-100" height="300px">
                        <a href="{{ url('/kota/pontianak') }}" class="card-img-overlay d-flex align-items-end">
                            <div class="title">Pontianak</div>
                        </a>
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