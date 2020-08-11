@foreach($viewkomentar as $komentar)
	<div class="komentar-header komentar-view-header">
		<h1 class="pull-left">{{ Applib::getJudulBlog($komentar->id) }} <a href="{{ url('appmaster/comments') }}"><i class="icon-action-undo"></i>&nbsp;Back </a></h1>
	</div>
	<div class="komentar-view-info">
		<div class="row">
			<div class="col-md-7">
				<img src="{{ asset('img/avatar.png') }}" class="img-circle" style="width:30px;height:30px;">
				<span class="bold">{{ $komentar->username }}</span>
				<span> | </span>
				<span class="bold"> 
				{{ Sistem::time_since($komentar->created_at) }}
				</span>
			</div>
			<div class="col-md-5 komentar-info-btn">
				<div class="btn-group">
					<button data-messageid="{{ $komentar->id }}" class="btn blue reply-btn">
						<i class="fa fa-reply"></i> Reply 
					</button>
					<button class="btn blue dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="javascript:;" data-messageid="{{ $komentar->id }} " class="reply-btn">
							<i class="fa fa-reply"></i> Reply </a>
						</li>
						<li>
							<a href="{{ url('appmaster/comments/'.$komentar->id) }}">
							<i class="fa fa-trash-o"></i> Delete </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="komentar-view">
		<p>
		{{ $komentar->komentar }}
		</p>
	</div>
	<hr>
@endforeach