	<div class="homepage">
	
		<div class="left-side">
			<?= widget('termek/termeklista/fooldaliszurowidget');?>
			
			<div class="banner">
            <a href="" title="">
                <img src="<?= base_url().TEMAMAPPA.'/'.FRONTENDTEMA; ?>pics/banner-260x320.jpg" alt="">
            </a>
			</div>
			
			<div class="banner">
            <a href="" title="">
                <img src="<?= base_url().TEMAMAPPA.'/'.FRONTENDTEMA; ?>pics/banner-260x160.jpg" alt="">
            </a>
			</div>
			
		</div>
		
		<div class="right-side">
			<?= widget('slider/slidermegjelenites/index', array('slider_id' => 1));?>
			<?= widget('termek/termeklista/fooldalitermekek');?>
			
		</div>
	
	</div>
