<?php foreach($lista as $sor):?>
<div class="sortable" style="margin: 2px;padding: 10px; border: 1px solid #aaa;" >
	<div style="float:right;width: 30%" >
		<div class="input-container ">
                    <div class="label-container">
                        <label class="">Cím</label>
                    </div>
                    <div class="input-select-container">
						<input type="text" name="kepsor[<?= $sor->id; ?>][leiras]" value="<?= $sor->leiras?>" placeholder="Leírás" />
					</div>
         </div>
		<div class="input-container ">
                    <div class="label-container">
                        <label class="">Sorrend</label>
                    </div>
                    <div class="input-select-container">
						<input type="text" name="kepsor[<?= $sor->id; ?>][sorrend]" value="<?= $sor->sorrend?>" placeholder="egész szám" />
					</div>
         </div>
         <br>
			<div class="input-container ">
                    
                    <div class="input-select-container">
						<input type="checkbox" name="kepsortorles[<?= $sor->id; ?>]" value="1" /> - kép törlése
					</div>
                </div>
	</div>
	
	<img src="<?= base_url().$sor->kep;?>" style="width: 66%" />
</div>
<?php endforeach ;?>
