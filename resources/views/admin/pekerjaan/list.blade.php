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
					<div class="x_title">
						<h2>Pekerjaan<small></small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<a href="{{ url('appmaster/pekerjaan/create') }}" class="btn btn-primary">
									<i class="fa fa-plus"></i>Tambah
								</a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-striped table-bordered table-hover" id="listpekerjaan">
							<thead>
								<tr role="row" class="heading">
									<th width="5%" >
										No
									</th>
									<th width="20%">
										Judul
									</th>
									<th width="10%">
										Kategori
									</th>
									<th width="10%">
										Gaji
									</th>
									<th width="10%">
										Tipe
									</th>
									<th width="10%">
										Status
									</th>
									<th width="10%">
										Hits
									</th>
									<th width="10%">
										Gambar
									</th>
									<th width="15%">
										Actions
									</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

