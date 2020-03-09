 	
 	                
                    <div class="tm-box-3" style="background-color: #fff;">
                        
                        <ul  class="list-group list-group-flush">
					
							
							<?php if($lista)foreach($lista as $kat):?>

								<li class="list-group-item" style="padding-left: <?= ($kat->szint+1)*20;?>px" >

									<a href="<?= base_url().beallitasOlvasas('termekek.oldal.url').'/'.$kat->slug; ?>" title="<?= $kat->nev;?>" class=""><span class="name"><?= $kat->nev;?></span> <small class="counter">(<?= $kat->termekdb;?>)</small></a>

								</li>

								<?php endforeach; ?>
							
							
						</ul>
                        
                       
                    </div>
               
 	
 	

