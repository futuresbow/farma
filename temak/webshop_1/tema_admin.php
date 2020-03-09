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
			$newName = "ws1_".date('YmdHi').rand(100,999).'.'.$ext;
			if(move_uploaded_file($_FILES['logokep']['tmp_name'], FCPATH.$dir.$newName))
				$_POST['a']['logokep'] = $dir.$newName;
		}
	}
	foreach($_POST['a'] as $k => $v) {
		$van = $ci->Sql->sqlSor("SELECT * FROM temavaltozok WHERE tema = 'webshop_1' AND kulcs = '$k' ");
		if(isset($van->id)) {
			$a = array('id' => $van->id, 'kulcs' => $k, 'ertek' => $v, 'tema' => 'webshop_1');
			$ci->Sql->sqlUpdate($a, 'temavaltozok');
		} else {
			$a = array( 'kulcs' => $k, 'ertek' => $v, 'tema' => 'webshop_1');
			$ci->Sql->sqlSave($a, 'temavaltozok');
		}
	}
	redirect(ADMINURL.'temak/beallitasok/webshop_1?m='.urlencode('Módosítás sikeres!'));
}

include 'tema_valtozok.php';



globalisMemoria('utvonal', array(array('felirat' => 'Általános webshop téma szerkesztése')));

$ALG = new Adminlapgenerator;

$ALG->adatBeallitas('lapCim', "Általános webshop téma szerkesztése (témák/webshop_1) ");

$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
$ALG->tartalomDobozStart();

$doboz = $ALG->ujDoboz();
$doboz->dobozCim( 'Alapadatok', 2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'aruhaztelefon', 'felirat' => 'Fejléc telefonszám', 'ertek'=> @$aruhaztelefon));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'aruhazemail', 'felirat' => 'Fejléc email', 'ertek'=> @$aruhazemail));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$file = new Filefeltolto(array('nevtomb' => '', 'mezonev' => 'logokep', 'felirat' => 'Logó feltöltése (PNG, JPG, GIF, SVG)'));
$doboz->szimplaInput($file);

if(@$logokep!="") {
	$doboz->HTMLHozzaadas('<p style="padding:10px;background: #ddd;">Jelenlegi logókép:<br><br><img src="'.base_url().$logokep.'" style="border: 1px solid #aaa;max-height:200px;" /></p>');

}

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'cookieinfo_url', 'felirat' => 'Cookie infó URL', 'ertek'=> @$cookieinfo_url));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'adatvedelem_url', 'felirat' => 'Adatvédelem URL', 'ertek'=> @$adatvedelem_url));

$doboz->duplaInput($input1, $input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'szallitasiinfok_url', 'felirat' => 'Szállítási infó URL', 'ertek'=> @$szallitasiinfok_url));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'kapcsolat_url', 'felirat' => 'Kapcsolat URL', 'ertek'=> @$kapcsolat_url));

$doboz->duplaInput($input1, $input2);

$input1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'stilus_css', 'felirat' => 'Színséma beállítása', 'ertek'=> @$stilus_css, 'opciok' => array('green' => "Zöld színváltozat",'blue' => "Kék változat", 'turkiz' => "Türkiz színváltozat" )));
$doboz->szimplaInput($input1);


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
