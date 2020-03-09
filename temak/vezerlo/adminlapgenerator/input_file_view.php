<?php $r = rand(1, 999999);if(!isset($gombfelirat)) $gombfelirat = @$felirat;?>
<label for="upload_<?= $r; ?>"  class="btn" ><span><?= ($gombfelirat!='')?$gombfelirat:'Feltöltés'; ?></span></label>
<input type="file" id="upload_<?= $r; ?>" name="<?= $name; ?>" <?= @$attr;?>  style="display:none">
