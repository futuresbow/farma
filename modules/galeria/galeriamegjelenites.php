<?php

class Slidermegjelenites extends MY_Modul{
	
	function index($param) {
		$id = (int)($param['slider_id']);		
		$slider = $this->ci->Sql->get($id, DBP.'sliderek', 'id');
		if(isset($slider->id)) $slider_id = $slider->id; else $slider_id = 0;
		$lista = $this->ci->Sql->gets(DBP.'slider_kepek', ' WHERE slider_id = '.$slider_id.' ORDER BY sorrend ASC ');
		
		return $this->ci->load->view(FRONTENDTEMA.'html/slider', array('lista' => $lista), true);
	}
}
