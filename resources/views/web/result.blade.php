
@extends('layouts.web')

@section('main')
<section class="py-5">
    <div class="container">
        <div class="row row-pane align-items-center mx-n1 mb-4">
            <div class="col px-1 mb-4 mb-lg-0">
                {{ $totalpekerjaan }} lowongan kerja cocok dengan pencarian anda 
            </div>
            <div class="col-lg-auto px-1 d-none d-lg-block mb-4 mb-lg-0">
                <div class="row">
                    <div class="col-auto align-self-center">Tampilan</div>
                    <div class="col-auto">
                        <div class="btn-group btn-grid-select">
                            <button type="button" class="btn btn-secondary btn-grid-card"><i class="fa fa-th"></i></button>
                            <button type="button" class="btn btn-secondary btn-grid-list active"><i class="fa fa-list"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-auto px-1 mb-4 mb-lg-0">
                <select name="" id="" class="form-control">
                    <option value="">Semua Industri</option>
                    <option value="">Desain & Seni</option>
                    <option value="">Perhotelan & Penginapan</option>
                    <option value="">Kesehatan & Kebugaran</option>
                    <option value="">Keuangan</option>
                    <option value="">Makanan & Minuman</option>
                    <option value="">Manufaktur</option>
                    <option value="">Pendidikan & Pelatihan</option>
                    <option value="">Sales/ Marketing</option>
                    <option value="">Layanan & Keamanan</option>
                    <option value="">Staf</option>
                    <option value="">Teknologi</option>
                </select>
            </div>
            <div class="col-lg-auto px-1 mb-4 mb-lg-0">
                <select name="" id="" class="form-control">
                    <option value="">Dibutuhkan Segera</option>
                    <option value="">Terbaru</option>
                    <option value="">Gaji Tertinggi</option>
                </select>
            </div> --}}
        </div>
        <div class="row row-lowongan-wrap">
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
            <div class="col-md-6 col-lg-12 mb-4">
                <div class="card card-lowongan p-4">
                    <div class="row row-card-lowongan">
                        <div class="col-lg-auto text-center">
                            @empty($data->gambar)
                                <a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}"><img src="{{ asset('img/no-image.png') }}" alt="{{ $data->gambar }}" class="object-fit-contain" width="150" height="150"></a>
                            @else
                                <a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}"><img src="{{ asset('img/'.$data->gambar.'') }}" alt="{{ $data->gambar }}" class="object-fit-contain" width="150" height="150"></a>
                            @endempty
                        </div>
                        <div class="col-lg">
                            <h5><a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}" class="text-reset">{{ $data->pekerjaan }}</a></h5>
                            <div class="desc text-muted mb-2">
                                {{ $data->perusahaan }}
                            </div>
                            <div class="row row-detail mb-1 font-small">
                                <div class="col-auto pr-0"><i class="fa fa-fw fa-map-marker"></i></div>
                                <div class="col"> {{ Applib::CariNamaKota($data->kota)}} {{ Applib::CariNamaProvinsi($data->provinsi)}}</div>
                            </div>
                            <div class="row row-detail mb-1 font-small">
                                <div class="col-auto pr-0"><i class="fa fa-fw fa-graduation-cap"></i></div>
                                <div class="col">{{ Applib::CariNamaPendidikan($data->pendidikan)}}</div>
                            </div>
                            <div class="row row-detail mb-1 font-small">
                                <div class="col-auto pr-0"><i class="fa fa-fw fa-user-circle-o"></i></div>
                            <div class="col">{{ ucwords(Applib::CariNamaKategori($data->id_kategori)) }}</div>
                            </div>
                            <div class="mt-2">
                                <div class="badge bg-action text-white">{{ $label }}</div>
                                <div class="badge badge-secondary">{{ $gaji }}</div>
                            </div>
                            <div class="text-muted mt-2"><small>Terakhir Update  {{ Sistem::time_since($data->created_at) }}</small></div>
                        </div>
                        <div class="col-lg-auto col-action border-left mt-4 mt-lg-0">
                            <div class="d-flex align-items-center h-100">
                                <div class="w-100">
                                    <a href="{{ $website.'/loker/p/'.$data->id.'/'.$data->slug }}" class="btn btn-accent btn-block py-2 px-4 mb-1">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $jobs->links()}}
    </div>
</section>
@endsection