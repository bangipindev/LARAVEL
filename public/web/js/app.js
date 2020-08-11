$(function(){
    
    if($('.section-parallax').length){
        $(window).on('scroll',function(){
	        var y = $(window).scrollTop() /5;
	        $('.section-parallax .bg').css({'transform':'translateY('+y+'px)'})
	    });
    }
    $('[data-toggle=scroll]').on('click',function(){
        var offset = $(this).data('offset') || 0;
        var href = $(this).attr('href');
        var target = $(href).offset().top - offset;
        $('html,body').animate({
            scrollTop:target
        },500)
    });

    $('.btn-grid-card').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('.row-lowongan-wrap').addClass('grid-card');
    });
    $('.btn-grid-list').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('.row-lowongan-wrap').removeClass('grid-card');
    });
    
});