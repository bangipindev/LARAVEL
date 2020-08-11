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
						<form action="{{ url('appmaster/fanpage') }}" class="form-horizontal form-row-seperated form-bordered form-label-stripped" id="formlokasi" method="POST">
							@csrf
							<input type="hidden" readonly="true" class="form-control" name="id" id="id" value="{{ $id }}" placeholder="ID">
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Application ID: <span class="required">* </span></label>
								<div class="col-md-10 col-xs-12">
									<input type="text" class="form-control" name="applicationid" id="applicationid" value=" {{ $applicationid }}">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">URL: <span class="required">* </span></label>
								<div class="col-md-10 col-xs-12">
									<input type="text" class="form-control " name="url" id="url"  value="{{ $url }}">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">width: <span class="required">*</span></label>
								<div class="col-md-10 col-xs-12">
									<input type="text" class="form-control " name="width" id="width"  maxlength="3"  value="{{ $width }}">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Height: <span class="required">*</span></label>
								<div class="col-md-10 col-xs-12">
									<input type="text" class="form-control" name="height" id="height"  maxlength="3"  value="{{ $height }}">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Show Face: <span class="required">* </span></label>
								<div class="col-md-10 col-xs-12">
									<select name="show_face" class="table-group-action-input form-control select2me">
										@foreach ($dd_show_face as $key => $value)
										<option value="{{ $key }}" {{ ( $key == $show_face) ? 'selected' : $show_face }}> 
											{{ $value }} 
										</option>
										@endforeach    
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Show Status: <span class="required">* </span></label>
								<div class="col-md-10 col-xs-12">
									<select  name="show_status" class="table-group-action-input form-control select2me">
										@foreach ($dd_show_status as $key => $value)
										<option value="{{ $key }}" {{ ( $key == $show_status) ? 'selected' : $show_status }}> 
											{{ $value }} 
										</option>
										@endforeach    
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Show Header Fb: <span class="required">* </span></label>
								<div class="col-md-10 col-xs-12">
									<select name="show_header_fb" class="table-group-action-input form-control select2me">
										@foreach ($dd_show_header_fb as $key => $value)
										<option value="{{ $key }}" {{ ( $key == $show_header_fb) ? 'selected' : $show_header_fb }}> 
											{{ $value }} 
										</option>
										@endforeach    
									</select>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-4 col-md-offset-8">
									<button class="btn btn-success"><i class="fa fa-check"></i> Save</button>
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