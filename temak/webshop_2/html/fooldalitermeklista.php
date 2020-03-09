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
                        <div class="sale-badge">Akció</div>
                        <div class="new-badge" style="display:none">Új</div>
                        <div class="img-container">
                            <img src="<?= ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" >
                        </div>
                        <div class="details">
                            <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                            <div class="price"><?= ws_arformatum($t->ar);?> Ft
								<?php if($t->eredeti_ar>0):?><span class="old-price"><?= ws_arformatum($t->eredeti_ar);?> Ft</span><?php endif; ?></div>
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
                        <div class="sale-badge" style="display:none">Akció</div>
                        <div class="new-badge" style="display:none">Új</div>
                        <div class="img-container">
                            <img src="<?= ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" >
                        </div>
                        <div class="details">
                            <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                            <div class="price"><?= ws_arformatum($t->ar);?> Ft
								<?php if($t->eredeti_ar>0):?><span class="old-price"><?= ws_arformatum($t->eredeti_ar);?> Ft</span><?php endif; ?></div>
                        </div>
                    </a>
                </li>
                <?php endforeach;?>
                
              
                
                
            </ul>

        </div>

