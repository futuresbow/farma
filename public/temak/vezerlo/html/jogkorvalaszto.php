			<div class="box-item fw">



                <div class="input-container <?= (isset($urlapHiba[$input1->data['mezonev']]))?' error ':'';?>">

                    <div class="label-container">

                        <label >Kik láthatják a menüpontot</label>

                    </div>

                    <div class="multiselector">
						<?php 
						
						foreach($jogValaszto as $ertek => $nev):
						?>
						<div onclick="jogkorszamolas(this)" data-jogkor="<?= $ertek;?>" class="<?= (@$sor->jogkor & $ertek)>0?'selected':'';?>"><?= $nev ;?></div>
						<?php endforeach; ?>
						
                    </div>
					<input type="hidden" id="jogkorInp" name="a[jogkor]" value="<?= @$sor->jogkor?>" />
                </div>



            </div>
<script>
function jogkorszamolas (o) {
	$(o).toggleClass('selected');
	
	divs = $('.multiselector div');
	ossz = 0;
	for(i = 0; i < divs.length;i++) {
		if($(divs[i]).hasClass("selected") ) {
			
			ossz += parseInt($(divs[i]).attr('data-jogkor'));
		}
	}
	$('#jogkorInp').val(ossz);
}
</script>

