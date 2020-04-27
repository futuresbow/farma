			<div class="box-item fw">



                <div class="input-container">

                    <div class="label-container">

                        <label >Mezők a termékcsoportban:</label>

                    </div>

                    <div class="multiselector">
						<?php 
						
						foreach($mezoArr as $id => $mezo):
						?>
						<div onclick="jogkorszamolas(this)" data-jogkor="<?= $mezo->id;?>" class="<?= ($mezo->csatolva)==1?'selected':'';?>"><?= $mezo->nev ;?></div>
						<input name="b[<?= $mezo->id;?>]" value="<?= $mezo->csatolva;?>" type="hidden"/>
						<?php endforeach; ?>
						
                    </div>
					
                </div>



            </div>
<script>
function jogkorszamolas (o) {
	$(o).toggleClass('selected');
	if($(o).hasClass('selected')) {
		$(o).next().val(1);
	}
	else 
	{
		$(o).next().val(0);	
	}
	
}
</script>

