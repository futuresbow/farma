<?php

function oldalak_adminmenu() {
	$ci = getCI();
	$lista = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."oldal_urlek ORDER BY nev ASC");
	$ret = array();
	if($lista) foreach($lista as $sor) {
		$ret[] = (object)array('felirat' => $sor->nev, 'modul_eleres' => ADMINURL.'oldalak/tartalomepito/'.$sor->id);
	}
	return $ret;
}
