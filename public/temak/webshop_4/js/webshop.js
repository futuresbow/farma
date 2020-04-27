$(document).ready(function () {

	// mobile menu
	$('.mobile-menu').click(function() {
		$('.header').removeClass('search-open');
		$('.header').removeClass('login-reg-open');
		$('.header').removeClass('cart-open');
		$('.header').toggleClass('menu-open');
		return false;
	});

	// search mobile menu
	$('.search-icon').click(function() {
		$('.header').removeClass('menu-open');
		$('.header').removeClass('login-reg-open');
		$('.header').removeClass('cart-open');
		$('.header').toggleClass('search-open');
		return false;
	});

	// login-reg mobile menu
	$('.login-reg-icon').click(function() {
		$('.header').removeClass('menu-open');
		$('.header').removeClass('search-open');
		$('.header').removeClass('cart-open');
		$('.header').toggleClass('login-reg-open');
		return false;
	});

	// cart mobile menu
	$('.cart-icon').click(function() {
		$('.header').removeClass('menu-open');
		$('.header').removeClass('login-reg-open');
		$('.header').removeClass('search-open');
		$('.header').toggleClass('cart-open');
		return false;
	});

	// close esc btn
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
		   $('.header').removeClass('menu-open');
		   $('.header').removeClass('search-open');
		   $('.header').removeClass('login-reg-open');
		   $('.header').removeClass('cart-open');
	    }
	});

	// footer menu
	$('.box-title').click(function() {
		$(this).parent().toggleClass('open');
		$(this).parent().children('.box-content').slideToggle(250);
		return false;
	});

	// category mobile
	$('.cat-title').click(function() {
		if ($(window).width() < 960) {
			$(this).parent().children('.cat-content').slideToggle(250);
			$(this).toggleClass('open');
		}
	});

	$('.main-pic').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		asNavFor: '.thumbnails'
 	});

	$('.thumbnails').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.main-pic',
		focusOnSelect: true,
		arrows: false
 	});

});
