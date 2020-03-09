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
			$newName = "central_".date('YmdHi').rand(100,999).'.'.$ext;
			if(move_uploaded_file($_FILES['logokep']['tmp_name'], FCPATH.$dir.$newName))
				$_POST['a']['logokep'] = $dir.$newName;
		}
	}
	
	
	foreach($_POST['a'] as $k => $v) {
		$van = $ci->Sql->sqlSor("SELECT * FROM temavaltozok WHERE tema = 'central' AND kulcs = '$k' ");
		if(isset($van->id)) {
			$a = array('id' => $van->id, 'kulcs' => $k, 'ertek' => $v, 'tema' => 'central');
			$ci->Sql->sqlUpdate($a, 'temavaltozok');
		} else {
			$a = array( 'kulcs' => $k, 'ertek' => $v, 'tema' => 'central');
			$ci->Sql->sqlSave($a, 'temavaltozok');
		}
	}
	redirect(ADMINURL.'temak/beallitasok/2103_central?m='.urlencode('Módosítás sikeres!'));
}

include 'tema_valtozok.php';



globalisMemoria('utvonal', array(array('felirat' => 'Parfüm téma szerkesztése')));

$ALG = new Adminlapgenerator;

$ALG->adatBeallitas('lapCim', "central téma szerkesztése (témák/2103_central) ");

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

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'copyright', 'felirat' => 'Copyright szöveg', 'ertek'=> @$copyright));

$doboz->szimplaInput($input1);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'fooldalcim', 'felirat' => 'Header cím', 'ertek'=> @$fooldalcim));
$doboz->szimplaInput($input1);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'fooldalbevezeto', 'felirat' => 'Header kiemelés', 'ertek'=> @$fooldalbevezeto));
$doboz->szimplaInput($input1);




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


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'doboz4_cim', 'felirat' => 'Footer nyitvatartás cím', 'ertek'=> @$doboz4_cim));
$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'attr' => ' id="szoveg" ', 'mezonev' => 'doboz4_html', 'felirat' => 'Footer nyitvatartás HTML', 'ertek'=> @$doboz4_html));

$doboz->jodit();

$doboz->szimplaInput($input1);
$doboz->szimplaInput($input2);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'footermondat', 'felirat' => 'A copyright feletti mondat', 'ertek'=> @$footermondat));

$doboz->szimplaInput($input1);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'fb_url', 'felirat' => 'Footer Facebook URL', 'ertek'=> @$fb_url));

$doboz->szimplaInput($input1);


$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'twitter_url', 'felirat' => 'Footer Twitter URL', 'ertek'=> @$twitter_url));

$doboz->szimplaInput($input1);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'youtube_url', 'felirat' => 'Footer Youtube URL', 'ertek'=> @$youtube_url));

$doboz->szimplaInput($input1);

$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'instagram_url', 'felirat' => 'Footer Instagram URL', 'ertek'=> @$instagram_url));

$doboz->szimplaInput($input1);



$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups1_cim', 'felirat' => '1. UPS cím', 'ertek'=> @$ups1_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups1_szoveg', 'felirat' => '1. UPS mondat', 'ertek'=> @$ups1_szoveg));
$doboz->duplaInput($input1, $input2);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups2_cim', 'felirat' => '2. UPS cím', 'ertek'=> @$ups2_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups2_szoveg', 'felirat' => '2. UPS mondat', 'ertek'=> @$ups2_szoveg));
$doboz->duplaInput($input1, $input2);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups3_cim', 'felirat' => '3. UPS cím', 'ertek'=> @$ups3_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups3_szoveg', 'felirat' => '3. UPS mondat', 'ertek'=> @$ups3_szoveg));
$doboz->duplaInput($input1, $input2);
$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups4_cim', 'felirat' => '4. UPS cím', 'ertek'=> @$ups4_cim));
$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'ups4_szoveg', 'felirat' => '4. UPS mondat', 'ertek'=> @$ups4_szoveg));
$doboz->duplaInput($input1, $input2);








$input1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'stilus_css', 'felirat' => 'Színséma beállítása', 'ertek'=> @$stilus_css, 'opciok' => array('style' => "Alap színváltozat",'style-purple' => "Lila változat", 'style-turquoise' => "Türkiz színváltozat" )));
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
