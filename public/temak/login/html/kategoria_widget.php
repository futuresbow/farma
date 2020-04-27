					<div class="box">
						<div class="box-title">Termékkategóriák</div>
						<div class="box-content">
							<p>
								<?php if($lista)foreach($lista as $kat):?>
								<a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kat->slug; ?>" title="<?= $kat->nev;?> (<?= $kat->termekdb;?>)"><?= $kat->nev;?> (<?= $kat->termekdb;?>)</a> 
								<?php endforeach; ?>
							</p>
							
						</div>
	
					</div>


				
