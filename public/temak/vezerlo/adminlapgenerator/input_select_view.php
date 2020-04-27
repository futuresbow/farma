<select name="<?= @$name?>" <?= @$attr; ?> >
	<?php foreach($opciok as $k => $v): ?>
	<option value="<?= $k?>" <?= ($k==@$ertek)?' selected ':'';?> ><?= $v?></option>
	<?php endforeach;?>
</select>

