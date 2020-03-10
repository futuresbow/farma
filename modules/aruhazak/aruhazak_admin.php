<?php

class Aruhazak_admin extends MY_Modul {		public $masolandoTablak = array(			);	public $kihagyando = array(		'adminmenu',		'aruhazak',			);	public $adatmasolas = array(				'email_sablonok',		'fizetesmodok',		'frontendmenu',		'oldal_urlek',		'oldalak',		'post',		'postxkategoria',		'post_kategoriak',		'settings',		'szallitasmodok',		'temavaltozok',		'rendeles_statusz',		'termek_jellemzok',	);
		public function __construct() {				$ci = getCI();				$sql = "SHOW TABLES";		$rs = $ci->Sql->sqlSorok($sql);		$arr = array();		foreach($rs as $sor) {			$arr[] = current($sor);		}		$this->masolandoTablak = array_diff($arr, $this->kihagyando);			}	public function eltavolitas() {		$ci = getCI();		$id = (int)$ci->uri->segment(4);				$tablak = $this->sqlSorok("SHOW TABLES");		$tablatomb = array();		foreach($tablak as $tablasor) {			$tablatomb[] = current($tablasor);					}				$aruhaz = $this->Sql->get($id, "aruhazak", 'id');		if(!$aruhaz) {			redirect(ADMINURL."aruhazak/lista?m=Áruház nem található");			return;		}		foreach($this->masolandoTablak as $tabla) {			if(!vanTabla($tabla)) continue; // adott tábla nincs telepítve						$ujTabla = $aruhaz->prefix.$tabla;									$sql = "DROP TABLE $ujTabla ";						if(in_array($ujTabla, $tablatomb)) 				$this->db->query($sql);											}				redirect(ADMINURL."aruhazak/lista?m=Táblák sikeresen eltávolítva");	}
		public function letrehozas() {		$ci = getCI();		$id = (int)$ci->uri->segment(4);		$tag = belepettTag();		$aruhaz = $this->Sql->get($id, "aruhazak", 'id');		if(!$aruhaz) {			redirect(ADMINURL."aruhazak/lista?m=Áruház nem található");			return;		}								foreach($this->masolandoTablak as $tabla) {			if(!vanTabla($tabla)) continue; // adott tábla nincs telepítve						$ujTabla = $aruhaz->prefix.$tabla;						if(in_array($tabla, $this->adatmasolas)) {				$sql = "						CREATE TABLE $ujTabla LIKE $tabla										";				$this->db->query($sql);				$sql = "												INSERT INTO $ujTabla SELECT * FROM $tabla				";				$this->db->query($sql);			} else {				$sql = "						CREATE TABLE $ujTabla LIKE $tabla				";				$this->db->query($sql);			}																	}		// felhasználó átvitele		$sql = "INSERT INTO {$aruhaz->prefix}felhasznalok SELECT * FROM felhasznalok WHERE id = ".$tag->id;		print $sql;		$this->db->query($sql);				redirect(ADMINURL."aruhazak/lista?m=Táblák sikeresen létrehozva");	}
	
	public function lista () {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('felirat' => 'Áruházak listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Áruházak");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'aruhazak/szerkesztes/0', 'felirat' => 'Új áruház'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		$tablak = $this->sqlSorok("SHOW TABLES");		$tablatomb = array();		foreach($tablak as $tablasor) {			$tablatomb[] = current($tablasor);					}				
		$lista = $this->sqlSorok('SELECT * FROM aruhazak '.$w.' ORDER BY nev ASC LIMIT '.$start.', 30');
		foreach($lista as $k => $sor) {						if($sor->prefix==DBP) {				$sor->aktivalas= 'Aktív';			} else {				$sor->aktivalas= '<a href="'.ADMINURL.'aruhazak/aktivalas/'.$sor->id.'">Bekapcsolás</a>';			}									if($sor->prefix=='') {							 continue;			}			if(!in_array($sor->prefix.'settings', $tablatomb)) {				$sor->letrehozas= '<a href="'.ADMINURL.'aruhazak/letrehozas/'.$sor->id.'">Táblák létrehozása</a>';				} else {								$sor->letrehozas= '<a href="'.ADMINURL.'aruhazak/eltavolitas/'.$sor->id.'" onclick="return(Confirm(\'Biztos vagy benne? Minden adat el fog veszni.\'))" style="color:red">Táblák eltávolítása</a>';			}
			// módosítás
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'aruhazak/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'aruhazak/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'prefix' => 'Prefix', 'letrehozas' => 'Adatbázis kialakítása','aktivalas' => 'Aktiválás', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'aruhazak/lista', 'felirat' => 'Áruházak') , array('felirat'=> 'Áruház szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;			
			if($id == 0) {
				$this->Sql->sqlSave($a, 'aruhazak');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, 'aruhazak');
					
			}
			redirect(ADMINURL.'aruhazak/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, 'aruhazak', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Áruház adatok");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'aruhazak/lista', 'felirat' => 'Vissza a áruházakhoz') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Áruház jellemzői', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'prefix', 'felirat' => 'Prefix', 'ertek'=> @$sor->prefix));
		
		$doboz->duplaInput($input1, $input2);
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'aruhazak/lista',
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
		$id = (int)$ci->uri->segment(4);		$aruhaz = $this->Sql->get($id, "aruhazak", 'id');		
		if($aruhaz->prefix=='') {			redirect(ADMINURL."aruhazak/lista?m=Az alapértelmezett áruház nem törölhető!");			return;		}
		$this->db->query("DELETE FROM aruhazak WHERE id =  ".$id);
		redirect(ADMINURL.'aruhazak/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}		public function aktivalas() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);		$aruhaz = $this->Sql->get($id, "aruhazak", 'id');		$beallitas = $this->Sql->get('db_prefix', "settings", 'kulcs');				
		$DBP = $aruhaz->prefix;				if($beallitas) {			$sql = "UPDATE settings SET ertek = '".$DBP."' WHERE id = ".$beallitas->id;		} else {			$sql = "INSERT INTO settings SET ertek = '".$DBP."', kulcs = 'db_prefix' ";		}		$this->db->query($sql);		
		redirect(ADMINURL.'aruhazak/lista?m='.urlencode('Aktiválás sikeres!'));
		return;
	}
}
