<?php


function temak_adminmenu() {
	$lista = ws_temaadatok();
	$ret = array();
	if($lista) foreach($lista as $sor) {
		$ret[] = (object)array('felirat' => $sor['nev'], 'modul_eleres' => ADMINURL.'temak/beallitasok/'.$sor['dir']);
	}
	return $ret;
}
