<?php
/*
$modulAdatok[] = (object)array(
	'eleresek' => array('webshopadmin' => 'index'),
	'nev' => 'admin'
);
* */

$hookBelepesipontok = globalisMemoria('hookBelepesipontok');
$hookBelepesipontok['felhasznalo.hirlevelfeliratkozas'][] = 'hirlevel/feliratkozas/ujfeliratkozas_hook';
$hookBelepesipontok['felhasznalo.hirlevelleiratkozas'][] = 'hirlevel/feliratkozas/leiratkozas_hook';
$hookBelepesipontok['felhasznalo.hirlevelemailfeliratkozas'][] = 'hirlevel/feliratkozas/emailfeliratkozas_hook';
globalisMemoria('hookBelepesipontok' , $hookBelepesipontok);
