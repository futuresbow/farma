
            <h2>Termékkategóriák</h2>
            <ul>
				<?php $kategoriak = $kategoria->kategoriaLista(); if($kategoriak) foreach($kategoriak as $sor):?>
                <li>
                    <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$sor->slug;?>" title="<?= $sor->nev; ?>">
                        <div class="txt">
                            <div class="inner"><?= $sor->nev; ?></div>
                        </div>
                        <?php if($sor->kep!=''):?>
                        <img src="<?= base_url().ws_image($sor->kep, 'smallboxed')?>" alt="">
						<?php else: ?>
                        <img src="<?= base_url().TEMAMAPPA;?>/honda/pics/category-pic-110x110.jpg" alt="">
						<?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <h2>Hírek &amp; újdonságok</h2>
            <?php $lista = $postok->listaKategoriaNevSzerint('Hírek'); if($lista): ?>
                    
                <ul>
					<?php foreach($lista as $post): ?>
                    <li>
                        <div class="img-container">
                            <a href="<?= $post->link; ?>" title="">
                                <img src="<?= base_url().ws_image($post->fokep, 'medium')?>" alt="">
                            </a>
                        </div>
                        <div class="details">
                            <a href="<?= $post->link; ?>xxx" title=""><h3><?= $post->cim;?></h3></a>
                            <div class="date"><?= date('Y. m. d.',strtotime( $post->datum));?></div>
                            <p class="lead">
                                <?= $post->bevezeto;?>
                            </p>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
                
                    <a href="<?= base_url()?>hirek" title="Hírek">További hírek</a>
                
        
			<?php endif;?>