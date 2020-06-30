<!-- start: product-container -->

<div class="product-container">



    <!-- start: product -->

    <div class="product">



        <div class="product-inner">

			<?php $kepek = $termek->kepBetoltes();if($kepek): ?>

            <div class="img-container product-img-container">
				
				
				<?php $i = 0; foreach($termek->cimkek as $cimke):?>
					<?php if($cimke->cimkeosztaly!='' and $termek->cimkeTag($cimke->id)) : $c = $termek->cimkeTag($cimke->id);?>
						<div class="prod<?= $cimke->cimkeosztaly. ' prodbadge-pos'.$i;?> "><?= $c->felirat!=''?$c->felirat:$cimke->nev;?></div>
						
					<?php $i++; endif;?>
                <?php endforeach;?>
				

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
				<?php if( $termek->jellemzo('Youtube') ):?>
					<p><br></p>
					<iframe width="100%" height="255" src="https://www.youtube.com/embed/<?= $termek->jellemzo('Youtube'); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php endif; ?>
            
            </div>

            <?php endif; ?>

            <div class="details">

                
    			
				
	            
                <div class="termeklap_kosar_div">
				<?php include('termeklap_kosar.php'); ?>
				</div>

                
				
                

                <div class="description">
					<div class="sr-num">Cikkszám: <?= $termek->cikkszam; ?></div>
                    <?php foreach($termek->jellemzok as $jellemzo): ?>
                    <?php if($jellemzo->nev=="HTML"):?>
                    <?= $termek->jellemzo($jellemzo->nev); ?>
                    <?php continue; endif;?>
                    <?php if(trim(strip_tags($termek->jellemzo($jellemzo->nev)))=='') continue; ?>
					<?php $felirat = $termek->jellemzoFeliratTermelap($jellemzo->nev); ?>
						<h4><?= $felirat;?></h4>
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

