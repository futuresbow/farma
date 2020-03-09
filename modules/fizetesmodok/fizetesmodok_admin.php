<?php

class Fizetesmodok_admin extends MY_Modul {
	
	
	public function lista () {		globalisMemoria("Nyitott menüpont",'Beállítások');
		globalisMemoria('utvonal', array(array('felirat' => 'Fizetési módok listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Fizetési módok");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'fizetesmodok/szerkesztes/0', 'felirat' => 'Új mód'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM fizetesmodok '.$w.' ORDER BY nev ASC LIMIT '.$start.', 30');
		foreach($lista as $sor) {
			
			$sor->statusznev = $sor->statusz==0?' Kikapcsolva ':' Bekapcsolva ';
			$sor->ar = ws_arformatum($sor->ar).' Ft';
			
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Megnevezés', 'mezonev' => 'nev'),
			array('felirat' => 'Kód', 'mezonev' => 'kod'),
			
		);
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'fizetesmodok/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'fizetesmodok/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'kod' => 'Kód','ar' => 'Felár', 'statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Beállítások');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'fizetesmodok/lista', 'felirat' => 'Fizetési módok') , array('felirat'=> 'Fizetési mód szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$this->Sql->sqlSave($a, 'fizetesmodok');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, 'fizetesmodok');
					
			}
			redirect(ADMINURL.'fizetesmodok/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, 'fizetesmodok', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Fizetési módok");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'fizetesmodok/lista', 'felirat' => 'Fizetési módok') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Fizetési mód jellemzői', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'kod', 'felirat' => 'Kód', 'ertek'=> @$sor->kod));
		
		$doboz->duplaInput($input1, $input2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ar', 'felirat' => 'Ár (ezt választva hozzáadódik a rendelés összeghez)', 'ertek'=> @$sor->ar));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ingyeneslimitar', 'felirat' => 'Ingyenes értéklimit (efölött az összérték felett nem számolunk plussz árat)', 'ertek'=> @$sor->ingyeneslimitar));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($input2);
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));
		$doboz->duplaInput($select);
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'fizetesmodok/lista',
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
		
		$this->db->query("DELETE FROM fizetesmodok WHERE id =  ".$id);
		redirect(ADMINURL.'fizetesmodok/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
}
