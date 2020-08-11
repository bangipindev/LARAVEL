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
<table id="sentkomentarall" class="table table-striped table-advance table-hover">
	<thead>
		<tr>
			<th>
				Name
			</th>
			<th>
				email
			</th>
			<th>
				Review
			</th>
			<th>
				Tanggal
			</th>
			<th>
				Aksi
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($datakomentar as $komentar)
		<tr @if($komentar->dibaca=='0')	$status="class=read"; @else	$status=""; @endif data-messageid ="{{ $komentar->id }}">
			<td class="view-message">
					{{ $komentar->username }}
			</td>
			<td class="view-message">
					{{ $komentar->email }}
			</td>
			<td class="view-message">
				{{ Str::limit($komentar->komentar,30) }}
			</td>
			<td class="view-message text-right">
				{{ Sistem::time_since($komentar->created_at) }} WIB
			</td>
			<td class="text-right">
				<a href="{{ url('appmaster/comments/'.$komentar->id) }}" class="btn btn-sm btn-danger btn-editable">
				<i class="fa fa-trash"></i> </a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
	<script>
		$(document).ready(function() {
			var table = $('#sentkomentarall');

			table.dataTable({
			"language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
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

            "bStateSave": true, 
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
            "sorting": [
                [3, "DESC"]
            ]
        });   
    });
	</script>
