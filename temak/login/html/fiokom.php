
<!-- start: static -->
<div class="static forms">
    <div class="inner">
 
        <h1><?= __f('Fiók beállítások');?></h1>
		
				
        <form method="post" id="urlap">
            
            
        <div class="box">
			<div class="item">
                <h2><?= __f('Személyes adatok');?></h2>
				<?php if(@$hiba!='') print '<h4 style="color:red">'.$hiba.'</h4>';?>
				
				
				
				
				
                <div class="input-line">
                    <div class="input-container">
                        <label for="" class="important"><?= __f('Vezetéknév'); ?></label>
                        <input type="text" id="lname" name="u[vezeteknev]" value="<?= $tag->vezeteknev;?>">
                        <div class="error-msg"><?= __f('Hiba!');?></div>
                    </div>
                    <div class="input-container">
                        <label for="" class="important"><?= __f('Keresztnév');?></label>
                        <input type="text" id="fname" name="u[keresztnev]"   value="<?= $tag->keresztnev;?>">
                        <div class="error-msg"><?= __f('Hiba!');?></div>
                    </div>
                </div>

                <div class="input-line">
                    <div class="input-container">
                        <label for="" class="important"><?= __f('E-mail cím');?></label>
                        <input type="text" id="email" name="u[email]"  value="<?= $tag->email;?>">
                        <div class="error-msg"><?= __f('Hiba!');?></div>
                    </div>
                    
                </div>
			</div>
			<div class="item">
                <h2><?= __f('Jelszó módosítása');?></h2>
                <div class="input-line jelszosor" >
                    <div class="input-container">
                        <label for="" class=""><?= __f('Jelszó (hagyd üresen, ha nem változtatod)');?></label>
                        <input id="pwd1" type="password" name="pwd" value="">
                        <div class="error-msg"><?= __f('Jelszó túl rövid');?></div>
                    </div>
                    <div class="input-container">
                        <label for="" class=""><?= __f('Jelszó újra');?></label>
                        <input id="pwd2" type="password" name="pwd2" value="">
                        <div class="error-msg"><?= __f('A jelszavak nem egyeznek');?></div>
                    </div>
                </div>

            </div>

            
            <div class="item">

                <div class="input-line">
                    <div class="checkbox-container">
                        <div class="ch-line">
                            <input name="hirlevel" type="checkbox" value="1" id="ch0" <?= $hirlevelFeliratkozas?'checked':'';?> >
                            <label for="ch0"><?= __f('Hírlevél feliratkozás');?></label>
                        </div>
                        
                    </div>
                </div>

            </div>

        </div>
		
        <div class="buttons">
            <button type="button" id="regisztracioStart" class="btn btn-green">
                <?= __f('Módosítás'); ?>
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
			
			
			vnev = $('#lname').val().trim();
			knev = $('#fname').val().trim();
			email = $('#email').val().trim();
			if(vnev.length<2) {
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
			
			if($('#pwd1').val().trim()!="") {
				
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

