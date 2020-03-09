<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fokontroller extends CI_Controller {
	var $data = array();
	var $nyelvek = array();
	public function __construct() {
		parent::__construct();
		
		// prefic
		
		// élő adatbázis prefix

		//defined('DBP') OR define('DBP','');
		$beallitas = $this->Sql->get('db_prefix', "settings", 'kulcs');
		defined('DBP') OR define('DBP',$beallitas->ertek);
		
		
		
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
				include_once(FCPATH.'modules/'.$modul.'/'.$osztaly.'.php');
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
		 * jogosultságkezelés
		 */
		 
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
				include_once(FCPATH.'modules/'.$modul.'/'.$osztaly.'.php');
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
		
		
		if(!empty($modulAdatok)) {
			foreach($modulAdatok as $modulAdat) {
				if(isset($modulAdat->eleresek)) {
					
					if(isset($modulAdat->eleresek[$this->uri->segment(1)])) {
						// modul által lefoglalt URL
						$controllerNev = $modulAdat->nev.'_modul';
						if(file_exists(FCPATH.'modules/'.$modulAdat->nev.'/'.$controllerNev.'.php')) {
							include_once(FCPATH.'modules/'.$modulAdat->nev.'/'.$controllerNev.'.php');
						} else {
							$controllerNev = $modulAdat->nev;
							include_once(FCPATH.'modules/'.$modulAdat->nev.'/'.$controllerNev.'.php');
						}
						
						$m = new $controllerNev;
						$metodus = $modulAdat->eleresek[$this->uri->segment(1)];
						$m->{$metodus}();
						return;
					}
				}
			}
		
		}
		
		
		// alapértelmezett oldal
		$tartalmak = $this->Sql->sqlSorok("SELECT * FROM oldalak WHERE url = '***' ORDER BY sorrend ASC");
		
		
		if(!empty($tartalmak)) {
			$kimenet = '';
			foreach($tartalmak as $tartalom) {
				
				$modulEleres = explode("/", $tartalom->moduleleres);
				$modul = $modulEleres[0];
				$osztaly = $modulEleres[1];
				$metodus = isset($modulEleres[2])?$modulEleres[2]:'index';
				include_once(FCPATH.'modules/'.$modul.'/'.$osztaly.'.php');
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
			
			$this->load->view($tema.'keret_view', $this->data);
			return;
		}
		
	}
}
