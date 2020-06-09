	<div class="buttons">
        <div class="default-btn">
            <?php foreach($gombok as $gomb):?>
            
            <?php if($gomb['link']!=''):?>
            <a href="<?= @$gomb['link'];?>" title="" <?= @($gomb['onclick'])?' onclick="'.$gomb['onclick'].'" ':'';?>  <?= @$gomb['attr'];?> class="btn <?= @$gomb['osztaly']; ?>"><?= @$gomb['felirat'];?></a>
            <?php else: ?>
            <button <?= @($gomb['onclick'])?' onclick="'.$gomb['onclick'].'" ':'';?> type="<?= @$gomb['tipus'];?>"  <?= @$gomb['attr'];?> class="btn <?= @$gomb['osztaly']; ?>"><?= @$gomb['felirat'];?></button>
			<?php endif; ?>
			<?php endforeach; ?>
        </div>
    </div>
