		<div class="home-tabs">
            <ul>
                <li><a onclick="$('.home-tabs ul li a').removeClass('active');$(this).addClass('active');$('.product-list').hide();$('#pl1').fadeIn();" href="javascript:void();" title="Akciós termékek" class="active">Akciós</a></li>
                <li><a onclick="$('.home-tabs ul li a').removeClass('active');$(this).addClass('active');$('.product-list').hide();$('#pl2').fadeIn();" href="javascript:void();" title="Kiemelt termékek">Kiemelt</a></li>
                
            </ul>
        </div>

        <div class="product-list" id="pl1">

            <ul class="products">
				<?php foreach($akciostermekek as $t):?>
                <li>
                    <a  href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" class="sale new">
                     <?php if($t->cimkeTag(1)):?><div class="sale-badge">Akció</div><?php endif;?>
                        
                      <?php if($t->cimkeTag(4)):?><div class="new-badge" >Új</div><?php endif;?>   
                        
                        <div class="img-container">
                            <img src="<?= ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" >
                        </div>
                        <div class="details">
                            <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                            <div class="price"><?= ws_arformatum($t->bruttoAr);?> Ft
								<?php if($t->eredetiBruttoAr>0):?><span class="old-price"><?= ws_arformatum($t->eredetiBruttoAr);?> Ft</span><?php endif; ?></div>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
                
              
                
                
            </ul>

        </div>
        <div class="product-list" id="pl2" style="display:none;">

            <ul class="products">
				<?php foreach($kiemelttermekek as $t):?>
                <li>
                    <a  href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" class="sale new">
                         <?php if($t->cimkeTag(1)):?><div class="sale-badge">Akció</div><?php endif;?>
                        
                      <?php if($t->cimkeTag(4)):?><div class="new-badge" >Új</div><?php endif;?>   
                        <div class="img-container">
                            <img src="<?= ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" >
                        </div>
                        <div class="details">
                            <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                            <div class="price"><?= ws_arformatum($t->bruttoAr);?> Ft
								<?php if($t->eredetiBruttoAr>0):?><span class="old-price"><?= ws_arformatum($t->eredetiBruttoAr);?> Ft</span><?php endif; ?></div>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
                
              
                
                
            </ul>

        </div>

