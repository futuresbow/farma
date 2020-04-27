$(document).ready(function () {

	// mobile-menu open-close
	$('.mobile-menu').click(function() {
		$('.profile').removeClass('profile-dropdown-open');
		$(this).parent().parent().toggleClass('menu-open');
		return false;
	});

	// close mobile-menu & profile dropdown by body click
	$('.main').click(function() {
		$(this).parent().parent().removeClass('menu-open');
		$('body').find('.profile').removeClass('profile-dropdown-open');
		$('.select-all').parent().removeClass('select-dropdown-open');
		$('.action-btn').parent().removeClass('selection-action-open');
	});

    // close nav & profile dropdown by pressing esc
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
	       $('body').removeClass('menu-open');
		   $('.profile').removeClass('profile-dropdown-open');
		   $('.select-all').parent().removeClass('select-dropdown-open');
		   $('.action-btn').parent().removeClass('selection-action-open');
	    }
	});

	// main nav dropdown open-close
	$('.nav-dropdown').click(function() {
		$(this).parent().children('ul').slideToggle(250);
		$(this).parent().toggleClass('active');
		return false;
	});

	//profile dropdownopen-close
	$('.profile-btn').click(function() {
		$('body').removeClass('menu-open');
		$(this).parent().toggleClass('profile-dropdown-open');
		return false;
	});

	// table select dropdown
	$('.select-all').click(function() {
		$(this).parent().toggleClass('select-dropdown-open');
		$('.action-btn').parent().removeClass('selection-action-open');
		return false;
	});

	// table action dropdown
	$('.action-btn').click(function() {
		$(this).parent().toggleClass('selection-action-open');
		$('.select-all').parent().removeClass('select-dropdown-open');
		return false;
	});



	// disabled selects
	$(this).find('select:disabled').parent().addClass('disabled');

	// select focus
	$(this).delegate('select','focus blur',function() {
	  var elem = $(this);
	  setTimeout(function() {
	    elem.parent().toggleClass('focus', elem.is(':focus'));
	  }, 0 );
	});


	/*
	// Fancybox call & options
	$().fancybox({
	    selector : '[data-fancybox]',
		buttons: [
	        //"zoom",
	        //"share",
	        //"slideShow",
	        //"fullScreen",
	        //"download",
	        //"thumbs",
	        "close"
	    ]
	});
	*/

});
