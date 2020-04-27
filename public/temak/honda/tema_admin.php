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
			$newName = "hondalogo_".date('YmdHi').rand(100,999).'.'.$ext;
			if(move_uploaded_file($_FILES['logokep']['tmp_name'], FCPATH.$dir.$newName))
				$_POST['a']['logokep'] = $dir.$newName;
		}
	}
	
	foreach($_POST['a'] as $k => $v) {
		$van = $ci->Sql->sqlSor("SELECT * FROM temavaltozok WHERE tema = 'honda' AND kulcs = '$k' ");
		if(isset($van->id)) {
			$a = array('id' => $van->id, 'kulcs' => $k, 'ertek' => $v, 'tema' => 'honda');
			$ci->Sql->sqlUpdate($a, 'temavaltozok');
		} else {
			$a = array( 'kulcs' => $k, 'ertek' => $v, 'tema' => 'honda');
			$ci->Sql->sqlSave($a, 'temavaltozok');
		}
	}
	redirect(ADMINURL.'temak/beallitasok/honda?m='.urlencode('Módosítás sikeres!'));
}

include 'tema_valtozok.php';



globalisMemoria('utvonal', array(array('felirat' => 'Parfüm téma szerkesztése')));

$ALG = new Adminlapgenerator;

$ALG->adatBeallitas('lapCim', "Honda téma szerkesztése (témák/honda) ");

$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
$ALG->tartalomDobozStart();

$doboz = $ALG->ujDoboz();
$doboz->dobozCim( 'Nincs beállítási lehetőség', 2);

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


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz1_cim', 'felirat' => 'Footer 1. szekció cím', 'ertek'=> @$doboz1_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'doboz1_szoveg', 'felirat' => 'Footer 1. szekció leírás', 'ertek'=> @$doboz1_szoveg));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz1_linkurl', 'felirat' => 'Footer 1. szekció link URL', 'ertek'=> @$doboz1_linkurl));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz1_linkszoveg', 'felirat' => 'Footer 1. szekció link cím', 'ertek'=> @$doboz1_linkszoveg));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz2_cim', 'felirat' => 'Footer 2. szekció cím', 'ertek'=> @$doboz2_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'doboz2_szoveg', 'felirat' => 'Footer 2. szekció leírás', 'ertek'=> @$doboz2_szoveg));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz2_linkurl', 'felirat' => 'Footer 2. szekció link URL', 'ertek'=> @$doboz2_linkurl));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz2_linkszoveg', 'felirat' => 'Footer 2. szekció link cím', 'ertek'=> @$doboz2_linkszoveg));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz3_cim', 'felirat' => 'Footer 3. szekció cím', 'ertek'=> @$doboz3_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz3_fburl', 'felirat' => 'Footer 3. szekció Facebook oldal URL', 'ertek'=> @$doboz3_fburl));

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz4_cim', 'felirat' => 'Footer 4. szekció cím', 'ertek'=> @$doboz4_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'attr' => ' id="szoveg" ', 'mezonev' => 'doboz4_html', 'felirat' => 'Footer 4. szekció HTML', 'ertek'=> @$doboz4_html));

$doboz->jodit();

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'footercopyright', 'felirat' => 'Footer copy right felirat', 'ertek'=> @$footercopyright));
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
