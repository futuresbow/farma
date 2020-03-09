<form id="termlistaform">
		<?php $ci = getCI();?>

        <div class="products-heading">
            <h1><?= (isset($listacim))?$listacim:'Termékek'; ?></h1>
            <div class="styled-select">
                <select onchange="$('#termlistaform').submit();" name="rend">
                    <option  value="" <?= ($ci->session->userdata('termek_rendezes')=="")?' selected ':''; ?> >Rendezés</option>
                    <option value="nev" <?= ($ci->session->userdata('termek_rendezes')=="nev")?' selected ':''; ?>  >Név szerint</option>
                    <option <?= $rendezes == 'ar'?' selected ':''?> value="ar"<?= ($ci->session->userdata('termek_rendezes')=="ar")?' selected ':''; ?> >Ár szerint</option>
                    <option <?= $rendezes == 'nepszeruseg'?' selected ':''?> value="nepszeruseg" <?= ($ci->session->userdata('termek_rendezes')=="nepszeruseg")?' selected ':''; ?> >Népszerűség szerint</option>
                </select>
            </div>
        </div>



        <div class="row">
			<?php if($termekek): ?>
			
        
			
			<?php foreach($termekek as $t):?>
				<div class="col-md-3" style="box-shadow:2px 2px 3px #aaa;margin:3px;box-size:borderbox;">
                    <a href="<?= $t->link();?>" title="<?= $t->jellemzo('Név');?>" >
                    <div class="image">
                        <img style="width:100%;" src="<?= base_url().ws_image($t->fokep(),'mediumboxed');?>" title="<?= $t->jellemzo('Név');?>" alt="<?= $t->jellemzo('Név');?>" class="img-fluid">
                    </div>
                    </a>
                    <div class="tm-box-3">
                        <b><?= $t->jellemzo('Név');?></b><br><br>
                        <div class="price"> <?= PN_ELO.' '.ws_arformatum($t->bruttoAr).' '.PN_UTO;?>
                            <?php if($t->eredetiBruttoAr != 0): ?><span class="old-price"> <?= PN_ELO.' '.ws_arformatum($t->eredetiBruttoAr).' '.PN_UTO;?></span><?php endif;?>
                        </div>
                        
                        
                    </div>
                </div>
              
            <?php endforeach;?>   


            
            <?php else:?>
            <h3>Nem található termék, folytasd az <a href="<?= base_url();?>termekek">Összes terméknél</a>.</h3>
            <?php endif;?>

        </div>
		<?php if(isset($termekdb)): ?>
		
		<nav aria-label="Page navigation example">
			<?php if($termekdb>(int)$ci->session->userdata('termek_listalimit')):?>
		  <ul class="pagination">
			  <?php $lap = 0; for($i = 0; $i < $termekdb;$i += $limit):$lap++;?>
                <li class="page-item"><a href="?start=<?= $i; ?>" title="" class="page-link <?= ($start == $i)?' active ':'';?>"><?= $lap; ?></a></li>
                <?php endfor; ?>
			
		  </ul>
		  <?php endif; ?>
		</nav>

        <div class="pagination">
            <div class="styled-select">
                <select  value="0"  name="dbszam" onchange="$('#termlistaform').submit();">
                    <option value="12" <?= ((int)$ci->session->userdata('termek_listalimit')==12 )?' selected ':''; ?> >12 / oldal</option>
                    <option value="24"  <?= ((int)$ci->session->userdata('termek_listalimit')==24 )?' selected ':''; ?> >24 / oldalt</option>
                    <option value="48"  <?= ((int)$ci->session->userdata('termek_listalimit')==48 )?' selected ':''; ?> >48 / oldalt</option>
                </select>
            </div>
         
        </div>
        <?php endif; ?>

</form>



