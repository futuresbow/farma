<?php

class Megjelenites extends MY_Modul{
	
	public function index($param = false) {		naplozo('Statikus oldal megtekintése');
		if(isset($param['filenev'])) {
			if(file_exists(FCPATH.TEMAMAPPA.'/'.FRONTENDTEMA.'html/'.$param['filenev'])) {
				return $this->ci->load->view(FRONTENDTEMA.'html/'.$param['filenev'], array(), true);
			}			else 
			{
				return '<b>FILE hiányzik: </b>'.FRONTENDTEMA.'html/'.$param['filenev'].'<br><br>';
			}
		} else {
			return '<b>Nincs oldal beállítva</b>';
		}
	}

}
