				<div class="edmeditoritems">
					<div draggable="true"  id="e1" data-eleres="oldalak/szekcio" ondragstart="dragEventHandler(event);" class="edmeitem"><i class="far fa-square"></i>Szekció</div>
					<div draggable="true"  id="e2" data-eleres="oldalak/hasab2" ondragstart="dragEventHandler(event);"  class="edmeitem"><i class="fas fa-columns"></i>2 Hasáb</div>
					<div draggable="true"  id="e3" data-eleres="oldalak/hasab3" ondragstart="dragEventHandler(event);"  class="edmeitem"><i class="fas fa-columns"></i>3 Hasáb</div>
					<div class="edmeitem"><i class="fas fa-font"></i>Szöveg</div>
					<div class="edmeitem"><i class="fas fa-image"></i>Kép</div>
					<div class="edmeitem"><i class="fas fa-camera-retro"></i>Slider</div>
					<div class="edmeitem"><i class="fab fa-product-hunt"></i>Terméklista</div>
					<div class="edmeitem"><i class="fas fa-laptop-code"></i>HTML</div>
				</div>
				<div class="edmeditcontent">
					<h3><?= $oldal->nev ;?> építése</h3>
					<div class="edmeditorwraper"  >
						<div class="edmplaceholder" ondrop="event.preventDefault();dropEventHandler(event);$(this).removeClass('felette');" ondragleave="$(this).removeClass('felette');" ondragover="$(this).addClass('felette');event.preventDefault();">Húzz ide egy elemet</div>
						<?php if(!empty($lista))foreach ($lista as $k =>  $sor):?>
						<div  class="edmmodulcontent-live" data-eleres="<?=  $sor->moduleleres;?>" data-sortable="1" id="item_<?=  $k; ?>" >
							<div class="edmmodulcontent-move" draggable="true" ondragstart="dragEventHandler(event);"><i class="fas fa-expand-arrows-alt"></i></div>
							<div class="edmmodulloader"><?=  $sor->moduleleres;?></div>
						</div>
						<div class="edmplaceholder" ondrop="event.preventDefault();dropEventHandler(event);$(this).removeClass('felette');" ondragleave="$(this).removeClass('felette');" ondragover="$(this).addClass('felette');event.preventDefault();">Húzz ide egy elemet</div>
						
						<?php endforeach;?>
					
					</div>
					
				</div>
				
				
				<div  class="edmmodulcontent" style="display:none;">
					<div class="edmmodulcontent-move" draggable="true" ondragstart="dragEventHandler(event);"><i class="fas fa-expand-arrows-alt"></i></div>
					<div class="edmmodulloader">Tartalmi elem ide...</div>
				</div>
				
<script>
	var dragIndex = 0;
var dragEventHandler = function(theEvent) {
	//console.log(event);
	id = theEvent.target.id;
	sortable = $("#"+id).parents('.edmmodulcontent-live').attr('data-sortable');
	
	console.log(sortable);
	console.log(sortable==1?true:false);
	
	theEvent.dataTransfer.setData("Text", id);
	theEvent.dataTransfer.setData("Sort", sortable==1?true:false);
	console.log(theEvent);
	
}
var itemIndex = 0;

var dropEventHandler = function(theEvent) {
	var id = theEvent.dataTransfer.getData("Text");
	var rendezes = theEvent.dataTransfer.getData("Sort")=='true'?true:false;
	eleres = $("#"+id).attr('data-eleres');
	
	if(rendezes) {
		$(".opaclass").fadeTo( 1000 , 1).removeClass('opclass');
	}
	
	
	
	if(rendezes==false) {
		clone = $(theEvent.target).clone().removeClass('felette');
	$(clone).insertAfter(theEvent.target);
	
		content = $('.edmmodulcontent').clone();
		$(content).attr('id', 'item_'+itemIndex);
		$(content).find('.edmmodulcontent-move').attr('id', 'sorter'+itemIndex);
		$(content).attr('data-sortable', '1');
		$(content).removeClass('edmmodulcontent').addClass('edmmodulcontent-live').attr('data-eleres', eleres).css('display', 'block');
		$(content).insertAfter(theEvent.target);
		itemIndex++;
	
	} else {
		// áthelyezés
		content = $("#"+id).parents('.edmmodulcontent-live');
		drop = $(content).next();
		$(content).insertAfter(theEvent.target);
		$(drop).insertAfter(content);
		
	}
	
	
	
}
</script>

<style>

.edmmodulcontent-live {
	min-height:80px;
	position:relative;
}
.edmmodulcontent-move {
	position: absolute;
	top: 10px;
	right: 10px;
	width: 30px;
	height: 30px;
	border-radius: 15px;
	text-align: center;
	line-height: 30px;
	font-size: 18px;
	background: #2E0071;
	color: #fff;
	user-select: none;
	cursor: all-scroll;
	-webkit-user-drag: element;
}

.edmeditorwraper {
	position:relative;
	border-radius: 10px;
	box-sizing: border-box;
	
	margin: 20px 20%;
	background: #fff;
}
.edmeditcontent h3{ text-align:center; margin-top:10px;}
.edmeditcontent {
	background-color: #E4E4E4;
    box-sizing: border-box;
    
    height: calc(100% - 96px);
    width: calc(100% - 15% - 240px ) !important;
    position:absolute;
    top: 96px;
    right: 15%;
    overflow-y: scroll;
}
@media screen and (max-width: 960px) {
	.edmeditcontent {
		width: calc(100% - 15%) !important;
    
	}
}

.edmplaceholder.felette {
	background: #A5F9B3;
	font-size:20px;
	min-height: 50px;
	line-height: 50px;
}
.edmplaceholder {
	border: 1px dashed #A7A2A2;
	border-radius: 10px;
	min-height: 15px;
	line-height: 12px;
	text-align:center;
	font-size: 12px;
	-webkit-transition: width 1s; /* Safari */
	transition: width 1s;
	-webkit-transition: font-size 1s; /* Safari */
	transition: font-size 1s;
	-webkit-transition: line-height 1s; /* Safari */
	transition: line-height 1s;
	margin:4px 0 4px 0;
}
.edmeditor {
	font-family: Helvetica,sans-serif;
    font-size: .75rem;	
}
.edmeditoritems {
	height: calc(100% - 96px);
	background-color: #373d49;
	color: #a0aabf;
	right: 0;
    width: 15%;
        top: 96px;
    overflow: auto;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
    display: inline-block;
    position: absolute;
    box-sizing: border-box;
    text-align: center;
    padding: 5px;
    z-index: 3;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
}
.edmeitem i { font-size:30px; }
.edmeitem:hover { color: #fff; }
.edmeitem {
	border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 3px;
    /* margin: 10px 2.5% 5px; */
    box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.15);
    transition: box-shadow, color 0.2s ease 0s;
    background-color: #373d49;
        user-select: none;
           display: -webkit-flex;
    display: -ms-flexbox;
    display: -ms-flex;
    display: flex;
    width: 45%;
    min-width: 45px;
    padding: 1em;
    box-sizing: border-box;
    min-height: 90px;
    cursor: all-scroll;
    font-size: 11px;
    font-weight: lighter;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin: 10px 2.5% 5px;
    -webkit-user-drag: element;
}
</style>
