<!-- start: product-container -->
<div class="product-container">

    <!-- start: product -->
    <div class="product">

        <div class="product-inner">
			<?php $kepek = $termek->kepBetoltes();if($kepek): ?>
            <div class="img-container">
                <div class="main-img-slider">
					<?php
					foreach($kepek as $kep):
					?>
                    <div class="slide">
                        <img src="<?= base_url().ws_image($kep->file,'big');?>" alt="">
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="nav-slider">
                    <?php
					foreach($kepek as $kep):
					?>
                    <div class="slide">
                        <img src="<?= base_url().ws_image($kep->file,'smallboxed');?>" alt="">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="details">
                <h1><?= $termek->jellemzo('Név'); ?></h1>
                <div class="sr-num"><?= $termek->cikkszam; ?></div>
                
                <?php
					include('termeklap_kosar.php');
				?>
                
                
                
                <div class="description">
                    <h2><?= __f('Termék leírása:'); ?></h2>
                    
                    <?php if(trim($termek->jellemzo('Adattábla'))!=''):?>
					<ul>
						<?php foreach(explode("\n", $termek->jellemzo('Adattábla')) as $sor):?>
						<li>
							<?php $adatok = explode(':', $sor);?>
							<b><?= $adatok[0]?></b>: 
							<?= @$adatok[1]?>
						</li>
						<?php endforeach;?>
					</ul>
					<?php endif;?>
                    
                   
                    <p><?= $termek->jellemzo('Leirás');?></p>
                </div>
                <div class="additional-info">
                    <?= $termek->jellemzo('További információ');?>
                </div>
            </div>
        </div>

    </div>
    <!-- end: product -->

    <!-- start: offer-slider -->
    <div class="offer-slider">
        <div class="slider-heading">
            <div class="head">
                <h2>Ezek is érdekelhetnek</h2>
            </div>
        </div>
        <div class="slider">
            <?php $tl = new Termeklista_osztaly();$lista = $tl->termekAjanlo($termek->id);foreach($lista as $t):?>
               <div class="slide sale">
				 <div class="item">
                    <div class="sale-badge">Akció</div>
                    <div class="new-badge">Új</div>
                    <div class="img-container">
                        <a  href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" >
                            <img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
                        </a>
                    </div>
                    <div class="prod-name">
                        <a  href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" ><?= $t->jellemzo('Név');?></a>
                    </div>
                    <div class="prod-price">
                        <?= PN_ELO.' '.ws_arformatum($t->ar).' '.PN_UTO;?>
                    </div>
                </div>
				
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end: offer-slider -->

</div>
<!-- end: product-container -->
