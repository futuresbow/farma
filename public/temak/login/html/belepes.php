<!-- start: static -->
<div class="static forms">
    <div class="inner">

        <h1><?= __f('Belépés');?></h1>
		<table align="center" cellspacing=10 cellpadding=10><tr>
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
						$('#email').val( profile.getEmail()).attr('readonly', 1);
						$('.jelszosor').fadeOut();
						$('#urlap').submit();
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
				$('#email').val( response.email);
				$('.jelszosor').fadeOut();
				$('#urlap').submit();
				
			});
		}

		
		</script>
				
				
        <form method="post" id="urlap">
        <input type="hidden" id="regtipus" name="u[regtipus]" value="" />
        <input type="hidden" id="smedia_id" name="u[smedia_id]" value="" />
           
            
        <div class="box">
			<div class="item">
                <h2><?= __f('Belépéshez használd a közösségi médiát, vagy add meg E-mail címedet és jelszavadat');?></h2>
				<?php if($hiba==true) print '<h4 style="color:red">'.__f('Hibás belépési adatok').'</h4>';?>
				
				
				
				
				
             
                <div class="input-line">
                    <div class="input-container">
                        <label for="" class="important"><?= __f('E-mail cím');?></label>
                        <input type="text" id="email" name="u[email]"  value="<?= $email; ?>">
                        <div class="error-msg"><?= __f('Hiba!');?></div>
                    </div>
                    
                </div>

                <div class="input-line jelszosor " >
                    <div class="input-container ">
                        <label for="" class="important"><?= __f('Jelszó');?></label>
                        <input id="pwd1" type="password" name="pwd" value="">
                        <div class="error-msg"><?= __f('Jelszó túl rövid');?></div>
                    </div>
                  
                </div>

            </div>

            
           
        </div>
		
        <div class="buttons">
            <button type="submit" id="regisztracioStart" class="btn btn-green">
                <?= __f('Belépés'); ?>
            </button>
        </div>
		</form>
    </div>
</div>
<!-- end: static -->
<script>
	
</script>

