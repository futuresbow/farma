<!-- start: static -->
<div class="static ">
    
		<form method="post" id="rendelesForm">
        <h1><?= __f('Kosár és megrendelés') ;?></h1>
		<?php if(@$hiba!=''):?>
		<div class="hibabox"><?= $hiba;?></div>
		<?php endif ;?>
        <div class="box">			
            <div class="item">
                <h2><?= __f('A kosár tartalma'); ?></h2>
                <div class="cart-content nagykosar" id="nagykosar">
                    <?php include('kosaroldal_termeklista.php');?>
                    
                </div>
            </div>
			
            <div class="form-elements">
                <div class="form-line">
                    <div class="input-container ">
                        <label for="" class="important">Szállítási mód</label>
                        <div class="styled-select">
                            <select class="armodositok" name="szallitasmod" id="szallitasmod" onchange="siteJs.kosarOsszarKalkulacio()">
                                <option value="0">Kérem, válasszon!</option>
                                <?php foreach($szallitasmodok as $mod):?>
                                <option <?= (@$rendeles->armodositok['szallitasmod']->id==$mod->id)?' selected ':'';?> value="<?= $mod->id?>"><?= __f($mod->nev);?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="error-msg">Hiba!</div>
                    </div>
                    <div class="input-container price-container szallitasmodar">
                    <?php $mod = 'szallitasmod'; include('kosaroldal_armodositoar.php');?>
                    </div>
                </div>
            </div>

            <div class="form-elements">
                <div class="form-line">
                    <div class="input-container">
                        <label for="" class="important">Fizetési mód</label>
                        <div class="styled-select">
                            <select class="armodositok" name="fizetesmod" id="fizetesmod" onchange="siteJs.kosarOsszarKalkulacio()">
                                <option value="0">Kérem, válasszon!</option>
                                <?php foreach($fizetesmodok as $mod):?>
                                <option <?= (@$rendeles->armodositok['fizetesmod']->id==$mod->id)?' selected ':'';?> value="<?= $mod->id?>"><?= __f($mod->nev);?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="error-msg">Hiba!</div>
                    </div> 
                    
                    <div class="input-container price-container fizetesmodar">
                    <?php $mod = 'fizetesmod'; include('kosaroldal_armodositoar.php');?>
                    </div>
                </div>
            </div>
			
            <div class="cart-content price-summ" >
				<?php include('kosaroldal_vegosszeg.php');?>
                
            </div>

        </div>

        <div class="box">

            <div class="item" id="szemelyesadatok">
                <h2><?= __f('Személyes adatok'); ?></h2>
				<?php if(!is_object($f)): ?>
				<table style="display:none;" align="center" cellspacing=10 cellpadding=10><tr>
			<td style="padding:10px"><div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div></td>
			<td style="padding:10px">
			
			
			<!-- Display login status -->
<div id="status"></div>

<!-- Facebook login or logout button -->
<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink"><img src="https://i.imgur.com/fKwjtLE.png"/></a>

<!-- Display user profile data -->
<div id="userData"></div>
			
			</td>
		</tr></table>
		
		<!-- GOOGLE LOGIN  -->
		
		
		<script>
					function onSignIn(googleUser) {
					// Useful data for your client-side scripts:
					var profile = googleUser.getBasicProfile();
					
					$('#regtipus').val("google");
					$('#smedia_id').val(profile.getId());
					$('#keresztnev').val( profile.getGivenName());
					$('#vezeteknev').val( profile.getFamilyName());
					$('#email').val( profile.getEmail()).attr('readonly', 1);
					$('.jelszosor').fadeOut();
					$('#rendelesForm').submit();
					}
		</script>
		<script>
		// Facebook login with JavaScript SDK
		function fbLogin() {
			FB.login(function (response) {
				if (response.authResponse) {
					// Get and display the user profile data
					getFbUserData();
				} else {
				
				}
			}, {scope: 'email'});
		}

		// Fetch the user profile data from facebook
		function getFbUserData(){
			FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
			function (response) {
				if(!response.email) {
					alert("<?= __f('A Fecebook nem osztotta meg E-mail címedet, így nem tudunk beléptetni.');?>");
					return;
				}
				$('#regtipus').val("facebook");
				$('#smedia_id').val( response.id );
				$('#vezeteknev').val( response.last_name);
				$('#keresztnev').val( response.first_name);
				$('#email').val( response.email);
				$('.jelszosor').fadeOut();
				$('#rendelesForm').submit();
				
			});
		}

		
		</script>
				
				
       <input type="hidden" id="regtipus" name="f[regtipus]" value="" />
        <input type="hidden" id="smedia_id" name="f[smedia_id]" value="" />
           
		<?php endif; ?>
				<div class="form-elements">	
					<div class="form-line">
						<div class="input-container">
							<label for="" class="important">Vezetéknév</label>
							<input class="req" type="text" id="vezeteknev"  name="f[vezeteknev]" value="<?= @$f->vezeteknev; ?>">
							<div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
						</div>
						<div class="input-container">
							<label for="" class="important">Keresztnév</label>
							<input class="req" type="text" id="keresztnev"    name="f[keresztnev]" value="<?= @$f->keresztnev; ?>">
							<div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
						</div>
					</div>

					<div class="form-line">
						<div class="input-container">
							<label for="" class="important">E-mail cím</label>
							<input class="req checkemail" type="text" name="f[email]" id="email" <?= isset($f->id)?' readonly ':''; ?> value="<?= @$f->email;?>">
							<div class="error-msg"><?= __f('Kérem, adja meg e-mail címét!');?></div>
						</div>
						<div class="input-container">
							<label for="" class="important">Mobiltelefon</label>
							<input class="req" type="text" name="v[telefonszam]" value="<?= @$v->telefonszam;?>">
							<div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
						</div>
					</div>
					 <?php if(!$f) if((int)beallitasOlvasas("regisztralas.vasarlaskor")!=0):?>
					<div class="form-line">
						<div class="checkbox-container">
							<div class="ch-line">
								<input  type="checkbox" id="chjsz" <?= isset($p['jelszocb'])?'checked':'';?> name="jelszocb" onchange="if(this.checked)$('.jelszosor').show(); else $('.jelszosor').hide(); ">
								<label for="chjsz"><?= __f('A vásárlással egyben regisztrálok is az oldalra.');?></label>
							</div>
						</div>
					</div>
				   
					 <div class="form-line jelszosor" style="display:<?= isset($p['jelszocb'])?'block':'none';?>" >
						<div class="input-container">
							<label for="" class="important">Jelszó</label>
							<input type="password" name="jelszo" id="jelszo"  value="">
							<div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
						</div>
						<div class="input-container">
						   
						</div>
					</div>
					<?php endif;?>				
				</div>

            </div>

            <div class="form-elements">
                <h3>Számlázási adatok</h3>
                
                <div class="form-line">
                    <div class="input-container">
                        <label for="" class="important">Név vagy cégnév</label>
                        <input class="req" type="text" name="v[szaml_nev]" value="<?= @$v->szaml_nev;?>">
                        <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                    </div>
                    <div class="input-container">
                        <label for="" class="">Adószám</label>
                        <input type="text" name="f[adoszam]" value="<?= @$f->adoszam;?>">
                    </div>
                </div>

                <div class="form-line">
                    <div class="input-container">
                        <label for="" class="important">Irányítószám</label>
                        <input class="req" type="text" name="v[szaml_irszam]" value="<?= @$v->szaml_irszam;?>">
                        <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                    </div>
                    <div class="input-container">
                        <label for="" class="important">Település</label>
                        <input class="req"  type="text" name="v[szaml_telepules]" value="<?= @$v->szaml_telepules;?>">
                        <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                    </div>
                </div>

                <div class="form-line">
                    <div class="input-container">
                        <label for="" class="important">Utca, házszám stb.</label>
                        <input class="req"  type="text" name="v[szaml_utca]" value="<?= @$v->szaml_utca;?>">
                        <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                    </div>
                    <div class="input-container">
                        <label for="" class="important">Ország</label>
                        <div class="styled-select">
                            <select class="req"  name="v[szaml_orszag]">
                                <option>Magyarország</option>
                            </select>
                        </div>
                        <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                    </div>
                </div>

            </div>

            <div class="form-elements">
                <h3>Szállítási adatok</h3>

                <div class="form-line">
                    <div class="checkbox-container">
                        <div class="ch-line">
                            <input type="checkbox" id="ch1" <?= isset($p['szalszamlcb'])?'checked':'';?> name="szalszamlcb" onchange="if(this.checked){$('#szalszamldiv').hide().find('input').removeClass('req').parent().removeClass('error');} else {$('#szalszamldiv').show().find('input').addClass('req');;} ">
                            <label for="ch1"><?= __f('A szállítási cím megegyezik a számlázási címemmel.');?></label>
                        </div>
                    </div>
                </div>

                <div style="display:<?= isset($p['szalszamlcb'])?'none':'block';?>;" id="szalszamldiv"> <!-- display:block;, if unchecked -->
                    <div class="form-line">
                        <div class="input-container">
                            <label for="" class="important">Név vagy cégnév</label>
                            <input type="text" name="v[szall_nev]" value="<?= @$v->szall_nev;?>">
                            <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                        </div>
                       
                    </div>

                    <div class="form-line">
                        <div class="input-container">
                            <label for="" class="important">Irányítószám</label>
                            <input type="text" name="v[szall_irszam]" value="<?= @$v->szall_irszam;?>">
                            <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                        </div>
                        <div class="input-container">
                            <label for="" class="important">Település</label>
                            <input type="text" name="v[szall_telepules]" value="<?= @$v->szall_telepules;?>">
                            <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                        </div>
                    </div>

                    <div class="form-line">
                        <div class="input-container">
                            <label for="" class="important">Utca, házszám stb.</label>
                            <input type="text" name="v[szall_utca]" value="<?= @$v->szall_utca;?>">
                            <div class="error-msg"><?= __f('A mező kitöltése kötelező');?></div>
                        </div>
                        <div class="input-container">
                            <label for="" class="important">Ország</label>
                            <div class="styled-select">
                                <select name="v[szall_orszag]">
                                    <option>Magyarország</option>
                                </select>
                            </div>
                            <div class="error-msg">Hiba!</div>
                        </div>
                    </div>
                </div>

                <div class="form-line">
                    <div class="input-container">
                        <label for="">Üzenet</label>
                        <textarea name="v[megjegyzes]"><?= @$v->megjegyzes;?></textarea>
                    </div>
                </div>

            </div>

            <div class="form-elements">

                <div class="form-line">
                    <div class="checkbox-container">
                        <div class="ch-line">
                            <input type="checkbox" id="ch0"  <?= isset($p['hirlevelfeliratkozascb'])?'checked':'';?> name="hirlevelfeliratkozascb" >
                            <label for="ch0">Feliratkozom a hírlevélre.</label>
                        </div>
                        <div class="ch-line ">
                            <input class="req checkbox" type="checkbox" name="akcb" <?= isset($p['akcb'])?'checked':'';?> id="ch2">
                            <label for="ch2" class="important">Elfogadom az Adatkezelési elveket.</label>
                            <div class="error-msg">Hiba!</div>
                        </div>
                        <div class="ch-line">
                            <input class="req checkbox" type="checkbox" name="aszfcb" <?= isset($p['aszfcb'])?'checked':'';?> id="ch3">
                            <label for="ch3" class="important">Elfogasom az Általános Szerződési Feltételeket.</label>
                            <div class="error-msg">Hiba!</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="buttons clearfix">
            <div class="left">
                <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url'); ?>" title="<?= __f('Tovább vásárolok'); ?>" class="btn btn-gray">
                    <?= __f('Tovább vásárolok'); ?>
                </a>
            </div>
            <div class="right">
                <a href="javascript:void(0);" onclick="siteJs.rendelesEllenorzes();" title="<?= __f('Rendelés elküldése');?>" class="btn btn-green">
                    <?= __f('Rendelés elküldése');?>
                </a>
            </div>
        </div>
		</form>
    </div>
</div>
<!-- end: static -->

