	
		<form id="termlistaform">
        <div class="product-list" >
			<div class="products-heading">
                <h1>Akciós termékek</h1>
                <a href="<?= base_url();?>termekek" title="" class="see-all-link">Összes termék</a>
            </div>
            
            <ul class="products">
				<?php foreach($akciostermekek as $t):?>
                <li>
					<div href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="product-container ">
						<div class="badges" style="display:none">
							<div class="sale-badge">-30%</div>
							<div class="new-badge">Új</div>
						</div>
						<a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="img-container">
							<img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
						</a>
						<div class="details">
							<a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="prod-name"><?= $t->jellemzo('Név');?></a>
							<div class="price"><?php if($t->eredetiBruttoAr != 0): ?><span class="old-price"><?= PN_ELO.' '.ws_arformatum($t->eredetiBruttoAr).' '.PN_UTO;?></span><?php endif;?><?= PN_ELO.' '.ws_arformatum($t->bruttoAr).' '.PN_UTO;?></div>
						</div>
						<div class="add-to-cart">
							<a data-termekid="<?= $t->id; ?>" href="javascript:void(0);" title="Megrendelés" class="btn kosar_elkuldes">Kosárba</a>
						</div>
					</div>
					
				</li>

                <?php endforeach;?>
                
              
                
                
            </ul>

        </div>
        <div class="product-list" >
			<div class="products-heading">
                <h1>Akciós termékek</h1>
                <a href="<?= base_url();?>termekek" title="" class="see-all-link">Összes termék</a>
            </div>
            
            <ul class="products">
				<?php foreach($kiemelttermekek as $t):?>
                <li>
					<div href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="product-container ">
						<div class="badges" style="display:none">
							<div class="sale-badge">-30%</div>
							<div class="new-badge">Új</div>
						</div>
						<a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="img-container">
							<img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
						</a>
						<div class="details">
							<a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="prod-name"><?= $t->jellemzo('Név');?></a>
							<div class="price"><?php if($t->eredetiBruttoAr != 0): ?><span class="old-price"><?= PN_ELO.' '.ws_arformatum($t->eredetiBruttoAr).' '.PN_UTO;?></span><?php endif;?><?= PN_ELO.' '.ws_arformatum($t->bruttoAr).' '.PN_UTO;?></div>
						</div>
						<div class="add-to-cart">
							<a data-termekid="<?= $t->id; ?>" href="javascript:void(0);" title="Megrendelés" class="btn kosar_elkuldes">Kosárba</a>
						</div>
					</div>
					
				</li>

                <?php endforeach;?>
                
              
                
                
            </ul>

        </div>
		</form>
		<script>$().ready(function() { siteJs.kosarElokeszites ();})</script>
