@extends('layouts.admin')

@section('title')
	<title> {{ $title }} </title>
	@endsection
@section('section')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>{{ $title }} <small></small></h3>
		</div>

	</div>

	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="row">
					<div class="x_content">
						<form action="{{ url('appmaster/pekerjaan/create') }}" id="formpekerjaan" class="form-horizontal" method="POST" enctype="multipart/form-data" >
							@csrf
							<div class="row margin-bottom-25 produk-block">
								<h3 class="block">Detail Pekerjaan</h3>
								<div class="item form-group">
									<input type="hidden" class="form-control" name="id" value="{{ $id }}" readonly="true">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label"> Judul Pekerjaan: <span class="required">* </span></label>
									<div class="col-md-10 col-xs-12">
										<input type="text" class="form-control maxlength-handler" maxlength="110"name="nama_pekerjaan" id="nama_pekerjaan" value="{{ $nama_pekerjaan }}" required>
										
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Description: <span class="required"></span></label>
									<div class="col-md-10 col-xs-12">
										<textarea class="form-control" id="ckeditor" id="deskripsi" name="deskripsi"  >{{ $deskripsi }} </textarea>
										
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Short Description: <span class="required">
									</span>
									</label>
									<div class="col-md-10 col-xs-12">
										<textarea class="form-control" name="short_deskripsi" id="editorsummernote" rows="8" >{{ $short_deskripsi }}</textarea>
										<span class="help-block">shown in product listing </span>
										
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Kategori: <span class="required">*</span></label>
									<div class="col-md-10 col-xs-12">
										<select name="kategori" id="kategori" class="table-group-action-input form-control select2me">
											@foreach ($dd_kategori as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $kategori) ? 'selected' : $kategori }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								
							</div>
						
							<div class="row margin-bottom-25 produk-block">
								<div class="form-body">
								<h3 class="block">Posting Loker di Kota</h3>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Loker Kota: <span class="required">*</span></label>
									<div class="col-md-10 col-xs-12">
										<select name="lokerkota" id="lokerkota" class="table-group-action-input form-control select2me">
											@foreach ($dd_lokerkota as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $lokerkota) ? 'selected' : $lokerkota }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								</div>
							</div>

							<div class="row margin-bottom-25 produk-block">
								<h3 class="block">Detail Info</h3>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Provinsi</label>
									<div class="col-md-10 col-xs-12">
										<select name="provinsi" id="destination" class="table-group-action-input form-control select2me">
											@foreach ($dd_provinsi as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $provinsi) ? 'selected' : $provinsi }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Kota/Kab</label>
									<div class="col-md-10 col-xs-12">
										<select name="kota" id="kabupatenkota" class="table-group-action-input form-control select2me">
											@foreach ($dd_kotakab as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $kota) ? 'selected' : $kota }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Gaji: <span class="required">* </span></label>
									<div class="col-md-10 col-xs-12">
										<input type="text" class="form-control" name="gaji" id="gaji" value="{{ $gaji }}" required>
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Status: <span class="required">* </span>	</label>
									<div class="col-md-10 col-xs-12">
										<select name="status" id="status" class="table-group-action-input form-control select2me">
											@foreach ($dd_status as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $status) ? 'selected' : $status }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-2">Pendidikan</label>
									<div class="col-md-10 col-xs-12">
										<select name="pendidikan" id="pendidikan" class="table-group-action-input form-control select2me">
											@foreach ($levelpendidikan as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $pendidikan) ? 'selected' : $pendidikan }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Tipe Pekerjaan: <span class="required"></span></label>
									<div class="col-md-10 col-xs-12">
										<select name="label" id="label" class="table-group-action-input form-control select2me">
											@foreach ($dd_label as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $label) ? 'selected' : $label }}> 
													{{ $value }} 
												</option>
											@endforeach    
										</select>
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Batas Waktu: <span class="required"></span></label>
									<div class="col-md-10 col-xs-12">
										<input class="form-control" name="bataswaktu"  id="bataswaktu" value="{{ $bataswaktu }}">
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Email Perusahaan: <span class="required"></span></label>
									<div class="col-md-10 col-xs-12">
										<input type="text" class="form-control" name="email" id="email" value="{{ $email }}" >
									</div>
								</div>
							</div>
					
							<div class="row margin-bottom-25 produk-block">
								<h3 class="block">Detail Meta</h3>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Meta Description:</label>
									<div class="col-md-10 col-xs-12">
										<textarea class="form-control maxlength-handler" rows="8" name="meta_deskripsi"  maxlength="255">{{ $meta_deskripsi }}</textarea>
										<span class="help-block">
										max 255 chars </span>
									</div>
								</div>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Meta Keywords:</label>
									<div class="col-md-10 col-xs-12">
										<textarea class="form-control maxlength-handler" rows="8" name="meta_keyword" maxlength="1000">{{ $meta_keyword }}</textarea>
										<span class="help-block">
										max 1000 chars </span>
									</div>
								</div>
							</div>
						
							<div class="row margin-bottom-25 produk-block">
								<h3 class="block">Detail Perusahaan</h3>
								<div class="item form-group">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Nama Perusahaan: <span class="required">* </span></label>
									<div class="col-md-10 col-xs-12">
										<input type="text" class="form-control" name="perusahaan" id="perusahaan" value="{{ $perusahaan }}" required>
									</div>
								</div>
								<div class="item form-group ">
									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Logo:<span class="text-danger">*</span></label>
									<div class="col-md-10 col-xs-12">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												@empty($image)
													<img src="{{ asset('img/no-image.png') }}" style="width:200px;height:150px;" alt=""/>
												@else
													<img src="{{ asset('img/'.$image) }}" style="width:200px;height:150px;"  alt=""/>
												@endempty
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
											<div>
												<span class="btn btn-primary btn-file">
													<span class="fileinput-new">Select image </span>
													<span class="fileinput-exists">Change </span>
													<input type="file" name="image">
												</span>
												<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">Remove </a>
												<input type="hidden"  class="form-control" name="imagelama" value="{{ $image }}">
												<span class="help-block"> Maksimal Size Gambar 1 mb</span>
												<span class="help-block"> Biarkan Kosong bila tidak ada gambar</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-4 col-md-offset-8">
									<a href="{{ url('appmaster/pekerjaan') }}" class="btn btn-primary ">
										<i class="fa fa-angle-left"></i><span class="hidden-480"> Back</span>
									</a>
									<button class="btn btn-success" name="submit"><i class="fa fa-check"></i> Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

