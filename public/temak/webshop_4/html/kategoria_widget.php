		<div class="categories">

            <div class="cat-title">Kategóriák</div>

            <div class="cat-content">
				<ul>

						<?php if($lista)foreach($lista as $kat):?>

                        <li  style="padding-left: <?= ($kat->szint)*20;?>px" >

                            <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kat->slug; ?>" title="<?= $kat->nev;?>" class=""><?= $kat->nev;?> <span><?= $kat->termekdb;?></span></a>

                        </li>

                        <?php endforeach; ?>

                        

                </ul>
                
            </div>

        </div>
