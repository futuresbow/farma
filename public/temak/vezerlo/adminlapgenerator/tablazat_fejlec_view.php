<?php if($keresoMezok):?>
<div class="box box-dark box-flat">
	<form class="keresoUrlap">
		
            <div class="table-top-search">
				
					<div class="table-top-select">
						<div class="input-container">
							<div class="input-select-container">
								<div class="styled-select">
									<select name="sr[keresomezo]" id="sel01">
										<?php if($keresoMezok): foreach($keresoMezok as $k => $mezo): ?>
										<option <?= @$_GET['keresomezo'] == $k?' selected ':''; ?> value="<?= $k; ?>"><?= $mezo['felirat']; ?></option>
										<?php endforeach; endif; ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="table-top-input">
						<input name="sr[keresoszo]" class="keresoInput" type="text" value="<?= @$_GET['keresoszo']; ?>" placeholder="Keresés...">
						<label></label>
						<a href="javascript:void();" onclick="$('.keresoInput').val();$('.keresoUrlap').submit();" title="Keresés törlése" class="search-delete" style="display:none"></a> <!-- display:block if not empty -->
					</div>

					<div class="table-top-btn">
						<input  type="submit" class="btn btn-small" value="Keresés">
					</div>
                
            </div>

		
	</form>
</div>
	
<?php endif; ?>
