<a href="<?= ADMINURL; ?>termek/szerkesztes/0" class="btn btn-info topadminlink">Új termék</a>
<h3>Termékek</h3>

<table class="table table-striped">
	<tr>
		<th>#ID</th>
		<th>Név</th>
		<th>Cikkszám</th>
		<th>Műveletek</th>
	</tr>
<?php if($lista)foreach($lista as $sor):?>
	<tr>
		<th><?= $sor->id; ?></th>
		<th><?= $sor->nev; ?></th>
		<th><?= $sor->cikkszam; ?></th>
		<th>
			<a href="<?= ADMINURL; ?>termek/szerkesztes/<?= $sor->id; ?>" class="btn btn-info topadminlink"><span class="glyphicon glyphicon-pencil"></span></a>
			<!-- <a href="<?= ADMINURL; ?>termek/torles/<?= $sor->id; ?>" class="btn btn-info topadminlink"></a> -->
		</th>
	</tr>
<?php endforeach; ?>
</table>
