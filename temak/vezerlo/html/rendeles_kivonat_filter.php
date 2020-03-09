<div class="box box-dark box-flat">

	<form class="keresoUrlap">

		

            <div class="table-top-search">

				

					<div class="table-top-select">

						<div class="input-container">

							<div class="input-select-container">

								<div class="styled-select">

									<select name="sr[aruhaz]" id="sel01">
										<option value="0">Összes áruház</option>

										<?php foreach($aruhazak as $aruhaz):?>
										<option "<?= (@$_GET['sr']['aruhaz']==$aruhaz->id)?' selected ':''?>" value="<?= $aruhaz->id; ?>"><?= $aruhaz->nev; ?></option>
										<?php endforeach;?>
										
										
										
									</select>

								</div>

							</div>

						</div>

					</div>



					<div class="table-top-input">

						<input name="sr[email]" class="keresoInput" type="text" value="<?= @$_GET['sr']['email'];?>" placeholder="E-mail...">

						
						
					</div>
					
					<div class="table-top-input">

						<input name="sr[tol]" class="keresoInput" type="text" value="<?= @$_GET['sr']['tol'];?>" placeholder="Időszak kezdete">

						
						
					</div>

					<div class="table-top-input">

						<input name="sr[ig]" class="keresoInput" type="text" value="<?= @$_GET['sr']['ig'];?>" placeholder="Időszak Vége">

						
					</div>



					<div class="table-top-btn">

						<input type="submit" class="btn btn-small" value="Keresés">

					</div>

                

            </div>



		

	</form>

</div>
