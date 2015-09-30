jQuery(document).ready(function($) {

    $('.scroll').click(function(event) {
        event.preventDefault();
        var offset = $($(this).attr('href')).offset().top;
        $('html, body').animate({scrollTop:offset}, 800);
    });

	$('body').addClass('js');

    $( 'a > img' ).parent().addClass( 'has-image' );

    $( document.body ).on( 'click', 'div.gallery, div.tiled-gallery', function(e) {
         $('body').addClass( 'carousel-open');
    });

    $( document.body ).bind('jp_carousel.afterClose', function(e) {
        $('body').removeClass('carousel-open');
    });

});
