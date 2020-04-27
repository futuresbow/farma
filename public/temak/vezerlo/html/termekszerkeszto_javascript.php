<script>
var editedTid = <?= (int)$tid; ?>;
$().ready(function(){
	
		$('.valtozat_es_opcio').load('<?= ADMINURL?>termek/valtozatesopcio/<?= $tid;?>?ajax=1');
		$.get('<?= ADMINURL; ?>termek/keplista/<?= $tid;?>?ajax=1', function(r) { aJs.kepgaleria(r);});		
		aJs.kepHuzasInditas();
		
});



</script>



<style>
.kepdragdrop {
	width: 100%;
	height: 180px;
	border: 2px dashed #aaa;
	line-height: 180px;
	font-size: 20px;
	text-align:center;
	margin:10px;
	display:block;
}
</style>
