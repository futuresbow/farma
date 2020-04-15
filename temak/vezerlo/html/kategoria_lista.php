<div class="szintbox" style="backgroundx: rgb(<?= rand(200,255).','.rand(200,255).','.rand(200,255); ?>);" data-szulo_id="0">
	<?php $nyitott = 0; if($lista) foreach($lista as $i => $sor): ?>
	
		<?php if(isset($lista[$i-1])) 
			if($sor->szint > $lista[$i-1]->szint): $nyitott++ ;?>
			<div class="szintbox" data-szulo="<?= $sor->szulo_id; ?>" style="backgroundx: rgb(<?= rand(200,255).','.rand(200,255).','.rand(200,255); ?>);padding: 10px;" data-szulo_id="0">
		<?php endif;?>
		
		<div class="dropElement" >
		
				<div style="margin-left: <?= ($sor->szint+1)*30;?>px"  class="helyorzodiv droploc " ondrop="drop(event,this)"  ondragover="allowDrop(event)" ></div>
			
			
				<span  draggable="false" ondrop="drop(event,this)" ondragover="allowDrop(event)" data-id="<?= $sor->id; ?>" style="margin-left: <?= ($sor->szint+1)*30;?>px"  class="kategoriaListaSor droploc">

					<span  draggable="true"   class="dragElement"  data-szint="<?= $sor->szint;?>" data-id="<?= $sor->id; ?>"  >
						<i class="fas fa-plane" ></i>
					</span>

					<a draggable="false"  href="<?= ADMINURL; ?>kategoria/torol/<?= $sor->id?>" class=" "><i class="fas fa-trash-alt"></i></a>

					<a draggable="false"  href="<?= ADMINURL; ?>kategoria/szerkesztes/0?szulo_id=<?= $sor->id; ?>" class=" "><i class="fas fa-plus-square"></i></a>

					<a draggable="false"  href="<?= ADMINURL; ?>kategoria/szerkesztes/<?= $sor->id?>" class=" "><i class="fas fa-edit"></i></a>
					
					<?= $sor->nev;?>

				</span>
			
				<div style="margin-left: <?= ($sor->szint+1)*30;?>px" ondrop="drop(event,this)"  class="helyorzodiv droploc" ondragover="allowDrop(event)"  ></div>
		
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
var dgagedid = 0;
function allowDrop(ev) {
		
		ev.preventDefault();
}

function drop(ev, hova) {
  ev.preventDefault();
  ref = 0;
  mod = '';
  
  if($(hova).hasClass('kategoriaListaSor')) {
		// betesszük adott kategóriába első helyre...
		window.location.href='?mit='+dgagedid+'&mibe='+parseInt($(hova).attr('data-id'));
		return;
	}
  
  kov = $(hova).next();
  
  
  if($(kov).hasClass('kategoriaListaSor')) {
		// betesszük adott kategóriába első helyre...
		window.location.href='?mit='+dgagedid+'&kov='+parseInt($(kov).attr('data-id'));
		return;	
  }
  
  elo = $(hova).prev();
  console.log(elo);
  if($(elo).hasClass('kategoriaListaSor')) {
		// betesszük adott kategóriába első helyre...
		window.location.href='?mit='+dgagedid+'&elo='+parseInt($(elo).attr('data-id'));
		return;	
  }
  
  
}

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
		dgagedid  = parseInt($(e.target).attr('data-id'));
		
	});
	
	var dragItems = document.querySelectorAll('[draggable=true]');

		for (var i = 0; i < dragItems.length; i++) {
			dragItems[i].addEventListener('dragstart', function(e){
				e.dataTransfer.setData('application/node type', this);
				console.log("dragstart:", e)
			});

	}
	
})


</script>



<style>

[draggable=true] {
  -khtml-user-drag: element;
}

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
span.kategoriaListaSor span {
    
    -moz-user-select: none;
    cursor: move;
}
</style>




