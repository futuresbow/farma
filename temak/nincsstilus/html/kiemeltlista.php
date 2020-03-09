
        <?php if($tipus==1) $leiras = array('cim' => 'Akciós termékek', 'link' => 'minden akciós termék megtekintése', 'url' => base_url().'akcios_termekek');?>
        <?php if($tipus==3) $leiras = array('cim' => 'Kiemelt termékek', 'link' => 'minden kiemelt termék megtekintése', 'url' => base_url().'termekek');?>
        <?php if($tipus==4) $leiras = array('cim' => 'Legújabb termékeink', 'link' => 'minden új termék megtekintése', 'url' => base_url().'uj_termekek');?>
        

            <h2><?= __f($leiras['cim']);?></h2>

        <a href="<?= __f($leiras['url']);?>" title="<?= __f($leiras['cim']);?>"><?= __f($leiras['link']);?></a>
<br>
   	<?php foreach($lista as $t):?>
   
            <div class="item">
                <div class="sale-badge">Akció</div>
                <div class="new-badge">Új</div>
                <div class="img-container">
                    <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" >
						<img src="<?= ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>">
                    </a>
                </div>
                <div class="prod-name">
                    <a href="<?= $t->jellemzo('Név');?>" title=""><?= $t->jellemzo('Név');?></a>
                </div>
                <div class="prod-price">
                    <?= ws_arformatum($t->ar);?> Ft
                </div>
            </div>
        <?php endforeach; ?>