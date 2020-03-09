<?php
/*
$modulAdatok[] = (object)array(
	'eleresek' => array('webshopadmin' => 'index'),
	'nev' => 'admin'
);
* */
$tartalomkezeloAdatok['rendelesek/rendelesmegjelenites/lista'] = array(

	'cim' => 'Felhasználó saját rendelései',
	'jogkorok' => JOG_SUPERADMIN

);

$hookBelepesipontok = globalisMemoria('hookBelepesipontok');
$hookBelepesipontok['rendeles.statuszvaltozas'][] = 'rendelesek/rendelesek_admin/megrendelesStatuszvaltozasHook';
globalisMemoria('hookBelepesipontok' , $hookBelepesipontok);
$beepulok[] = 'rendelesek/rendelesmegjelenites/letoltes';
