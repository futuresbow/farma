<table style="width:100%;background:#f8f8f8;">
	<tr>
		<td style="padding:10px;background:#000;color:#fff;font-family:sans-serif;">Megrendelés adatok</td>
	</tr>
	
	<tr>
		<td style="padding:10px;font-family:sans-serif;">
			<table style="width:100%;background:#ffffff;" cellpadding="10" cellspacing="0" >
				<tr>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;"></td>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Név/változat/opció</td>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Nettó egységár</td>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Darab</td>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#98DEFF;">Nettó összár</td>
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
					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;"><?= PN_ELO.' '.ws_arformatum($t->megrendeltEgysegAr()).' '.PN_UTO;?></td>
					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;"><?= $t->darab;?></td>
					<td style="color:#000;font-family:sans-serif;;border-bottom: 1px solid #ddd;"><?= PN_ELO.' '.ws_arformatum($t->megrendeltOsszAr()).' '.PN_UTO;?></td>
					
                                
				</tr>
				<?php endforeach;?>
				
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding:10px;font-family:sans-serif;">
			<table style="width:100%;background:#ffffff;" cellpadding="10" cellspacing="0" >
				<tr>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#fff;" width="70%">Megnevezés</td>
					<td style="color:#333;font-family:sans-serif;font-weight:bold;background:#fff;">Nettó ár</td>
				</tr>
				<?php foreach($this->armodositok as $sor):?>					
				<tr>
					<td colspan="2" style="color:#333;font-family:sans-serif;background:#fff;font-weight:bold;" width="85%"><?= $sor->megnevezes; ?></td>
					
				</tr>
				<tr>
					<td style="padding:5px;" colspan="2">
						<table style="background:#eee;width:100%;">
							<tr>
								<td style="padding:10px;color:#333;font-family:sans-serif;" width="60%"><?= $sor->nev;?></td>
								<td style="padding:10px;color:#333;font-family:sans-serif;" width="22%">(<?= $sor->kod;?>)</td>				
								<td style="padding:10px;color:#333;font-family:sans-serif;"><?= PN_ELO.' '.ws_arformatum($sor->nettoAr).' '.PN_UTO;?><?= (trim($sor->cikkszamok)!='')? '<br>(a '.$sor->cikkszamok.' cikkszámú termék(ek) árából kerül levonásra)':''; ?></td>
								
							</tr>
						</table>
					</td>
				</tr>
				
				<?php endforeach;?>
			</table>
		</td >
	</tr>
	<tr>
		<td>
			<table style="background:#FFF;width:100%;">
				<tr>
					<td style="padding:10px;color:#333;font-family:sans-serif;font-size:1.2em;" width="80%">
						Megrendelés összár nettó
					</td>
					<td style="font-family:sans-serif;"><?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszar()).' '.PN_UTO;?></td>
				</tr>
				<tr>
					<td style="padding:10px;color:#333;font-family:sans-serif;">
						ÁFA-tartalom
					</td>
					<td style="font-family:sans-serif;"><?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszarAfa()).' '.PN_UTO;?></td>
				</tr>
				<tr>
					<td style="padding:10px;color:#333;font-family:sans-serif;">
						Bruttó érték összesen
					</td>
					<td style="font-family:sans-serif;"><b><?= PN_ELO.' '.ws_arformatum($this->megrendelesOsszarBrutto()).' '.PN_UTO;?></b></td>
				</tr>
				
			</table>
		</td>
	</tr>
	
	<tr>
		<td style="padding:10px;background:#000;color:#fff;font-family:sans-serif;">SZEMÉLYES ADATOK</td>
	</tr>
	<tr>
		<td>
			<table style="background:#FFF;width:100%;">
				
				<tr>
					<td width="25%" style="padding:5px;font-weight:bold;font-family:sans-serif;">Név:</td>
					<td width="25%" style="padding:5px;font-family:sans-serif;"><?= $this->vevo->vezeteknev.' '.$this->vevo->keresztnev; ?></td>
					<td width="25%" style="padding:5px;;font-weight:bold;font-family:sans-serif;">E-mail:</td>
					<td style="padding:5px;font-family:sans-serif;"><?= $this->vevo->email; ?></td>
				
				</tr>
				
				<tr>
					<td width="25%" style="padding:5px;font-weight:bold;font-family:sans-serif;">Telefonszám:</td>
					<td width="25%" style="padding:5px;font-family:sans-serif;"><?= $this->vevo->telefonszam; ?></td>
					<td width="25%" style="padding:5px;;font-weight:bold;font-family:sans-serif;">&nbsp;</td>
					<td style="padding:5px;font-family:sans-serif;">&nbsp;</td>
				
				</tr>
				<tr>
					<td colspan="4" style="padding:5px;font-weight:bold;font-family:sans-serif;color:#3999F4;">Szállítási adatok</td>
					
				</tr>
				<tr>
					<td width="25%" style="padding:5px;font-weight:bold;font-family:sans-serif;">Szállítási név:</td>
					<td width="25%" style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szall_nev; ?></td>
					<td width="25%" style="padding:5px;;font-weight:bold;font-family:sans-serif;">Ország:</td>
					<td style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szall_orszag; ?></td>
				
				</tr>
				<tr>
					<td width="25%" style="padding:5px;font-weight:bold;font-family:sans-serif;">Irányítószám:</td>
					<td width="25%" style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szall_irszam; ?></td>
					<td width="25%" style="padding:5px;;font-weight:bold;font-family:sans-serif;">Utca:</td>
					<td style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szall_utca; ?></td>
				
				</tr>
				<tr>
					<td colspan="4" style="padding:5px;font-weight:bold;font-family:sans-serif;color:#3999F4;">Számlázási adatok</td>
					
				</tr>
				<tr>
					<td width="25%" style="padding:5px;font-weight:bold;font-family:sans-serif;">Számlázási név:</td>
					<td width="25%" style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szaml_nev; ?></td>
					<td width="25%" style="padding:5px;;font-weight:bold;font-family:sans-serif;">Ország:</td>
					<td style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szaml_orszag; ?></td>
				
				</tr>
				<tr>
					<td width="25%" style="padding:5px;font-weight:bold;font-family:sans-serif;">Irányítószám:</td>
					<td width="25%" style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szaml_irszam; ?></td>
					<td width="25%" style="padding:5px;;font-weight:bold;font-family:sans-serif;">Utca:</td>
					<td style="padding:5px;font-family:sans-serif;"><?= $this->vevo->szaml_utca; ?></td>
				
				</tr>
				
			</table>
		</td>
</table>

