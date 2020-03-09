<div class="static ">

    
 

				

        <form method="post" id="kontakturlap" onsubmit="">

            

            

        <div class="box">

			<div class="item">

                <h2><?= __f('Üzenet küldés');?></h2>

				<?php if(@$hiba!='') print '<h4 style="color:red">'.$hiba.'</h4>';?>

				

				

				

				

				

                <div class="form-elements">

                    <div class="form-line">
						<div class="input-container <?= (isset($h['nev']))?' error ':'';?> ">
						
							<label for="" class="important"><?= __f('Az Ön neve'); ?></label>
							
							<input type="hidden" name="m[nev]" value="Név" />
							
							<input type="text" id="nev" name="a[nev]" value="<?= @$_POST['a']['nev'];?>">

							<div class="error-msg"><?= __f('Kérjük, add meg nevedet!');?></div>

						</div>
                    </div>

                    <div class="form-line">
						<div class="input-container <?= (isset($h['email']))?' error ':'';?>">

							<label for="" class="important"><?= __f('E-mail címe');?></label>
							
							<input type="hidden" name="m[email]" value="E-mail cím" />
							<input type="text" id="email" name="a[email]"   value="<?= @$_POST['a']['email'];?>">

							<div class="error-msg"><?= __f('Nem megfelelő E-mail cím!');?></div>
				
						</div>
					</div>
					
                    <div class="form-line">
						<div class="input-container <?= (isset($h['text']))?' error ':'';?>">

							<label for="" class="important"><?= __f('text');?></label>
							<input type="hidden" name="m[text]" value="Üzenet" />
							<textarea name="a[text]" id="text" ><?= @$_POST['a']['text'];?></textarea>

							<div class="error-msg"><?= __f('Az üzenet túl rövid');?></div>
				
						</div>
					</div>

                </div>
           </div>
           </div>
			 <div class="buttons">

            <button type="submit"  id="urlapElkuldes" class="btn btn-green">

                <?= __f('Levél elküldése'); ?>

            </button>

        </div>

		
		</form>
		
		</div>
		<p></p>
