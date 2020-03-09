<?php
/*
$modulAdatok[] = (object)array(
	'eleresek' => array('webshopadmin' => 'index'),
	'nev' => 'admin'
);
* */
$tartalomkezeloAdatok['felhasznalok/felhasznalok/regisztracio'] = array(
	'cim' => 'Regisztráció',
	'jogkorok' => JOG_SUPERADMIN
);
$tartalomkezeloAdatok['felhasznalok/felhasznalok/fiokom'] = array(
	'cim' => 'Fiókom',
	'jogkorok' => JOG_SUPERADMIN
);
$tartalomkezeloAdatok['felhasznalok/felhasznalok/belepes'] = array(
	'cim' => 'Belépés az oldalra',
	'jogkorok' => JOG_SUPERADMIN
);
$tartalomkezeloAdatok['felhasznalok/felhasznalok/adminlogin'] = array(
	'cim' => 'Admin belépés',
	'jogkorok' => JOG_SUPERADMIN
);
$tartalomkezeloAdatok['felhasznalok/felhasznalok/hirlevelfeliratkozas'] = array(
	'cim' => 'Hírlevél feliratkozó',
	'jogkorok' => JOG_SUPERADMIN
);
// hook
$hookBelepesipontok = globalisMemoria('hookBelepesipontok');
$hookBelepesipontok['felhasznalo.beleptetes'][] = 'felhasznalok/felhasznalok/beleptetes_hook';
globalisMemoria('hookBelepesipontok' , $hookBelepesipontok);

// kilépés
$beepulok[] = 'felhasznalok/felhasznalok/kilepes';
