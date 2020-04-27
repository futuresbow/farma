  <div class="static">

    <h1><?= __f('Jelszó visszaállítás');?></h1>
	<?php if($kizaroUzenet):?>
    <p class="lead">
        <?= $kizaroUzenet; ?>
    </p>
    <?php else:?>
    
    
    <?php if($jelszohiba):?>
    <p class="lead">
        <?= $jelszohiba; ?>
    </p>
    <?php endif;?>
    
      <form method="post" id="urlap">
			<div class="form-elements">

				<div class="form-line">
					<div class="input-container ">
						<label class="important"><?= __f('Új jelszó');?> <small><?= __f('legalább 6 karakter hosszú'); ?></small></label>
						<input type="password" id="pwd1" name="pwd1" value="" placeholder="******">
						<div class="error-msg"> <?= __f('Hiba!');?></div>
					</div>
				</div>

				
				<div class="form-line">
					<div class="input-container ">
						<label class="important"><?= __f('Jelszó újra');?> <small></small></label>
						<input type="password" id="pwd2" name="pwd2" value="" placeholder="******">
						<div class="error-msg"> <?= __f('Hiba!');?></div>
					</div>
				</div>

				

			</div>
            

           

            <div class="form-btn-container">
                <button type="submit"  class="btn btn-green">
                    <?= __f('Jelszó visszaállítása'); ?>
                </button>
            </div>
        </form>
        
        
    <?php endif;?>
 </div>
 
 

