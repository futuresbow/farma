<?php
		
class Vasarlo_osztaly extends MY_Model {
	public $regisztraltFelhasznalo = false;
	public $legutolsoVasarlasFelhasznalo = false;
	
	function __construct($id = false) {
		if(!$id) return false;
		$vasarlo = $this->get($id , DBP.'rendeles_felhasznalok', 'id');
		if($vasarlo) {
			foreach($vasarlo as $k => $v) $this->$k =  $v;
		} else {
			return false;
		}
		if($vasarlo->felhasznalo_id!=0) {
			$this->regisztraltFelhasznalo = $this->get($vasarlo->felhasznalo_id, DBP.'felhasznalok', 'id');
			$this->legutolsoVasarlasFelhasznalo = $this->sqlSor("SELECT *  FROM ".DBP."rendeles_felhasznalok WHERE felhasznalo_id = {$vasarlo->felhasznalo_id} AND $id != {$vasarlo->id} ORDER BY ido DESC");
		}
		
	}
	
	function legfrissebbErtek($kulcs) {
		if($this->$kulcs!='') return $this->$kulcs;
		if($this->legutolsoVasarlasFelhasznalo) return $this->legutolsoVasarlasFelhasznalo->$kulcs;
		return '';
	}
		
}
