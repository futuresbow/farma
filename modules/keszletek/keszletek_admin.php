<?php

class Keszletek_admin extends MY_Modul{
	var $data = array();
	
	
	public function ajax() {
		$termekId = $_GET['tid'];
		if(isset($_GET['keszlet'])) {
			$keszlet = (int)$_GET['keszlet'];
			$this->ci->db->query("UPDATE ".DBP."termekek SET keszlet = $keszlet WHERE id = $termekId");
			exit;
		}
		
		if(isset($_GET['lefoglalt'])) {
			$lefoglalt = (int)$_GET['lefoglalt'];
			$this->ci->db->query("UPDATE ".DBP."termekek SET lefoglalva = $lefoglalt WHERE id = $termekId");
			exit;
		}
		
		die("0");
	}
	public function darabszam() {
		ws_autoload('termek');
		$valtozatTipusok = $this->Sql->sqlSorok("SELECT DISTINCT(tipus) FROM ".DBP."termek_armodositok WHERE tipus != 1 ");
		$tipusok = array();
		foreach($valtozatTipusok as $sor) $tipusok[] = $sor->tipus;
		
		
		$w = '';
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékkészlet')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Termék darabszám");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		
		$ALG->tartalomDobozStart();
		
		// kereshető lapozható terméklista
		// keresések
		$sr = $this->ci->input->get('sr');
		$nyelv = $_SESSION['CMS_NYELV'];
		$keresestorles = false;
		
		if( isset( $_SESSION['keszlet_sr'] )) {
			if(!isset($sr['keresoszo'])) {
				$sr = $_SESSION['keszlet_sr'];
			}
		}
		
		
		if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {
			$_SESSION['keszlet_sr'] = $sr;
			$mod = (int)$sr['keresomezo'];
			if($mod==0) $w = ' t.cikkszam LIKE "%'.$sr['keresoszo'].'%" ';
			$sql = "SELECT DISTINCT(t.id) FROM ".DBP."termekek t, ".DBP."termek_mezok_{$nyelv} j WHERE t.id = j.termek_id AND $w";
			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');
			//print($sql);
			//exit;
			if($idArr) {
				$w = "  t.id IN (".implode(',', $idArr).") AND ";
				
			} else {
				$w = "  t.id = -1 AND ";
				
			}
		}
		$ci = getCI();
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$limit = 10;
		$sql = "SELECT COUNT( DISTINCT(t.id)) as ossz FROM `".DBP."termek_mezok_{$nyelv}` j, ".DBP."termekek t WHERE  $w j.termek_id = t.id  ";
		$osszSorok = $this->sqlSor($sql);
		if($start>$osszSorok->ossz) $start = 0;
		$sql = "SELECT t.id, j.nev as nev, t.* FROM `".DBP."termek_mezok_{$nyelv}` j, ".DBP."termekek t WHERE  $w j.termek_id = t.id  GROUP BY t.id  ORDER BY nev ASC LIMIT $start, $limit";
		//die( $sql);
		$lista = $this->sqlSorok($sql);
		
		foreach($lista as $listaIndex => $sor) {
			$termek = new Termek_osztaly($sor->id);
			$id = $sor->id;
			$sor->nev = $termek->jellemzo('Név');
			$adatlista[] = $sor;
			
			// lista
			$valtozatSorok = array();
			foreach($tipusok as $tipus_id) {
				$valtozatSorok[] = $this->Sql->sqlSorok("SELECT * FROM ".DBP."termek_armodositok WHERE termek_id = {$id} AND tipus = $tipus_id ORDER BY nev ASC ");
			}
			
			$adatlista = $this->kombinaciosLista($valtozatSorok);
			
			if(!empty($adatlista)) {
				foreach($adatlista as $kindex => $amSor) {
					$adatlista[$kindex]->id = 0;
					
					$sql = "SELECT * FROM ".DBP."termek_keszletek WHERE termek_id = $id AND ";
					$w = array();
					foreach(explode('_', $amSor->amid) as $k => $amodid) {
						
						$w[] =  " valtozat".($k+1)."_id = ".$amodid." ";
						
					}
					$sql .= implode(' AND ', $w);
					
					$rs = $this->Sql->sqlSor( $sql);
					if(isset($rs->keszlet)) {
						$db = $rs->keszlet;
						$foglalt = $rs->lefoglalt;
						$keszlet_id = $rs->id;
					} else {
						$db = 0;
						$foglalt = 0;
						$keszlet_id = 0;
					}
					$adatlista[$kindex]->db = $db;
					$adatlista[$kindex]->foglalt = $foglalt;
					$adatlista[$kindex]->keszlet_id = $keszlet_id;
					
					
				}
				$lista[$listaIndex]->adatlista = $adatlista;
					
			} else {
				$lista[$listaIndex]->adatlista = false;
			}
			
		}
		// táblázat beállítás
		//print_r($lista);
		if(isset($_GET['ajax'])) {
		
		
		
			
		
		
		
		
		
		
			print ( $ci->load->view('vezerlo/html/darabszam_lista', array('lista' => $lista), true ) );
			return;
		}
		
		
		
		$ALG->tartalomHozzaadas( $ci->load->view('vezerlo/html/darabszam_fej', array(), true ) );
		
		
		$ALG->tartalomDobozVege();
		
		return $ALG->kimenet();
	}
	
	
	public function index() {
		ws_autoload('termek');
		
		$w = '';
		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Termékkészlet')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Termékkészlet");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		
		$ALG->tartalomDobozStart();
		
		// kereshető lapozható terméklista
		// keresések
		$sr = $this->ci->input->get('sr');
		$nyelv = $_SESSION['CMS_NYELV'];
		$keresestorles = false;
		
		if( isset( $_SESSION['keszlet_sr'] )) {
			if(!isset($sr['keresoszo'])) {
				$sr = $_SESSION['keszlet_sr'];
			}
		}
		
		
		if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {
			$_SESSION['keszlet_sr'] = $sr;
			$mod = (int)$sr['keresomezo'];
			if($mod==0) $w = ' t.cikkszam LIKE "%'.$sr['keresoszo'].'%" ';
			if($mod==1) $w = ' j.nev LIKE "%'.$sr['keresoszo'].'%" ';
			if($mod==2) $w = ' j.leiras LIKE "%'.$sr['keresoszo'].'%" ';
			$sql = "SELECT DISTINCT(t.id) FROM ".DBP."termekek t, ".DBP."termek_mezok_{$nyelv} j WHERE t.id = j.termek_id AND $w";
			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');
			//print($sql);
			//exit;
			if($idArr) {
				$w = "  t.id IN (".implode(',', $idArr).") AND ";
				
			} else {
				$tabla = $ALG->ujTablazat();
				$tabla->keresoTorles();
				redirect(ADMINURL."keszletek/keszletek?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
				return;
			}
		}
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		if(isset($_GET['start'])) $start = (int)$_GET['start'];
		$limit = beallitasOlvasas('admin.lapozo.limit');
		$sql = "SELECT COUNT( DISTINCT(t.id)) as ossz FROM `".DBP."termek_mezok_{$nyelv}` j, ".DBP."termekek t WHERE  $w j.termek_id = t.id  ";
		$osszSorok = $this->sqlSor($sql);
		if($start>$osszSorok->ossz) $start = 0;
		$sql = "SELECT t.id, j.nev as nev, t.* FROM `".DBP."termek_mezok_{$nyelv}` j, ".DBP."termekek t WHERE  $w j.termek_id = t.id  GROUP BY t.id  ORDER BY nev ASC LIMIT $start, $limit";
		//die( $sql);
		$lista = $this->sqlSorok($sql);
		
		foreach($lista as $k => $sor) {
			$termek = new Termek_osztaly($sor->id);
			$sor->nev = $termek->jellemzo('Név');
			$adatlista[] = $sor;
			$valtozatTipusok = $this->Sql->sqlSor("SELECT COUNT(id) as ossz FROM ".DBP."termek_armodositok WHERE termek_id = {$sor->id} AND tipus != 1 ");
			$lista[$k]->valtozatszam = $valtozatTipusok->ossz;
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Cikkszám', 'mezonev' => 'cikkszam'),
			array('felirat' => 'Terméknév', 'mezonev' => 'nev'),
			array('felirat' => 'Leírás', 'mezonev' => 'leiras'),
		);
		
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'keszletek/keszletszerkesztes/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'cikkszam' => 'Cikkszám', 'valtozatszam' => 'Változatok',  'szerkesztes' => 'Készlet szerkesztés'));
		$tablazat->adatBeallitas('lista', $adatlista);
		
		$tablazat->lapozo($start, $limit, $osszSorok->ossz);
		
		$ALG->tartalomDobozVege();
		
		return $ALG->kimenet();
	}
	public function keszletszerkesztes() {
		ws_autoload('termek');
		
		globalisMemoria("Nyitott menüpont",'Termékek');
		$this->data['tid'] = $id = (int)$this->ci->uri->segment(4);
		$termek = $this->data['termek'] = new Termek_osztaly($id);
		$valtozatTipusok = $this->Sql->sqlSorok("SELECT DISTINCT(tipus) FROM ".DBP."termek_armodositok WHERE tipus != 1 ");
		$tipusok = array();
		foreach($valtozatTipusok as $sor) $tipusok[] = $sor->tipus;
		$redirect = false;
		// módosítás
		if(is_array($this->ci->input->post('db'))) {
			$arr = $this->ci->input->post('db');
			foreach($arr as $keszlet_id => $db) {
				$a = array('id' => $keszlet_id, 'keszlet' => $db, 'lefoglalt' => $_POST['foglalt'][$keszlet_id]);
				$this->Sql->sqlUpdate($a, 'termek_keszletek');
			}
			$redirect = true;
		}
		
		// új darabszámok felvitele
		if(is_array($this->ci->input->post('ujdb'))) {
			$arr = $this->ci->input->post('ujdb');
			
			foreach($arr as $amod_ids => $db) {
				
				$foglalt = $_POST['ujfoglalt'][$amod_ids];
				
				if($db == 0 and $foglalt == 0) continue;
				
				
				$amod_ids = explode('_',$amod_ids);
				$sql = "INSERT INTO ".DBP."termek_keszletek SET keszlet = $db,lefoglalt = $foglalt,  termek_id = $id , ";
				$w = array();
				foreach($amod_ids as $k => $amodid) {
					
					$w[] =  " valtozat".($k+1)."_id = ".$amodid." ";
					
				}
				$sql .= implode(' , ', $w);
				$this->ci->db->query( $sql) ;
			}
			$redirect = true;
		}
		if($redirect) {
			redirect(ADMINURL.'keszletek/index');
			return;
		}
		
		globalisMemoria('utvonal', array(array('felirat' => 'Készletlista', 'url' => 'keszletek/index' ), array('felirat' => 'Termékkészlet szerkesztése')));
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Készlet szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'keszletek/index', 'felirat' => 'Vissza'));
		
		$ALG->urlapStart(array('attr' => 'method="post" id="termekForm" class="termekForm"'));
		
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim($termek->jellemzo('Név')." készlet megadása");
		$tablazat = $ALG->ujTablazat();
		if(empty($tipusok)) {
			$adatlista = array((object)array(
				'id' => 0, 
				'nev' => $termek->jellemzo('Név'), 
				'db' => '<div class="quantity clearfix">
							<a onclick="aJs.keszletNoveles(this, -1);" href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
							<input type="text" name="" value="999">
							<a onclick="aJs.keszletNoveles(this, 1);" href="javascript:void(0);" title="" class="btn btn-small increase"></a>
						</div>' ));
		} else {
			
			$valtozatSorok = array();
			foreach($tipusok as $tipus_id) {
				$valtozatSorok[] = $this->Sql->sqlSorok("SELECT * FROM ".DBP."termek_armodositok WHERE termek_id = $id AND tipus = $tipus_id ORDER BY nev ASC ");
			}
			
			// rekurzív tömbflépítés a változatok permutálásával...
			$adatlista = $this->kombinaciosLista($valtozatSorok);
			
			foreach($adatlista as $kindex => $sor) {
				$adatlista[$kindex]->id = 0;
				
				$sql = "SELECT * FROM ".DBP."termek_keszletek WHERE termek_id = $id AND ";
				$w = array();
				foreach(explode('_', $sor->amid) as $k => $amodid) {
					
					$w[] =  " valtozat".($k+1)."_id = ".$amodid." ";
					
				}
				$sql .= implode(' AND ', $w);
				$rs = $this->Sql->sqlSor( $sql);
				if(isset($rs->keszlet)) {
					$db = $rs->keszlet;
					$foglalt = $rs->lefoglalt;
					$keszlet_id = $rs->id;
				} else {
					$db = 0;
					$foglalt = 0;
					$keszlet_id = 0;
				}
				
				$adatlista[$kindex]->db = '
						<div class="quantity clearfix">
							<a onclick="aJs.keszletNoveles(this, -1);"  href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
							<input type="text" name="'.($keszlet_id==0?'ujdb['.$sor->amid.']':'db['.$rs->id.']').'" value="'.$db.'">
							<a onclick="aJs.keszletNoveles(this, 1);"  href="javascript:void(0);" title="" class="btn btn-small increase"></a>
						</div>' ;
				$adatlista[$kindex]->foglalt = '
						<div class="quantity clearfix">
							<a onclick="aJs.keszletNoveles(this, -1);"  href="javascript:void(0);" title="" class="btn btn-small decrease"></a>
							<input type="text" name="'.($keszlet_id==0?'ujfoglalt['.$sor->amid.']':'foglalt['.$rs->id.']').'" value="'.$foglalt.'" >
							<a onclick="aJs.keszletNoveles(this, 1);"  href="javascript:void(0);" title="" class="btn btn-small increase"></a>
						</div>' ;
				
				
				
			}
			
			
		}
		
		$tablazat->adatBeallitas('keresoMezok', false);
		$tablazat->adatBeallitas('szerkeszto_url', 'termek/keszletszerkesztes/');
		
		$tablazat->adatBeallitas('megjelenitettMezok', 
			array(
				'nev' => 'Név', 
				'db' => 'Készlet' , 
				'foglalt' => 'Foglalt',
			)
		);
		$tablazat->adatBeallitas('lista', $adatlista);
		$tablazat->adatBeallitas('cellaAttr', array('db' => ' class="quantity-cell" '));
		
		$ALG->tartalomDobozVege();
		
		$ALG->urlapGombok(array(
			array('osztaly' => 'btn-ok', 'felirat' => 'Űrlap rögzítése', 'tipus' => 'submit', 'link' => ''),
		));
		$ALG->urlapVege();
		
		return $ALG->kimenet();
	}
	
	public function kombinaciosLista($valtozatok,  $index = 0) {
		$nevTomb = array();
		foreach($valtozatok[$index] as $sor) {
			if(!empty($valtozatok[$index+1])) {
				$alLista = $this->kombinaciosLista($valtozatok, $index+1);
			}
			if(!empty($alLista)) {
				foreach($alLista as $alSor) {
					$nevTomb[] = (object)array('nev' => $sor->nev.' '.$alSor->nev, 'amid' => $sor->id.'_'.$alSor->amid); 
				}
			} else {
				$nevTomb[] = (object)array('nev' => $sor->nev, 'amid' => $sor->id); 
			}
			
		}
		return $nevTomb;
	}
	
}
