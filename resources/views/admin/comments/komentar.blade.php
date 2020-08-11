@if (session('SUCCESSMSG'))
	<div role="alert" class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
		<strong>Sukses!</strong>
		{{ session('SUCCESSMSG') }}
	</div>
@endif
@if (session('GAGALMSG'))
	<div role="alert" class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
		{{ session('GAGALMSG') }}
	</div>
@endif
<table id="komentarall" class="table table-striped table-advance table-hover">
	<thead>
		<tr>
			<th width="2%" class="hidden-xs">
				No
			</th>
			<th width="8%">
				Nama
			</th>
			<th  width="10%"class="hidden-xs">
				Email
			</th>
			<th>
				Komentar
			</th>
			<th>
				Tanggal
			</th>
			<th width="25%">
				Aksi
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($datakomentar as $komentar)
			<tr @if($komentar->dibaca =='0') {{ $status ="class=unread" }} @else {{ $status="" }} @endif data-messageid ="{{ $komentar->id }}">
				<td class="hidden-xs">
					{{ $loop->iteration }}
				</td>
				<td class="view-message">
					{{ $komentar->username }}
				</td>
				<td class="view-message hidden-xs">
					{{ $komentar->email }}
				</td>
				<td class="view-message">
					{{ Str::limit($komentar->komentar,30) }}
				</td>
				<td class="view-message text-right">
					{{ Sistem::time_since($komentar->created_at) }} 
				</td>
				<td class="text-right">
					@if ($komentar->disetujui ==0)
					<a class="btn btn-sm btn-primary btn-editable"  title="Approve" onclick="event.preventDefault(); document.getElementById('approve').submit();" >
						<i class="fa fa-check"></i> 
					</a>
					<form id="approve" action="{{ url('appmaster/comments/'.$komentar->id.'/approve') }}" method="POST" style="display: none;">
						@csrf
					</form>
					@endif
					<a class="btn btn-sm btn-danger btn-editable"  title="Delete Permanent" onclick="event.preventDefault(); document.getElementById('delete').submit();" >
						<i class="fa fa-trash"></i>
					</a>
					<form id="delete" action="{{ url('appmaster/comments/'.$komentar->id) }}" method="post" style="display: none;">
						@method('DELETE')
						@csrf
					</form>
					<a class="btn btn-sm btn-warning btn-editable" title="Move to Trash" onclick="event.preventDefault(); document.getElementById('trash').submit();">
						<i class="fa fa-ban"></i> 
					</a>
					<form id="trash" action="{{ url('appmaster/comments/'.$komentar->id.'/trash') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
	<script>
		$(document).ready(function() {
			var table = $('#komentarall');

			table.dataTable({
			"language": {
               
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "bStateSave": false, 
            "pagingType": "bootstrap_extended",

            "lengthMenu": [
                [10, 20, 50, -1],
                [10, 20, 50, "All"] 
            ],
            "pageLength": 10,
            "columnDefs": [{  
               'orderable': true,
               'targets': [0]
            }, {
                "searchable": true,
				"targets": [0]
            }],
       
        });   
    });
	</script>
