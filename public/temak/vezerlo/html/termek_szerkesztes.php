<a href="<?= ADMINURL; ?>termek/lista" class="btn btn-info topadminlink">Mégsem</a>

<h3>Termék szerkesztése</h3>

<form method="post" class="termekForm">


<div class="form-group">
	<label>Cikkszám</label>
	<input class="form-control" name="a[cikkszam]" value="<?= @$sor->cikkszam; ?>" />
	
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Ár</label>
			<input class="form-control" name="a[ar]" value="<?= @$sor->ar; ?>" />
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
			<label>Megjelenítve</label>
			<select class="form-control" name="a[aktiv]">
				<option value="1" <?= @$sor->aktiv==1?' selected ':''; ?>>Igen</option>
				<option value="0" <?= @$sor->aktiv==0?' selected ':''; ?>>Nem</option>
			</select>
		</div>
	</div>
	
</div>
<br><hr><br>
<?= $this->load->view(ADMINTEMPLATE.'html/jellemzoformbuilder', @$sor, true);?>
<br><hr><br>
<div class="valtozat_es_opcio">
	
</div>


<br><hr><br>
<div class="form-group">
	<label>Kategória besorolás</label>
	<?php if(isset($_GET['szulo_id'])) { $sor = new stdClass;$sor->szulo_id=(int)$_GET['szulo_id']; } ?>
	
	<?php if($lista)foreach($lista as $kat):?>
	<div style="margin-left: <?= ($kat->szint+1)*20;?>px"  class="kategoriaValasztoSor">
		<input type="checkbox" value="<?= $kat->id; ?>" class="" name="k[]" <?= (isset($termekXKategoria[$kat->id]))?' checked ':''; ?> /> - <?= $kat->nev;?>
	</div>	
	<?php endforeach; ?>
	 
</div>
<br><hr><br>
<div  >
	<label>Képfeltöltés</label>
	<input type="file" class="form-control " name="imgupload" id="imgupload" onchange="aJs.kelFeltoltes(<?= $tid;?>)" />
	<label>Feltöltött képek:</label>
	<div class="kepkonyvtar"></div>
</div>

<div class="form-group">
	
	<input class="btn btn-success" value="Ment" type="submit" />
	
</div>
</form>
<script>
 var tid = <?= $tid;?>;
$().ready(function(){
	
		$('.valtozat_es_opcio').load('<?= ADMINURL?>termek/valtozatesopcio/<?= $tid;?>?ajax=1');
		$('.fedit').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']]
				]
			});
		
		$.get('<?= ADMINURL; ?>termek/keplista/<?= $tid;?>?ajax=1', function(r) { aJs.kepgaleria(r);});
	
});
</script>
 <style>
    .kepborder { border: 3px solid #56A5F0;}
    .keptaska { display:inline-block;width=200px;padding:2px;margin:2px;background:#E1FFB4;text-align:center;}
    </style>
