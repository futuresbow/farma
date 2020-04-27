$(document).ready(function () {


    // mobile menu
	$('.menu-mobile').click(function() {
        $('.header').removeClass('cs-open');
		$('.header').removeClass('search-open');
        $('.header').removeClass('login-open');
		$('.header').toggleClass('menu-mobile-open');
		return false;
	});

    // cs mobile menu
	$('.cs-mobile').click(function() {
        $('.header').removeClass('menu-mobile-open');
		$('.header').removeClass('search-open');
        $('.header').removeClass('login-open');
		$('.header').toggleClass('cs-open');
		return false;
	});

    // search mobile menu
	$('.search-mobile').click(function() {
        $('.header').removeClass('menu-mobile-open');
		$('.header').removeClass('cs-open');
        $('.header').removeClass('login-open');
		$('.header').toggleClass('search-open');
		return false;
	});

    // login mobile menu
	$('.login-mobile').click(function() {
        $('.header').removeClass('menu-mobile-open');
		$('.header').removeClass('cs-open');
        $('.header').removeClass('search-open');
		$('.header').toggleClass('login-open');
		return false;
	});

    // esc --> remove mobile menus
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
		   $('.header').removeClass('menu-mobile-open');
		   $('.header').removeClass('search-open');
           $('.header').removeClass('login-open');
           $('.header').removeClass('cs-open');
	    }
	});

	// category mobile
	$('.cat-title').click(function() {
		if ($(window).width() < 960) {
			$(this).parent().children('.cat-content').slideToggle(250);
			$(this).toggleClass('open');
		}
	});

	/*
    // search input not empty check
	$('.search input').blur(function() {

	    if (!$('.search input').val() == '') {
	        $(this).addClass('not-empty');
	    }

		else {
			$(this).removeClass('not-empty');
		}
	});

	// if search input focused (autocomplete)
	$('.search input').focusin(function() {
		$(this).addClass('has-focus');
	});

	// if search input defocused (autocomplete)
	$('.search input').focusout(function() {
		$(this).removeClass('has-focus');
	});


	// esc --> remove focus, mobile menu, search menu
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
	       $('.search input').blur();
		   $('.header-container').removeClass('mobile-menu-open');
		   $('.header-container').removeClass('search-menu-open');
	    }
	});

	// footer-mobile-open-close
	$('.box-title').click(function() {
		if ($(window).width() < 960) {
			$(this).parent().children('.box-content').slideToggle(250);
			$(this).parent().toggleClass('active');
			return false;
		}
	});



	// search menu
	$('.search-menu').click(function() {
		$('.header-container').removeClass('mobile-menu-open');
		$('.header-container').toggleClass('search-menu-open');
		return false;
	});

	// close mobile-menu & search dropdown by body click
	$('.main').click(function() {
		$('.header-container').removeClass('mobile-menu-open');
		$('.header-container').removeClass('search-menu-open');
	});

	// mobile menu dropdown
	$('.menu-dd').click(function() {
		if ($(window).width() < 769) {
			$(this).parent().children('.dropdown').slideToggle(250);
			$(this).parent().toggleClass('active');
		}
		return false;
	});

	// home-page tab-1
	$('.counter-box .tab-1').click(function() {
		$('.counter-box').removeClass('tab-content-2-active');
		$('.counter-box').addClass('tab-content-1-active');
		return false;
	});

	// home-page tab-2
	$('.counter-box .tab-2').click(function() {
		$('.counter-box').removeClass('tab-content-1-active');
		$('.counter-box').addClass('tab-content-2-active');
		return false;
	});


	// homepage countdown (tab-2)
	function makeTimer() {

		var endTime = new Date("29 November 2019 00:00:00 GMT+01:00");
			endTime = (Date.parse(endTime) / 1000);

			var now = new Date();
			now = (Date.parse(now) / 1000);

			var timeLeft = endTime - now;

			var days = Math.floor(timeLeft / 86400);
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			$("#days").html(days);
			$("#hours").html(hours);
			$("#minutes").html(minutes);
			$("#seconds").html(seconds);

	}

	setInterval(function() { makeTimer(); }, 1000);


	// shop-list add-to-favs
	$('.add-to-favs').click(function() {
		$(this).parent().toggleClass('favorite');
		return false;
	});

	// shop-list categories show more-less
	$('.show-all').click(function() {
		$(this).parent().children('.unimportant').slideToggle(250);
		$(this).toggleClass('open');
	});


	// shop-list category mobile
	$('.category-title').click(function() {
		if ($(window).width() < 960) {
			$(this).parent().children('.category-content').slideToggle(250);
			$(this).toggleClass('open');
		}
	});

	 */

	$('.main-slider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
  		autoplaySpeed: 5000,
		dots: false
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
