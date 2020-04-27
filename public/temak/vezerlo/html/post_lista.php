<a href="<?= ADMINURL; ?>post/szerkesztes/0" class="btn btn-info topadminlink">Új bejegyzés</a>
<h3>Bejegyzések</h3>

<table class="table table-striped">
	<tr>
		<th>#ID</th>
		<th>Cím</th>
		<th>Műveletek</th>
	</tr>
<?php if($lista)foreach($lista as $sor):?>
	<tr>
		<th><?= $sor->id; ?></th>
		<th><?= $sor->cim; ?></th>
		<th>
			<a href="<?= ADMINURL; ?>post/szerkesztes/<?= $sor->id; ?>" class="btn btn-info topadminlink"><span class="glyphicon glyphicon-pencil"></span></a>
			<!-- <a href="<?= ADMINURL; ?>post/torles/<?= $sor->id; ?>" class="btn btn-info topadminlink"></a> -->
		</th>
	</tr>
<?php endforeach; ?>
</table>
