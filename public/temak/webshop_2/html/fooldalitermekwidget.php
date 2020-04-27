	<!-- start: home-categories -->
    <div class="home-categories">
		<?php foreach($kategoriak as $kategoria):?>
        <div class="box">
            <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kategoria->slug ;?>" title="<?= $kategoria->nev;?>">
                <?php if($kategoria->kep!=''):?>

				<img src="<?= base_url().ws_image($kategoria->kep, 'mediumboxed')?>" alt="<?= $kategoria->nev;?>">
				<?php else: ?>
				<img src="<?= base_url().TEMAMAPPA;?>/honda/pics/category-pic-110x110.jpg" alt="<?= $kategoria->nev;?>">
				<?php endif; ?>

                <div class="details">
                    <div class="cat-name"><?= $kategoria->nev;?></div>
                    <div class="counter" style="display:none; ">234 termék</div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>

       
    </div>
    <!-- end: home-categories -->
