<?php

class Tag_osztaly extends MY_Model {
	
	function __construct($id = false) {
		if($id) {
			$tag = $this->get($id, DBP.'felhasznalok', 'id');
			if($tag) {
				foreach($tag as $k => $v) $this->$k = $v;
			}
		}
		
	}
	
	function is($jog) {
		
		if(((int)$this->adminjogok & (int)$jog)>0) return true;
		return false;
	}
	
		function teljesNev() {
		return $this->vezeteknev.' '.$this->keresztnev;
	}
	function monogram() {
		return strtoupper($this->vezeteknev[0].$this->keresztnev[0]);
	}
	
	function vasarloAdatok() {
	
	}
	
}
