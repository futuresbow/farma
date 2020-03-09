
    <h1><?= __f('Elfelejtett jelszó visszaállítása');?></h1>
    <p class="lead">
        <?= __f('Kérjük, add meg E-mail címedet');?>
    </p>

    <?php if($hiba==true) print '<h4 style="color:red">'.__f('Nem megfelelő E-mail cím, vagy nem szerepel az adatbázisban.').'</h4>';?>


        <form method="post" id="urlap">
			
				<div class="form-line">
					<div class="input-container ">
						<label class="important"><?= __f('E-mail cím');?></label>
						<input type="text" id="email" name="elfelejtett_email" value="<?= @$_POST['elfelejtett_email']; ?>">
						<div class="error-msg"> <?= __f('Hiba!');?></div>
					</div>
				</div>

				

			

           

                <button type="submit"  class="btn btn-green">
                    <?= __f('Jelszó visszaállítása'); ?>
                </button>
           
        </form>
