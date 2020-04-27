<html>
<head>
  <meta charset="utf-8">
  <title>Képvágó</title>
  <base href="/">
   <script src="http://code.jquery.com/jquery-latest.min.js"></script>
	
   
     
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>


<body>


<form method="post" id="mailKepCropForm" enctype="multipart/form-data">
	
<input name="kepeleres" value="<?= $kepeleres; ?>" id="kepeleres" type="hidden">	


<div class="vagokeret" id="vagokeret">
	<img src="<?= $kepeleres; ?>" class="targykep" style="max-height: 100%;" style="box-shadow: 0px 0px 5px rgba(0,0,0,0.25);" />
	<div class="resizable vagolap"><br><button type="submit" class="cropit">VÁGÁS</button>
		<div class='resizers'>
			<div class='resizer top-left'></div>
			<div class='resizer top-right'></div>
			<div class='resizer bottom-left'></div>
			<div class='resizer bottom-right'></div>
		</div>
	</div>
</div>
<center>
	<button type="button" onclick="window.location.href='<?= $visszaUrl;?>';">BEZÁRÁS</button>
</center><br>
<div class="visszajelzok">
X: <input name="cropx" value="0" readonly  />
Y: <input name="cropy" value="0" readonly />
W: <input name="cwidth" value="0" readonly />
H: <input name="cheight" value="0" readonly />
IW: <input name="owidth" value="0"  readonly />
IH: <input name="oheight" value="0" readonly />
</div>

</form>




<script>
	
	function setDatas() {
		//eredeti kép látszólagos mérete
		
		img = $('.targykep');
		$('input[name=owidth]').val(img[0].clientWidth);
		$('input[name=oheight]').val(img[0].clientHeight);
		div = $('.resizers');
		$('input[name=cwidth]').val($('.resizable').width());
		$('input[name=cheight]').val($('.resizable').height());
		y = parseInt($('.resizable').css('top'));
		x = parseInt($('.resizable').css('left'))
		$('input[name=cropx]').val( x - (($(window).width()/2)-(img[0].clientWidth/2)) );
		$('input[name=cropy]').val( y - 20 );
		
		
		
	};
	
function makeResizableDiv(div) {
	
	
  const element = document.querySelector(div);
  const resizers = document.querySelectorAll(div + ' .resizer')
  const minimum_size = 70;
  let original_width = 0;
  let original_height = 0;
  let original_x = 0;
  let original_y = 0;
  let original_mouse_x = 0;
  let original_mouse_y = 0;
  for (let i = 0;i < resizers.length; i++) {
    const currentResizer = resizers[i];
    currentResizer.addEventListener('mousedown', function(e) {
      e.preventDefault()
      original_width = parseFloat(getComputedStyle(element, null).getPropertyValue('width').replace('px', ''));
      original_height = parseFloat(getComputedStyle(element, null).getPropertyValue('height').replace('px', ''));
      original_x = element.getBoundingClientRect().left;
      original_y = element.getBoundingClientRect().top;
      original_mouse_x = e.pageX;
      original_mouse_y = e.pageY;
      window.addEventListener('mousemove', resize)
      window.addEventListener('mouseup', stopResize)
    })
    
    function resize(e) {
		setDatas();
		
		var doc = document,
            docElem = doc.documentElement,
            body = document.body,
            win = window,
            clientTop  = docElem.clientTop  || body.clientTop  || 0,
            clientLeft = docElem.clientLeft || body.clientLeft || 0,
            scrollTop  = win.pageYOffset || jQuery.support.boxModel && docElem.scrollTop  || body.scrollTop,
            scrollLeft = win.pageXOffset || jQuery.support.boxModel && docElem.scrollLeft || body.scrollLeft,
            
            
		box = document.getElementById('vagokeret').getBoundingClientRect();
		
		console.log(window.pageYOffset);
		
		
      if (currentResizer.classList.contains('bottom-right')) {
        const width = original_width + (e.pageX - original_mouse_x);
        const height = original_height + (e.pageY - original_mouse_y)
        if (width > minimum_size) {
          element.style.width = width + 'px'
        }
        if (height > minimum_size) {
          element.style.height = height + 'px'
        }
      }
      else if (currentResizer.classList.contains('bottom-left')) {
        const height = original_height + (e.pageY - original_mouse_y)
        const width = original_width - (e.pageX - original_mouse_x)
        if (height > minimum_size) {
          element.style.height = height + 'px'
        }
        if (width > minimum_size) {
          element.style.width = width + 'px'
          element.style.left = original_x + (e.pageX - original_mouse_x) + 'px'
        }
      }
      else if (currentResizer.classList.contains('top-right')) {
        const width = original_width + (e.pageX - original_mouse_x)
        const height = original_height - (e.pageY - original_mouse_y)
        if (width > minimum_size) {
          element.style.width = width + 'px'
        }
        if (height > minimum_size) {
          element.style.height = height + 'px'
          element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
        }
      }
      else {
        const width = original_width - (e.pageX - original_mouse_x)
        const height = original_height - (e.pageY - original_mouse_y)
        if (width > minimum_size) {
          element.style.width = width + 'px'
          element.style.left = original_x + (e.pageX - original_mouse_x) + 'px'
        }
        if (height > minimum_size) {
          element.style.height = height + 'px'
          element.style.top = original_y + (e.pageY - original_mouse_y) + 'px'
        }
      }
    }
    
    function stopResize() {
      window.removeEventListener('mousemove', resize)
    }
  }
}


makeResizableDiv('.resizable')
setTimeout("setDatas();",500);

</script>

<style>
.visszajelzok {
	border: none;
	color: #777;
	font-size: 11px;
	text-align: center;
}
.visszajelzok input {
	border: none;
	color: #777;
	font-size: 11px;
	width: 50px
}


.resizable {
  background: rgba(255,255,255,0.5);
  width: 50%;
  height: 50%;
  position: absolute;
  top: 10%;
  left: 10%;
}

.resizable .resizers .resizer{
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: white;
  border: 3px solid #4286f4;
  position: absolute;
}
.resizable .resizers .resizer.top-left {
  left: -5px;
  top: -5px;
  cursor: nwse-resize; /*resizer cursor*/
}
.resizable .resizers .resizer.top-right {
  right: -5px;
  top: -5px;
  cursor: nesw-resize;
}
.resizable .resizers .resizer.bottom-left {
  left: -5px;
  bottom: -5px;
  cursor: nesw-resize;
}
.resizable .resizers .resizer.bottom-right {
  right: -5px;
  bottom: -5px;
  cursor: nwse-resize;
}
	.vagokeret img {
		    max-width: 100%;
	}
	.vagokeret {
		margin: 0%;
		background: #fff;
		position:relative;
		height: auto;
		box-sizing: border-box;
		padding:20px;
		text-align:center;
		height: calc( 70% );
	}
	.vagokeret img {
		box-shadow: 0px 0px 5px rgba(0,0,0,0.25);
	}


</style>

</body>

</html>
