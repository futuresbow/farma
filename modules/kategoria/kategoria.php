<?php

class Kategoria extends MY_Modul{
	
	
	public function __construct() {
		parent::__construct();
		include_once(ROOTPATH.'modules/termek/osztaly/osztaly_kategoria.php');
	}
	
	
	public function kiemeltkategoriak() { 
		$lista = $this->Sql->gets(DBP."kategoriak", ' WHERE kiemeles > 0 ORDER BY kiemeles ASC  ');
		return $this->load->view(FRONTENDTEMA.'html/kiemelt_kategoriak', array('kategoriak' => $lista), true);
	}
	public function szurowidget_termeklista() {
		$ci = getCI();
		$kategoriak = new Kategoriak_osztaly();
		$data['lista'] = $kategoriak->kategoriaFa();
		
		return $ci->load->view(FRONTENDTEMA.'html/kategoria_widget_termeklista', $data, true);
	}
}
