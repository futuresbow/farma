
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class="">Kategória besorolás</label>
                    </div>
                    <div class="input-select-container">
                       
                    <?php if(isset($_GET['szulo_id'])) { $sor = new stdClass;$sor->szulo_id=(int)$_GET['szulo_id']; } ?>
	
					<?php if($lista)foreach($lista as $kat):?>
					<div onclick="var cd = $(this).find('input').prop('checked');$(this).find('input').prop('checked', !cd);" style="margin-left: <?= ($kat->szint+1)*20;?>px"  class="kategoriaValasztoSor">
						<input type="checkbox"  value="<?= $kat->id; ?>" name="k[]" <?= (isset($termekXKategoria[$kat->id]))?' checked ':''; ?> class="kategoria-cbbox" /><div ></div> - <?= $kat->nev;?>
					</div>	
					<?php endforeach; ?>
                    
                    
                    </div>
				</div>

			</div>

