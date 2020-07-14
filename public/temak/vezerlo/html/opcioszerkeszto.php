<div class="box-item">



	<h3>Új méret létrehozása:</h3>

</div>

<input name="opc[0][id]" type="hidden" value="0" >

<div class="box-item double">

				<div class="input-container">

					<div class="label-container">

						<label >Változatcsoport betölése</label>

						

					</div>

					<div class="input-select-container">

						<div class="styled-select">

							<select name="termekOpcioHozzadas2" onchange="aJs.opcioBetoltes2(<?= $tid; ?>, $(this).val());">

							<option value="0">Válassz</option>

							<?php foreach($amlista as $sor):?>

							<option value="<?= $sor->id; ?>"><?= $sor->nev; ?></option>

							<?php endforeach;?>

							</select>

						</div>

					</div>

				</div>
				
				
				
				
				<div class="input-container">

					<div class="label-container">

						<label >Méretek/változatok másolása</label>

						

					</div>

					<div class="input-select-container">

						<div class="styled-select">

							<select name="termekOpcioHozzadas" onchange="aJs.opcioBetoltes(<?= $tid; ?>, $(this).val());">

							<option value="0">Válasszd ki a terméket, aminek a méreteit ide szeretnéd másolni</option>

							<?php foreach($termeklista as $sor):?>

							<option value="<?= $sor->id; ?>"><?= $sor->nev; ?></option>

							<?php endforeach;?>

							</select>

						</div>

					</div>

				</div>

</div>

<div class="box-item double">
	
	<p style="text-align:center;width:100%;">vagy adj meg új méretet:</p>
	
</div>	
<div class="box-item double">

				

				

				

				

                <div class="input-container">

                    <div class="label-container">

                        <label >Méret/változat megnevezése</label>

                        

                    </div>

                    <div class="input-select-container">

						<input type="text" name="opc[0][nev]" value="" class="form-control" >

                    </div>

                </div>

                



				

                <div class="input-container">

                    <div class="label-container">

                        <label >Megjelenés sorrendje</label>

                        

                    </div>

                    <div class="input-select-container">

						<input type="text" name="opc[0][sorrend]" value="" class="form-control" >

                    </div>

                </div>

                

</div>

<div class="box-item double">

				

                <div class="input-container">

                    <div class="label-container">

                        <label >Cikkszám (felülírja a termék cikkszámot, lehet üres)</label>

                        

                    </div>

                    <div class="input-select-container">

						<input type="text" name="opc[0][cikkszam]" value="" class="form-control" >

                    </div>

                </div>

                



				

                <div class="input-container" style="xvisibility:hidden">

                    <div class="label-container">

                        <label >Ár (ha nulla, akkor nem változik a termékár)</label>

                        

                    </div>

                    <div class="input-select-container">

						<input type="text" name="opc[0][ar]" value="" class="form-control" >

                    </div>

                </div>

                

</div>

            
<input type="hidden" name="opc[0][tipus]" value="0" >
<div class="box-item ">

				
				

                <div class="input-container" style="display:none;">

                    <div class="label-container">

                        <label >Típus</label>

                        

                    </div>

                    <div class="input-select-container">

						<div class="styled-select" >
							<select name="opc[0][tipus]"  class="form-control" >

								<option value="0">Termék változat </option>
                                <?php /* 
								<option value="2">Termék változat 2 (felülírja az alapárat)</option>
								opció még nem lesz
								<option value="1" style="">Opció (hozzáadódik az alapárhoz)</option>
								*/ ?>
							</select>

						</div>

                    </div>

                </div>

               



                <div class="input-container" style="display:none;">

                    <div class="label-container">

                        <label >Nyelv</label>

                        

                    </div>

                    <div class="input-select-container">

						<div class="styled-select">

							<select name="opc[0][nyelv]"  class="form-control" >

								<?php $nyelvNev = array('hu' => 'Magyar', 'en' => 'Angol');$nyelvek =  beallitasOlvasas('nyelvek'); foreach(explode(',',$nyelvek) as $nyelv):?>

								<option value="<?= $nyelv; ?>"><?= $nyelvNev[$nyelv]; ?></option>

								<?php endforeach; ?>

							</select>

						</div>

                    </div>

                </div>

                

</div>

            

 



<button type="button" class="btn btn-info" onclick="aJs.opcioHozzaadas(<?= $tid; ?>, 1)">Új méret/változat rögzítése</button><br><br>

<div class="box-item">



	<h3>Termék méretek:</h3>

</div>

<?php if(!empty($opc)):?>

 <div class="adminOpciosTabla">



	<?php $i = 0;foreach($opc as $opcSor):$i++; ?>
		
	<div>	
		
		<input name="opc[<?= $i; ?>][tipus]"  value="<?= $opcSor->tipus; ?>" type="hidden"/>
		<?php /*
		<select name="opc[<?= $i; ?>][tipus]"  class="" >

            <option value="0" <?= ($opcSor->tipus==0)?'selected':''; ?> >Termék változat (felülírja az alapárat)</option>

            <option value="2" <?= ($opcSor->tipus==2)?'selected':''; ?> >Termék változat 2 (felülírja az alapárat)</option>
            <?php /*
            <option value="1" <?= ($opcSor->tipus==1)?'selected':''; ?> >Opció (hozzáadódik az alapárhoz)</option>
            
        </select>
        */ ?>
	
	<table class="">

	<tr>

	<td><input name="opc[<?= $i; ?>][id]" value="<?= $opcSor->id; ?>" type="hidden" ><b >Megnevezés:</b><br><input class="ov_nev" name="opc[<?= $i; ?>][nev]" value="<?= $opcSor->nev; ?>" class="" ></td>

	<td><b >Sorrend:</b><br><input name="opc[<?= $i; ?>][sorrend]" value="<?= $opcSor->sorrend; ?>" class="" ></td>

	

	</tr><tr>
    <td><b >Cikkszám (felülírja ha nem üres):</b><br><input  name="opc[<?= $i; ?>][cikkszam]" value="<?= @$opcSor->cikkszam; ?>" class="" ></td>
	<td style="xvisibility:hidden"><b >Ár:</b><br><input name="opc[<?= $i; ?>][ar]" value="<?= $opcSor->ar; ?>" class="" ></td>

	
	

	</tr><tr>
    <td><b >Nyelv:</b><br><select name="opc[<?= $i; ?>][nyelv]"  class="" >

		<?php foreach(explode(',',$nyelvek) as $nyelv):?>

		<option <?= ($opcSor->nyelv==$nyelv)?'selected':''; ?> value="<?= $nyelv; ?>"><?= $nyelv; ?></option>

		<?php endforeach; ?>

	</select>

	

	</td>
	<td> <button type="button" class="btn btn-alert btn-small" onclick="$(this).parent().parent().parent().parent().parent().fadeOut().find('.ov_nev').val('');">Méret törlése</button>

	</td>

	</tr>

	</table>
	<br />
	<hr />
	<br /> 
    </div>
    
	<?php endforeach;?>

	



</div>

<input style="display:none;" type="button" name="objModositas" class="btn btn-info" onclick="aJs.opcioHozzaadas(<?= $tid; ?>, 2)" value="Méret módósítása">





<?php endif;?>

