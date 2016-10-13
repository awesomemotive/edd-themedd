jQuery(document).ready(function($) {

    $('.scroll').click(function(event) {
        event.preventDefault();
        var offset = $($(this).attr('href')).offset().top;
        $('html, body').animate({scrollTop:offset}, 800);
    });

	$('body').addClass('js');

    $( 'a > img' ).parent().addClass( 'link-has-image' );

    $('body').on('click.eddAddToCart', '.edd-add-to-cart', function (e) {
        $( '.nav-cart' ).removeClass('empty');
    });

});
