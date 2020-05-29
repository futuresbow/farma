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
			$lista[$k]->termekdb = $ci->Sql->getFieldValue("SELECT COUNT(x.id) as ossz FROM ".DBP."termekxkategoria x , ".DBP."termekek t WHERE t.aktiv = 1 AND t.id = x.termek_id AND x.kategoria_id = {$v->id} ", 'ossz');
			
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
