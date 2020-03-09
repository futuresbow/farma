<div class="content-container <?= $szelessegOsztaly;?>">
	
    <div class="heading">
        <div class="top">
            <h1><?= $lapCim;?></h1>
            <?php if(isset($fejlecGomb)):?>
				<a href="<?= $fejlecGomb['url'];?>" title="<?= $fejlecGomb['felirat'];?>" class="btn btn-ok"><?= $fejlecGomb['felirat'];?></a>
            <?php endif;?>
        </div>
    </div>

   
 
