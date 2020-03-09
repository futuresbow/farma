<div class="wrap">
	<div class="homepage">
		<div class="homepage product-list-page">
			
			<form id="termlistaform">
			
				<?= widget('termek/termeklista', array('view' => 'termeklistaoldal_fejlec'));?>
					
				<div class="clearfix">

					<div class="left-side">
						<?= widget('kategoria/kategoria/szurowidget_termeklista');?>
						<div class="categories">

							<div class="cat-title">Szűrés</div>

							<div class="cat-content">
								<p>
									<input class="arszuro" type="number" name="artol" value="<?= isset($_GET['artol'])?(int)$_GET['artol']:''?>" placeholder="Minimál ár" /> -
									<input class="arszuro" type="number" name="arig" value="<?= isset($_GET['arig'])?(int)$_GET['arig']:''?>" placeholder="Maximális ár" /> 
								</p>
								<p><input type="submit" value="Keresés"></p>
							</div>
							<div class="cat-title">Méretek</div>
							<div class="cat-content">
								<?php $tl = new Termeklista_osztaly(); 
								$kapcsolok = $tl->jellemzoFajtak('Méret', 2); 
								if($kapcsolok):?>
								<?php foreach($kapcsolok as $i => $sor): if($sor->ertek=='') continue; ?>
									<input <?= (@$_GET['meret'][$i]==$sor->ertek)?' checked ':''; ?> onclick="$(this).parents('form').submit();" type="checkbox" name="meret[<?= $i?>]" value="<?= $sor->ertek?>" > - <?= $sor->ertek?><br>
								<?php endforeach;?>
								<?php endif;?>
								
							</div>

						</div>
					</div>
					
					<div class="right-side">
						<?= widget('termek/termeklista', array('view' => 'termeklistaoldal_lista.php'));?>
						
					</div>
					
				
				</div>
		
			</form>
	
		</div>
	
	</div>

</div>


