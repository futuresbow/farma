
<!-- start: static -->
<div class="static forms">
    <div class="inner">

        <h1><?= __f('Regisztráció');?></h1>
		<table style="display:none;margin:0 auto;"><tr>
			<td style="padding:10px"><div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div></td>
			<td style="padding:10px">
			
			
			<!-- Display login status -->
<div id="status"></div>

<!-- Facebook login or logout button -->
<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink"><img alt="fb" title="" src="https://i.imgur.com/fKwjtLE.png"/></a>

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
					$('#fname').val( profile.getGivenName());
					$('#lname').val( profile.getFamilyName());
					$('#email').val( profile.getEmail()).attr('readonly', 1);
					$('.jelszosor').fadeOut();
					
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
				$('#lname').val( response.last_name);
				$('#fname').val( response.first_name);
				$('#email').val( response.email);
				$('.jelszosor').fadeOut();
				
				
			});
		}

		
		</script>
				
				
        <form method="post" id="urlap">
        <input type="hidden" id="regtipus" name="u[regtipus]" value="" />
        <input type="hidden" id="smedia_id" name="u[smedia_id]" value="" />
           
            
        <div class="box">
			<div class="item">
                <h2><?= __f('Kérjük, add meg a következő adatokat');?></h2>
				<?php if(@$hiba!='') print '<h4 style="color:red">'.$hiba.'</h4>';?>
				
				
				
								<div class="form-elements">
				
					<div class="form-line">
						<div class="input-container">
							<label for="lname" class="important"><?= __f('Vezetéknév'); ?></label>
							<input type="text" id="lname" name="u[vezeteknev]" value="">
							<div class="error-msg"><?= __f('Hiba!');?></div>
						</div>
						<div class="input-container">
							<label for="fname" class="important"><?= __f('Keresztnév');?></label>
							<input type="text" id="fname" name="u[keresztnev]"   value="">
							<div class="error-msg"><?= __f('Hiba!');?></div>
						</div>
					</div>

					<div class="form-line">
						<div class="input-container">
							<label for="email" class="important"><?= __f('E-mail cím');?></label>
							<input type="text" id="email" name="u[email]"  value="">
							<div class="error-msg"><?= __f('Hiba!');?></div>
						</div>
						
					</div>

					<div class="form-line jelszosor" >
						<div class="input-container">
							<label for="pwd1" class="important"><?= __f('Jelszó');?></label>
							<input id="pwd1" type="password" name="pwd" value="">
							<div class="error-msg"><?= __f('Jelszó túl rövid');?></div>
						</div>
						<div class="input-container">
							<label for="pwd2" class="important"><?= __f('Jelszó újra');?></label>
							<input id="pwd2" type="password" name="pwd2" value="">
							<div class="error-msg"><?= __f('A jelszavak nem egyeznek');?></div>
						</div>
					</div>

				</div>
            </div>

            
            <div class="item">
				<div class="form-elements">
                
					<div class="form-line">
                    <div class="checkbox-container">
                        <div class="ch-line">
                            <input name="hirlevel" type="checkbox" value="1" id="ch0" checked>
                            <label for="ch0"><?= __f('Feliratkozom a hírlevélre.');?></label>
                        </div>
                        <div class="ch-line">
                            <input id="adatkezeles" type="checkbox" value="1" >
                            <label for="adatkezeles" class="important"><?= __f('Elfogadom az <a title="adatkezelés" href="'.base_url().'adatkezeles" target="_blank">Adatkezelési elveket</a>.');?></label>
                            <div class="error-msg"><?= __f('Hiba!');?></div>
                        </div>
                        <div class="ch-line">
                            <input id="regaszf" type="checkbox" value="1" >
                            <label for="regaszf" class="important"><?= __f('Elfogasom az <a title="aszf" href="'.base_url().'aszf" target="_blank">Általános Szerződési Feltételeket</a>.');?></label>
                            <div class="error-msg"><?= __f('Hiba!');?></div>
                        </div>
                    </div>
                </div>

				</div>
            </div>

        </div>
		
        <div class="buttons">
            <button type="button" id="regisztracioStart" class="btn btn-green">
                <?= __f('Regisztráció'); ?>
            </button>
        </div>
		</form>
    </div>
</div>
<!-- end: static -->
<script>
	var Validalas = function() {
		this.init = function() {
			$('#regisztracioStart').click(function() {
				vJs.regisztacioEllenorzes();
			});
		}
		
		this.regisztacioEllenorzes = function() {
			// cb
			hiba = false;
			
			if($('#adatkezeles').prop("checked")!=true) {
				hiba = true;
				$('#adatkezeles').parent().addClass("error");
			} else {
				$('#adatkezeles').parent().removeClass("error");
				
			}
			if($('#regaszf').prop("checked")!=true) {
				hiba = true;
				$('#regaszf').parent().addClass("error");
			} else {
				$('#regaszf').parent().removeClass("error");
				
			}
			vnev = $('#lname').val().trim();
			knev = $('#fname').val().trim();
			email = $('#email').val().trim();
			if(vnev.length<3) {
				hiba = true;
				$('#lname').parent().addClass("error");
			} else {
				$('#lname').parent().removeClass("error");
			}
			if(knev.length<3) {
				hiba = true;
				$('#fname').parent().addClass("error");
			} else {
				$('#fname').parent().removeClass("error");
			}
			if(!this.validateEmail(email)) {
				hiba = true;
				$('#email').parent().addClass("error");
			} else {
				$('#email').parent().removeClass("error");
			}
			
			if($('#regtipus').val()=="") {
				
				pwd1 = $('#pwd1').val().trim();
				pwd2 = $('#pwd2').val().trim();
				if(pwd1!=pwd2) {
					hiba = true;
					$('#pwd2').parent().addClass("error");
				} else {
					$('#pwd2').parent().removeClass("error");
				}
				if(pwd1.length < 6) {
					hiba = true;
					$('#pwd1').parent().addClass("error");
				} else {
					$('#pwd1').parent().removeClass("error");
				}
				
			}
			console.log("hiba");
			if(!hiba) $('#urlap').submit();
		}
		this.validateEmail = function(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
		}
	}
	vJs = new Validalas;
	vJs.init();
</script>

