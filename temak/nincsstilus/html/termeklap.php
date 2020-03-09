
            <div class="main-pic">
				<?php $kepek = $termek->kepBetoltes();if($kepek): ?>
                


					<?php

					foreach($kepek as $kep):

					?>

                    <div class="slide">

                        <img data-full="<?= base_url().ws_image($kep->file,'big');?>" src="<?= base_url().ws_image($kep->file,'medium');?>" alt="">

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
                

            </div>
			
			
			<?php if( $termek->jellemzo('Youtube') ):?>
			<p><br></p>
			<iframe width="100%" height="255" src="https://www.youtube.com/embed/<?= $termek->jellemzo('Youtube'); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php endif; ?>
            

      
			
			
			<h1><?= $termek->jellemzo('Név'); ?> 
			
			
			</h1>
            
            <?= ($termek->jellemzo('Szín')!='')?' szín: '.$termek->jellemzo('Szín'):''; ?> 
			<?= ($termek->jellemzo('Méret')!='')?' Méret: '.$termek->jellemzo('Méret'):''; ?> 
            
            <div >Cikkszám: <?= $termek->cikkszam; ?></div>
			
			<?php

			include('termeklap_kosar.php');

			?>

           

            <h2>Termék leírása</h2>
            
            <?= $termek->jellemzo('Leírás');?>
       

    
            <h2>Ezek is érdekelhetnek</h2>
        
        
            <ul class="products">
				 <?php $tl = new Termeklista_osztaly();$lista = $tl->termekAjanlo($termek->id);foreach($lista as $t):?>
				
					<li>
                        <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="">
                            <div class="new-badge">Új</div>
                            <div class="img-container">
                                <img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
								
                            </div>
                            <div class="details">
                                <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                                <div class="price"><?php if($t->eredeti_ar != 0): ?><span class="old-price"><?= PN_ELO.' '.ws_arformatum($t->eredeti_ar).' '.PN_UTO;?></span><?php endif;?><?= PN_ELO.' '.ws_arformatum($t->ar).' '.PN_UTO;?></div>
                            </div>
                        </a>
                    </li>
				
				
				
                
				<?php endforeach; ?>
               

            </ul>


<style>
	
.slick-prev, .slick-next {
	display:none!important;
}

</style>
