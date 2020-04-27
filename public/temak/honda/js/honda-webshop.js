$(document).ready(function () {

	// smooth scroll
	$("a").on('click', function(event) {

	    if (this.hash !== "") {
	      event.preventDefault();
	      var hash = this.hash;
	      $('html, body').animate({
	        scrollTop: $(hash).offset().top
		}, 400, function(){
	           window.location.hash = hash;
	      });
	    }
	});

	// cart open-close
	$('.cart-btn').click(function() {
		$(this).parent().toggleClass('cart-open');
		return false;
	});

	// close cart by pressing esc
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
	       $('.cart-btn').parent().removeClass('cart-open');
	    }
	});

	// cart open-close
	$('.main').click(function() {
		$('.header').find('.cart-btn').parent().removeClass('cart-open');
	});

	//footer open-close
	$('.box-title').click(function() {
		$(this).parent().children('.box-content').slideToggle(250);
		$(this).parent().toggleClass('active');
		return false;
	});

	//mobile menu open-close
	$('.mobile-menu').click(function() {
		$(this).parent().removeClass('search-menu-open');
		$(this).parent().removeClass('login-menu-open');
		$(this).parent().toggleClass('mobile-menu-open');
		return false;
	});

	//mobile menu open-close
	$('.search-menu').click(function() {
		$(this).parent().removeClass('login-menu-open');
		$(this).parent().removeClass('mobile-menu-open');
		$(this).parent().toggleClass('search-menu-open');
		return false;
	});

	//mobile menu open-close
	$('.login-menu').click(function() {
		$(this).parent().removeClass('mobile-menu-open');
		$(this).parent().removeClass('search-menu-open');
		$(this).parent().toggleClass('login-menu-open');
		return false;
	});

	//categories mobile open-close
	$('.cat-title').click(function() {
		$(this).parent().children('.cat-content').slideToggle(250);
		$(this).parent().toggleClass('active');
		return false;
	});


	// slick offer slider
	$('.offer-slider .slider').slick({
	  dots: false,
	  infinite: true,
	  speed: 300,
	  slidesToShow: 5,
	  slidesToScroll: 1,
	  responsive: [
	    {
	      breakpoint: 1200,
	      settings: {
	        slidesToShow: 4,
	        slidesToScroll: 1
	      }
	    },
		{
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1
	      }
	    },
		{
	      breakpoint: 480,
	      settings: {
	        slidesToShow: 2,
	        slidesToScroll: 1
	      }
	    },
	    {
	      breakpoint: 375,
	      settings: {
	        slidesToShow: 1,
	        slidesToScroll: 1
	      }
	    }
	  ]
	});

	// prod main-img-slider
	$('.main-img-slider').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.nav-slider'
	});

	// prod img thumbnails
	$('.nav-slider').slick({
	  slidesToShow: 5,
	  slidesToScroll: 1,
	  asNavFor: '.main-img-slider',
	  centerMode: false,
	  focusOnSelect: true,
	  responsive: [
	    {
	      breakpoint: 1200,
	      settings: {
	        slidesToShow: 4,
	        slidesToScroll: 1
	      }
	    },
		{
	      breakpoint: 960,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1
	      }
	    },
		{
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 4,
	        slidesToScroll: 1
	      }
	    },
		{
	      breakpoint: 480,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 1
	      }
	    }
	  ]
	});

	// main banner
	$('.main-banner .slider').slick({
		  dots: true,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 1,
		  adaptiveHeight: true
		});



});
