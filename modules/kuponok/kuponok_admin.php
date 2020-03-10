<?php

class Kuponok_admin extends MY_Modul {
		
	
	public function lista () {				if(!vanTabla(DBP.'kuponok')) return "A modul nincs megfelelően telepítve";				globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Kuponok listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Kuponok");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'kuponok/szerkesztes/0', 'felirat' => 'Új kupon'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'kuponok '.$w.' ORDER BY nev ASC LIMIT '.$start.', 30');
		foreach($lista as $k => $sor) {
			
			$lista[$k]->tipus = $sor->tipus==0?' Lejáratos ':' Darabszámos ';			$lista[$k]->statusznev = $sor->statusz==0?' Kikapcsolva ':' Bekapcsolva ';			$lista[$k]->ar = $sor->ar.' '.(($sor->mukodesimod==1)?'%':PNUTO);
			
			
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'kuponok/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'kuponok/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'tipus' => 'Típus', 'kod' => 'Kód', 'ar' => 'Kedvezmény', 'darabszam' => 'Db', 'kod' => 'Kód','indulas' => 'Kezdet','lejarat' => 'Lejárat','statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'kuponok/lista', 'felirat' => 'Kuponok') , array('felirat'=> 'Kupon szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;			$a['extrakalkulacio'] = 0;
			if($id == 0) {
				$this->Sql->sqlSave($a, DBP.'kuponok');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'kuponok');
					
			}
			redirect(ADMINURL.'kuponok/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, DBP.'kuponok', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Kupon adatok");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'kuponok/lista', 'felirat' => 'Vissza a kuponokhoz') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Kupon jellemzői', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'kod', 'felirat' => 'Kód', 'ertek'=> @$sor->kod));
		
		$doboz->duplaInput($input1, $input2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'indulas', 'felirat' => 'Kezdés (ÉÉÉÉ-HH-NN ÓÓ:pp)', 'ertek'=> @$sor->indulas));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'lejarat', 'felirat' => 'Lejárat (ÉÉÉÉ-HH-NN ÓÓ:pp)', 'ertek'=> @$sor->lejarat));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($input2);
				$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'tipus', 'felirat' => 'Típus', 'ertek'=> @$sor->tipus, 'opciok' => array(0=>'Lejáratos', 1=>'Darabszámos')));		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'darabszam', 'felirat' => 'Darabszám', 'ertek'=> @$sor->darabszam));
		
		
		$doboz->duplaInput($select, $input1);		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ar', 'felirat' => 'Kedvezmény', 'ertek'=> @$sor->ar));
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));
		$doboz->duplaInput($input1,$select);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'cikkszamok', 'felirat' => 'Termék szikkszámok ( vesszővel elválasztva) <smal>Ha ki van töltve, csak ezekkel a termékekkel működik</smal>', 'ertek'=> @$sor->cikkszamok));
		
		$doboz->szimplaInput($input1);
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'kuponok/lista',
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
		
		$this->db->query("DELETE FROM ".DBP."kuponok WHERE id =  ".$id);
		redirect(ADMINURL.'kuponok/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
}
