<!-- start: prod list -->
<div class="product-list clearfix">
    <?= widget('kategoria/kategoria/szurowidget_termeklista');?>
    
    <div class="prod-container">
		
		
		
		<?php if($kategoriak): ?>
		<div class="heading">
            <h3>Alkategóriák</h3>
        </div>
		
		<ul class="products clearfix">
		<?php if(!empty($kategoriak))foreach($kategoriak as  $kategoria):?>
		
			<li class="new">
                <div class="item">
					<div class="img-container">
                        <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kategoria->slug ;?>" title="<?= $kategoria->nev;?>" >
                            
                            <?php if($kategoria->kep!=''):?>
							<img src="<?= base_url().ws_image($kategoria->kep, 'mediumboxed')?>" alt="<?= $kategoria->nev;?>">
							<?php else: ?>
							<img src="<?= base_url();?>templates/honda/pics/category-pic-110x110.jpg" alt="<?= $kategoria->nev;?>">
							<?php endif; ?>
                            
                            
                        </a>
                    </div>
                    
                    <div class="new-badge">Kategória</div>
                    
                    <div class="prod-name">
                        <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kategoria->slug ;?>" title="<?= $kategoria->nev; ?>"><?= $kategoria->nev; ?></a>
                    </div>
                    
                </div>
            </li>
		<?php endforeach;?>
		</ul>
		<?php endif;?>
		
		
		
		
        <div class="heading">
            <h1><?= (isset($listacim))?$listacim:'Termékek'; ?></h1>
            <div class="styled-select">
                <select>
                    <option>Rendezés</option>
                </select>
            </div>
        </div>
		
		
		<?php if($termekek): ?>
        
        <ul class="products clearfix">
			<?php foreach($termekek as $t):?>
            <li class="">
                <div class="item">
                    <div class="sale-badge">Akció</div>
                    <div class="new-badge">Új</div>
                    <div class="img-container">
                        <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" >
                            <img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
                        </a>
                    </div>
                    <div class="prod-name">
                        <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"><?= $t->jellemzo('Név');?></a>
                    </div>
                    <div class="prod-price">
                        <?= PN_ELO.' '.ws_arformatum($t->ar).' '.PN_UTO;?>
                    </div>
                </div>
            </li>

           <?php endforeach; ?>
        </ul>
		<?php endif; ?>
        
        
        
        <div class="pagination" style="display:none">
            <div class="styled-select">
                <select>
                    <option>100 / oldal</option>
                </select>
            </div>
            <ul>
                <li><a href="" title="" class="prev"></a></li>
                <li><a href="" title="" class="active">1</a></li>
                <li><a href="" title="">2</a></li>
                <li><a href="" title="">3</a></li>
                <li>...</li>
                <li><a href="" title="">99</a></li>
                <li><a href="" title="" class="next"></a></li>
            </ul>
        </div>
		
    </div>
</div>
<!-- end: prod list -->
