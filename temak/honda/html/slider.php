<?php if ($lista):?>
<!-- start: main-banner -->
<div class="main-banner">
    <div class="slider">
		<?php foreach($lista as $sor):?>
        <div class="slide">
            <a href="" title="">
                <img src="<?= base_url().$sor->kep; ?>" alt="">
            </a>
        </div>
        <?php endforeach;?>
        
    </div>
</div>
<!-- end: main-banner -->
<?php endif; ?>
