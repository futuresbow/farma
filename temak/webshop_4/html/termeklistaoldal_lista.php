
		<?php $ci = getCI();?>
        

        <div class="product-list">
			<?php if($termekek): ?>

        
			<ul class="products">

			<?php foreach($termekek as $t):?>
            
                <li>
					
                   
                    <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" class="sale ">
                         <?php if($t->cimkeTag(4)):?><div class="new-badge" style="display:block;">Új</div><?php endif;?>
                        
                        <div class="img-container">
                            <img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
                        </div>
                        <div class="details">
                            <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                            <div class="price"> <?= PN_ELO.' '.ws_arformatum($t->bruttoAr).' '.PN_UTO;?>
                            <?php if($t->eredetiBruttoAr != 0): ?><span class="old-price"> <?= PN_ELO.' '.ws_arformatum($t->eredetiBruttoAr).' '.PN_UTO;?></span><?php endif;?></div>
                        </div>
                    </a>
                </li>

            <?php endforeach;?>   


            </ul>
            
            <?php else:?>
            <h3>Nem található termék, folytasd az <a href="<?= base_url();?>termekek">Összes terméknél</a>.</h3>
            <?php endif;?>

        </div>
		<?php if(isset($termekdb)): ?>
        <div class="pagination">
            <div class="styled-select">
                <select  value="0"  name="dbszam" onchange="$('#termlistaform').submit();">
                    <option value="12" <?= ((int)$ci->session->userdata('termek_listalimit')==12 )?' selected ':''; ?> >12 / oldal</option>
                    <option value="24"  <?= ((int)$ci->session->userdata('termek_listalimit')==24 )?' selected ':''; ?> >24 / oldalt</option>
                    <option value="48"  <?= ((int)$ci->session->userdata('termek_listalimit')==48 )?' selected ':''; ?> >48 / oldalt</option>
                </select>
            </div>
            <?php if($termekdb>(int)$ci->session->userdata('termek_listalimit')):?>
            <ul>
				<?php $lap = 0; for($i = 0; $i < $termekdb;$i += $limit):$lap++;?>
                <li><a href="?start=<?= $i; ?>" title="" class="<?= ($start == $i)?' active ':'';?>"><?= $lap; ?></a></li>
                <?php endfor; ?>
            </ul>
            <?php endif; ?>
        </div>
        <?php endif; ?>





