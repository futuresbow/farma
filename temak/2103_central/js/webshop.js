$(document).ready(function () {

	

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
 	
 	$('.main-pic').slickLightbox({
		src: 'data-full',
		itemSelector: '.slide img'
	});

});
