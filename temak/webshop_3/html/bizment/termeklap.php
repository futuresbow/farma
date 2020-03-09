<div class="homepage product-page">

    <div class="product sale">

        <div class="img-container">

            <div class="sale-badge">Akció</div>
            <div class="new-badge">Új</div>
			
            <div class="main-pic">
				<?php $kepek = $termek->kepBetoltes();if($kepek): ?>
                


					<?php

					foreach($kepek as $kep):

					?>

                    <div class="slide">

                        <img src="<?= base_url().ws_image($kep->file,'medium');?>" alt="">

                    </div>

                    <?php endforeach; ?>
                    
                    
               <?php endif;?>

            </div>

            <div class="thumbnails">
				<?php

					foreach($kepek as $kep):

					?>

                    <div class="slide">

                        <img src="<?= base_url().ws_image($kep->file,'smallboxed');?>" alt="">

                    </div>

               <?php endforeach; ?>
                
				<?php if( $termek->jellemzo('Youtube') ):?>
				<p><br></p>
				<iframe width="100%" height="255" src="https://www.youtube.com/embed/<?= $termek->jellemzo('Youtube'); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<?php endif; ?>
            </div>


        </div>

        <div class="details">
			
			<h1><?= $termek->jellemzo('Név'); ?> </h1>
            <div class="subtitle">
            <?= ($termek->jellemzo('Szín')!='')?' szín: '.$termek->jellemzo('Szín'):''; ?> 
			<?= ($termek->jellemzo('Méret')!='')?' Méret: '.$termek->jellemzo('Méret'):''; ?> 
            </div>
            <div class="barcode">Cikkszám: <?= $termek->cikkszam; ?></div>
			
			<?php

			include('termeklap_kosar.php');

			?>

           

           <h2>Termék leírása</h2>
			<?= $termek->jellemzo('Leírás');?>
        </div>

    </div>


    <div class="similar-products">
        <div class="products-heading">
            <h2>Ezek is érdekelhetnek</h2>
        </div>

        <div class="product-list">

            <ul class="products">
				 <?php $tl = new Termeklista_osztaly();$lista = $tl->termekAjanlo($termek->id);foreach($lista as $t):?>
				
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
										<div class="price"><?php if($t->eredeti_ar != 0): ?><span class="old-price"><?= PN_ELO.' '.ws_arformatum($t->eredeti_ar).' '.PN_UTO;?></span><?php endif;?><?= PN_ELO.' '.ws_arformatum($t->ar).' '.PN_UTO;?></div>
									</div>
									<div class="add-to-cart">
										<a data-termekid="<?= $t->id; ?>" href="javascript:void(0);" title="Megrendelés" class="btn kosar_elkuldes">Kosárba</a>
									</div>
								</div>
								
							</li>
				
                
				<?php endforeach; ?>
               

            </ul>

        </div>
    </div>


</div>


