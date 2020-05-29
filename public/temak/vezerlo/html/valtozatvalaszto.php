
				<input name="a[termekszulo_id]" value="<?= (int)@$szulo->id;?>" id="a_fotermekid" type="hidden"/>
				<?php if($szulo):?>
				<div class="fotermekvalaszto_bal">

                    
                        Kiválasztott főtermék:<br><br>
						<a target="_blank" href="<?= $szulo->link();?>" title="<?= $szulo->jellemzo('Név');?>" >
							
                            <img src="<?= base_url().ws_image($szulo->fokep(),'smallboxed');?>" title="<?= $szulo->jellemzo('Név');?>" alt="<?= $szulo->jellemzo('Név');?>" style="margin: 5px auto;">
							
							<?= $szulo->jellemzo('Név');?>
                        </a><br>
                        <button onclick="$('#a_fotermekid').val(0);$('.fotermekvalaszto_bal').html('Ez egy főtermék');" >Főtermék törlése</button>
                    
				</div>
				<?php else:?>
				<div class="fotermekvalaszto_bal">
					Ez egy főtermék
				</div>
				<?php endif;?>
				<div class="fotermekvalaszto_jobb">

                    <div class="label-container">

                        <label class="">Főtermék keresése</label>

                        
                    </div>
                    <div class="input-select-container">
						<input type="text" name="fotermekKereso" value="<?= @$_GET['str'];?>" onkeyup="aJs.fotermekkereso(this.value, <?= $sor->id;?>);" />
						<div id="fotermekLista"></div>
					</div>
				</div>

              
<style>
.fotermekvalaszto_bal {
	width: 49%;
	float:left;
	text-align:center; 
}
.fotermekvalaszto_bal img{
	max-width: 100%;
}
.fotermekvalaszto_jobb input {
-webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    border: 1px solid #c7d2d9;
    background: #ffffff;
    width: 100%;
    height: 36px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    padding: 0 10px;
    color: #44505b;
    font-family: 'Open Sans',sans-serif;
    font-weight: 400;
    font-style: normal;
    font-size: .875em;
    line-height: inherit;
    letter-spacing: 0;
    -webkit-transition: border .1s;
    -moz-transition: border .1s;
    -o-transition: border .1s;
    transition: border .1s;
    -webkit-transition: box-shadow .1s;
    -moz-transition: box-shadow .1s;
    -o-transition: box-shadow .1s;
    transition: box-shadow .1s;	
}
.fotermekvalaszto_jobb {
	float: right;
	width: 50%
}
.fotermekLista > div {
	clear:both;
}
</style>   
