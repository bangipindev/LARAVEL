@extends('layouts.web')

@section('main')
@php
    $baca=$detail['hits']; 
    Applib::updatehits($detail->id,$baca);
@endphp
<section class="py-4 bg-action text-white section-lowongan-detail-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-auto mb-4 mb-lg-0 text-center">
                @empty($detail->gambar)
                    <img src="{{ asset('img/no-image.png') }}" alt="{{ $detail->pekerjaan }}" class="object-fit-contain radius-5" width="150" height="150">
                @else
                    <img src="{{ asset('img/'.$detail->gambar.'') }}" alt="{{ $detail->pekerjaan }}" class="object-fit-contain radius-5" width="150" height="150">
                @endempty
            </div>
            <div class="col-lg mb-4 mb-lg-0 text-center text-md-left">
                <h5><a href="{{ $website.'/loker/p/'.$detail->id.'/'.$detail->slug }}" class="text-reset">{{ $detail->pekerjaan }}</a></h5>
                <div class="desc mb-2">
                    {{ $detail->perusahaan }}
                </div>
                <div class="row justify-content-center justify-content-md-start">
                    <div class="col-auto">
                        <div class="row row-detail mb-1 font-small">
                            <div class="col-auto pr-0"><i class="fa fa-fw fa-map-marker"></i></div>
                            <div class="col">{{ Applib::CariNamaKota($detail->kota)}} {{ Applib::CariNamaProvinsi($detail->provinsi)}}</div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="row row-detail mb-1 font-small">
                            <div class="col-auto pr-0"><i class="fa fa-fw fa-graduation-cap"></i></div>
                            <div class="col">{{ Applib::CariNamaPendidikan($detail->pendidikan) }}</div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="row row-detail mb-1 font-small">
                            <div class="col-auto pr-0"><i class="fa fa-fw fa-user-circle-o"></i></div>
                            <div class="col">{{ ucwords(Applib::CariNamaKategori($detail->id_kategori)) }}</div>
                        </div>
                    </div>
                </div>
                @php
                if ($detail['gaji']== 0){
                    $gaji = "Dirahasiakan";
                }else{
                    $gaji = Sistem::format_rupiah($detail['gaji']);
                }
                if($detail['label'] == 0){
                    $label = "Freelance";
                }elseif($detail['label'] == 1 ){
                    $label = "Full Time";
                }elseif($detail['label'] == 2 ){
                    $label = "Part Time";
                }
                @endphp
                <div class="mt-2">
                    <div class="badge bg-second text-white">{{ $label }}</div>
                    <div class="badge badge-secondary">{{ $gaji }}</div>
                </div>
                <div class="mt-2"><small>Terakhir Update  {{ Sistem::time_since($detail->created_at) }}</small></div>
            </div>
            <div class="col-lg-auto align-self-center">
                @php 
                    $selisih = Applib::selisih($detail['id']);
                    $cek	 = Applib::expired($detail['id'],$selisih);
                @endphp
                @if($detail['expired'] == 0 )
                    <a href="mailto:{{ $detail->email }}" class="btn btn-light btn-block py-2 px-4 mb-1 disabled">Closed</a>
                @else
                    @empty($detail->email)
                        <a href="#" class="btn btn-light btn-block py-2 px-4 mb-1 iklan-hide ">Kirim Lamaran</a>
                    @else
                        <a href="mailto:{{ $detail->email }}" class="btn btn-light btn-block py-2 px-4 mb-1 ">Kirim Lamaran</a>
                    @endempty
                @endif
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg mb-4 mb-lg-0 article">
                <h4 class="mb-4">Deskripsi Lowongan</h4>
                {!! $detail->deskripsi !!}
            </div>
            <div class="col-lg-4 border-lg-dashed-left">
                <h4 class="mb-3">Bagikan Lowongan ini</h4>
                <ul class="nav">
                    <div id="sharePopup" class="share"></div>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="py-5 section-list-lowongan">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="font-weight-bold">LOWONGAN KERJA TERKAIT</h3>
        </div>
        <div class="row row-lowongan flex-nowrap flex-md-wrap overflow-auto">
            @foreach($lokerterkait as $data)
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
                            <div class="col">{{ Applib::CariNamaKota($data->kota)}} {{ Applib::CariNamaProvinsi($data->provinsi)}}</div>
                        </div>
                        <div class="row row-detail mb-1 font-small">
                            <div class="col-auto pr-0"><i class="fa fa-fw fa-graduation-cap"></i></div>
                            <div class="col">{{ ucwords(Applib::CariNamaPendidikan($data->pendidikan)) }}</div>
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
    </div>
</section>
@endsection