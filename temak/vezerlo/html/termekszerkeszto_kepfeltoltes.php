
			<div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class="">Képfeltöltés (maximum 15 kép, jpg formátumban)</label>
                    </div>
                    <div class="input-select-container">
                       	<input type="file" class="form-control " name="imgupload" id="imgupload" onchange="aJs.kelFeltoltes(<?= $tid;?>)" />
                    </div>
				</div>
				
			</div>
			<div class="box-item fw">

               <div class="kepkonyvtar"></div>				
			</div>
			<div class="box-item fw">



               <div class="kepdragdrop" id="dropZone" data-url="<?= $tid;?>" >Húzz ide egy képet</div>
				

			</div>
