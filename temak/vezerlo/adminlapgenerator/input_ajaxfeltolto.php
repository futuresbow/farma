			<?php $r = rand(1, 999999);?>

			<label for="upload_<?= $r; ?>"  class="btn" ><span><?= 'Feltöltés'; ?></span></label>
			<input type="file" name="ajaxfile" class="ajaxfile" id="upload_<?= $r; ?>" onchange="aJs.ajaxKepFeltoltes( 'upload_<?= $r; ?>', '<?= $url; ?>', this);" <?= @$attr;?> style="display:none">

			
		
