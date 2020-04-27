 	
 	<div class="categories">

            <div class="cat-title">Kategóriák</div>

            <div class="cat-content">
                <ul>
					
                    <li><a href="<?= base_url();?>termekek" title=""><span class="name">ÖSSZES TERMÉK</span></a></li>
                    
                    <?php if($lista)foreach($lista as $kat):?>

                        <li  style="padding-left: <?= ($kat->szint+1)*20;?>px" >

                            <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kat->slug; ?>" title="<?= $kat->nev;?>" class=""><span class="name"><?= $kat->nev;?></span> <span class="counter"><?= $kat->termekdb;?></span></a>

                        </li>

                        <?php endforeach; ?>
                    
                    
                </ul>
            </div>

        </div>
 	
 	
 	

