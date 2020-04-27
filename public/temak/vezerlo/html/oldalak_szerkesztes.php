<a href="<?= ADMINURL; ?>oldalak/lista" class="btn btn-info topadminlink">Mégsem</a>

<h3>Oldal címének szerkesztése</h3>

<form method="post">
<div class="form-group">
	<label>Slug (oldal URL, üresen hagyva főoldal, ***: alapértelmezett oldal)</label>
	<input class="form-control" name="a[url]" value="<?= @$sor->url; ?>" />
</div>

<div class="form-group">
	<label>Tartalom kiválasztása</label>
	<select class="form-control"  name="a[moduleleres]">
	<?php foreach ($moduleleresek as $eleres => $adat):?>
		<option value="<?= $eleres; ?>" <?= ($eleres==@$sor->moduleleres)?' selected ':''?> ><?= $adat['cim'];?></option>
	<?php endforeach ;?>
	</select>
</div>
<div class="form-group">
	<label>Sorrend</label>
	<input class="form-control" name="a[sorrend]" value="<?= @$sor->sorrend; ?>" />
</div>



<div class="form-group">
	
	<input class="btn btn-success" value="Ment" type="submit" />
	
</div>
</form>
