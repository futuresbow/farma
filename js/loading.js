/**
 *
 */
function showLoading () {

  $('body').loadingModal({
  	  animation: 'threeBounce'
  	});
}


/**
 *
 */
function hideLoading () {

  $('body').loadingModal ('hide');  
  $('body').loadingModal ('destroy') ;
}
