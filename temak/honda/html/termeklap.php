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
                </div>				<?php if( $termek->jellemzo('Youtube') ):?>
					<p><br></p>
					<iframe width="100%" height="255" src="https://www.youtube.com/embed/<?= $termek->jellemzo('Youtube'); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php endif; ?>
            
            </div>
            <?php endif; ?>
            <div class="details">
                
    			
				
	            
                
                <?php
					include('termeklap_kosar.php');
				?>
                				
                
                <div class="description">					<div class="sr-num">Cikkszám: <?= $termek->cikkszam; ?></div>
                    <?php foreach($termek->jellemzok as $jellemzo): if(trim(strip_tags($termek->jellemzo($jellemzo->nev)))=='') continue; ?>
				
						<h4><?= $jellemzo->nev;?></h4>
						<?= nl2br(strip_tags($termek->jellemzo($jellemzo->nev))); ?><br><br>
					
					<?php endforeach;?>
					
					

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
