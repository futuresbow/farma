<?php

class Rendelesmegjelenites extends MY_Modul {
	
	function lista(){
		
		$tag = ws_belepesEllenorzes();
		if(!$tag) {
			redirect(base_url());
			return;
		}
		
		naplozo('Rendelések megtekintése');
		
		$start = 0;
		$limit = 2000;  // TODO lapozó a rendelésekhez
		$w = " WHERE r.rendeles_felhasznalo_id = f.id AND f.felhasznalo_id = ".$tag->id;
		$lista = $this->sqlSorok('SELECT r.id as rendelesid, r.* FROM '.DBP.'rendelesek r, '.DBP.'rendeles_felhasznalok f  '.$w.' ORDER BY ido DESC LIMIT '.$start.', '.$limit);
		
		$statuszopciok = '';

		$statuszArr = array();

		foreach($this->gets(DBP."rendeles_statusz", " ORDER BY sorrend ASC") as $sor)  {

			$statuszopciok .= '<option  value="'.$sor->id.'">'.$sor->nev.'</option>';

			$statuszArr[$sor->id] = $sor->nev;

			

		}

		foreach($lista as $sor) {

			$sor->statusz = $statuszArr[$sor->statusz];

			$vevoRs = $this->Sql->sqlSor("SELECT * FROM ".DBP."rendeles_felhasznalok WHERE id = {$sor->rendeles_felhasznalo_id} LIMIT 1");

			$sor->vevo = $vevoRs->vezeteknev.' '.$vevoRs->keresztnev;

			$sor->osszar = ws_arformatum($sor->osszbrutto).' Ft';

			$sor->ido = date('Y-m-d', strtotime($sor->ido));
			
			$sor->szamlak = $this->Sql->sqlSorok("SELECT * FROM ".DBP."szamlazas WHERE rendeles_id =  ".$sor->rendelesid);
			

		}
		return ws_frontendView('html/rendeleseim', array('lista' => $lista), true);
		
	}
	
	
	function letoltes() {
		
		$tag = ws_belepesEllenorzes();
		if(!$tag) {
			
			return;
		}
		naplozo('Rendelés számla letöltése');
		
		if($this->ci->uri->segment(1)=='szamlaletoltes') {
			$id = (int)$this->ci->uri->segment(2);
			$sor = $this->Sql->get($id, 'szamlazas', 'id');
			if($sor){
				if(file_exists(SZAMLAMAPPA.'pdf/'.$sor->szamlanev.'.pdf')) {
					$vevo = $this->Sql->get($sor->rendeles_felhasznalo_id, 'rendeles_felhasznalok', 'id');
				
					if($tag->id!=$vevo->felhasznalo_id) {
						die('Nincs hozzáférésed ehhez a tartalomhoz');
					}
					
					
					header("Content-type:application/pdf");
					header("Content-Disposition:attachment;filename={$sor->szamlanev}.pdf");

					readfile (SZAMLAMAPPA.'pdf/'.$sor->szamlanev.'.pdf');
					die();
				} else {
					die("Probléma maerült fel: a file nem található.");
				}
			} else {
				die('Nincs hozzáférésed ehhez a tartalomhoz');
			}
		}
		
		
	}
}
