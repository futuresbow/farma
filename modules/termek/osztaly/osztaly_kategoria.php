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
			//$lista[$k]->termekdb = $ci->Sql->getFieldValue("SELECT COUNT(x.id) as ossz FROM ".DBP."termekxkategoria x , ".DBP."termekek t WHERE t.aktiv = 1 AND t.id = x.termek_id AND x.kategoria_id = {$v->id} ", 'ossz');			$arr = $this->kategoriaOsszesAltermek($v->id);			//print_r($arr);						$lista[$k]->termekdb = count($arr);			
			
		} else {			$lista = array();		}
		
		return $lista;
	}	public function kategoriaOsszesAltermek($kategoriaId,  $idArr = [] ) {		$ci = getCI();						$sql = "SELECT id FROM ".DBP."kategoriak WHERE szulo_id = ".$kategoriaId." ";		$alKat = $ci->Sql->sqlSorok($sql);				if($alKat) {			foreach($alKat as $alKategoria) {				 $arr = $this->kategoriaOsszesAltermek($alKategoria->id, $idArr);				 if(is_array($arr)) {					 foreach($arr as $tid) {						if(!isset($idArr[$tid])) {							$idArr[$tid] = $tid;						}					}					 				 }				 			}		} 				$termekek = $ci->Sql->sqlSorok("SELECT t.id  FROM ".DBP."termekxkategoria x , ".DBP."termekek t WHERE t.aktiv = 1 AND t.id = x.termek_id AND x.kategoria_id = {$kategoriaId} ");		if($termekek) {			foreach($termekek as $termek) {				if(!isset($idArr[$termek->id])) {					$idArr[$termek->id] = $termek->id;				}			}		}				return $idArr;	}
	
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
