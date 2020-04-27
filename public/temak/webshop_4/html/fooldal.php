<?php include FCPATH.TEMAMAPPA.'/webshop_4/tema_valtozok.php';?>
<div class="homepage">

    <div class="main-banner">
        <div class="wrap">

            <div class="head-container">
                <h1><?= $fooldalcim;?></h1>
            </div>

            <div class="content-container">

                <div class="text-container">
                    <p><strong><?= $fooldalbevezeto;?></strong></p>
                    <p><?= $fooldalleiras?></p>
                    <a href="<?= base_url().beallitasOlvasas('kosar.oldal.url');?>" title="Termékek" class="btn">Termékek</a>

                </div>

                <div class="img-container">
                    <img src="<?= base_url().TEMAMAPPA;?>/webshop_4/pics/main-banner-pic-500x245.png" alt="">
                </div>
            </div>

        </div>
    </div>

    <!--start: wrapper -->
    <div class="wrap">

        <!-- start: usp -->
        <div class="usp">
            <div class="inner">

                <div class="item usp-1">
                    <div class="title"><?= $ups1_cim; ?></div>
                    <div class="subtitle"><?= $ups1_szoveg;?></div>
                </div>
                <div class="item usp-2">
                    <div class="title"><?= $ups2_cim; ?></div>
                    <div class="subtitle"><?= $ups2_szoveg;?></div>
                </div>
                <div class="item usp-3">
                    <div class="title"><?= $ups3_cim; ?></div>
                    <div class="subtitle"><?= $ups3_szoveg;?></div>
                </div>
                <div class="item usp-4">
                    <div class="title"><?= $ups4_cim; ?></div>
                    <div class="subtitle"><?= $ups4_szoveg;?></div>
                </div>

            </div>
        </div>
        <!-- end: usp -->
		<?php $param['termekdarab'] = 6; ?>
		<?= widget('termek/termeklista/fooldalitermekek', $param);?>

	</div>
</div>

	
	
