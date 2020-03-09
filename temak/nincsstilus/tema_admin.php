<?php
$ci = getCI();
if(isset($_POST['a'])) {
	
	if($_FILES['logokep']['name']!='') {
		$dir = 'assets/tema/';
		if(!is_dir(FCPATH.$dir)) {
			mkdir(FCPATH.$dir,0777);
		}
		$ext = strtolower(ws_ext($_FILES['logokep']['name']));
		
		if($ext=='png' or $ext=='svg' or $ext=='gif' or $ext=='jpg' or $ext=='jpeg'  ) {
			$newName = "ws4_".date('YmdHi').rand(100,999).'.'.$ext;
			if(move_uploaded_file($_FILES['logokep']['tmp_name'], FCPATH.$dir.$newName))
				$_POST['a']['logokep'] = $dir.$newName;
		}
	}
	
	
	foreach($_POST['a'] as $k => $v) {
		$van = $ci->Sql->sqlSor("SELECT * FROM temavaltozok WHERE tema = 'parfum' AND kulcs = '$k' ");
		if(isset($van->id)) {
			$a = array('id' => $van->id, 'kulcs' => $k, 'ertek' => $v, 'tema' => 'parfum');
			$ci->Sql->sqlUpdate($a, 'temavaltozok');
		} else {
			$a = array( 'kulcs' => $k, 'ertek' => $v, 'tema' => 'parfum');
			$ci->Sql->sqlSave($a, 'temavaltozok');
		}
	}
	redirect(ADMINURL.'temak/beallitasok/nincsstilus?m='.urlencode('Módosítás sikeres!'));
}

include 'tema_valtozok.php';



globalisMemoria('utvonal', array(array('felirat' => 'Parfüm téma szerkesztése')));

$ALG = new Adminlapgenerator;

$ALG->adatBeallitas('lapCim', "üres téma szerkesztése (témák/nincsstilus) ");

$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
$ALG->tartalomDobozStart();

$doboz = $ALG->ujDoboz();
$doboz->dobozCim( 'Alapadatok', 2);






$ALG->tartalomDobozVege();
$ALG->urlapGombok(array(


0 => array(

	'tipus' => 'submit',

	'felirat' => 'Mentés',

	'link' => '',

	'osztaly' => 'btn-ok',

	

),

));

$ALG->urlapVege();

$kimenet = $ALG->kimenet();
