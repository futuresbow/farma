<div class="szintbox" style="background: rgb(<?= rand(200,255).','.rand(200,255).','.rand(200,255); ?>);" data-szulo_id="0">
	<?php $nyitott = 0; foreach($lista as $i => $sor): ?>	
		<?php if(isset($lista[$i-1])) 
			if($sor->szint > $lista[$i-1]->szint): $nyitott++ ;?>
			<div class="szintbox" data-szulo="<?= $sor->szulo_id; ?>" style="background: rgb(<?= rand(200,255).','.rand(200,255).','.rand(200,255); ?>);padding: 10px;" data-szulo_id="0">
		<?php endif;?>
		
		<div class="dropElement" >
		
				<div style="margin-left: <?= ($sor->szint+1)*30;?>px"  class="helyorzodiv droploc " ></div>
			
			
				<span  draggable="false" ondrop="alert();" data-id="<?= $sor->id; ?>" style="margin-left: <?= ($sor->szint+1)*30;?>px"  class="kategoriaListaSor droploc">

					<span  draggable="true"   class="dragElement"  data-szint="<?= $sor->szint;?>" data-id="<?= $sor->id; ?>"  >
						<i class="fas fa-plane" ></i>
					</span>

					<a draggable="false"  href="<?= ADMINURL; ?>kategoria/torol/<?= $sor->id?>" class=" "><i class="fas fa-trash-alt"></i></a>

					<a draggable="false"  href="<?= ADMINURL; ?>kategoria/szerkesztes/0?szulo_id=<?= $sor->id; ?>" class=" "><i class="fas fa-plus-square"></i></a>

					<a draggable="false"  href="<?= ADMINURL; ?>kategoria/szerkesztes/<?= $sor->id?>" class=" "><i class="fas fa-edit"></i></a>
					
					<?= $sor->nev;?>

				</span>
			
				<div style="margin-left: <?= ($sor->szint+1)*30;?>px"  class="helyorzodiv droploc" ></div>
		
		</div>
		
		<?php if(isset($lista[$i+1])) 
			if($lista[$i+1]->szint < $sor->szint) : 
				$x = $lista[$i+1]->szint; while($x < $sor->szint):$x++;$nyitott--;?>
			</div>
		<?php endwhile;endif;?>
		
		<?php if(!isset($lista[$i+1])): while ($nyitott>0): $nyitott--;?>
			</div>
		<?php endwhile;endif;?>
		
		
		
		
	<?php endforeach;?>
		<div style="margin-left: 30px"  class="helyorzodiv droploc" ></div>
</div>

<script>
var dragged = 0;
$().ready(function(){
	
	$('.droploc').bind('dragover', function(event) { 
		if($(event.target).hasClass('droploc')) {
			$(event.target).addClass("helyfelette");
		}
	});
	$('.droploc').bind('dragleave', function(event) {
		if($(event.target).hasClass('droploc')) {
			$(event.target).removeClass("helyfelette");
		}
	});
	
	$('.dragElement').bind('dragstart', function(e){
		
		// e.stopPropagation();
		//e.preventDefault();
		
		console.log($(e.target).attr('data-id'));
	});
	
	
	var drop = document.querySelector('.droploc');

	drop.addEventListener( 'drop', function (event) {
	  // stops the browser from redirecting off to the text.
	  if (event.preventDefault) {
		event.preventDefault(); 
	  }

	  alert("drop");
	  return false;
	});
})


</script>


<style>
	
.kategoriaListaSor a {
	
}
	
.felette {
	background-color: #E5FF69!important;
}

.helyorzodiv {
	height: 5px;
	 transition: color 0.3s, height 0.3s;
}
.helyorzodiv.helyfelette {
	height: 20px;
}


.helyfelette {
	
	background: #7EED7D!important;
}
span.kategoriaListaSor span {
	 transition: color 0.3s;
    float: right;
    display: inline-block;
    color: #333;
    padding: 4px;
    font-size: 16px;
    user-select: none;
}
</style>




