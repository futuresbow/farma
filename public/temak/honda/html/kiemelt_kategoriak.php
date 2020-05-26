<!-- kategóriák -->
<?php if(!empty($kategoriak)): ?>
			
			<div class="offer-slider">

				<div class="slider-heading">

					<div class="head">

						<h2>Kiemelt kategóriák</h2>

					</div>

				</div>
			</div>
		<div class="product-list clearfix">
		<div class="prod-container fooldalikategoriak">
			<ul class="products clearfix">

		<?php foreach($kategoriak as  $kategoria):?>

		

			<li class="new">

                <div class="item">

					<div class="img-container">

                        <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kategoria->slug ;?>" title="<?= $kategoria->nev;?>" >

                            

                            <?php if($kategoria->kep!=''):?>

							<img src="<?= base_url().ws_image($kategoria->kep, 'mediumboxed')?>" alt="<?= $kategoria->nev;?>">

							<?php else: ?>

							<img src="<?= base_url().TEMAMAPPA;?>/honda/pics/category-pic-110x110.jpg" alt="<?= $kategoria->nev;?>">

							<?php endif; ?>

                            

                            

                        </a>

                    </div>

                    

                    <div class="new-badge">Kategória</div>

                    

                    <div class="prod-name">

                        <a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kategoria->slug ;?>" title="<?= $kategoria->nev; ?>"><?= $kategoria->nev; ?></a>

                    </div>

                    

                </div>

            </li>

		<?php endforeach;?>

		</ul>
		</div>
		</div>
		<?php endif;?>
