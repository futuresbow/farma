<?php

/***************************************************
 * 
 * termek modul
 * 
 * Az áruház rendszer code modulja
 * 
 * termék adminisztrációs és listázó modulja, valamint tartallmazza a kosár oldal 
 * feladatainak ellátását. 
 * Az áruház legfontosabb osztályait itt tároljuk az osztalyok mappában
 * 
 * A megjelenítésekért a Termeklista osztály a felel
 * 
 */
 
 


/*
$modulAdatok[] = (object)array(
	'eleresek' => array('webshopadmin' => 'index'),
	'nev' => 'admin'
);
* */


/* 
 * Termékoldal oldaltartalmi elem
 */
 

$tartalomkezeloAdatok['termek/termeklista'] = array(
	'cim' => 'Termékoldal',
	'jogkorok' => JOG_SUPERADMIN,
);

/* 
 * Címke szerinti szűrt termékek oldaltartalmi elem
 */

$tartalomkezeloAdatok['termek/termeklista/cimketermeklista'] = array(
	'cim' => 'Termékek listázása cimke alapján'
);

/* 
 * Terméklap oldaltartalmi elem
 */

$tartalomkezeloAdatok['termek/termeklista/termeklap'] = array(
	'cim' => 'Terméklap megjelenítése',
	'jogkorok' => JOG_SUPERADMIN,
);

/* 
 * kosároldal oldaltartalmi elem
 */


$tartalomkezeloAdatok['termek/rendelesek/kosar'] = array(
	'cim' => 'Kosár oldal megjelenítése',
	'jogkorok' => JOG_SUPERADMIN,
);

/* 
 * Widget a főoldalra oldaltartalmi elem
 */


$tartalomkezeloAdatok['termek/termeklista/fooldaliszurowidget'] = array(

	'cim' => 'Főoldali termékszűrő widget',
	'jogkorok' => JOG_SUPERADMIN,

);

/* 
 * Speciális főoldali termékmegelenítő tartalom (általában témánként más)
 */


$tartalomkezeloAdatok['termek/termeklista/fooldalitermekek'] = array(

	'cim' => 'Főoldali terméklisták',
	'jogkorok' => JOG_SUPERADMIN,

);

/*
 * kosár árlekérdezések ajax feldolgozás beépülő
 */
 

$beepulok[] = 'termek/rendelesek/kosarajax';

/*
 * a globális keresőbe delegált termék-kereső
 */


$keresesiPontok[] = 'termek/termeklista/kereses';

