<?php

/*

$modulAdatok[] = (object)array(

	'eleresek' => array('webshopadmin' => 'index'),

	'nev' => 'admin'

);

* */

$tartalomkezeloAdatok['post/postmegjelenites'] = array(

	'cim' => 'Szöveges tartalom megjelenítése'

);
$tartalomkezeloAdatok['post/blogoldal'] = array(

	'cim' => 'Blogoldal',
	'jogkorok' => JOG_SUPERADMIN

);


$keresesiPontok[] = 'post/postmegjelenites/kereses';

include_once('fuggvenyek.php');
