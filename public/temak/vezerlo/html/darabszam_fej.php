<div class="box box-dark box-flat">

	<form class="keresoUrlap">

		

            <div class="table-top-search">

				

					<div class="table-top-select">

						<div class="input-container">

							<div class="input-select-container">

								<div class="styled-select">

									<select name="sr[keresomezo]" id="sel01">

										<option selected="" value="0">Cikkszám</option>
									</select>

								</div>

							</div>

						</div>

					</div>


					<div class="table-top-input">

						<input name="sr[keresoszo]" class="keresoInput" type="text" value="" onkeyup="$.get('<?= ADMINURL;?>keszletek/darabszam?ajax=1', $('.keresoUrlap').serialize(), function(e) { $('.talalatlista').html(e);} );" placeholder="Keresés...">

						<label></label>

						
					</div>



					

                

            </div>



		

	</form>

</div> 


<div class="talalatlista"></div>
