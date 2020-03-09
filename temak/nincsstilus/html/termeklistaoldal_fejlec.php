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
        
