<?php if ($lista):?>


		<div class="main-slider">
            <?php foreach($lista as $sor):?>

			<div class="slide">

				<a href="" title="">

					<img src="<?= base_url().$sor->kep; ?>" alt="">

				</a>

			</div>

        <?php endforeach;?>

        </div>


<?php endif; ?>
