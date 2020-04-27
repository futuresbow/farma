<a href="<?= ADMINURL; ?>oldalak/szerkesztes/0" class="btn btn-info topadminlink">Új tartalom felvitele</a>
<h3>Oldalak</h3>

<table class="table table-striped">
	<tr>
		<th>#ID</th>
		<th>URL</th>
		<th>Tartalom</th>
		<th>Sorrend</th>
		<th>Műveletek</th>
	</tr>
<?php if($lista)foreach($lista as $sor): $url = $sor->url; if($url=='') $url = 'Főoldal';if($url=='***') $url = 'Alapértelmezett oldal';?>
	<tr>
		<th><?= $sor->id; ?></th>
		
		<th><?= $url; ?></th>
		<th><?= $moduleleresek[$sor->moduleleres]['cim']; ?></th>
		<th><?= $sor->sorrend; ?></th>
		<th>
			<a href="<?= ADMINURL; ?>oldalak/torles/<?= $sor->id; ?>" class="btn btn-danger topadminlink"><span class="glyphicon glyphicon-trash"></span></a>
			<a href="<?= ADMINURL; ?>oldalak/szerkesztes/<?= $sor->id; ?>" class="btn btn-info topadminlink"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="<?= ADMINURL; ?>oldalak/tartalomkezeles/<?= $sor->id; ?>" class="btn btn-info topadminlink"><span class="glyphicon glyphicon-plus-sign"></span></a>
		</th>
	</tr>
<?php endforeach; ?>
</table>
