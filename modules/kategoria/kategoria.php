<?php

class Kategoria extends MY_Modul{
	
	
	public function __construct() {
		parent::__construct();
		include_once(FCPATH.'modules/termek/osztaly/osztaly_kategoria.php');
	}
	
	
	public function szurowidget_termeklista() {
		$ci = getCI();
		$kategoriak = new Kategoriak_osztaly();
		$data['lista'] = $kategoriak->kategoriaFa();
		
		return $ci->load->view(FRONTENDTEMA.'html/kategoria_widget_termeklista', $data, true);
	}
}
