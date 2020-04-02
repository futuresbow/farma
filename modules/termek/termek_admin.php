<?php

class Termek_admin extends MY_Modul{
	var $data = array();
	
	public function __construct() {
		parent::__construct();
		include_once('osztaly/osztaly_termeklista.php');
	}
	/*
	 * Termékek listázása cimke alapján
	 * 
	 * a tartalmi elem admin beállításának validálása
	 * 
	 */
	 
	public function termeklistasliderlista_beallito ($param, $ALG) {
		globalisMemoria("Nyitott menüpont",'Termékek');
		$doboz = $ALG->ujDoboz();
		$opciok = array();
		$cimkek = $this->Sql->gets(DBP."termek_cimkek", " ORDER BY nev ASC");
		if($cimkek) foreach($cimkek as $cimke) $opciok[$cimke->id] = $cimke->nev." ({$cimke->nyelv}) ";
		
		$select = new Legordulo(array('felirat' => 'Terméklista típusa', 'nevtomb' => 'a', 'mezonev' => 'tipus', 'opciok' => $opciok, 'ertek' => @$param['tipus']));
		$input = new Szovegmezo(array('felirat' => 'Megjeleníthető termékek száma (pl. 10)', 'nevtomb' => 'a', 'mezonev' => 'termek_db',  'ertek' => isset($param['termek_db'])?$param['termek_db']:12));
		
		$doboz->duplaInput($select, $input);
	}
	/*
	 * Termékek listázása cimke alapján
	 * 
	 * a tartalmi elem admin beállításának validálása
	 * 
	 */
	 
	public function termeklistacimketermeklista_ellenorzes  ($adat) {
		
		$param = unserialize($adat['parameter']);
		
		$elem = $lista = $this->ci->Sql->get( $param['cimke_id'], DBP."termek_cimkek", " id ");
		if(isset($elem->nev)) $adat['elemnev'] = $elem->nev.' címke terméklistája'; else return false;
		return $adat;
		
	}
	/*
	 * Termékek listázása cimke alapján
	 * 
	 * a tartalmi elem admin beállító függvény
	 * 
	 */
	public function termeklistacimketermeklista_beallito  ($param, $ALG) {
		globalisMemoria("Nyitott menüpont",'Termékek');
		$doboz = $ALG->ujDoboz();
		$opciok = array();
		$cimkek = $this->Sql->gets(DBP."termek_cimkek", " ORDER BY nev ASC");
		if($cimkek) foreach($cimkek as $cimke) $opciok[$cimke->id] = $cimke->nev." ({$cimke->nyelv}) ";
		$select = new Legordulo(array('felirat' => 'Terméklista típusa', 'nevtomb' => 'a', 'mezonev' => 'cimke_id', 'opciok' => $opciok, 'ertek' => @$param['cimke_id']));
		
		$doboz->szimplaInput($select);
		$input1 = new Szovegmezo(array('attr'=> ' type="number" ', 'nevtomb'=>'a', 'mezonev' => 'talalatszam', 'felirat' => 'Megjelenítendő termékek száma', 'ertek' => @$param['talalatszam']));
		$doboz->szimplaInput($input1);
		
	}
	
	/*
	 * valtozatesopcio
	 * 
	 * ármódosítók (változatok és opciók) panel megjelenítése 
	 * az admin termékszerkesztőben
	 * 
	 */
	 
	public function valtozatesopcio() {
		
		$this->data['tid'] = $id = (int)$this->ci->uri->segment(4);
		$this->data['opc'] = false;
		
		
		$opc = $this->sqlSorok("SELECT * FROM ".DBP."termek_armodositok WHERE termek_id = $id ORDER BY tipus ASC, sorrend ASC");

		if(isset($_POST['termekOpcioHozzadas']))if($_POST['termekOpcioHozzadas']!='0') {
			$sql = "SELECT * FROM ".DBP."termek_armodositok WHERE termek_id = ".(int)$_POST['termekOpcioHozzadas']." ORDER BY tipus ASC, sorrend ASC";
			$opc = $this->sqlSorok($sql);
			unset($_POST['opc']);
			if($opc) foreach($opc as $k => $v) $opc[$k]->id = 0;
		}
		
		if(!$opc) $opc = array();
		if(isset($_POST['opc'])) {
			if($_GET['tipus']=='2') unset($_POST['opc'][0]);
			$opciok = array();
			foreach($_POST['opc'] as $postOpcio) if($postOpcio['id']=='0') $opciok[] = (object)$postOpcio;
			
			$this->data['opc'] = array_merge($opciok, $opc);
		} else {
			$this->data['opc'] = $opc;
		}
		$sql = "SELECT t.id, j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE  j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." GROUP BY t.id  ORDER BY nev ASC";
		$this->data['termeklista'] = $this->sqlSorok($sql);
		
		return  $this->ci->load->view(ADMINTEMPLATE.'html/opcioszerkeszto', $this->data, true);
	}
	
	/*
	 * lista
	 * 
	 * termékek listázása az adminon
	 * 
	 */
	
	public function lista() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		$w = '';
		$sr = $this->ci->input->get('sr');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékek listája')));
		$ALG = new Adminlapgenerator;
		
		
		
		
		
		// keresések
		$keresestorles = false;
		if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {
			
			$mod = (int)$sr['keresomezo'];
			if($mod==0) $w = ' t.cikkszam LIKE "%'.$sr['keresoszo'].'%" ';
			if($mod==1) $w = ' j.termek_id = t.id AND j.ertek_2 LIKE "%'.$sr['keresoszo'].'%" ';
			if($mod==2) $w = ' j.termek_id = t.id AND j.ertek_3 LIKE "%'.$sr['keresoszo'].'%" ';
			
			$sql = "SELECT DISTINCT(t.id) FROM ".DBP."termekek t, ".DBP."jellemzok j WHERE $w";
			
			if($mod==3) {
				$w = ' t.id = x.termek_id and x.cimke_id = c.id AND c.nev LIKE "%'.$sr['keresoszo'].'%" ';
				$sql = "SELECT DISTINCT(t.id) FROM ".DBP."termekek t, ".DBP."termek_cimkek c, ".DBP."termekxcimke x WHERE $w";
			
			}
			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');
			
			if($idArr) {
				$w = "  t.id IN (".implode(',', $idArr).") AND ";
				
			} else {
				$tabla = $ALG->ujTablazat();
				$tabla->keresoTorles();
				redirect(ADMINURL."termek/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
				return;
			}
		}
		
		
		
		
		$ALG->adatBeallitas('lapCim', "Termékek");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/szerkesztes/0', 'felirat' => 'Új termék'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		
		$sql = "SELECT t.id, j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE  $w j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." GROUP BY t.id  ORDER BY nev ASC";
		
		$lista = $this->sqlSorok($sql);
		
		foreach($lista as $sor) {
			$termek = new Termek_osztaly($sor->id);
			$sor->nev = $termek->jellemzo('Név');
			$sor->masolas = '<a onclick="if(!confirm(\'Biztosan?\')) return false;" href="'.ADMINURL.'termek/klonozas/'.$sor->id.'">Klónozás</a>';
			$adatlista[] = $sor;
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Cikkszám', 'mezonev' => 'cikkszam'),
			array('felirat' => 'Terméknév', 'mezonev' => 'nev'),
			array('felirat' => 'Leírás', 'mezonev' => 'leiras'),
			array('felirat' => 'Cimke', 'mezonev' => 'cimke'),
		);
		
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'termek/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'termek/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'cikkszam' => 'Cikkszám',  'szerkesztes' => 'Szerkesztés',  'masolas' => 'Klónozás','torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $adatlista);
		// táblázat beállítás vége
		$ALG->tartalomDobozVege();
		
		return $ALG->kimenet();
		
	}
	
	/*
	 * torles
	 * 
	 * termék törlése az adminon
	 * 
	 */
	 
	public function torles() {
		
		
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		$ci->db->query("DELETE FROM ".DBP."termekxkategoria WHERE termek_id = $id");
		$ci->db->query("DELETE FROM ".DBP."termek_armodositok WHERE termek_id = $id");
		$ci->db->query("DELETE FROM ".DBP."jellemzok WHERE termek_id = $id");
		
		
		include_once('osztaly/osztaly_termekkep.php');
		$tk = new Termekkep_osztaly();
		$tk->osszesKepTorlese($id);
		
		$ci->db->query("DELETE FROM ".DBP."termekek WHERE id = $id");
		
		redirect(ADMINURL.'termek/lista?m='.urlencode("Törlés sikeres"));
	}
	/*
	 * klonozas
	 * 
	 * termék többszörözése az adminon.
	 * a klónozás után az új termék szerkesztőjébe ugrik
	 * 
	 */
	public function klonozas() {
		$ci = getCI();
		$this->data['tid'] = $id = (int)$ci->uri->segment(4);
		$termek = $ci->Sql->sqlSor("SELECT * FROM ".DBP."termekek WHERE id = $id");
		
		$armodositok = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termek_armodositok WHERE termek_id = $id");
		$termekxcimke = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termekxcimke WHERE termek_id = $id");
		$termekxkategoria = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termekxkategoria WHERE termek_id = $id");
		$termek_kepek = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termek_kepek WHERE termek_id = $id");
		$jellemzok = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."jellemzok WHERE termek_id = $id");
		
		$termek = (array)$termek;
		unset($termek['id']);
		$ujid = $this->Sql->sqlSave($termek, DBP.'termekek');
		if($armodositok) foreach($armodositok as $armodosito) {
			$armodosito = (array)$armodosito;
			$armodosito['termek_id'] = $ujid;
			$this->Sql->sqlSave($armodosito, DBP.'termek_armodositok');
		}
		
		if($termekxcimke) foreach($termekxcimke as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			$this->Sql->sqlSave($sor, DBP.'termekxcimke');
		}
		if($jellemzok) foreach($jellemzok as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			$this->Sql->sqlSave($sor, DBP.'jellemzok');
		}
		
		if($termekxkategoria) foreach($termekxkategoria as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			$this->Sql->sqlSave($sor, DBP.'termekxkategoria');
		}
		ws_autoload('termek');
		if($termek_kepek) foreach($termek_kepek as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			
			$kep = file_get_contents(FCPATH.$sor['file']);
			$filename = basename($sor['file']);
			
			$tk = new Termekkep_osztaly();
			$termekMappa = $tk->mappakeszites($ujid);
			
			
			$location = $termekMappa.$filename;
			file_put_contents($location, $kep);
			
			
			$sor['file'] = $location;
			
			$this->Sql->sqlSave($sor, DBP.'termek_kepek');
		}
		
		redirect(ADMINURL.'termek/szerkesztes/'.$ujid);
		
	}
	
	/*
	 * szerkesztes
	 * 
	 * termék szerkesztése
	 * terméktörzs, árak, opciók/változatok, kategóriák, cimkék és képek hozzáadása
	 * 
	 * 
	 */
	 
	public function szerkesztes() {
		
		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$this->data['tid'] = $id = (int)$ci->uri->segment(4);
		
		
		
		
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a');
			if($id==0) {
				$id = $this->sqlSave($a, DBP.'termekek');
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, DBP.'termekek', 'id');
			}
			$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
			$foNyelv = current($nyelvek);
			
			
			// jellemzők mentése
			$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
			foreach($nyelvek as $nyelv) {
			
				
				$alapadatok = (isset($_POST['ti'])?$_POST['ti']:array());
				$alapadatok['termek_id'] = $id;
						
				$tabla = DBP.'termek_mezok_'.$nyelv;
				
				if(isset($_POST['tj'][$nyelv])) {
					$alapadatok = array_merge($alapadatok, $_POST['tj'][$nyelv]);
				}
				$van = $this->Sql->sqlSor("SELECT id FROM $tabla WHERE termek_id = $id LIMIT 1");
				if($van) {
					$alapadatok['id'] = $van->id;
					$this->Sql->sqlUpdate($alapadatok, $tabla, 'id');
				} else {
					$this->Sql->sqlSave($alapadatok, $tabla);
				}
				
			}
				
			
			if($ci->input->post('opc')) {
				foreach($ci->input->post('opc') as $opcSor) {
					$opcSor['termek_id'] = $id;
					if($opcSor['nev']=='') {
						$this->ci->db->query("DELETE FROM ".DBP."termek_armodositok WHERE id = {$opcSor['id']} LIMIT 1");
						continue;
					}
					if($opcSor['id']==0) {
						
						$this->sqlSave($opcSor, DBP.'termek_armodositok');
					} else {
						$this->sqlUpdate($opcSor, DBP.'termek_armodositok');
						
					}
					
				}
			}
			
			if($ci->input->post('k')) {
				$termekXKategoriaId = array();
				foreach($ci->input->post('k') as $kategoria_id) {
					$a = array('termek_id' => $id, 'kategoria_id' => $kategoria_id);
					$letezoSor = $this->sqlSor("SELECT id FROM ".DBP."termekxkategoria WHERE termek_id = {$a['termek_id']} AND kategoria_id = {$a['termek_id']}");
					if(!isset($letezoSor->id)) {
						$termekXKategoriaId[] = $this->sqlSave($a, DBP.'termekxkategoria', 'id');
						
					} else {
						$termekXKategoriaId[] = $letezoSor->id;
					}
				}
				$this->db->query("DELETE FROM ".DBP."termekxkategoria WHERE termek_id = $id AND id NOT IN (".implode(",", $termekXKategoriaId).")");
			}
			// cimkék
			$valasztottCimkek = $this->ci->Sql->gets(DBP."termekxcimke", " WHERE termek_id = {$id} ");
			$checked = array();
			if($valasztottCimkek) {
				foreach($valasztottCimkek as $vc) $checked[$vc->id] = $vc->id;
			}
			if($ci->input->post('cimke')) {
				foreach($ci->input->post('cimke') as  $cimkeId => $v) {
					$sql = "SELECT id FROM ".DBP."termekxcimke WHERE termek_id = $id AND cimke_id = $cimkeId";
					$rs = $this->Sql->sqlSor($sql);
					if(isset($rs->id)) {
						unset($checked[$rs->id]);
					} else {
						// nincs felvive
						$a = array('termek_id' => $id, 'cimke_id' => $cimkeId);
						$this->Sql->sqlSave($a, DBP.'termekxcimke');
					}
				}
			}
			// maradék
			if(!empty($checked)) {
				foreach($checked as $maradekCimke) {
					$this->ci->db->query("DELETE FROM ".DBP."termekxcimke WHERE id = ".$maradekCimke);
				}
			}
			
			
			// képek
			if($ci->uri->segment(4)==0) {
				include_once('osztaly/osztaly_termekkep.php');
				$tk = new Termekkep_osztaly();
				$termekMappa = $tk->kepathelyezes($id);
				
				
			}
			
			
			redirect(ADMINURL.'termek/lista');
			//die();
		}
		
		$this->data['lista'] = $ci->Sql->kategoriaFa(0);
		$sor = $this->data['sor'] = new Termek_osztaly($id);
		$this->data['termekXKategoria'] = $this->getsIdArr(DBP.'termekxkategoria', 'kategoria_id', ' WHERE termek_id = '.$id.' ');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Termékek', 'url' => 'termek/lista' ), array('felirat' => 'Termékszerkesztés')));
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Termék szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/lista', 'felirat' => 'Vissza'));
		
		$ALG->urlapStart(array('attr' => 'method="post" onsubmit="return false;" id="termekForm" class="termekForm"'));
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim("Termék törzsadatok");
		
		$input1 = new Szovegmezo(array('attr'=> ' id="cikkszamertek"  ', 'nevtomb'=>'a', 'mezonev' => 'cikkszam', 'felirat' => 'Cikkszám', 'ertek' => @$sor->cikkszam));
		$gomb = new Urlapgomb(array('attr' => 'class="btn" onclick="aJs.cikkszamGeneralas();" ', 'nevtomb'=>'', 'mezonev' => '', 'felirat' => 'Automatikus cikkszám generálás', 'ertek' => 'Generál'));
		
		$doboz->duplaInput($input1, $gomb);
		
		$input1 = new Szovegmezo(array('attr' => ' onchange="aJs.bruttoSzamitas();" id="arertek" ' ,'nevtomb'=>'a', 'mezonev' => 'ar', 'felirat' => 'Ár (nettó)', 'ertek' => @$sor->ar));
		$input2 = new Szovegmezo(array('attr' => '' ,'nevtomb'=>'a', 'mezonev' => 'eredeti_ar', 'felirat' => 'Eredeti ár (nettó)', 'ertek' => @$sor->eredeti_ar));
		
		$doboz->duplaInput($input1, $input2);
		
		$afak = array();
		$rs = $this->Sql->sqlSorok("SELECT * FROM afaertekek ORDER BY nev ASC");
		foreach($rs as $afasor) $afak[(string)$afasor->ertek] = $afasor->nev;
		
		$select1 = new Legordulo(array('attr' => ' onchange="aJs.bruttoSzamitas();" id="afaertek" ' , 'nevtomb'=>'a', 'mezonev' => 'afa', 'felirat' => 'Áfaosztály', 'ertek' => @$sor->afa, 'opciok' => $afak)) ;
		$brutto = 0;
		if(isset($sor->ar)) {
			if($sor->afa!=0) {
				$brutto = $sor->ar + (($sor->ar/100)*$sor->afa);
			}
		}
		$input = new Szovegmezo(array('nevtomb' => '', 'mezonev' => 'brutto', 'felirat' => 'Bruttó érték', 'ertek' => $brutto, 'attr' => ' onchange="aJs.nettoSzamitas();" id="bruttoertek" '));
		
		$doboz->duplaInput($select1, $input);
		
		$gyartok = array('0' => 'Nincs megadva');
		$rs = $this->Sql->sqlSorok("SELECT * FROM ".DBP."gyartok ORDER BY nev ASC");
		foreach($rs as $gyartosor) $gyartok[(string)$gyartosor->id] = $gyartosor->nev;
		$select1 = new Legordulo(array('attr' => '' , 'nevtomb'=>'a', 'mezonev' => 'gyarto_id', 'felirat' => 'Gyártó', 'ertek' => @$sor->gyarto_id, 'opciok' => $gyartok)) ;
		$select2 = new Legordulo(array('nevtomb'=>'a', 'mezonev' => 'aktiv', 'felirat' => 'Megjelenítve', 'ertek' => @$sor->aktiv, 'opciok' => array('0' => 'NEM', '1' => 'Igen'))) ;
		
		$doboz->duplaInput($select1, $select2);
		
		// termékcsoport
		$csoportok = array();
		$rs = $this->Sql->sqlSorok("SELECT * FROM termek_csoportok ORDER BY nev ASC");
		foreach($rs as $csoport) $csoportok[(string)$csoport->id] = $csoport->nev;
		
		$select1 = new Legordulo(array('attr' => ' onchange="aJs.jellemzoBetoltes($(this).val(), '.(int)(@$sor->id).');" id="jellemzotipus" ' , 'nevtomb'=>'a', 'mezonev' => 'termek_csoport_id', 'felirat' => 'Termékcsoport', 'ertek' => @$sor->termek_csoport_id, 'opciok' => $csoportok)) ;
		$doboz->szimplaInput($select1);
		if(isset($sor->termek_csoport_id)) {
			$this->data['termek_csoport_id'] = $sor->termek_csoport_id;
		} else {
			// vesszük az első csoportot
			$this->data['termek_csoport_id'] = $rs[0]->id;	
		}
		
		$doboz->HTMLHozzaadas('<hr><br><div id="jellemzo_szerkeszto">'.$this->load->view(ADMINTEMPLATE.'html/jellemzoformbuilder', $this->data, true).'</div><hr>');
		
		$doboz->HTMLHozzaadas($this->load->view(ADMINTEMPLATE.'html/termekszerkeszto_kategoriak', $this->data, true).'<hr>');
		$this->data['cimkelista'] = $this->ci->Sql->gets(DBP."termek_cimkek", " WHERE mukodesi_mod = 'manualis' ORDER BY nev ASC, nyelv ASC");
		$valasztottCimkek = $this->ci->Sql->gets(DBP."termekxcimke", " WHERE termek_id = {$sor->id} ");
		$checked = array();
		if($valasztottCimkek) {
			foreach($valasztottCimkek as $vc) $checked[$vc->cimke_id] = 1;
		}
		$this->data['checked'] = $checked;
		$doboz->HTMLHozzaadas($this->load->view(ADMINTEMPLATE.'html/termekszerkeszto_cimkek', $this->data, true));
		if(beallitasOlvasas('termek_valtozat_opcio_engedelyezes')=='1') {
			$doboz->HTMLHozzaadas('<hr><div class="valtozat_es_opcio"></div>');
		}
		$doboz->HTMLHozzaadas($this->load->view(ADMINTEMPLATE.'html/termekszerkeszto_kepfeltoltes', $this->data, true));
		$doboz->HTMLHozzaadas($this->load->view(ADMINTEMPLATE.'html/termekszerkeszto_javascript', $this->data, true));
		$doboz->HTMLHozzaadas("<script>var tid = ".$this->data['tid']."</script>");
		
		
		$ALG->tartalomDobozVege();
		
		$ALG->urlapGombok(array(
			array('osztaly' => 'btn-ok', 'onclick' => "document.forms[0].submit();", 'felirat' => 'Űrlap rögzítése', 'tipus' => 'button', 'link' => ''),
		));
		$ALG->urlapVege();
		
		return $ALG->kimenet();
		
	}
	function jellemzoform() {
		ws_autoload('termekek');
		$ALG = new Adminlapgenerator;
		$doboz = $ALG->ujDoboz();
		$termek = $this->Sql->get((int)$this->ci->uri->segment(4), DBP."termekek", 'id');
		$this->data['sor'] = new Termek_osztaly($termek->id);
		$this->data['termek_csoport_id'] = $_GET['csoportid'];
		
		
		$doboz->HTMLHozzaadas($this->load->view(ADMINTEMPLATE.'html/jellemzoformbuilder', $this->data, true));
		print $doboz->tartalomKimenet();
	}
	/*
	 * imageupload
	 * 
	 * ajax képfeltöltés
	 * 
	 */
	 
	 
	// képfeltöltés
	public function imageupload() {
		$tid = $this->ci->uri->segment(4);
		
		include_once('osztaly/osztaly_termekkep.php');
		$tk = new Termekkep_osztaly();
		$termekMappa = $tk->mappakeszites($tid);
		
		
		// postként jön D&D képként?
		if(isset($_POST['file'])) {
			// igen
			$filename = date('YmdHi').rand(1000,9999).'.jpg';
			$location = $termekMappa.$filename;
			
			$imageData = base64_decode(str_replace('data:image/jpeg;base64,', '', $_POST['file']));
			$source = imagecreatefromstring($imageData);
			if(imagejpeg($source, FCPATH.$location)) {
				$a = array('file' => $location, 'termek_id' => $tid);
				$this->Sql->sqlSave($a, DBP.'termek_kepek');
				
				$this->keplista();
				return;
				
			
			}
			
			print 0;
			
			
			return;
		}
		/**
		 * 
		 $file = str_replace('data:image/jpeg;base64,','', $_POST['file']);
			print $file;
			$source = imagecreatefromstring($file);
			if(imagejpeg($source, FCPATH.$location)) {
				$a = array('file' => $location, 'termek_id' => $tid);
				$this->Sql->sqlSave($a, 'termek_kepek');
				
				$this->keplista();
				return;
				
				
			}
			print 0;
			
			return;
		 */
		
		
		$filename = strToUrl(ws_withoutext($_FILES['file']['name'])).'.'.strtolower(ws_ext($_FILES['file']['name']));
		$location = $termekMappa.$filename;
		
		$uploadOk = 1;
		$imageFileType = pathinfo( $_FILES['file']['name'],PATHINFO_EXTENSION);

		// Check image format
		$imageFileType = strtolower($imageFileType);
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			$uploadOk = 0;
		}
		
		if($uploadOk == 0){
			echo 0;
		}else{
			 /* Upload file */
			 if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				$a = array('file' => $location, 'termek_id' => $tid);
				$this->Sql->sqlSave($a, DBP.'termek_kepek');
				
				$this->keplista();
			}else{
				echo 0;
			}
		}
		
	}
	// adott levél kéének törlése
	
	/*
	 * keptorles
	 * 
	 * ajax képtörlés (terméklapról)
	 * 
	 */
	 
	
	function keptorles() {
		include_once('osztaly/osztaly_termekkep.php');
		
		$kepid = $_POST['kep'];
		
		$tk = new Termekkep_osztaly();
		$tk->kepTorles($kepid);
		
	}
	
	/*
	 * keplista
	 * 
	 * ajax képlista (terméklapra)
	 * 
	 */
	function keplista() {
		include_once('osztaly/osztaly_termekkep.php');
		$tk = new Termekkep_osztaly();
		
		$tid = $this->ci->uri->segment(4);
		$lista = $tk->teljesKeplista($tid);
		foreach($lista as $k => $v) {
			$lista[$k]->file = ws_image($v->file,'mediumboxed');
		}
		
		print json_encode($lista);
	}
}
