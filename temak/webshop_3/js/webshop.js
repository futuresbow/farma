$(document).ready(function () {

	// footer menu
	$('.box-title').click(function() {
		if ($(window).width() < 960) {
			$(this).parent().toggleClass('open');
			$(this).parent().children('.box-content').slideToggle(250);
			return false;
		}
	});

	// mobile menu
	$('.mobile-menu').click(function() {
		$('.middle-inner').removeClass('search-open');
        $('.header').toggleClass('nav-open');
		return false;
	});

	// open search dropdown
	$('.search-mobile').click(function() {
		$('.header').removeClass('nav-open');
        $(this).parent().toggleClass('search-open');
		return false;
	});

	// close search popup by esc btn
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
		   $('.middle-inner').removeClass('search-open');
		   $('.header').removeClass('nav-open');
	    }
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
