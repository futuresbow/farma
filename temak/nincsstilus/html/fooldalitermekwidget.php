<?php foreach($kategoriak as $kategoria):?>
            <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kategoria->slug ;?>" title="<?= $kategoria->nev;?>">
                <?php if($kategoria->kep!=''):?>

				<img src="<?= base_url().ws_image($kategoria->kep, 'mediumboxed')?>" alt="<?= $kategoria->nev;?>">
				<?php else: ?>
				<img src="<?= base_url().TEMAMAPPA0;?>/honda/pics/category-pic-110x110.jpg" alt="<?= $kategoria->nev;?>">
				<?php endif; ?>

                <p><?= $kategoria->nev;?></div>
                   
                   
            </a>
        <?php endforeach; ?>
