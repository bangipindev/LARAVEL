@foreach($viewkomentar as $kmntr)
<form action="{{ url('appmaster/comments') }}" class="komentar-compose form-horizontal" id="fileupload" method="POST" >
	@csrf
	<div class="komentar-form-group">
		{{ $kmntr->username }} :&nbsp; {{ $kmntr->komentar }}
	</div>
	<div class="komentar-form-group">
		<div class="controls-row">
			<input type="hidden" name="blogid" value="{{ $kmntr->blogid }}" required />
			<input type="hidden" name="commentid" value="{{ $kmntr->komentarid }}" required />
			<input type="hidden" name="indukid" value=" {{ $kmntr->id }}" required />
			<textarea class="komentar-editor komentar-wysihtml5 form-control" name="review" rows="12"></textarea>
		</div>
	</div>
	<div class="komentar-compose-btn">
		<button class="btn blue"><i class="fa fa-check"></i>Send</button>
	</div>
</form>
@endforeach