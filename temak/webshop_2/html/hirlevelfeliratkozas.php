
<!-- start: static -->
<div class="static forms">
    <div class="inner">

        <h1><?= __f('Hírlevél feliratkozás');?></h1>
        <form method="post" id="urlap">
        
            
        <div class="box">
			<div class="item">
                <h2><?= __f('Kérjük, add meg a következő adatokat');?></h2>
				
				
				
								<div class="form-elements">
				
					<div class="form-line">
						<div class="input-container <?= (isset($hiba['nev'])?' error ':'')?>">
							<label for="" class="important"><?= __f('Teljes neved'); ?></label>
							<input type="text" id="hlname" class="hluser" name="hu[nev]" value="<?= @$_POST['hu']['nev'];?>">
							<div class="error-msg"><?= __f('Hiba!');?></div>
						</div>
					
					</div>

					<div class="form-line">
						<div class="input-container <?= (isset($hiba['email'])?' error ':'')?>">
							<label for="" class="important"><?= __f('E-mail cím');?></label>
							<input type="text" id="email" class="hlemail"  name="hu[email]" value="<?= @$_POST['hu']['email'];?>">
							<div class="error-msg"><?= __f('Hiba!');?></div>							<?php if(isset($hiba['feliratkozott'])):?>
							<div class="error-msg" style="display:block;"><?= __f('Ezzel az E-mail címmel már regisztráltak.');?></div>
							
							<?php endif;?>
						</div>
						
					</div>
					<div class="form-line">						<div class="ch-line <?= (isset($hiba['aszf'])?' error ':'')?>">

                            <input id="adatkezeles" name="hladatk" type="checkbox" value="1" >

                            <label for="adatkezeles" class="important"><?= __f('Elfogadom az <a title="adatkezelés" href="'.base_url().'adatkezeles" target="_blank">Adatkezelési elveket</a>.');?></label>

                            <div class="error-msg"><?= __f('Hiba!');?></div>

                        </div>
                     </div>
			
				</div>
            </div>

            
            <div class="item">
			
            
            </div>

        </div>
		
        <div class="buttons">
            <button type="button" id="regisztracioStart" class="btn btn-green">
                <?= __f('Feliratkozás'); ?>
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
			
			nev = $('.hluser').val().trim();
			
			email = $('.hlemail').val().trim();
			if(nev.length<3) {
				hiba = true;
				$('.hluser').parent().addClass("error");
			} else {
				$('.hluser').parent().removeClass("error");
			}
			
		
			if(!this.validateEmail(email)) {
				hiba = true;
				$('.hlemail').parent().addClass("error");
			} else {
				$('.hlemail').parent().removeClass("error");
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

