<?php

class Termek_admin extends MY_Modul{
	var $data = array();
	
	public function __construct() {
		parent::__construct();
		include_once('osztaly/osztaly_termeklista.php');
	}
	
	/*
	 * termek_armodositocsoportlista
	 * 
	 * termék változatok csoportosítása
	 */
	 function armodositocsoportszerkesztes() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();

		$id = (int)$ci->uri->segment(4);

		globalisMemoria('utvonal', array(array('url' => 'termek/armodositocsoportlista', 'felirat' => 'Változatcsoportok') , array('felirat'=> 'Változatcsoportok szerkesztése')));

		

		if($ci->input->post('a')) {

			$a = $ci->input->post('a') ;

			if($id == 0) {

				$this->Sql->sqlSave($a, DBP.'termek_armodositocsoportok');

			} else {

				$a['id'] = $id;

				$this->Sql->sqlUpdate($a, DBP.'termek_armodositocsoportok');

					

			}

			redirect(ADMINURL.'termek/armodositocsoportlista?m='.urlencode("A módosítások rögzítésre kerültek."));

		}

		

		$sor = $this->Sql->get($id, DBP.'termek_armodositocsoportok', 'id');

		

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Változatcsoportok szerkesztése");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/armodositocsoportlista', 'felirat' => 'Vissza') );

		

		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));

		

		$ALG->tartalomDobozStart();

		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Jellemzők', 2);

		

		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));

		$input2 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'nyelv', 'felirat' => 'Nyelv', 'ertek'=> @$sor->nyelv, 'opciok' => array('hu'=>'Magyar')));

		

		$doboz->duplaInput($input1, $input2);

		

		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nevlista', 'felirat' => 'Változatok listája, pontosvesszővel elválasztva', 'ertek'=> @$sor->nevlista));

		
		
		$doboz->szimplaInput($input1);


		$ALG->tartalomDobozVege();

		$ALG->urlapGombok(array(

			0 => array(

				'tipus' => 'hivatkozas',

				'felirat' => 'Mégse',

				'link' => ADMINURL.'termek/armodositocsoportlista',

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
	
	
	
	
	function armodositocsoportlista() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Változatcsoportok listája')));

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Változatcsoportok");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/armodositocsoportszerkesztes/0', 'felirat' => 'Új érték felvitele'));

		

		$ALG->tartalomDobozStart();

		

		// táblázat adatok összeállítása

		$adatlista = array();

		$start = 0;

		$w = '';

		

		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'termek_armodositocsoportok '.$w.' ORDER BY nev ASC ');

		foreach($lista as $sor) {

			

			

		}

		// táblázat beállítás

		$tablazat = $ALG->ujTablazat();

		

		

		$keresoMezok = false;

		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);

		$tablazat->adatBeallitas('szerkeszto_url', 'termek/armodositocsoportszerkesztes/');

		$tablazat->adatBeallitas('torles_url', 'termek/termekcsoporttorles/');

		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név','nyelv' => 'Nyelv','szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));

		
		

		$tablazat->adatBeallitas('lista', $lista);

		

		

		$ALG->tartalomDobozVege();

		return $ALG->kimenet();

		

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
		if(isset($_POST['termekOpcioHozzadas2']))if($_POST['termekOpcioHozzadas2']!='0') {
			$sql = "SELECT * FROM ".DBP."termek_armodositocsoportok WHERE id = ".(int)$_POST['termekOpcioHozzadas2']." LIMIT 1";
			$opcRs = $this->sqlSor($sql);
			unset($_POST['opc']);
			
			$adat = explode(";", $opcRs->nevlista);
			$opc = array() ;
			foreach($adat as $ix => $opcNev) {
				if(trim($opcNev)!="") {
					$arr = (object)array(
						'id' => 0,
						'tipus' => 0,
						'nev' => trim($opcNev),
						'leiras' => '',
						'nyelv' => $opcRs->nyelv,
						'ar' => 0,
						'sorrend' => $ix*10,
						'termek_id' => $id
					);
					$opc[] = $arr;
				}
				
			}
			
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
		$nyelv = $_SESSION['CMS_NYELV'];
		$sql = "SELECT t.id, j.nev , t.* FROM `".DBP."termek_mezok_{$nyelv}` j, ".DBP."termekek t WHERE  j.termek_id = t.id  GROUP BY t.id  ORDER BY nev ASC";
		$this->data['termeklista'] = $this->sqlSorok($sql);
		
		$sql = "SELECT * FROM `".DBP."termek_armodositocsoportok` ORDER BY nev ASC";
		$this->data['amlista'] = $this->sqlSorok($sql);
		
		
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
		
		if($sr) {
			$_SESSION['termekszuro'] = $sr;
		} else {
			if(isset($_SESSION['termekszuro'])){
				$_GET['sr'] = $sr = $_SESSION['termekszuro'];
			}
		}
		
		globalisMemoria('utvonal', array(array('felirat' => 'Termékek listája')));
		$ALG = new Adminlapgenerator;
		
		
		
		
		
		// keresések
		$keresestorles = false;
		$nyelv = $_SESSION['CMS_NYELV'];
		
		if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {
			
			$mod = (int)$sr['keresomezo'];
			
			if($mod!=2)  {
				if($mod==0) $w = ' t.cikkszam LIKE "%'.$sr['keresoszo'].'%" ';
				if($mod==1) $w = ' j.termek_id = t.id AND j.keresostr LIKE "%'.$sr['keresoszo'].'%" ';
				
				if($mod<2) $sql = "SELECT DISTINCT(t.id) FROM ".DBP."termekek t, ".DBP."termek_kereso_$nyelv j WHERE $w";
				
				
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
					unset($_SESSION['termekszuro']);
					redirect(ADMINURL."termek/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
					return;
				}
			} elseif($mod==2) {
				$sql = "SELECT id FROM ".DBP."termek_csoportok WHERE nev LIKE '{$sr['keresoszo']}'";
				$csoport = $this->Sql->sqlSor($sql);
				if(isset($csoport->id)) {
				
					$w = ' t.termek_csoport_id = '.$csoport->id.' AND ';
				} else {
					$tabla = $ALG->ujTablazat();
					$tabla->keresoTorles();
					unset($_SESSION['termekszuro']); 
					redirect(ADMINURL."termek/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
					return;
				}
			
			}
		}
		
		
		
		
		$ALG->adatBeallitas('lapCim', "Termékek");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/szerkesztes/0', 'felirat' => 'Új termék'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		
		$sql = "SELECT t.id FROM  ".DBP."termekek t WHERE $w 1 = 1  ";
		
		$lista = $this->sqlSorok($sql);
		
		foreach($lista as $sor) {
			$termek = new Termek_osztaly($sor->id);
			$sor->nev = '<a target="_blank" title="Előnézet" href="'.$termek->link().'">'.$termek->jellemzo('Név').'</a>';
			if($termek->termekszulo_id!=0) $sor->nev = '<span style="color:#5F00D8">'.$sor->nev.'</span>';
			$sor->cikkszam = $termek->cikkszam;
			$sor->masolas = '<a onclick="if(!confirm(\'Biztosan?\')) return false;" href="'.ADMINURL.'termek/klonozas/'.$sor->id.'">Klónozás</a>';
			$sor->valtozat = '<a  href="'.ADMINURL.'termek/ujvaltozat/'.$sor->id.'">Új változat</a>';
			$adatlista[] = $sor;
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Cikkszám', 'mezonev' => 'cikkszam'),
			array('felirat' => 'Szöveges', 'mezonev' => 'nev'),
			array('felirat' => 'Termékcsoport', 'mezonev' => 'csoport'),
			array('felirat' => 'Cimke', 'mezonev' => 'cimke'),
		);
		
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'termek/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'termek/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'cikkszam' => 'Cikkszám',  'szerkesztes' => 'Szerkesztés',  'valtozat' => 'Változat',  'masolas' => 'Klónozás','torles' => 'Törlés' ));
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
		// bentmaradt jellemzők
		
		$sql = "DELETE FROM ".DBP."termek_kereso_hu WHERE termek_id NOT IN (SELECT id FROM termekek)";
		$ci->db->query($sql);
		$sql = "DELETE FROM ".DBP."termek_mezok_hu WHERE termek_id NOT IN (SELECT id FROM termekek)";
		$ci->db->query($sql);
		
		
		redirect(ADMINURL.'termek/lista?m='.urlencode("Törlés sikeres"));
	}
	
	function egyediCikkszam($cikkszam, $tid = 0) {
		$van = $this->Sql->sqlSor("SELECT cikkszam FROM ".DBP."termekek WHERE id != $tid AND cikkszam = '$cikkszam'");
		if(!$van) return $cikkszam;
		$i = 1;
		while($van) {
			$sql = "SELECT cikkszam FROM ".DBP."termekek WHERE id != $tid AND cikkszam = '{$cikkszam}-{$i}'";
			//print $sql."<br>";
			$van = $this->Sql->sqlSor($sql);
			//var_dump($van);
			if($van) $i++;
		}
		//exit;
		return $cikkszam.'-'.$i;
	}
	/*
	 * ujvaltozat
	 * 
	 * termék változat készítése
	 */
	public function ujvaltozat() {
		$this->klonozas(true);
	}
	/*
	 * klonozas
	 * 
	 * termék többszörözése az adminon.
	 * a klónozás után az új termék szerkesztőjébe ugrik
	 * 
	 */
	public function klonozas($valtozat = false) {
		$ci = getCI();
		$this->data['tid'] = $id = (int)$ci->uri->segment(4);
		$termek = $ci->Sql->sqlSor("SELECT * FROM ".DBP."termekek WHERE id = $id");
		//print_r($termek);
		
		$armodositok = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termek_armodositok WHERE termek_id = $id");
		
		//print_r($armodositok);
		
		
		$termekxcimke = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termekxcimke WHERE termek_id = $id");
		
		//print_r($termekxcimke);
		
		
		$termekxkategoria = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termekxkategoria WHERE termek_id = $id");
		
		//print_r($termekxkategoria);
		
		
		
		$termek_kepek = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."termek_kepek WHERE termek_id = $id");
		
		//print_r($termek_kepek);
		
		
		// TODO többnyelvűsíteni
		$jellemzok = $ci->Sql->sqlSor("SELECT * FROM ".DBP."termek_mezok_hu WHERE termek_id = $id LIMIT 1");
		
		$termek = (array)$termek;
		unset($termek['id']);
		
		$termek['cikkszam'] = $this->egyediCikkszam($termek['cikkszam']);
		if($valtozat) {
			if($termek['termekszulo_id']==0) {
				$termek['termekszulo_id'] = $id;
			}
		}
		$ujid = $this->Sql->sqlSave($termek, DBP.'termekek');
		
		
		$jellemzok = (array)$jellemzok;
		$jellemzok['termek_id'] = $ujid;
		unset($jellemzok['id']);
		$this->Sql->sqlSave($jellemzok, DBP.'termek_mezok_hu', 'id');
		
		
		
		if($armodositok) foreach($armodositok as $armodosito) {
			$armodosito = (array)$armodosito;
			$armodosito['termek_id'] = $ujid;
			unset($armodositok['id']);
			$this->Sql->sqlSave($armodosito, DBP.'termek_armodositok');
		}
		
		if($termekxcimke) foreach($termekxcimke as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			unset($sor['id']);
			$this->Sql->sqlSave($sor, DBP.'termekxcimke');
		}
		
		
		if($termekxkategoria) foreach($termekxkategoria as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			unset($sor['id']);
			$this->Sql->sqlSave($sor, DBP.'termekxkategoria');
		}
		ws_autoload('termek');
		if($termek_kepek) foreach($termek_kepek as $sor) {
			$sor = (array)$sor;
			$sor['termek_id'] = $ujid;
			unset($sor['id']);
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
			
			// gyártó felvitel?
			if(($_POST['gyartonev'])!="") {
				$van = $this->Sql->sqlSor("SELECT id FROM ".DBP."gyartok WHERE nev LIKE '{$_POST['gyartonev']}' LIMIT 1") ;
				if($van) {
					$a['gyarto_id'] = $van->id;
				} else {
					$gyArr = array('nev' => $_POST['gyartonev']);
					$a['gyarto_id'] = $this->Sql->sqlSave($gyArr, DBP.'gyartok');
				}
			}
			
			
			// cikkszám vizsgálat
			$a['cikkszam'] = $this->egyediCikkszam($a['cikkszam'], $id);
			// főtermék kérdés
			if($a['termekszulo_id']!=0) {
				// ha már főtermékvolt, de hozzárendeljük másik főtermékhez, akkor a gyerekek annak a terméknek lesznek a gyerekei:
				$this->db->query("UPDATE ".DBP."termekek SET termekszulo_id = ".$a['termekszulo_id']." WHERE termekszulo_id = ".$id);
				// ha egy gyerekhez rendeljük, azt főtermékké tesszük
				$this->db->query("UPDATE ".DBP."termekek SET termekszulo_id = 0 WHERE id = ".$a['termekszulo_id']);
				
			}
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
				
				// base64 decode
				
				foreach($alapadatok as $k => $v) {
					
					if(strpos($v, 'b64//')!==false) {
						$alapadatok[$k]= base64_decode(str_replace("b64//", "", $v));
					}
				}
				$alapadatok['label_feliratok'] = base64_encode(serialize( ($_POST['jellemzo_felirat'])));
				
				if($van) {
					$alapadatok['id'] = $van->id;
					$this->Sql->sqlUpdate($alapadatok, $tabla, 'id');
				} else {
					$this->Sql->sqlSave($alapadatok, $tabla);
				}
				
			}
			
			
			
			//opciók
			
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
			
			// Kategóriák
			
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
			} else {
				// nincs bejelölve egy sem
				$this->db->query("DELETE FROM ".DBP."termekxkategoria WHERE termek_id = $id ");
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
			
			ws_hookFuttatas('termek.keresostrfrissites', array('id'=> $id ) );
			
			if(isset($_POST['elonezet'])) {
				
				print 'okok';
			} else {
				redirect(ADMINURL.'termek/lista');
				return;
			}
		}
		
		$this->data['lista'] = $ci->Sql->kategoriaFa(0);
		$sor = $this->data['sor'] = new Termek_osztaly($id);
		$this->data['termekXKategoria'] = $this->getsIdArr(DBP.'termekxkategoria', 'kategoria_id', ' WHERE termek_id = '.$id.' ');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Termékek', 'url' => 'termek/lista' ), array('felirat' => 'Termékszerkesztés')));
		
		$ALG = new Adminlapgenerator;
		
		if(@$sor->id>0) {
			$ALG->adatBeallitas('lapCim', "Termék szerkesztése - ".@$sor->jellemzo("Név"));
		} else {
			$ALG->adatBeallitas('lapCim', "Termék szerkesztése");
		}
		
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/lista', 'felirat' => 'Vissza'));
		
		$ALG->urlapStart(array('attr' => 'method="post" onsubmit="return false;" id="termekForm" class="termekForm" enctyle="multipart/form-data"'));
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim("Termék törzsadatok");
		
		// előnézet? nyissuk meg a terméket új tabon
		if(isset($_POST['elonezet'])) {
			$doboz->HTMLHozzaadas("<script>window.open('".$sor->link()."', 'elonezet');</script>");
		}
		
		
		$input1 = new Szovegmezo(array('attr'=> ' id="cikkszamertek"  ', 'nevtomb'=>'a', 'mezonev' => 'cikkszam', 'felirat' => 'Cikkszám', 'ertek' => @$sor->cikkszam));
		$gomb = new Urlapgomb(array('attr' => 'class="btn" onclick="aJs.cikkszamGeneralas();" ', 'nevtomb'=>'', 'mezonev' => '', 'felirat' => 'Automatikus cikkszám generálás', 'ertek' => 'Generál'));
		
		$doboz->duplaInput($input1, $gomb);
		
		// változat
		$this->data['szulo'] = false;
		if(@$sor->termekszulo_id != 0) {
			$this->data['szulo'] = new Termek_osztaly($sor->termekszulo_id);
		}
		$doboz->HTMLHozzaadas('<div id="valtozatvalaszto">'.$this->load->view(ADMINTEMPLATE.'html/valtozatvalaszto', $this->data, true).'</div>');
		
		
		
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
		$input = new Szovegmezo(array('nevtomb' => '', 'mezonev' => 'gyartonev', 'felirat' => 'vagy új gyártó neve', 'ertek' => "", 'attr' => ' "  '));
		
		$doboz->duplaInput($select1, $input);
		
		
		
		// termékcsoport
		$csoportok = array();
		$rs = $this->Sql->sqlSorok("SELECT * FROM ".DBP."termek_csoportok ORDER BY nev ASC");
		foreach($rs as $csoport) $csoportok[(string)$csoport->id] = $csoport->nev;
		
		$select1 = new Legordulo(array('attr' => ' onchange="aJs.jellemzoBetoltes($(this).val(), '.(int)(@$sor->id).');" id="jellemzotipus" ' , 'nevtomb'=>'a', 'mezonev' => 'termek_csoport_id', 'felirat' => 'Termékcsoport', 'ertek' => @$sor->termek_csoport_id, 'opciok' => $csoportok)) ;
		$select2 = new Legordulo(array('attr' => "", 'nevtomb'=>'a', 'mezonev' => 'aktiv', 'felirat' => 'Megjelenítve', 'ertek' => @$sor->aktiv, 'opciok' => array('0' => 'NEM', '1' => 'Igen'))) ;
		
		$doboz->duplaInput($select1,$select2);
		
		if(isset($sor->termek_csoport_id)) {
			$this->data['termek_csoport_id'] = $sor->termek_csoport_id;
		} else {
			// vesszük az első csoportot
			$this->data['termek_csoport_id'] = $rs[0]->id;	
		}
		$this->data['nyelvek'] =  explode(',', beallitasOlvasas('nyelvek'));
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
			array('osztaly' => 'btn-ok', 'onclick' => "aJs.htmlencode();", 'felirat' => 'Mentés és vissza a listához', 'tipus' => 'button', 'link' => ''),
			array('osztaly' => 'btn-ok', 'onclick' => "$(this).parent().append('<input name=elonezet type=hidden value=1 />');aJs.htmlencode();", 'attr' => '  ' , 'felirat' => 'Frissítés és termék megnyitása új lspon', 'tipus' => 'button', 'link' => ''),
		));
		$ALG->urlapVege();
		
		return $ALG->kimenet();
		
	}
	function fotermekkivalasztas() {
		// változat
		
		
		$this->data = array();
		$this->data['szulo'] = false;
		
		$this->data['sor'] = new Termek_osztaly(@$_GET['sajatid']);
		if(@$_GET['sajatid']==@$_GET['id']) $_GET['id'] = 0;
		if(@$_GET['id']!=0) {
			
			
			$t = $this->data['szulo'] = new Termek_osztaly($_GET['id']);
			if($t->termekszulo_id!=0) {
				// módosítás a valódi főtermékre ha az nem a hívó termék
				if($t->termekszulo_id != @$_GET['sajatid']) {
					$this->data['szulo'] = new Termek_osztaly($t->termekszulo_id);
				}
			}
			
		}
		
		$this->load->view(ADMINTEMPLATE.'html/valtozatvalaszto', $this->data);
		return;
	}
	function fotermekvalaszto() {
		
		
		$str = trim(@$_GET['str']);
		if(strlen($str)<3) die("Legalább 3 betű szükséges.");
		ws_autoload('termek');
		$termeklista = new Termeklista_osztaly();
		$lista = $termeklista->kereses($str,10);
		foreach($lista as $sor) {
			$t = new Termek_osztaly($sor['id']);
			print '<div style="clear:both;cursor:pointer;" onclick="aJs.fotermekKivalasztas('.$t->id.', '.$_GET['sajatid'].')">';
			print '<img src="'.base_url().ws_image($t->fokep(),'smallboxed').'" style="float:left;" >';
			print $t->jellemzo('Név').' ('.$t->cikkszam.')';
			print '</div>';
							
		}
	}
	function jellemzoform() {
		ws_autoload('termekek');
		$ALG = new Adminlapgenerator;
		$doboz = $ALG->ujDoboz();
		$termek = $this->Sql->get((int)$this->ci->uri->segment(4), DBP."termekek", 'id');
		$id = 0;
		if($termek) $id = $termek->id;
		$this->data['sor'] = new Termek_osztaly($id);
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
			
			//var_dump(count($_POST['file']));
			
			$filename = date('YmdHi').rand(1000,9999).'.jpg';
			$location = $termekMappa.$filename;
			$imageData = explode(',' , $_POST['file']);
			if(!isset($imageData[1])) return 0;
			$imageData = base64_decode($imageData[1]);
			//file_put_contents(FCPATH.'assets/termekkepek/teszt.jpg', $imageData);
			//print $imageData;
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
	
	// képfeltöltés 2
	public function imageupload2() {
		$tid = $this->ci->uri->segment(4);
		
		include_once('osztaly/osztaly_termekkep.php');
		$tk = new Termekkep_osztaly();
		$termekMappa = $tk->mappakeszites($tid);
		
		
		
		// postként jön D&D képként?
		if(isset($_POST['file'])) {
			// igen
			
			//var_dump(count($_POST['file']));
			
			$filename = date('YmdHi').rand(1000,9999).'.jpg';
			$location = $termekMappa.$filename;
			$imageData = explode(',' , $_POST['file']);
			if(!isset($imageData[1])) return 0;
			$imageData = base64_decode($imageData[1]);
			//file_put_contents(FCPATH.'assets/termekkepek/teszt.jpg', $imageData);
			//print $imageData;
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
	
	/********
	 * termekcsoportlista
	 * 
	 * termék mezők csoportosítása
	 * 
	 */
	function termekcsoportlista() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékcsoportok listája')));

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Termékcsoportok");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/termekcsoportszerkesztes/0', 'felirat' => 'Új érték felvitele'));

		

		$ALG->tartalomDobozStart();

		

		// táblázat adatok összeállítása

		$adatlista = array();

		$start = 0;

		$w = '';

		

		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'termek_csoportok '.$w.' ORDER BY nev ASC ');

		foreach($lista as $sor) {

			

			

		}

		// táblázat beállítás

		$tablazat = $ALG->ujTablazat();

		

		

		$keresoMezok = false;

		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);

		$tablazat->adatBeallitas('szerkeszto_url', 'termek/termekcsoportszerkesztes/');

		$tablazat->adatBeallitas('torles_url', 'termek/termekcsoporttorles/');

		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név','szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));

		
		

		$tablazat->adatBeallitas('lista', $lista);

		

		

		$ALG->tartalomDobozVege();

		return $ALG->kimenet();

		

	}
	
	function termekcsoportszerkesztes() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('url' => 'termek/termekcsoportlista','felirat' => 'Termékcsoportok listája'),array('felirat' => 'Termékcsoport szerkesztés')));

		

		$id = (int)$this->ci->uri->segment(4);

		

		if($this->ci->input->post('a')) {
			$mezok = $this->Sql->gets(DBP.'termek_jellemzok', " ORDER BY nev ASC ");
			$kapcsolok = $this->Sql->getsIdArr(DBP.'termek_csoportxjellemzo',"termek_jellemzo_id", " WHERE termek_csoport_id = ".$id);
			$a = $this->ci->input->post('a');
			$b = $this->ci->input->post('b');
			
			if($id == 0) {

				$id = $this->Sql->sqlSave($a, DBP.'termek_csoportok');

			} else {

				$a['id'] = $id;

				$this->Sql->sqlUpdate($a, DBP.'termek_csoportok');

					

			}

			
			foreach($b as $jellemzo_id => $ertek) {
				if($ertek == 0) {
					if(isset($kapcsolok[$jellemzo_id])) {
						// törölni kell
						$this->db->query("DELETE FROM ".DBP."termek_csoportxjellemzo WHERE id = ".$kapcsolok[$jellemzo_id]->id);
						
					}
				} else {
					if(!isset($kapcsolok[$jellemzo_id])) {
						// fel kell vinni
						$this->db->query("INSERT INTO ".DBP."termek_csoportxjellemzo  SET termek_csoport_id = $id, termek_jellemzo_id = $jellemzo_id");
						
						
					}
					
				}
			}
			redirect(ADMINURL.'termek/termekcsoportlista?m=Sikeres módosítás');

			return;

		}

		

		
		$sor = $this->Sql->get($id, DBP."termek_csoportok", 'id');
		
		

		$ALG = new Adminlapgenerator;

		$ALG->adatBeallitas('lapCim', "Termékcsoport elemeinek szerkesztése");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/termekcsoportlista', 'felirat' => 'Vissza'));

		$ALG->urlapStart(array('attr' => 'method="post" '));

		$ALG->tartalomDobozStart();

		$kapcsolok = $this->Sql->gets(DBP.'termek_csoportxjellemzo', " WHERE termek_csoport_id = ".$id);
		$mezok = $this->Sql->gets(DBP.'termek_jellemzok', " ORDER BY nev ASC ");
		
		$mezoArr = array();
		foreach($mezok as $mezo) {
			$mezo->csatolva = 0;
			$mezoArr[$mezo->id] = $mezo;
		}
		
		if($kapcsolok) foreach($kapcsolok as $kapcsolo) {
			$mezoArr[$kapcsolo->termek_jellemzo_id]->csatolva = 1;
		}
		
		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Termékcsoport', 2);

		

		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$doboz->szimplaInput($input1);

		
		
		$doboz->HTMLHozzaadas($this->ci->load->view(ADMINTEMPLATE."html/termekcsoport_mezok", array('mezoArr' => $mezoArr),true));
		
		
		
		$ALG->tartalomDobozVege();

		$ALG->urlapGombok(array(

			0 => array(

				'tipus' => 'hivatkozas',

				'felirat' => 'Mégsem',

				'link' => ADMINURL.'termek/termekcsoportlista',

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
	
	function termekmezolista() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékmező lista')));
		
		if(isset($_GET['sorrend'])) {
			$idArr = explode(',',$_GET['sorrend']) ;
			$i = 0;
			
			foreach($idArr as $sid) {
				$sid = (int)$sid;
				$this->db->query("UPDATE termek_jellemzok SET sorrend = $i WHERE id = $sid LIMIT 1");
				$i = $i+10;
			}
		}
		
		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Termékmezők");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/termekmezoszerkesztes/0', 'felirat' => 'Új érték felvitele'));

		

		$ALG->tartalomDobozStart();

		

		// táblázat adatok összeállítása

		$adatlista = array();

		$start = 0;

		$w = '';

		

		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'termek_jellemzok '.$w.' ORDER BY sorrend ASC ');

		foreach($lista as $sor) {
			if($sor->keresheto==1) $sor->keresheto = 'Igen'; else $sor->keresheto = 'Nem'; 
			switch($sor->tipus) {
				case 0: 
					$sor->tipus = 'Egész szám';
				break;
				
				case 1: 
					$sor->tipus = 'Nem egész szám';
				break;
				
				case 2: 
					$sor->tipus = 'Rövid szöveg';
				break;
				
				case 3: 
					$sor->tipus = 'Hosszú szöveg';
				break;
				
				
			}
			
			

		}

		// táblázat beállítás

		$tablazat = $ALG->ujTablazat();

		

		

		$keresoMezok = false;

		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);

		$tablazat->adatBeallitas('szerkeszto_url', 'termek/termekmezoszerkesztes/');

		$tablazat->adatBeallitas('torles_url', 'termek/termekmezotorles/');

		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'slug' => 'Db mezőnév','tipus' => 'Típus','keresheto' => 'Keresés','sorrend' => 'Sorrend',  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));

		$tablazat->adatBeallitas('cellaAttr', array('alapertelmezett' => ' style="text-align:center" ' ));

		$tablazat->sorrendezheto();

		$tablazat->adatBeallitas('lista', $lista);

		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Szinkronizálás', 2);
		$doboz->HTMLHozzaadas('<br><a class="btn btn-danger " href="'.ADMINURL.'termek/termekmezoszinkronizalas">Szinkronizálás indítása</a>');

		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Kereső mezők frissítése', 2);
		$doboz->HTMLHozzaadas('<br><a class="btn btn-warning " href="'.ADMINURL.'termek/termekkeresofrissites">Kereső mezők frissítése</a>');


		$ALG->tartalomDobozVege();

		return $ALG->kimenet();
	}
	function termekmezoszinkronizalas() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékmező szinkron')));
		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Termékmező szinkron");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/termekmezolista', 'felirat' => 'Vissza a listához'));

		include('osztaly/osztaly_mezogenerator.php');
		$mg = new Mezogenerator_osztaly;
		
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Szinkronizálás', 2);
		$doboz->HTMLHozzaadas('Szinkron start...<br>');
		
		$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
		$mezok = $this->Sql->gets(DBP.'termek_jellemzok', '');
		foreach($nyelvek as $nyelvKod) {
				$doboz->HTMLHozzaadas('Nyelv: '.$nyelvKod.'<br>');
				
				// tábla mező beolvasása
				$tabla = DBP.'termek_mezok_'.$nyelvKod;
				if(!$mg->letezik($tabla)) {
						$doboz->HTMLHozzaadas('<b style="color:red">Tábla nem létezik: '.$tabla.', létrehoztam!</b><br>');
						$mb->termekLeiroLetrehoz($tabla);
				
				}
				
				$mg->betolt($tabla);
				
				$doboz->HTMLHozzaadas('Tábla megnyitva: '.$tabla.'<br>');
				
				$lepesek = $mg->szinkronizalas($tabla);
				foreach($lepesek as $lepes) {
					$doboz->HTMLHozzaadas('Szinkron: '.$lepes.'<br>');
				
				}
		}
		

		$ALG->tartalomDobozVege();

		return $ALG->kimenet();
	}
	function termekkeresofrissites() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Kereső string frissítés')));
		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Kereső string frissítés");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/termekmezolista', 'felirat' => 'Vissza a listához'));

		
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Kereső string frissítés', 2);
		$doboz->HTMLHozzaadas('Frissítés indul...<br>');
		
		$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
		$mezok = $this->Sql->gets(DBP.'termek_jellemzok', '');
		
		$termekek = $this->Sql->gets(DBP.'termekek');
		
		foreach($termekek as $t) {
			$doboz->HTMLHozzaadas('Termék: '.$t->cikkszam.' ('.$t->id.')  <br>');
			// tábla mező beolvasása
			
			
			ws_hookFuttatas('termek.keresostrfrissites', array('id'=> $t->id ) );
			
			

		}
		
		// feleslegek eltávolítása
		$sql = "DELETE FROM ".DBP."termek_kereso_hu WHERE termek_id NOT IN (SELECT id FROM termekek)";
		$this->db->query($sql);
		$sql = "DELETE FROM ".DBP."termek_mezok_hu WHERE termek_id NOT IN (SELECT id FROM termekek)";
		$this->db->query($sql);
		
		
		
		$ALG->tartalomDobozVege();

		return $ALG->kimenet();
	}
	
	function keresostr_hook($data) {
		$id = $data['id'];
		$nyelvek = explode(',', beallitasOlvasas('nyelvek'));
		$mezok = $this->Sql->gets(DBP.'termek_jellemzok', '');
		$termek = $this->Sql->get($id, DBP.'termekek', 'id');
		
		foreach($nyelvek as $nyelvKod) {
			$tabla = DBP.'termek_mezok_'.$nyelvKod;
					
			$sor = $this->Sql->get($id, $tabla, ' termek_id ');
			
			$str = $termek->cikkszam.' ';
			foreach($mezok as $mezo) {
				if($mezo->keresheto == 0) continue;
				
				$str .= $sor->{$mezo->slug}.' ';
				
			}
			$str = strip_tags($str);
			/*
			 * TODO: ha adott nyelven nincs kereső tábla létrehozhatná autómatikusan
			 */
			$keresoTabla = DBP.'termek_kereso_'.$nyelvKod;
			$van = $this->Sql->get($id, $keresoTabla, ' termek_id ');
			if($van) {
				$a = array('id' => $van->id, 'keresostr' => $str);
				$this->Sql->sqlUpdate($a,$keresoTabla, 'id');
			} else {
				$a = array( 'keresostr' => $str, 'termek_id' => $id);
				$this->Sql->sqlSave($a,$keresoTabla, 'id');
				
			}
		}
		
	}
	
	
	function termekmezoszerkesztes() {
		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();

		$id = (int)$ci->uri->segment(4);

		globalisMemoria('utvonal', array(array('url' => 'termek/termekmezolista', 'felirat' => 'Termék mezők') , array('felirat'=> 'Termék mező szerkesztése')));

		

		if($ci->input->post('a')) {

			$a = $ci->input->post('a') ;

			if($id == 0) {

				$this->Sql->sqlSave($a, DBP.'termek_jellemzok');

			} else {

				$a['id'] = $id;

				$this->Sql->sqlUpdate($a, DBP.'termek_jellemzok');

					

			}

			redirect(ADMINURL.'termek/termekmezolista?m='.urlencode("A módosítások rögzítésre kerültek."));

		}

		

		$sor = $this->Sql->get($id, DBP.'termek_jellemzok', 'id');

		

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Termékmező szerkesztése");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'termek/termekmezolista', 'felirat' => 'Vissza') );

		

		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));

		

		$ALG->tartalomDobozStart();

		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Jellemzők', 2);

		

		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));

		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'slug', 'felirat' => 'Adatbázis mezőnév', 'ertek'=> @$sor->slug));

		

		$doboz->duplaInput($input1, $input2);

		

		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'sorrend', 'felirat' => 'Sorrend', 'ertek'=> @$sor->sorrend));

		$select1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'tipus', 'felirat' => 'Típus', 'ertek'=> @$sor->tipus, 'opciok' => array(0=>'Egész szám', 1=>'Valós szám', 2 => 'Rövid szöveg', 3 => 'hosszú szöveg')));

		
		$doboz->duplaInput($input1,$select1);

		
		$select1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'keresheto', 'felirat' => 'Kereshető tartalom?', 'ertek'=> @$sor->keresheto, 'opciok' => array(0=>'Nem', 1=>'Igen')));

		
		$doboz->duplaInput($select1);

		

		

		

		$ALG->tartalomDobozVege();

		$ALG->urlapGombok(array(

			0 => array(

				'tipus' => 'hivatkozas',

				'felirat' => 'Mégse',

				'link' => ADMINURL.'termek/termekmezolista',

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
	
	function termekmezotorles() {
		$ci = getCI();

		$id = (int)$ci->uri->segment(4);

		
		$van = $this->Sql->sqlSor('SELECT x.id, cs.nev FROM '.DBP.'termek_csoportxjellemzo x, termek_csoportok cs WHERE x.termek_csoport_id = cs.id AND termek_jellemzo_id = '.$id." LIMIT 1");
		if($van) {
			redirect(ADMINURL.'termek/termekmezolista?m='.urlencode('A mező nem törölhető, mert van olyan termékcsoport ('.$van->nev.'), ami tartalmazza ezt a mezőt!!'));
			return;
		}

		$this->db->query("DELETE FROM ".DBP."termek_jellemzok WHERE id =  ".$id);

		redirect(ADMINURL.'termek/termekmezolista?m='.urlencode('Sikeres törlés!'));

		return;
	}
	function termekcsoporttorles() {
		$ci = getCI();

		$id = (int)$ci->uri->segment(4);

		$van = $this->Sql->sqlSor('SELECT id FROM '.DBP.'termekek WHERE termek_csoport_id = '.$id." LIMIT 1");
		if($van) {
			redirect(ADMINURL.'termek/termekcsoportlista?m='.urlencode('A csoport nem törölhető, mert van olyan termék, ami ebbe a csoportba tertozik!'));
			return;
		}
		$this->db->query("DELETE FROM ".DBP."termek_csoportok WHERE id =  ".$id);

		redirect(ADMINURL.'termek/termekcsoportlista?m='.urlencode('Sikeres törlés!'));

		return;
	}
}
