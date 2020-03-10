<?php

class Kategoriak_osztaly extends MY_Model{
	
	public function kategoriaLista($limit = 11, $order = '') {
		$ci = getCI();		if ($order != '') $order = ' ORDER BY '.$order;
		$lista = $ci->Sql->gets(DBP."kategoriak", $order.' LIMIT '.$limit);
		return $lista;
	}
	public function kategoriaFa() {
		$ci = getCI();
		$lista = $ci->Sql->kategoriaFa(0);
		if($lista)foreach($lista as $k => $v) {
			$lista[$k]->termekdb = $ci->Sql->getFieldValue("SELECT COUNT(*) as ossz FROM ".DBP."termekxkategoria WHERE kategoria_id = {$v->id} ", 'ossz');
			
		} else {			$lista = array();		}
		
		return $lista;
	}
	
	public function gyermekKategoriak($kategoriaId = 0) {
		return $this->gets(DBP.'kategoriak', ' WHERE szulo_id = '.$kategoriaId." ORDER BY nev ASC");
	}
	
	public function kategoriaSzegmens($szegmens) {
		$kategoria = $this->sqlSor("SELECT * FROM ".DBP."kategoriak WHERE slug = '$szegmens' LIMIT 1");
		
		if($kategoria) {
			return $kategoria;
		} else {
			return false;
		}
	}
}
