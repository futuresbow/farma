<div class="wrap">
	<div class="homepage">
		<div class="homepage product-list-page">
			
			<form id="termlistaform">
				<?php $ci = getCI();?>
				
					<h1><?= (isset($listacim))?$listacim:'Termékek'; ?></h1>
					<?php if(!isset($maxTalalatszam)) $maxTalalatszam = 0; if($maxTalalatszam==0):?>
						<select onchange="$('#termlistaform').submit();" name="rend">
							<option  value="" <?= ($ci->session->userdata('termek_rendezes')=="")?' selected ':''; ?> >Rendezés</option>
							<option value="nev" <?= ($ci->session->userdata('termek_rendezes')=="nev")?' selected ':''; ?>  >Név szerint</option>
							<option <?= $rendezes == 'ar'?' selected ':''?> value="ar"<?= ($ci->session->userdata('termek_rendezes')=="ar")?' selected ':''; ?> >Ár szerint</option>
							<option <?= $rendezes == 'nepszeruseg'?' selected ':''?> value="nepszeruseg" <?= ($ci->session->userdata('termek_rendezes')=="nepszeruseg")?' selected ':''; ?> >Népszerűség szerint</option>
						</select>
					
					<?php else: ?>
					<a href="<?= base_url();?>termekek" title="Termékek" class="see-all">Minden termék</a>
					<?php endif; ?>
				
					
						<?php if($termekek): ?>

					
						<ul class="products">
						
						
						
						
						
						<?php foreach($termekek as $t):?>
						
							<li>
                        <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>"  class="">
                           <?php if($t->cimkeTag(4)):?><div class="new-badge" style="display:block;">Új</div><?php endif;?>
                        
                            <div class="img-container">
                                <img src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>">
								
                            </div>
                            <div class="details">
                                <div class="prod-name"><?= $t->jellemzo('Név');?></div>
                                <div class="price"><?php if($t->eredetiBruttoAr != 0): ?><span class="old-price"><?= PN_ELO.' '.ws_arformatum($t->eredetiBruttoAr).' '.PN_UTO;?></span><?php endif;?><?= PN_ELO.' '.ws_arformatum($t->bruttoAr).' '.PN_UTO;?></div>
                            </div>
                        </a>
                    </li>
						<?php endforeach;?>   


						</ul>
						
						<?php else:?>
						<h3>Nem található termék, folytasd az <a href="<?= base_url();?>termekek">Összes terméknél</a>.</h3>
						<?php endif;?>

					
					
					<?php if($maxTalalatszam==0):?>
					
					<?php if(isset($termekdb)): ?>
					<div class="pagination">
						<div class="styled-select">
							<select  value="0"  name="dbszam" onchange="$('#termlistaform').submit();">
								<option value="12" <?= ((int)$ci->session->userdata('termek_listalimit')==12 )?' selected ':''; ?> >12 / oldal</option>
								<option value="24"  <?= ((int)$ci->session->userdata('termek_listalimit')==24 )?' selected ':''; ?> >24 / oldalt</option>
								<option value="48"  <?= ((int)$ci->session->userdata('termek_listalimit')==48 )?' selected ':''; ?> >48 / oldalt</option>
							</select>
						</div>
						<?php if($termekdb>(int)$ci->session->userdata('termek_listalimit')):?>
						<ul>
							<?php $lap = 0; for($i = 0; $i < $termekdb;$i += $limit):$lap++;?>
							<li><a href="?start=<?= $i; ?>" title="" class="<?= ($start == $i)?' active ':'';?>"><?= $lap; ?></a></li>
							<?php endfor; ?>
						</ul>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php endif; ?>
				</div>
			</form>
		</div>
	</div>
</div>

<script >$().ready(function() { siteJs.kosarElokeszites() });</script>

