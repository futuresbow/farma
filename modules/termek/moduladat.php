<?php
/*
$modulAdatok[] = (object)array(
	'eleresek' => array('webshopadmin' => 'index'),
	'nev' => 'admin'
);
* */
$tartalomkezeloAdatok['termek/termeklista'] = array(
	'cim' => 'Termékoldal',
	'jogkorok' => JOG_SUPERADMIN,
);
$tartalomkezeloAdatok['termek/termeklista/cimketermeklista'] = array(
	'cim' => 'Termékek listázása cimke alapján'
);/*
 * 
 * HONDÁS TARTALOM
$tartalomkezeloAdatok['termek/termeklista/sliderlista'] = array(
	'cim' => 'Termék kiemelés listák',
);
*/
$tartalomkezeloAdatok['termek/termeklista/termeklap'] = array(
	'cim' => 'Terméklap megjelenítése',
	'jogkorok' => JOG_SUPERADMIN,
);
$tartalomkezeloAdatok['termek/rendelesek/kosar'] = array(
	'cim' => 'Kosár oldal megjelenítése',
	'jogkorok' => JOG_SUPERADMIN,
);
$tartalomkezeloAdatok['termek/termeklista/fooldaliszurowidget'] = array(

	'cim' => 'Főoldali termékszűrő widget',
	'jogkorok' => JOG_SUPERADMIN,

);
$tartalomkezeloAdatok['termek/termeklista/fooldalitermekek'] = array(

	'cim' => 'Főoldali terméklisták',
	'jogkorok' => JOG_SUPERADMIN,

);

$beepulok[] = 'termek/rendelesek/kosarajax';
$keresesiPontok[] = 'termek/termeklista/kereses';

