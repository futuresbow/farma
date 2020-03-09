
					<h1>Keresés eredménye: <?=  $keresoSzo; ?></h1>

						<?php if(!empty($eredmenyek['termek_termeklista_kereses'])): ?>
						<h3>Termékek</h3>
						<table class="talalattable">
							<?php foreach($eredmenyek['termek_termeklista_kereses'] as $sor):?>
							<tr>
								<td width="120">
									<a href="<?= $sor['link'];?>"><img src="<?= base_url().ws_image($sor['kep'],'mediumboxed');?>" title="<?= $sor['cim'] ;?>" alt="<?= $sor['cim'];?>"></a>
								</td>
								<td>
									<h5>
										<a href="<?= $sor['link'];?>">
											<?= $sor['cim'];?>
											</a>
										</h5>
										<br>
										<p><?= $sor['leiras'];?></p></td>
							</tr>
							
							<?php endforeach; ?>
						</table>
						<?php endif;?>
						
						
						
						<?php if(!empty($eredmenyek['post_postmegjelenites_kereses'])): ?>
						<h3>Bejegyzések</h3>
						<table class="talalattable">
							<?php foreach($eredmenyek['post_postmegjelenites_kereses'] as $sor):?>
							<tr>
								<td width="120">
									<a href="<?= $sor['link'];?>"><img src="<?= base_url().ws_image($sor['kep'],'mediumboxed');?>" title="<?= $sor['cim'] ;?>" alt="<?= $sor['cim'];?>"></a>
								</td>
								<td>
									<h5>
										<a href="<?= $sor['link'];?>">
											<?= $sor['cim'];?>
											</a>
										</h5>
										<br>
										<p><?= $sor['leiras'];?></p></td>
							</tr>
							
							<?php endforeach; ?>
						</table>
						<?php endif;?>
				
