<table style="width:100%;background:#f8f8f8;">

	<tr>

            <td style="padding:10px;background:#000;color:#fff;font-family:sans-serif;font-size:16px;">
                Rendelés részletei:<br><br><!-- comment -->
                
            </td>

	</tr>
	<tr>

            <td style="padding:10px;font-family:sans-serif;">
                Rendelésszám: <?= ws_ordernumber($this->id); ?><br>
                Rendelés dátuma: <?= ws_date($this->ido); ?><br>
                
                <br>
                <?php $fizmod = $szallmod = false; foreach ($this->armodositok as $sor) {
                    if($sor->tipus == 'fizetesmod') $fizmod = $sor;
                    if($sor->tipus == 'szallitasmod') $szallmod = $sor;
                } ?>
                
                Fizetés módja: <?= $fizmod->nev; ?><br>
                Szállítás módja: <?= $szallmod->nev; ?><br><br>
                
                Email cím: <?= $this->vevo->email; ?><br>
                Telefonszám: <?= $this->vevo->telefonszam; ?><br>

                Szállítási cím:   <?= $this->vevo->szall_irszam; ?> <?= $this->vevo->szall_telepules; ?>, <?= $this->vevo->szall_utca; ?>  <br>
                Számlázási cím:    <?= $this->vevo->szaml_irszam; ?> <?= $this->vevo->szaml_telepules; ?>, <?= $this->vevo->szaml_utca; ?> 
                
                <br>
                
            </td>

	</tr>

	

	<tr>

		<td style="padding:10px;font-family:sans-serif;">

			<table style="width:100%;background:#ffffff;" cellpadding="10" cellspacing="0" >

				<tr>

					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;"></td>

					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Terméknév</td>
                    
                    <td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Cikkszám</td>

					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Ár</td>

					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Mennyiség</td>

					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Összesen</td>

				</tr>

				<?php foreach($this->termekLista as $t):?>

				<tr >

					<td style="width:100px;color:#000;font-family:sans-serif;border-bottom: 1px solid #ddd;">

						<img src="<?= $t->fokep()?base_url().ws_image($t->fokep(), 'smallboxed'):beallitasOlvasas('kepek.nincskepurl');?>" width="100" height="100" title="<?= $t->jellemzo('Név'); ?>"  alt="<?= $t->jellemzo('Név'); ?>" />

                    </td>

					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;">

						<a href="<?= $t->link(); ?>" target="_blank" title=""><?= $t->nev; ?></a> 

						<?php if($t->megrendeltValtozat()):$v = $t->megrendeltValtozat();?>

						<br><b style="color:#555;"><?= $v->nev." (".ws_arformatum($v->ar).") "; ?></b>

						<?php endif;?><br>

						<?php if($t->megrendeltOpciok()) foreach($t->megrendeltOpciok() as $sor):?>

						<span style="opcioLabel"><?= $sor->nev." ( +".ws_arformatum($sor->ar).") "; ?> </span>&nbsp;

						<?php endforeach;?>

					</td>
					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;">

						
						<?php if($t->megrendeltValtozat()):$v = $t->megrendeltValtozat();?>
                        
						<b style="color:#555;"><?= $t->cikkszamMeghatarozas($v->id, true); ?></b>

						<?php else:?>
						
						<b style="color:#555;"><?= $t->cikkszam; ?></b>
						
						<?php endif;?>

						
					</td>

					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;"><?= PN_ELO.' '.ws_arformatum($t->megrendeltBruttoEgysegAr()).' '.PN_UTO;?></td>

					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;"><?= $t->darab;?></td>

					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;"><?= PN_ELO.' '.ws_arformatum($t->megrendeltOsszBruttoAr()).' '.PN_UTO;?></td>

					

                                

				</tr>

				<?php endforeach;?>

				

			</table>

		</td>

	</tr>
        <tr>

            <td style="padding:10px;font-family:sans-serif;">
                Nettó részösszeg:   <?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszar(true) ).' '.PN_UTO;?>  <br>       
                ÁFA (27%):  <?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszarAfa(true) ).' '.PN_UTO;?>       <br>
                Bruttó részösszeg:    <?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszarBrutto(true) ).' '.PN_UTO;?>  <br>
                
                
                    
                <?php if($szallmod->ar>0): $this->megrendelesArszamitas(); // ez számít bruttó szállítási összeget ?>
                
                Házhozszállítás futárszolgálattal:  <?= PN_ELO.' '.ws_arformatum(round($szallmod->bruttoAr,0)).' '.PN_UTO; ?> <br>          
                <?php endif; ?>
                Összesen bruttó: <?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszarBrutto() ).' '.PN_UTO;?> <br>
                
            
            
                <br>
                <br>
                <?php if(trim($rendeles->megjegyzes)!==''):?>
                Megjegyzés:
                <br>
                <i><?= htmlspecialchars($rendeles->megjegyzes)?></i><br><br>
                <?php endif; ?>
                Motoros üdvözlettel,<br>
                a Karasna Honda csapata
                <br>
                
            
                </td>
	<tr>

	</table>



