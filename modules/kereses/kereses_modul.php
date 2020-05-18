<?php

class Kereses_modul extends MY_Modul {
	public function index() {
		
		$data['keresoSzo'] = $keresoSzo = urldecode($this->ci->uri->segment(2));
		
		naplozo('Keresés', 0, '',$keresoSzo);
		
		global $keresesiPontok;
		if(empty($keresesiPontok)) ws_moduladatok();
		$eredmenyek = array();
		foreach($keresesiPontok as $eleres) {
			$eleres = explode('/', $eleres);
			if(@$eleres[0]=='' or @$eleres[1]=='' or @$eleres[2]=='') continue;
			include_once(ROOTPATH.'modules/'.$eleres[0].'/'.$eleres[1].'.php');
			$o = new $eleres[1];
			
			$eredmenyek[$eleres[0].'_'.$eleres[1].'_'.$eleres[2]] = $o->{$eleres[2]}($keresoSzo);
		}
		
		$tema = FRONTENDTEMA;
		$data['modulKimenet'] = $this->load->view($tema.'html/kereses_view', array('keresoSzo' => $keresoSzo, 'eredmenyek' => $eredmenyek), true);
		
		if(globalisMemoria('template_feluliras')) $tema = globalisMemoria('template_feluliras').'/';
		
		$this->load->view($tema.'keret_view', $data);
	}
}
