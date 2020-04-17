
<table class="table table-stripped" style="width:100%;">
	<thead>
		<tr>
			<th></th>
			<?php foreach($szintek as $szint):?>
			<th style=""><span style="writing-mode: vertical-rl;"><?= $szint->nev;?></span></th>
			<?php endforeach;?>
	</thead>
	<tbody>
		<?php foreach($eleresek as $sor):?>
		<tr>
			<td><?= $sor->eleres.' '.$sor->jogkor;?></td>
			<?php foreach($szintek as $k =>  $szint):?>
			<td style=""><input type="checkbox" value="<?= pow(2,$k); ?>" name="jk[<?= $sor->id ?>][<?= $k ?>]" <?= (((int)$szint->ertek & (int)$sor->jogkor)>0)?'checked':'';?> ></th>
			<?php endforeach;?>
			
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
