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
			$newName = "ws3_".date('YmdHi').rand(100,999).'.'.$ext;
			if(move_uploaded_file($_FILES['logokep']['tmp_name'], FCPATH.$dir.$newName))
				$_POST['a']['logokep'] = $dir.$newName;
		}
	}
	
	
	foreach($_POST['a'] as $k => $v) {
		$van = $ci->Sql->sqlSor("SELECT * FROM temavaltozok WHERE tema = 'it' AND kulcs = '$k' ");
		if(isset($van->id)) {
			$a = array('id' => $van->id, 'kulcs' => $k, 'ertek' => $v, 'tema' => 'it');
			$ci->Sql->sqlUpdate($a, 'temavaltozok');
		} else {
			$a = array( 'kulcs' => $k, 'ertek' => $v, 'tema' => 'it');
			$ci->Sql->sqlSave($a, 'temavaltozok');
		}
	}
	redirect(ADMINURL.'temak/beallitasok/webshop_3?m='.urlencode('Módosítás sikeres!'));
}

include 'tema_valtozok.php';



globalisMemoria('utvonal', array(array('felirat' => 'Általános webshop téma szerkesztése')));

$ALG = new Adminlapgenerator;

$ALG->adatBeallitas('lapCim', "it téma szerkesztése (témák/webshop_2) ");

$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
$ALG->tartalomDobozStart();

$doboz = $ALG->ujDoboz();
$doboz->dobozCim( 'Alapadatok', 2);



$file = new Filefeltolto(array('nevtomb' => '', 'mezonev' => 'logokep', 'felirat' => 'Logó feltöltése (PNG, JPG, GIF, SVG)'));
$doboz->szimplaInput($file);

if(@$logokep!="") {
	$doboz->HTMLHozzaadas('<p style="padding:10px;background: #ddd;">Jelenlegi logókép:<br><br><img src="'.base_url().$logokep.'" style="border: 1px solid #aaa;max-height:200px;" /></p>');

}



$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'aruhaztelefon', 'felirat' => 'Fejléc telefonszám', 'ertek'=> @$aruhaztelefon));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'aruhazemail', 'felirat' => 'Fejléc email', 'ertek'=> @$aruhazemail));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz1_cim', 'felirat' => 'Footer 1. szekció cím', 'ertek'=> @$doboz1_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'doboz1_szoveg', 'felirat' => 'Footer 1. szekció leírás', 'ertek'=> @$doboz1_szoveg));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz1_linkurl', 'felirat' => 'Footer 1. szekció link URL', 'ertek'=> @$doboz1_linkurl));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz1_linkszoveg', 'felirat' => 'Footer 1. szekció link cím', 'ertek'=> @$doboz1_linkszoveg));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);




$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'feliratkozas_szoveg', 'felirat' => 'Footer feliratkozó szöveg', 'ertek'=> @$feliratkozas_szoveg));

$doboz->szimplaInput($input1);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'feliratkozas_cim', 'felirat' => 'Footer feliratkozó cím', 'ertek'=> @$feliratkozas_cim));

$doboz->szimplaInput($input1);




$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz4_cim', 'felirat' => 'Footer nyitvatartás cím', 'ertek'=> @$doboz4_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'attr' => ' id="szoveg" ', 'mezonev' => 'doboz4_html', 'felirat' => 'Footer nyitvatartás HTML', 'ertek'=> @$doboz4_html));

$doboz->jodit();

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'fb_url', 'felirat' => 'Footer Facebook URL', 'ertek'=> @$fb_url));

$doboz->szimplaInput($input1);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'twitter_url', 'felirat' => 'Footer Twitter URL', 'ertek'=> @$twitter_url));

$doboz->szimplaInput($input1);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'youtube_url', 'felirat' => 'Footer Youtube URL', 'ertek'=> @$youtube_url));

$doboz->szimplaInput($input1);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'instagram_url', 'felirat' => 'Footer Instagram URL', 'ertek'=> @$instagram_url));

$doboz->szimplaInput($input1);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'footercopyright', 'felirat' => 'Footer copy right felirat', 'ertek'=> @$footercopyright));
$doboz->szimplaInput($input1);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jogi_link1_cim', 'felirat' => 'Footer link 1 cím', 'ertek'=> @$jogi_link1_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jogi_link1', 'felirat' => 'Footer link 1 URI', 'ertek'=> @$jogi_link1));

$doboz->duplaInput($input1, $input2);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jogi_link2_cim', 'felirat' => 'Footer link 2 cím', 'ertek'=> @$jogi_link2_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jogi_link2', 'felirat' => 'Footer link 2 URI', 'ertek'=> @$jogi_link2));

$doboz->duplaInput($input1, $input2);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jogi_link3_cim', 'felirat' => 'Footer link 3 cím', 'ertek'=> @$jogi_link3_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jogi_link3', 'felirat' => 'Footer link 3 URI', 'ertek'=> @$jogi_link3));

$doboz->duplaInput($input1, $input2);



$input1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'stilus_css', 'felirat' => 'Színséma beállítása', 'ertek'=> @$stilus_css, 'opciok' => array('orange' => "Narancs színváltozat",'red' => "Piros változat", 'green' => "Zöld színváltozat" )));
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
