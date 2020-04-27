<?php
defined('ROOTPATH') OR exit('No direct script access allowed');

class Fokontroller extends CI_Controller {
	var $data = array();
	var $nyelvek = array();
	public function __construct() {
		parent::__construct();
		
		// prefic
		
		// élő adatbázis prefix

		// definíciók betöltése
		
		
		$modulok = scandir(ROOTPATH.'modules');
		
		if($modulok) {
			foreach($modulok as $modul) {
				if($modul == '.' or $modul == '..') continue;
					
				$modulKonyvtar = ROOTPATH.'modules/'.$modul.'/';
				if(!@is_dir($modulKonyvtar)) continue;
				if(file_exists($modulKonyvtar.'definiciok.php'))  {
					include($modulKonyvtar.'definiciok.php');
				}
			}
		}
		
		
		
		
		if(defined('MODUL_ARUHAZAK_TELEPITVE')) {
			if(vanTabla('aruhazak')) {
				$beallitas = $this->Sql->sqlSor("SELECT prefix FROM aruhazak WHERE aktiv = 1");
				if($beallitas) {
					defined('DBP') OR define('DBP',$beallitas->prefix);
				} else {
					defined('DBP') OR define('DBP',"");
				}
			} else {
				defined('DBP') OR define('DBP',"");
			}
		} else {
			defined('DBP') OR define('DBP',"");
			
		}
		
		
		include_once(APPPATH.'core/MY_Modul.php');
		if(!$this->session->has_userdata('CMS_NYELV')) {
			// nyelvek
			$this->nyelvek = explode(',', beallitasOlvasas('nyelvek'));
			$this->session->set_userdata('CMS_NYELV',trim($this->nyelvek[0]) );
			
		}
		if(!defined('CMS_NYELV')) define ('CMS_NYELV', $this->session->userdata('CMS_NYELV'));
		if(!defined('BASE_CURR')) define ('BASE_CURR', 'HUF');
		if(!defined('PN_ELO')) define ('PN_ELO', '');
		if(!defined('PN_UTO')) define ('PN_UTO', ' Ft');
		
		if(beallitasOlvasas('oldal_karbantartas')==1) {
			if($this->uri->segment(1)!=beallitasOlvasas('ADMINURL')) {
				print $this->load->view('oldal_karbantartas', false, true);
				exit;
			}
		}
	}
	
	public function index()
	{
		$modulAdatok = ws_moduladatok();
		$beepulok = ws_beepulok();
		
		$seoTartalom = new stdClass();
		$seoTartalom->cim = beallitasOlvasas('soe_fooldali_title');
		$seoTartalom->leiras = beallitasOlvasas('soe_fooldali_description');
		
		globalisMemoria('seoTartalom', $seoTartalom);
		
		
		// beépülők futtatása; mindíg lefutnak, ha oldallekérés történik
		if(!empty($beepulok)) {
			foreach($beepulok as $eleres) {
				
				$modulEleres = explode("/", $eleres);
				$modul = $modulEleres[0];
				$osztaly = $modulEleres[1];
				$metodus = isset($modulEleres[2])?$modulEleres[2]:'index';
				include_once(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php');
				$o = new $osztaly;
				
				$o->{$metodus}();
					
				
			}
		
		}
		if(defined('beepulofuttatas_utan_leall')) return;
		
		// url-hez tartozó oldaltartalmak
		$url = strtolower((string)$this->uri->segment(1));
		$tartalmak = $this->Sql->sqlSorok("SELECT * FROM oldalak WHERE url LIKE '$url' ORDER BY sorrend ASC");
		$seoTartalom = $this->Sql->sqlSor("SELECT seo_title as cim, seo_description as leiras FROM oldal_urlek WHERE url LIKE '$url' ");
		
		if($seoTartalom) globalisMemoria('seoTartalom', $seoTartalom);
		
		/* TODO:
		 * jogosultságkezelés, jelenleg a modulokon belül 
		 * lehet kezelni a jogosultság kérdéseket
		 */
		
		// adott URL-hez tartozó tartalmak iterálása
		if(!empty($tartalmak)) {
			$kimenet = '';
			foreach($tartalmak as $tartalom) {
				
				
				
				
				$modulEleres = explode("/", $tartalom->moduleleres);
				
				// lehet modul/osztaly/metodus
				// lehet modul/osztaly    -> ilyenkor az index metódus fut
				// lehet modul -> ilyenkor a modul osztaly index metódus fut le
				if(!isset($modulEleres[0])) continue;
				if(!isset($modulEleres[2])) $modulEleres[2] = 'index';
				if(!isset($modulEleres[1])) $modulEleres[1] = $modulEleres[0];
				
				
				
				$modul = $modulEleres[0];
				$osztaly = $modulEleres[1];
				$metodus = isset($modulEleres[2])?$modulEleres[2]:'index';
				$ut = ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php';
				
				// ha nincs a modul a rendszerben, kihagyjuk
				if(!file_exists($ut)) continue;
				
				include_once($ut);
				
				if(!class_exists($osztaly)) continue;
				$o = new $osztaly;
				
				if($tartalom->parameter!='') {
					$kimenet .= $o->{$metodus}( unserialize($tartalom->parameter) );
				} else {
					
					$kimenet .= $o->{$metodus}();
				}
			}
			if(isset($_GET['ajax'])) {
				print $kimenet;
				return;
			}
			$this->data['modulKimenet'] = $kimenet;
			
			$tema = FRONTENDTEMA;
			if(globalisMemoria('template_feluliras')) $tema = globalisMemoria('template_feluliras').'/';
			
			
			$this->load->view($tema.'keret_view', $this->data);
			return;
		}
		
		/*
		 * komonens: olyan tartalom, ahol az url-t mereven kódoljuk a modulban, 
		 * pl. áruház, kosár, bizonyos ajax elérések
		 * ha a modul hiányzik, akkor nincs elérés, így itt nem kell figyelni a modul elérhetőségét
		 */ 
		
		if(!empty($modulAdatok)) {
			foreach($modulAdatok as $modulAdat) {
				if(isset($modulAdat->eleresek)) {
					
					if(isset($modulAdat->eleresek[$this->uri->segment(1)])) {
						// modul által lefoglalt URL
						$controllerNev = $modulAdat->nev.'_modul';
						if(file_exists(ROOTPATH.'modules/'.$modulAdat->nev.'/'.$controllerNev.'.php')) {
							include_once(ROOTPATH.'modules/'.$modulAdat->nev.'/'.$controllerNev.'.php');
						} else {
							$controllerNev = $modulAdat->nev;
							include_once(ROOTPATH.'modules/'.$modulAdat->nev.'/'.$controllerNev.'.php');
						}
						
						$m = new $controllerNev;
						$metodus = $modulAdat->eleresek[$this->uri->segment(1)];
						$m->{$metodus}();
						return;
					}
				}
			}
		
		}
		
		
		/* ha nincs semilyen tartalmunk az adott url-en
		 * akkor a 404-es oldalt hívjuk
		 */
		
		$tartalmak = $this->Sql->sqlSorok("SELECT * FROM oldalak WHERE url = '***' ORDER BY sorrend ASC");
		
		
		if(!empty($tartalmak)) {
			$kimenet = '';
			foreach($tartalmak as $tartalom) {
				
				$modulEleres = explode("/", $tartalom->moduleleres);
				$modul = $modulEleres[0];
				$osztaly = $modulEleres[1];
				$metodus = isset($modulEleres[2])?$modulEleres[2]:'index';
				include_once(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php');
				$o = new $osztaly;
				
				if($tartalom->parameter!='') {
					$kimenet .= $o->{$metodus}( unserialize($tartalom->parameter) );
				} else {
					
					$kimenet .= $o->{$metodus}();
				}
			}
			$this->data['modulKimenet'] = $kimenet;
			if(isset($_GET['ajax'])) {
				print $this->data['modulKimenet'];
				return;
			}
			$tema = FRONTENDTEMA;
			if(globalisMemoria('template_feluliras')) $tema = globalisMemoria('template_feluliras').'/';
			header("HTTP/1.1 404 Not Found");
			$this->load->view($tema.'keret_view', $this->data);
			return;
		}
		
	}
}
