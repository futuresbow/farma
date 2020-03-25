<?php

class Termeklista extends MY_Modul {
	var $rendezesiModok = array('nev','ar', 'nepszeruseg' );
	
	public function __construct() {
		parent::__construct();
		include_once('autoload.php');
		
	}	
	var $order = ' nev ASC ';
	
	/*
	 * kereses
	 * 
	 * a kereso mudul számára adja a találatokat
	 * 
	 **/
	public function kereses($keresoSzo) {
		ws_autoload('termek');
		$termekListaOsztaly = new Termeklista_osztaly();
		return $termekListaOsztaly->kereses($keresoSzo);
	}
	
	/*
	 * fooldaliszurowidget
	 * 
	 * kategória widger a főoldalra
	 * 
	 **/
	
	public function fooldaliszurowidget($param = false) {
		ws_autoload('termek');
		$kategoriaOsztaly = new Kategoriak_osztaly();
		$kategoriak = $kategoriaOsztaly->kategoriaFa();
		
		return $this->ci->load->view(FRONTENDTEMA.'html/fooldalitermekwidget', array('kategoriak' => $kategoriak), true);

	}
	
	/*
	 * fooldalitermekek
	 * 
	 * a főoldali tartalomhoz adja a terméklistát,
	 * általában widget-ként van meghívva a template-ből
	 * 
	 **/
	
	
	public function fooldalitermekek($param = false) {
		$data = array();
		$db = beallitasOlvasas('termeklista.cimkeszerint.limitdb');
		if(!$db) $db = 5;
		if(isset($param['termekdarab'])) {
			$db = (int)$param['termekdarab'];
		}
		$termekListaOsztaly = new Termeklista_osztaly();
		// mereven kódolom most a cimke id-ket.
		
		$data['akciostermekek'] = $termekListaOsztaly->termekekCimkeszerint(AKCIOSTERMEKCIMKE_ID, $db) ;
		$data['kiemelttermekek'] = $termekListaOsztaly->termekekCimkeszerint(KIEMELTTERMEKCIMKE_ID, $db) ;
		
		return $this->ci->load->view(FRONTENDTEMA.'html/fooldalitermeklista', $data, true);

	}
	
	/*
	 * cimketermeklista
	 * 
	 * adott cimkéhez (pl akcós) rendelt termékek listázása
	 * 
	 **/
	 
	 
	public function cimketermeklista($param = false) {
				$maxTalalatszam = (isset($param['talalatszam'])?$param['talalatszam']:0);
		
		$termekListaOsztaly = new Termeklista_osztaly();		if($maxTalalatszam) $termekListaOsztaly->maximumTalalatszam = $maxTalalatszam;
		$uri = $this->ci->uri->segment(2);		
		if(isset($_GET['dbszam'])) {
			$limit = (int)$_GET['dbszam'];
			if($limit < 12 or $limit > 48) $limit = 12;
			 $this->ci->session->set_userdata('termek_listalimit', $limit);
		}
		$limit = (int) $this->ci->session->userdata('termek_listalimit');
		
		if(!$limit) $limit = 12;
		if(isset($_GET['start'])) $start = (int)$_GET['start']; else  $start = 0;
		
		
		if(isset($_GET['rend'])) {
			$rendezes = $_GET['rend'];
			
			if(in_array($rendezes, $this->rendezesiModok)) {
				$this->ci->session->set_userdata('termek_listarendezes', $rendezes);
				$start = 0;
				
				
			}
			 
		}
		$rendezes = $this->ci->session->userdata('termek_listarendezes');
		
		
		
		if(!$rendezes) $rendezes = current($this->rendezesiModok);
		$termekListaOsztaly->rendezesBeallitas($rendezes);
		
		
		
		
		$kategoriak = array();
		$termekek = $termekListaOsztaly->termekekCimkeszerint($param['cimke_id']) ;		$cimke = $this->Sql->get($param['cimke_id'], DBP."termek_cimkek",'id' );
				if($cimke) {
			naplozo('Termékek megtekintése cimke szerint',$param['cimke_id'],'termek_cimkek', $cimke->nev);
		
			$listacim = $cimke->nev;		
			if($maxTalalatszam>0) {
				// csak adott számú terméket jelenítünk meg
				$termekek = array_slice($termekek, 0,$maxTalalatszam); 
			}
		} else {
			naplozo('Termékek megtekintése cimke szerint',0,'termek_cimkek', 'Cimke nem létezik');
			$listacim = 'Termékek';
			
		}
		return $this->ci->load->view(FRONTENDTEMA.'html/termeklista', array('maxTalalatszam' => $maxTalalatszam, 'rendezes' => $rendezes,'start' => $start, 'limit' => $limit, 'termekdb' => $termekListaOsztaly->talalatszam, 'termekek' => $termekek, 'kategoriak' => $kategoriak, 'listacim' => $listacim ), true);
		
	}
		/*
	 * index
	 * 
	 * a terméklista oldal 
	 * 
	 **/
	
	
	public function index($param = false) {		naplozo('Terméklista megtekintése');
		
		$termekListaOsztaly = new Termeklista_osztaly();		$listacim = 'Termékeink';
		$kategoriaOsztaly = new Kategoriak_osztaly();
		$uri = $this->ci->uri->segment(2);		if(isset($_GET['dbszam'])) {
			$limit = (int)$_GET['dbszam'];
			if($limit < 12 or $limit > 48) $limit = 12;
			 $this->ci->session->set_userdata('termek_listalimit', $limit);
		}
		$limit = (int) $this->ci->session->userdata('termek_listalimit');
		
		if(!$limit) $limit = 12;
		if(isset($_GET['start'])) $start = (int)$_GET['start']; else  $start = 0;		
		
		if(isset($_GET['rend'])) {
			$rendezes = $_GET['rend'];
			
			if(in_array($rendezes, $this->rendezesiModok)) {
				$this->ci->session->set_userdata('termek_listarendezes', $rendezes);
				$start = 0;
				
				
			}
			 
		}
		$rendezes = $this->ci->session->userdata('termek_listarendezes');
		
		
		
		if(!$rendezes) $rendezes = current($this->rendezesiModok);
		$termekListaOsztaly->rendezesBeallitas($rendezes);
		if(isset($_GET['artol'])) $termekListaOsztaly->szukites("SELECT id as tid FROM ".DBP."termekek WHERE (ar+(ar/100) * afa) > ".(int)$_GET['artol']." AND  (ar+(ar/100) * afa) < ".(int)$_GET['arig']  );
		if(isset($_GET['meret'])) {
			
			$jidArr = array();
			
			foreach($_GET['meret'] as $jid => $ertek) {
				$ertekArr[] = $ertek;
			}
			$termekListaOsztaly->szukites("SELECT termek_id as tid FROM ".DBP."jellemzok WHERE ertek_2 IN ('".implode("','", $ertekArr)."') ");
				
		}
		if($uri=='') {
			$kategoriak = $kategoriaOsztaly->gyermekKategoriak();
			$termekek = $termekListaOsztaly->termekek($limit, $start) ;
		} else {
			$termekek = $termekListaOsztaly->kategoriaTermekek($uri, $limit, $start) ;
			$kategoria = $kategoriaOsztaly->kategoriaSzegmens($uri);			
			
			if(!empty($kategoria)) {
				$seoTartalom = globalisMemoria('seoTartalom');

				
				//$seoTartalom = new stdClass();
				$seoTartalom->cim = $kategoria->nev.' kategória - Termékek';
				$listacim = $kategoria->nev.' kategória termékei';
				globalisMemoria('seoTartalom', $seoTartalom);			}
			if(empty($termekek) and empty($kategoria)) {
				// TODO:
				// ez csak akkor legyen igaz, ha az aoldalhoz terméklistát társítottunk
				$kategoriak = $kategoriaOsztaly->gyermekKategoriak();
				$termekek = $termekListaOsztaly->termekek($limit, $start) ;	
			} else  {
			
				$kategoriak =  $kategoriaOsztaly->gyermekKategoriak($kategoria->id);
			}
		} 		$view = 'termeklista';
		if(isset($param['view'])) $view = $param['view']; 
		
		return ws_frontendView('html/'.$view, array('listacim' => $listacim, 'rendezes' => $rendezes,'start' => $start, 'limit' => $limit, 'termekdb' => $termekListaOsztaly->talalatszam, 'termekek' => $termekek, 'kategoriak' => $kategoriak ), true);
		//return $this->ci->load->view(FRONTENDTEMA.'html/'.$view, array('rendezes' => $rendezes,'start' => $start, 'limit' => $limit, 'termekdb' => $termekListaOsztaly->talalatszam, 'termekek' => $termekek, 'kategoriak' => $kategoriak ), true);
		
	}
	/*
	 * sliderlista
	 * 
	 * kiemelt termékek megjelentése bitonyos template-eknél
	 * 
	 **/
	
	public function sliderlista($param) {
		$termekLista = new Termeklista_osztaly();
		return $this->ci->load->view(FRONTENDTEMA.'html/kiemeltlista', array( 'tipus' => $param['tipus'], 'lista' => $termekLista->kiemeltTermekek($param['tipus'], $param['termek_db'])), true);
		
	}
	
	/*
	 * termeklap
	 * 
	 * adott termék megelenítése, árak, kosárba tétel gombok
	 * 
	 **/

	public function termeklap() {
		$termekLista = new Termeklista_osztaly();
		$termekUrl = $this->ci->uri->segment(2);
		if($termekUrl=='') {
			redirect('404');
		}
		$adat =  explode('-', $termekUrl);
		
		$id = (int)$adat[0];
		$termek = new Termek_osztaly($id);		
		if(!isset($termek->id)) redirect(base_url());
		naplozo('Termék megtekintése', $id, 'termek', $termek->jellemzo('Név')." - ".$termek->cikkszam);
		
		
		$seoTartalom = new stdClass();
		$seoTartalom->cim = $termek->jellemzo('Név').' - Termékek';
		$arr = (explode("||", wordwrap(strip_tags($termek->jellemzo('Leírás')),200,'||')));
		$leiras = $arr[0];
		if(isset($arr[1])) $leiras .= '...';
		$seoTartalom->leiras = $leiras;
		
		globalisMemoria('seoTartalom', $seoTartalom);
				return ws_frontendView('html/termeklap', array('termek' => $termek), true);
		//return $this->ci->load->view(FRONTENDTEMA.'html/termeklap', array('termek' => $termek), true);
		
	}
}
