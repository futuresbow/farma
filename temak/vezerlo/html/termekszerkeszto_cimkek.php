			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class="">Cimkék hozzárendelése</label>
                    </div>
                    <div class="input-select-container">
                       
                    <?php if($cimkelista) foreach($cimkelista as $cimke):?>
                    <div class="checkbox-container">
						<input type="checkbox" id="cimkecb_<?= $cimke->id;?>" name="cimke[<?= $cimke->id;?>]" <?= (isset($checked[$cimke->id]))?'checked':''?> value="1">
						<label for="cimkecb_<?= $cimke->id;?>"><?= $cimke->nev." (".$cimke->nyelv.")";?></label>
					</div>
                    <?php endforeach;?>
                    
                    
                    </div>
				</div>

			</div>

