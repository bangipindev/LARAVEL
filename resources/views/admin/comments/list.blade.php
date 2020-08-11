@extends('layouts.admin')

@section('title')
	<title> {{ $title }} </title>
	@endsection
@section('section')
<div class="row komentar">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="row">
				<div class="x_content">
					<ul class="nav nav-tabs komentar-nav margin-bottom-10">
						<li class="komentar active">
							<a href="javascript:;" class="btn" data-title="Komentar">
							Komentar
							@if(!empty(Applib::totalKomentar()))
								<span class="badge badge-danger">{{ Applib::totalKomentar() }} </span> 
							@endif
							</a>
							<b></b>
						</li>
						<li class="sent">
							<a class="btn" href="javascript:;" data-title="Sent">
							Sent </a>
							<b></b>
						</li>
						<li class="trash">
							<a class="btn" href="javascript:;" data-title="Trash">
							Trash </a>
							<b></b>
						</li>
					</ul>
					
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="komentar-body">
						
						<div class="komentar-header">
							<h1 class="pull-left">Komentar</h1>
						</div>
						<div class="komentar-loading">
							Loading...
						</div>
						<div class="komentar-content"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection