<script>
$(document).ready(function(){

	var content = $('.komentar-content');
	var loading = $('.komentar-loading');
	var listListing = '';

	var loadKomentar = function (el, name) {
		var url = "{{ url('appmaster/comments/showkomentar') }}";
		var title = $('.komentar-nav > li.' + name + ' a').attr('data-title');
		listListing = name;

		loading.show();
		content.html('');
		toggleButton(el);

		$.ajax({
			type: "GET",
			cache: false,
			url: url,
			dataType: "html",
			success: function(res) 
			{
				toggleButton(el);

				$('.komentar-nav > li.active').removeClass('active');
				$('.komentar-nav > li.' + name).addClass('active');
				$('.komentar-header > h1').text(title);

				loading.hide();
				content.html(res);
				if (Layout.fixContentHeight) {
					Layout.fixContentHeight();
				}
				Metronic.initUniform();
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				toggleButton(el);
			},
			async: false
		});

		$('body').on('change', '.mail-group-checkbox', function () {
			var set = $('.mail-checkbox');
			var checked = $(this).is(":checked");
			$(set).each(function () {
				$(this).attr("checked",checked);
			});
			$.uniform.update(set);
		});
	}
	var loadSent = function (el, name) {
		var url = "{{ url('appmaster/comments/showsent') }}";
		var title = $('.komentar-nav > li.' + name + ' a').attr('data-title');
		listListing = name;

		loading.show();
		content.html('');
		toggleButton(el);

		$.ajax({
			type: "GET",
			cache: false,
			url: url,
			dataType: "html",
			success: function(res) 
			{
				toggleButton(el);

				$('.komentar-nav > li.active').removeClass('active');
				$('.komentar-nav > li.' + name).addClass('active');
				$('.komentar-header > h1').text(title);

				loading.hide();
				content.html(res);
				if (Layout.fixContentHeight) {
					Layout.fixContentHeight();
				}
				Metronic.initUniform();
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				toggleButton(el);
			},
			async: false
		});

		$('body').on('change', '.mail-group-checkbox', function () {
			var set = $('.mail-checkbox');
			var checked = $(this).is(":checked");
			$(set).each(function () {
				$(this).attr("checked",checked);
			});
			$.uniform.update(set);
		});
	}
	var loadTrash = function (el, name) {
		var url = " {{ url('appmaster/comments/showtrash') }}";
		var title = $('.komentar-nav > li.' + name + ' a').attr('data-title');
		listListing = name;

		loading.show();
		content.html('');
		toggleButton(el);

		$.ajax({
			type: "GET",
			cache: false,
			url: url,
			dataType: "html",
			success: function(res) 
			{
				toggleButton(el);

				$('.komentar-nav > li.active').removeClass('active');
				$('.komentar-nav > li.' + name).addClass('active');
				$('.komentar-header > h1').text(title);

				loading.hide();
				content.html(res);
				if (Layout.fixContentHeight) {
					Layout.fixContentHeight();
				}
				Metronic.initUniform();
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				toggleButton(el);
			},
			async: false
		});

		$('body').on('change', '.mail-group-checkbox', function () {
			var set = $('.mail-checkbox');
			var checked = $(this).is(":checked");
			$(set).each(function () {
				$(this).attr("checked",checked);
			});
			$.uniform.update(set);
		});
	}

	function loadMessage(el, name, resetMenu) {
		var url = "{{ url('appmaster/comments/viewkomentar') }}";

		loading.show();
		content.html('');
		toggleButton(el);

		var message_id = el.parent('tr').attr("data-messageid");  
		
		$.ajax({
			type: "GET",
			cache: false,
			url: url,
			dataType: "html",
			data: "message_id="+message_id,
			success: function(res) 
			{
				toggleButton(el);

				if (resetMenu) {
					$('.komentar-nav > li.active').removeClass('active');
				}
				$('.komentar-header > h1').text('Lihat Komentar');

				loading.hide();
				content.html(res);
				Layout.fixContentHeight();
				Metronic.initUniform();
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				toggleButton(el);
			},
			async: false
		});
	}

	function loadReply(el) {
		var messageid = $(el).attr("data-messageid");
		var url = "{{ url('appmaster/comments/balaskomentar') }}";
		
		loading.show();
		content.html('');
		toggleButton(el);

		$.ajax({
			type: "GET",
			cache: false,
			url: url,
			data: {'messageid': messageid},
			dataType: "html",
			success: function(res) 
			{
				toggleButton(el);

				$('.komentar-nav > li.active').removeClass('active');
				$('.komentar-header > h1').text('Reply');

				loading.hide();
				content.html(res);
				
				initWysihtml5();
				Layout.fixContentHeight();
				Metronic.initUniform();
			},
			error: function(xhr, ajaxOptions, thrownError)
			{
				toggleButton(el);
			},
			async: false
		});
	}

	
	function toggleButton(el) {
		if (typeof el == 'undefined') {
			return;
		}
		if (el.attr("disabled")) {
			el.attr("disabled", false);
		} else {
			el.attr("disabled", true);
		}
	}

	$('.komentar').on('click', '.reply-btn', function () {
		loadReply($(this));
	});

	$('.komentar-content').on('click', '.view-message', function () {
		loadMessage($(this));
	});

	$('.komentar-nav > li.komentar > a').click(function () {
		loadKomentar($(this), 'komentar');
	});

	$('.komentar-nav > li.sent > a').click(function () {
		loadSent($(this), 'sent');
	});

	$('.komentar-nav > li.trash > a').click(function () {
		loadTrash($(this), 'trash');
	});

	if (Metronic.getURLParameter("a") === "view") {
		loadMessage();
	} else if (Metronic.getURLParameter("a") === "compose") {
		loadCompose();
	} else {
	   $('.komentar-nav > li.komentar > a').click();
	}
});
</script>