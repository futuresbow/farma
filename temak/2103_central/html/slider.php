<?php if ($lista):?>

<section class="row" id="tm-section-1">
            <div class="col-lg-12 tm-slider-col">
                <div class="tm-img-slider">
					 <?php foreach($lista as $sor):?>
						<div class="tm-img-slider-item" href="<?= base_url().$sor->kep; ?>">
							<p class="tm-slider-caption"><?= $sor->leiras; ?></p>
							<img src="<?= $sor->kep; ?>" alt="<?= $sor->leiras; ?>" class="tm-slider-img">
						</div>
						

					<?php endforeach;?>
                    
                </div>
            </div>
        </section>

<?php endif; ?>
