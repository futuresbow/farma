<a href="<?= ADMINURL; ?>oldalak/lista" class="btn btn-info topadminlink">Vissza</a>
<a href="<?= ADMINURL; ?>oldalak/tartalomszerkesztes/0" class="btn btn-info topadminlink">Tartalom hozzáadása</a>
<h3>Tartalomkezelés: <?= $meta->ertek;?></h3>

<table class="table table-striped">
	<tr>
		<th>#ID</th>
		<th>Tartalomtípus neve</th>
		<th>URL</th>
		<th>Sorrend</th>
		<th>Műveletek</th>
	</tr>
<?php if($lista)foreach($lista as $sor):?>
	<tr>
		<td><?= $sor->id; ?></td>
		<td><?= $moduleleresek[$sor->moduleleres]['cim']; ?></td>
		<td><?= $sor->url; ?></td>
		<td><?= $sor->sorrend; ?></td>
		
		<td>
			<a href="<?= ADMINURL; ?>oldalak/tartalomtorles/<?= $sor->id; ?>" class="btn btn-danger topadminlink"><span class="glyphicon glyphicon-trash"></span></a>
			<a href="<?= ADMINURL; ?>oldalak/tartalomszerkesztes/<?= $sor->id; ?>" class="btn btn-info topadminlink"><span class="glyphicon glyphicon-pencil"></span></a>
			</td>
	</tr>
<?php endforeach; ?>
</table>
