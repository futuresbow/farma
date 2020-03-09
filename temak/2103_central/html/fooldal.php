	<?= widget('slider/slidermegjelenites/index', array('slider_id' => 1) );?>
	<section class="tm-section-2 tm-section-mb" id="tm-section-2">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 mb-lg-0 mb-md-5 mb-5 pr-md-5">
                    
					<?= widget('kategoria/kategoria/szurowidget_termeklista');?>
                </div>
                
                <div class="col-xl-8 col-lg-8 col-md-12">
                   <?= widget('termek/termeklista');?>
                </div>
            </div>
        </section>
