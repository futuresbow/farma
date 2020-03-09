<?php

class megjelenites extends MY_Modul{
	
	function index($param) {
		$id = (int)($param['kinezetielemek_id']);
		$sor = $this->ci->Sql->get($id, DBP.'kinezetielemek', 'id');
		
				if(!isset($sor->html)) return '';
		return $sor->html;
	}
}
