<?php

class Frontendlapok extends MY_Modul {
	
	
	public function fooldalitartalmak($param=null) {

		$ci = getCI();
		globalisMemoria('bodyclass', 'home');
		naplozo('Főoldal megtekintése');
		return $this->ci->load->view(FRONTENDTEMA.'html/fooldal', array('param' => $param), true);

	}
	
	
	public function termeklistatartalmak($param=null) {

		$ci = getCI();
		naplozo('Terméklista megtekintése');
		return $this->ci->load->view(FRONTENDTEMA.'html/termeklistaoldal', array(), true);

	}
}
