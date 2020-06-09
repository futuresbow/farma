<?php
if(is_null($sor)) $sor = new Termek;
$sor->jellemzoBetoltes($termek_csoport_id);
$index = 0;

if($sor->jellemzok) foreach($sor->jellemzok as $k => $v):
	
	switch($v->tipus) {
		case 0:
		?>
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class=""><?= $v->nev;?></label>  <input name="jellemzo_felirat[<?=  $v->slug;?>]" value="<?= htmlspecialchars($sor->jellemzoFelirat($v->slug));?>" class="jelemzofelirat" placeholder="Felirat felülírása:" />
                    </div>
                    <div class="input-select-container">
                       	<input type="text" class="form-control" name="ti[<?= $v->slug?>]" value="<?= (isset($v->adat)?$v->adat:''); ?>" />
                    </div>
				</div>

			</div>
			
		<?php
		break;
		case 1:
		?>
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class=""><?= $v->nev;?></label> <input name="jellemzo_felirat[<?=  $v->slug;?>]" value="<?= htmlspecialchars($sor->jellemzoFelirat($v->slug));?>" class="jelemzofelirat" placeholder="Felirat felülírása:" />
                    </div>
                    <div class="input-select-container">
                       	<input type="text" class="form-control" name="ti[<?= $v->slug?>]" value="<?= (isset($v->adat)?$v->adat:''); ?>" />
                    </div>
				</div>

			</div>
		
		<?php
		break;
		case 2:
			$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
			foreach($nyelvek as $nyelvKod):
				
		?>
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class=""><?= $v->nev;?> (<?= $nyelvKod; ?>)</label>  <input name="jellemzo_felirat[<?=  $v->slug;?>][<?= $nyelvKod; ?>]" value="<?= htmlspecialchars($sor->jellemzoFelirat($v->slug, $nyelvKod));?>" class="jelemzofelirat" placeholder="Felirat felülírása:" />
                    </div>
                    <div class="input-select-container">
                       	<input class="form-control" type="text"  name="tj[<?= $nyelvKod;?>][<?= $v->slug?>]" value="<?= $sor->jellemzo($v->nev, $nyelvKod); ?>" />
					</div>
				</div>

			</div>
		
		
		
		
		<?php
			endforeach;
		break;
		case 3:
			foreach($nyelvek as $nyelvKod):
				$txt = $sor->jellemzo($v->nev, $nyelvKod);				/*				if(beallitasOlvasas("Termek-HTML-szerkeszto")!=1) {					$txt = strip_tags($txt);				} else {					$txt = nl2br($txt);				}				*/
				$index++;
		?>
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class=""><?= $v->nev;?> (<?= $nyelvKod; ?>)</label> <input name="jellemzo_felirat[<?=  $v->slug;?>][<?= $nyelvKod; ?>]" value="<?= htmlspecialchars($sor->jellemzoFelirat($v->slug, $nyelvKod));?>" class="jelemzofelirat" placeholder="Felirat felülírása:" />
                    </div>
                    <div class="input-select-container">
                       	<textarea class="basecode" id="fedit<?= $index; ?>" name="tj[<?= $nyelvKod;?>][<?= $v->slug?>]"  ><?= $txt; ?></textarea>
					</div>
				</div>

			</div>
		
		<?php
			endforeach;
		break;
		case 4:
			foreach($nyelvek as $nyelvKod):
				$txt = $sor->jellemzo($v->nev, $nyelvKod);				if(beallitasOlvasas("Termek-HTML-szerkeszto")!=1) $txt = strip_tags($txt);
						?>
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class=""><?= $v->nev;?> (<?= $nyelvKod; ?>) <small>Kiválaszthat VÁLTOZAT: minden sorba egy elem : ár módosító, pl. <i>kiveheto ajtó:1000</i></small></label>
                    </div>
                    <div class="input-select-container">						
                       	<textarea class="form-control" name="tj[<?= $nyelvKod;?>][<?= $v->slug?>]"  ><?= $txt;?></textarea>
					</div>
				</div>

			</div>
		
		<?php
			endforeach;
		break;
		case 5:
			foreach($nyelvek as $nyelvKod):
				
		?>
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class=""><?= $v->nev;?> (<?= $nyelvKod; ?>) <small>Választható OPCIÓK: minden sorba egy elem : ár módosító, pl. <i>plussz egy nap:2000</i></small></label>
                    </div>
                    <div class="input-select-container">
                       	<textarea class="form-control" name="tj[<?= $nyelvKod;?>][<?= $v->slug?>]"  ><?= htmlspecialchars($sor->jellemzo($v->nev, $nyelvKod)); ?></textarea>
					</div>
				</div>

			</div>
		
		<?php
			endforeach;
		break;
	}
endforeach;
?><script type="text/javascript"></script><?php if(beallitasOlvasas("Termek-HTML-szerkeszto")==1): ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>
<script>
	$().ready(function(){
		<?php 
		$index = 0;
		foreach($sor->jellemzok as $k => $v):
			if($v->tipus==3):
				foreach($nyelvek as $nyelvKod):
					$index++;
				
		?>
		var editor<?= $index; ?> = new Jodit("#fedit<?= $index; ?>", {
			"buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"
		});
		<?php 	
				endforeach; 
			endif; 
		endforeach; 
		?>
	});

</script>
<?php endif; ?>