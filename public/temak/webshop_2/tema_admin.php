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
			$newName = "ws2_".date('YmdHi').rand(100,999).'.'.$ext;
			if(move_uploaded_file($_FILES['logokep']['tmp_name'], FCPATH.$dir.$newName))
				$_POST['a']['logokep'] = $dir.$newName;
		}
	}
	
	
	foreach($_POST['a'] as $k => $v) {
		$van = $ci->Sql->sqlSor("SELECT * FROM temavaltozok WHERE tema = 'fashion' AND kulcs = '$k' ");
		if(isset($van->id)) {
			$a = array('id' => $van->id, 'kulcs' => $k, 'ertek' => $v, 'tema' => 'fashion');
			$ci->Sql->sqlUpdate($a, 'temavaltozok');
		} else {
			$a = array( 'kulcs' => $k, 'ertek' => $v, 'tema' => 'fashion');
			$ci->Sql->sqlSave($a, 'temavaltozok');
		}
	}
	redirect(ADMINURL.'temak/beallitasok/webshop_2?m='.urlencode('Módosítás sikeres!'));
}

include 'tema_valtozok.php';



globalisMemoria('utvonal', array(array('felirat' => 'Általános webshop téma szerkesztése')));

$ALG = new Adminlapgenerator;

$ALG->adatBeallitas('lapCim', "Fashion téma szerkesztése (témák/webshop_2) ");

$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
$ALG->tartalomDobozStart();

$doboz = $ALG->ujDoboz();
$doboz->dobozCim( 'Alapadatok', 2);


$file = new Filefeltolto(array('nevtomb' => '', 'mezonev' => 'logokep', 'felirat' => 'Logó feltöltése (PNG, JPG, GIF, SVG)'));
$doboz->szimplaInput($file);

if(@$logokep!="") {
	$doboz->HTMLHozzaadas('<p style="padding:10px;background: #ddd;">Jelenlegi logókép:<br><br><img src="'.base_url().$logokep.'" style="border: 1px solid #aaa;max-height:200px;" /></p>');

}


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'fejleclink_felirat', 'felirat' => 'Fejléc link felirata', 'ertek'=> @$fejleclink_felirat));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'fejleclink_url', 'felirat' => 'Fejléc link URI', 'ertek'=> @$fejleclink_url));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups_1_text', 'felirat' => 'UPS 1. szöveg', 'ertek'=> @$ups_1_text));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups_2_text', 'felirat' => 'UPS 2. szöveg', 'ertek'=> @$ups_2_text));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups_3_text', 'felirat' => 'UPS 3. szöveg', 'ertek'=> @$ups_3_text));
$doboz->szimplaInput($input1);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'aruhaztelefon', 'felirat' => 'Áruház telefonszám', 'ertek'=> @$aruhaztelefon));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'aruhazemail', 'felirat' => 'Áruház email', 'ertek'=> @$aruhazemail));

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


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz4_cim', 'felirat' => 'Footer 3. szekció cím', 'ertek'=> @$doboz4_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'attr' => ' id="szoveg" ', 'mezonev' => 'doboz4_html', 'felirat' => 'Footer 3. szekció HTML', 'ertek'=> @$doboz4_html));

$doboz->jodit();

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);



$input1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'stilus_css', 'felirat' => 'Kinézet színsémája', 'ertek'=> @$stilus_css, 'opciok' => array('style' => "Kék színváltozat",'style-pink' => "Rózsaszín színváltozat", 'style-yellow' => "Sárga színváltozat")));

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
