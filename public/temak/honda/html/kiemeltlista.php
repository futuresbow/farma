<!-- start: offer-slider -->
<div class="offer-slider">
    <div class="slider-heading">
		
        <?php if($tipus==1) $leiras = array('cim' => 'Akciós termékek', 'link' => 'minden akciós termék megtekintése', 'url' => base_url().'akcios_termekek');?>
        <?php if($tipus==3) $leiras = array('cim' => 'Kiemelt termékek', 'link' => 'minden kiemelt termék megtekintése', 'url' => base_url().'termekek');?>
        <?php if($tipus==4) $leiras = array('cim' => 'Legújabb termékeink', 'link' => 'minden új termék megtekintése', 'url' => base_url().'uj_termekek');?>
        
        <div class="head">
            <h2><?= __f($leiras['cim']);?></h2>
        </div>
        <a href="<?= __f($leiras['url']);?>" title="<?= __f($leiras['cim']);?>"><?= __f($leiras['link']);?></a>
    </div>
    <div class="slider">
		<?php foreach($lista as $t):?>
        <div class="slide sale">
            <div class="item">
                 <?php $i = 0; foreach($t->cimkek as $cimke):?>
							<?php if($cimke->cimkeosztaly!='' and $t->cimkeTag($cimke->id)) : $c = $t->cimkeTag($cimke->id);?>
								<div class="<?= $cimke->cimkeosztaly. ' badge-pos'.$i;?>"><?= $c->felirat!=''?$c->felirat:$cimke->nev;?></div>
							
							<?php $i++;endif;?>
                     <?php endforeach;?>
                    
                <div class="img-container">
                    <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" >
						<img src="<?= ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>">
                    </a>
                </div>
                <div class="prod-name">
                    <a href="<?= $t->jellemzo('Név');?>" title=""><?= $t->jellemzo('Név');?></a>
                </div>				<?php $armod = (beallitasOlvasas('armod-termeklista')=='1')?'Bruttó':'Nettó';?>
                <div class="prod-price">					<?php if($t->eredeti_ar!=0):?>
					<span class="old-price"><?= PN_ELO.' '.ws_arformatum($t->eredetiAr($armod)).' '.PN_UTO;?></span>
					<?php endif;?>
					<?= PN_ELO.' '.ws_arformatum($t->alapAr($armod)).' '.PN_UTO;?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- end: offer-slider -->
