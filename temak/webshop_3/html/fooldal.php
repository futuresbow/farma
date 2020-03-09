<?php include FCPATH.TEMAMAPPA.'/webshop_3/tema_valtozok.php'; ?>

<div class="homepage">

    <!-- start: ups + slider -->
    <div class="ups-slider clearfix">

        <div class="ups">
            <div class="item">
                <img src="<?= base_url().TEMAMAPPA;?>/webshop_3/pics/ups-280x100-1-<?= $stilus_css; ?>.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?= base_url().TEMAMAPPA;?>/webshop_3/pics/ups-280x100-2-<?= $stilus_css; ?>.jpg" alt="">
            </div>
            <div class="item">
                <img src="<?= base_url().TEMAMAPPA;?>/webshop_3/pics/ups-280x100-3-<?= $stilus_css; ?>.jpg" alt="">
            </div>
        </div>
        
		<div class="main-slider-container">
        <?= widget('slider/slidermegjelenites/index', array('slider_id' => 1));?>
		</div>

    </div>
    <!-- end: ups + slider -->

    
	<?= widget('termek/termeklista/fooldalitermekek', $param);?>

</div>

	
	
