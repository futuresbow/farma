			<div class="box-item fw">



                <div class="input-container">

                    <div class="label-container">

                        <label >Elérhető fizetési módok: <small>Kattints a névre a hozzárendeléshez. A checkbox az aktivitást jelöli, ha nincs bepipálva, akkor nem jelenik meg a fizetési opció a kosárnál.</small></label>

                    </div>

                    <div class="multiselector">
						<?php 
						
						foreach($fizmodArr as $id => $mezo):
						?>
                        <div onclick="kijeloles(this)" data-jogkor="<?= $mezo->id;?>" class="<?= ($mezo->csatolva)==1?'selected':'';?>"><?= $mezo->nev ;?> <input type="checkbox" value="1" name="cb[<?= $mezo->id;?>]" <?= $mezo->xstatusz?'checked':''; ?> /></div>
						<input name="b[<?= $mezo->id;?>]" value="<?= $mezo->csatolva;?>" type="hidden"/>
						<?php endforeach; ?>
						
                    </div>
					
                </div>



            </div>
<script>
function kijeloles (o) {
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

