<?php

class Frontendlapok_admin {
	function  frontendlapokfooldalitartalmak_beallito ($param, $ALG) {
		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Főoldal beállítása', 2);

		

		$input1 = new Szovegmezo(array('attr' => '', 'nevtomb' => 'a', 'mezonev' => 'termekdarab', 'felirat' => 'Termék sliderben megjelenítendő termékek száma', 'ertek'=> @$param['termekdarab']));

		
		$doboz->szimplaInput($input1);

		
		

		
		return true;
	}
}
