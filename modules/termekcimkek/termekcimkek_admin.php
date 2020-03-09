<?php

class Termekcimkek_admin extends MY_Modul {
	
	
	public function cimkezes () {		// nincs kitaálva, így random cimkézünk toplistásokat		$cimke = $this->Sql->get('Top', 'termek_cimkek',  'nev');		if($cimke) {						$this->db->query("DELETE FROM termekxcimke WHERE cimke_id =  ".$cimke->id);			$termekek = $this->Sql->sqlSorok("SELECT id FROM termekek ORDER BY RAND() LIMIT 5");			foreach($termekek as $k => $termek) {				$this->db->query("INSERT INTO termekxcimke SET termek_id = {$termek->id}, cimke_id = {$cimke->id}, felirat = 'Top ".($k+1)."' ");							}			return 'Kész';		}	}	public function lista () {		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékcimkék listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Termékcimkék");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termekcimkek/szerkesztes/0', 'felirat' => 'Új cimke felvitele'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'termek_cimkek '.$w.' ORDER BY nev ASC ');
		foreach($lista as $sor) {
			
			 
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'termekcimkek/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'termekcimkek/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'nyelv' => 'Nyelv', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('cellaAttr', array('alapertelmezett' => ' style="text-align:center" ' ));
		
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'termekcimkek/lista', 'felirat' => 'Termékcimkék') , array('felirat'=> 'Cimke szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$this->Sql->sqlSave($a, DBP.'termek_cimkek');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'termek_cimkek');
					
			}
			redirect(ADMINURL.'termekcimkek/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, DBP. 'termek_cimkek', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Termékcimke szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termekcimkek/lista', 'felirat' => 'Vissza') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Fizetési mód jellemzői', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));		$nyelvopciok = array('hu' => 'Magyar');		$input2 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'nyelv', 'felirat' => 'Nyelv', 'ertek'=> @$sor->ertek, 'opciok' => $nyelvopciok));				$doboz->duplaInput($input1, $input2);						$opciok = array('automatikus' => 'Autómatikus', 'manualis' => 'Manuális', );		$input1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'mukodesi_mod', 'felirat' => 'Működési mód', 'ertek'=> @$sor->mukodesi_mod, 'opciok' => $opciok));		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'cimkeosztaly', 'felirat' => 'Cimke osztály (CSS osztály)', 'ertek'=> @$sor->cimkeosztaly));				$doboz->duplaInput($input1, $input2);		
		
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'termekcimkek/lista',
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'Mentés',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
		
		
	}
	public function torles() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		$this->db->query("DELETE FROM ".DBP."termek_cimkek WHERE id =  ".$id);
		redirect(ADMINURL.'termekcimkek/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	
	
}
