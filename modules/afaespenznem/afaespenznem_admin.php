<?php

class Afaespenznem_admin extends MY_Modul {
	
	
	public function lista () {		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Áfa értékek listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Áfa értékek");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'afaespenznem/szerkesztes/0', 'felirat' => 'Új érték felvitele'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM afaertekek '.$w.' ORDER BY nev ASC ');
		foreach($lista as $sor) {
			
			$sor->statusznev = $sor->statusz==0?' Kikapcsolva ':' Bekapcsolva ';
			$sor->alapertelmezett = $sor->alapertelmezett==1?' <i class="fas fa-check"></i> ':'';
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'afaespenznem/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'afaespenznem/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'ertek' => 'Érték','alapertelmezett' => 'Alapértelmezett', 'statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('cellaAttr', array('alapertelmezett' => ' style="text-align:center" ' ));
		
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'afaespenznem/lista', 'felirat' => 'ÁFA értékek') , array('felirat'=> 'ÁFA szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$this->Sql->sqlSave($a, 'afaertekek');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, 'afaertekek');
					
			}
			redirect(ADMINURL.'afaespenznem/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, 'afaertekek', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Áfaérték szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'afaespenznem/lista', 'felirat' => 'Vissza') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Fizetési mód jellemzői', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ertek', 'felirat' => 'Áfa %', 'ertek'=> @$sor->ertek));
		
		$doboz->duplaInput($input1, $input2);
		
		
		$select1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));
		$select2 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'alapertelmezett', 'felirat' => 'Alapértelmezett', 'ertek'=> @$sor->alapertelmezett, 'opciok' => array(0=>'nem', 1=>'Igen')));
		$doboz->duplaInput($select1, $select2);
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'afaespenznem/lista',
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
		
		$this->db->query("DELETE FROM afaertekek WHERE id =  ".$id);
		redirect(ADMINURL.'afaespenznem/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	
	// pénznemek
	
	public function penznemlista () {		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Pénznemek listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Pénznemek");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'afaespenznem/penznemszerkesztes/0', 'felirat' => 'Új pénznem felvitele'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM penznemek '.$w.' ORDER BY nev ASC ');
		foreach($lista as $sor) {
			
			$sor->statusznev = $sor->statusz==0?' Kikapcsolva ':' Bekapcsolva ';
			$sor->alapertelmezett = $sor->alapertelmezett==1?' <i class="fas fa-check"></i> ':'';
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'afaespenznem/penznemszerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'afaespenznem/penznemtorles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'kod' => 'Kód','alapertelmezett' => 'Alapértelmezett', 'statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('cellaAttr', array('alapertelmezett' => ' style="text-align:center" ' ));
		
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function penznemszerkesztes() {		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'afaespenznem/penznemlista', 'felirat' => 'Pénznemek listája') , array('felirat'=> 'Pénznem szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$this->Sql->sqlSave($a, 'penznemek');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, 'penznemek');
					
			}
			redirect(ADMINURL.'afaespenznem/penznemlista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, 'penznemek', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Pénznem szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'afaespenznem/penznemlista', 'felirat' => 'Vissza') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Fizetési mód jellemzői', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'kod', 'felirat' => 'Pénznemkód', 'ertek'=> @$sor->kod));
		
		$doboz->duplaInput($input1, $input2);
		
		
		$select1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));
		$select2 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'alapertelmezett', 'felirat' => 'Alapértelmezett', 'ertek'=> @$sor->alapertelmezett, 'opciok' => array(0=>'nem', 1=>'Igen')));
		$doboz->duplaInput($select1, $select2);
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'afaespenznem/penznemlista',
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
	public function penznemtorles() {		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		$this->db->query("DELETE FROM penznemek WHERE id =  ".$id);
		redirect(ADMINURL.'afaespenznem/penznemlista?m='.urlencode('Sikeres törlés!'));
		return;
	}
}
