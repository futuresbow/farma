<?php

class Sql extends MY_Model  {
	function __construct(){
		 parent::__construct();
		
	}
	function kategoriaFa($szuloId, $szint = 0) {
		$ret = array();
		$kategoriak = $this->sqlSorok("SELECT *, $szint as szint FROM ".DBP."kategoriak WHERE szulo_id = $szuloId ORDER BY sorrend");
		if($kategoriak) {
			foreach($kategoriak as $kategoria) {
				$ret[] = $kategoria;
				$gyerekek = $this->kategoriaFa($kategoria->id, ($szint+1));
				if($gyerekek) {
					$ret = array_merge($ret, $gyerekek);
				}
			}
			return $ret;
		}
		return false;
	}
}
