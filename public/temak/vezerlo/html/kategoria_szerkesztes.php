
<div class="box">
<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class="">Szülő kategória</label>
                        <div class="error-tooltip">
                            <div class="icon">
                                <div class="tooltip-container">
                                    <div class="tooltip-msg">
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="input-select-container ">


	<?php if(isset($_GET['szulo_id'])) { $sor = new stdClass;$sor->szulo_id=(int)$_GET['szulo_id']; } ?>
	<div style="paddig-left: 0px" class="kategoriaradio radio-container">
		<input id="rad" type="radio" value="0" class="" name="a[szulo_id]" <?= (@$sor->szulo_id == 0 || !isset($sor->szulo_id))?' checked ':''; ?> />
		<label for="rad"> - Főkategória</label>
	</div>
	<?php if($lista)foreach($lista as $k => $kat):?>
	<div style="margin-left: <?= ($kat->szint+1)*40;?>px"  class="kategoriaradio radio-container">
		<input type="radio" id="rad<?= $k; ?>" value="<?= $kat->id; ?>" class="" name="a[szulo_id]" <?= (@$sor->szulo_id == $kat->id)?' checked ':''; ?> />
		<label for="rad<?= $k; ?>"> - <?= $kat->nev;?></label>
	</div>	
	<?php endforeach; ?>




                    </div>
				</div>
             </div>

</div>

