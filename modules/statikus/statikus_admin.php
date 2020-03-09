<?php

class Statikus_admin extends MY_Modul{
	var $data = array();
		public function megjelenitesindex_ellenorzes($adat) {
		
		$param = unserialize($adat['parameter']);
		
		
		$adat['elemnev'] = "HTML megjelenítés: ".$param['filenev'];
		return $adat;
	}
	
	public function  megjelenitesindex_beallito($param, $ALG) {
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Statikus file név megadása', 2);
		

		$input1 = new Szovegmezo(array('attr' => '', 'nevtomb' => 'a', 'mezonev' => 'filenev', 'felirat' => 'File neve? ([témakönyvtár]/html/[filenév])', 'ertek'=> @$param['filenev']));

		$doboz->szimplaInput($input1);
		

		
		return true;
	}
	
	
}

