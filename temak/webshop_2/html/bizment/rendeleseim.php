<div class="static ">

		<p></p>
		<form method="post" id="">

        <h1><?= __f('Korábbi megrendelések') ;?></h1>
		
		<?php if(!$lista):?>
		<b>Nincs még megrendelése.</b>
		<?php else: ?>
		<table class="darkTable" style="width:100%;">
			<thead>
				<tr>
					<th>Időpont</th>
					<th>Státusz</th>
					<th>Összár</th>
					<th></th>
				</tr>
			</thead>
			<?php foreach($lista as $r):?>
			 <tr class="reszletek_<?= $r->id; ?>">

				<td class="thumb"><?= $r->ido?></td>

                <td class="prod-name"><?= $r->statusz?></td>
                <td class=""><?= ($r->osszar);?></td>
                <td class=""><a href="#" onclick="$(this).parent().parent().next().slideDown();return false ;">Részletek</a></td>
             </tr>
             <tr class="reszletek_<?= $r->id; ?>" style="display:none">
				<td colspan="4">
				<?php ws_autoload('termek');$rendeles = new Rendeles_osztaly();$rendeles->betoltesMegrendeles($r->rendelesid);$rendeles->megrendelesAdatTablak(); print $rendeles->megrendelesAdatTablak();?>
				</td>
             </tr>
             <?php endforeach;?>
		</table>
		<?php endif; ?>

</div>
