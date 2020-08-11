<script type="text/javascript" src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script>
	$(document).ready(function() { 
				
		var form = $('#formpekerjaan');
		var error = $('.alert-danger', form);
		var success = $('.alert-success', form);
		
		form.validate({
			doNotHideMessage: true, 
			errorElement: 'span', 
			errorClass: 'help-block help-block-error', 
			focusInvalid: false, 
			rules:{
				nama_pekerjaan: {
					required: true,
				},
				kategori: {
					required: true,
				},
				gaji: {
					required: true,
					number:true
				},
				status: {
					required: true,
				},
			},
			
			messages:{
				nama_pekerjaan: {
					required: 'Nama Pekerjaan harus diisi',
				},
				kategori: {
					required: 'Kategori harus diisi',
				},
				gaji: {
					required: 'Gaji harus diisi',
				},
				status: {
					required: 'Status belum dipilih',
				}
			},
			errorPlacement: function (error, element) { 
				if (element.attr("data-error-container")) { 
					error.appendTo(element.attr("data-error-container"));
				}else {
					error.insertAfter(element); 
				}
			},
			
			invalidHandler: function (event, validator) {    
					success.hide();
					error.show();
					Server.scrollTo(error, -200);
				},

			highlight: function (element) { 
				$(element)
					.closest('.form-group').removeClass('has-success').addClass('has-error'); 
			},

			unhighlight: function (element) { 
				$(element)
					.closest('.form-group').removeClass('has-error'); 
			},
			
			success: function (label) {
				label
					.addClass('valid') 
					.closest('.form-group').removeClass('has-error').addClass('has-success'); 
			},
			submitHandler: function (form) {
				success.show();
				error.hide();
				form.submit(); 
			},
		});
		$('.select2me',form).change(function () {
			form.validate().element($(this)); 
		});
		
	});
	var url = "{{ url('/ckfinder/ckfinder.html') }}";
	CKEDITOR.replace('ckeditor',{
		filebrowserBrowseUrl: url,
		filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
	});
	$(document).ready(function(){
		$('#bataswaktu').datepicker({
			lang:'en',
			format:'dd-mm-yyyy',
			autoclose:true,
			showAnim:'slide',
		});
	});
	$(document).ready(function(){
		$('#destination').change(function(){
			var prov = $('#destination').val();
			$.ajax({
				type : 'POST',
				url : '{{ url('appmaster/pekerjaan/getkabupaten') }}',
				data :  {
					'prov_id':  prov,
					'_method': 'GET',
					'_token': '{{ csrf_token() }}'
				},
				success: function (data) {
					$("#kabupatenkota").html(data);
				}
			});
		});
	});
	$(document).ready(function() { 
			
		$('.maxlength-handler').maxlength({
			limitReachedClass: "label label-danger",
			alwaysShow: true,
			threshold: 3
		});
	});
	$(document).ready(function() { 
		
		$("#gaji").keypress(function(data){
			if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
				return false;
			}
		});

	});
</script>