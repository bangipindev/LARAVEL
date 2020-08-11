<script>
	$(document).ready(function() { 
		var grid = new Datatable();

		grid.init({
			src: $("#listartikel"),
			onSuccess: function (grid) {
				
			},
			onError: function (grid) {
				  
			},
			loadingMessage: 'Loading...',
			dataTable: {
				"lengthMenu": [
					[10, 20, 50, 100, 150],
					[10, 20, 50, 100, 150]  
				],
				"pageLength": 10, 
				"ajax": {
				  "url": "{{ url('appmaster/articles') }}",
				  "data": {
					  "_token":"{{ csrf_token() }}"
					}
				 },
				"order": [
					[1, "asc"]
				] 
			}  
		});
	});
	function hapusid(id) {
		if(confirm('Apakah anda yakin mau menghapus data ini?')){
			$.ajax({
				type: 'POST',
				url: "{{ url('appmaster/articles') }}",
				headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				data:{
					'id':id,
					'_method':'DELETE',
					'_token': '{{ csrf_token() }}'
				},
				success: function (data) {
					console.log(data);
					swal("Success!", "Data berhasil di hapus!", "success");
					window.location.reload('{{ url('appmaster/articles') }}');
				},
					error:function(data){
					swal("Oops...", "Something went wrong :(", "error");
				}
			});
		}
	};
</script>