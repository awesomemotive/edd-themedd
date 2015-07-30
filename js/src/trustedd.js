jQuery(document).ready(function($) {

    $('.scroll').click(function(event) {
        event.preventDefault();
        var offset = $($(this).attr('href')).offset().top;
        $('html, body').animate({scrollTop:offset}, 800);
    });

	$('body').addClass('js');

    $( 'a > img' ).parent().addClass( 'has-image' ); 

	var $menu = $('#site-navigation ul'),
	$menulink = $('.menu-link');

	$menulink.click(function() {
		$menulink.toggleClass('active');
		$menu.toggleClass('active');
		return false;
	});

});
