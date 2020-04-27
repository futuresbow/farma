$(document).ready(function () {


    // cart
	$('.cart').click(function() {
		$(this).toggleClass('open');
		return false;
	});

	// close search popup by esc btn
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
		   $('.search-overlay').removeClass('visible');
		   $('.header').removeClass('menu-open');
	    }
	});

	// close search popup
	$('.search-overlay .close').click(function() {
        $('.search-overlay').removeClass('visible');
		return false;
	});

	// open search popup
	$('.search-icon').click(function() {
        $('.search-overlay').addClass('visible');
		return false;
	});

	// mobile menu
	$('.mobile-menu').click(function() {
		$('.header').toggleClass('menu-open');
		return false;
	});

	// footer menu
	$('.box-title').click(function() {
		$(this).parent().toggleClass('open');
		$(this).parent().children('.box-content').slideToggle(250);
		return false;
	});

	// main slider
	$('.main-slider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
  		autoplaySpeed: 5000,
		dots: false,
		responsive: [
	    {
	      breakpoint: 768,
	      settings: {
	        arrows: false,
	      }
	    }
	  ]
 	});

	// category mobile
	$('.cat-title').click(function() {
		if ($(window).width() < 768) {
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
