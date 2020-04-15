<?php

// ez a függvény tölti be a view-t úgy hogy ha nincs az adott témamappában, akkor a közös elemek mappában is megnézi 
function ws_frontendView($file, $adat = null, $kimenet = false) {
	$ci = getCI();
	$filenev = $file;
	if(ws_ext($file)!='php') $filenev .= '.php';
	
	if(file_exists(FCPATH.TEMAMAPPA.'/'.FRONTENDTEMA.'/'.$filenev)) 
	{
		
		// egyszerű gyermek téma betöltés
		return $ci->load->view(FRONTENDTEMA.'/'.$file, $adat, $kimenet);

	}
	return $ci->load->view('kozos_elemek/'.$file, $adat, $kimenet);
}

// fordító függvény, nincs implementálva
function __f($str) {
	return $str;
}
// adott modul autoload.php fileját include-olja
function ws_autoload($modul) {
	$file = FCPATH.'modules/'.$modul.'/autoload.php';
	if(file_exists($file)) {
		include_once($file);
		return true;
	} else {
		return false;
	}
}
// a globális memóriából adja vissza az adott kilcshoz tartozó seo adtokat (title, description)
function ws_seo($kulcs) {
	$seo = globalisMemoria('seoTartalom');
	return @$seo->$kulcs;
}
// felhasználói tevékenység loggolása, egyszerű változat
function ws_log($csoport, $bejegyzes) {
	$CI = & get_instance();
	$tagid = $CI->session->userdata('__belepett_felhasznalo');
	
	$a = array('csoport' => $csoport, 'bejegyzes' => $bejegyzes,'felhasznalo_id' => (@$tag)?$tag:0);
	$CI->Sql->sqlSave($a, DBP.'naplo');
	
	
}

// munkamenetben kikeresi a tag adatait- ha van, egyébként loginra irányít
function belepesEllenorzo() {
	$CI = & get_instance();
	$tag = $CI->session->userdata('tag');
	
	if(!$tag) redirect('/login');
	return $tag;
}
// adatbázis tábla meglétét ellenőrzi: áruház táblák vizsgálatához, és egyes modulok meglétének ellenőrzéséhez használjuk
function vanTabla($tabla) {
	if(!globalisMemoria('db_tablak')) {
	
		$ci = getCI();
		
		$sql = "SHOW TABLES";
		$rs = $ci->Sql->sqlSorok($sql);
		$arr = array();
		foreach($rs as $sor) {
			$arr[] = current($sor);
		}
		globalisMemoria('db_tablak', $arr);
	}
	return (in_array($tabla, globalisMemoria('db_tablak')));
	
}
function belepettTag() {
	$CI = & get_instance();
	
	$tagid = $CI->session->userdata('__belepett_felhasznalo');
	if($tagid===null) return false;
	ws_autoload('felhasznalok');
	$tag = new Tag_osztaly($tagid);
	if(!isset($tag->id)) return false;
	return $tag;
}

function ws_arformatum($num) {
	return number_format($num, 0,'',' ');
}

// lecsupaszítja egyszerű szöveggé a kapott stringet, csak entereket hagy <br> formában 


function ws_plantxt($str) {
	return (strip_tags($str));
}

// kiterjesztés

function ws_ext($str) {
	$a = explode('.',$str);
	return end($a);
}

// közös dátumformázás
function ws_date($str) {
	$time = strtotime($str);
	$honapok = array('', 'január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december');
	return date('Y. ',$time).$honapok[(int)date('m', $time)].' '.(int)date('d', $time).'';
}

function ws_valueArray($arr, $fielsName) {
	if(empty($arr)) return false;
	$ret = array();
	foreach($arr as $sor) {
		$sor = (array)$sor;
		if(!isset($sor[$fielsName])) return false;
		$ret[] = $sor[$fielsName];
	}
	return $ret;
}

// config tábla beállításait adja vissza
function beallitasOlvasas($kulcs, $ujratoltes=false) {
	$CI = & get_instance();


	global $hkBeallitasok;
	if(is_null($hkBeallitasok) or !$ujratoltes) {
		$hkBeallitasok = $CI->Sql->getsIdArr(DBP.'settings','kulcs', '');
	}
	return trim(@$hkBeallitasok[$kulcs]->ertek);
	

}

// szöveg vágása adott karakterszám felett
function ws_wrap($str, $max=100) {

	$a = explode('|', wordwrap(strip_tags($str),$max, '|'));
	return trim($a[0], ' ,.;-').(trim(@$a[1]!='')?'...':'');
}

// url kompatibilis str nem utf szövegekből
function strToUrl($str) {
	
	$EXCEPT_CHAR = "ÁáÀàĂăẮắẰằẴẵẲẳÂâẤấẦầẪẫẨẩǍǎÅåǺǻÄäǞǟÃãȦȧǠǡĄąĀāẢảȀȁȂȃẠạẶặẬậḀḁȺⱫᶏḂḃḄḅḆḇɃƀᵬᶀƁɓƂƃĆćĈĉČčĊċÇçḈḉȻȼƇƈɕĎďḊḋḐḑḌḍḒḓḎḏĐđᵭᶁƉɖƊɗᶑƋƌȡÉéÈèĔĕÊêẾếỀềỄễỂểĚěËëẼẽĖėȨȩḜḝĘęĒēḖḗḔḕẺẻȄȅȆȇẸẹỆệḘḙḚḛɆɇᶒḞḟᵮᶂƑƒǴǵĞğĜĝǦǧĠġĢģḠḡǤǥᶃƓɠĤĥȞȟḦḧḢḣḨḩḤḥḪḫHẖĦħⱧⱨÍíÌìĬĭÎîǏǐÏïḮḯĨĩİiĮįĪīỈỉȈȉȊȋỊịḬḭIıƗɨᵻᶖĴĵǰȷɈɉʝɟʄḰḱǨǩĶķḲḳḴḵᶄƘƙⱩⱪĹĺĽľĻļḶḷḸḹḼḽḺḻŁłĿŀȽƚⱠⱡⱢɫɬᶅɭȴḾḿṀṁṂṃᵯᶆɱŃńǸǹŇňÑñṄṅŅņṆṇṊṋṈṉᵰƝɲȠƞᶇɳȵNnÓóÒòŎŏÔôỐốỒồỖỗỔổǑǒÖöȪȫŐőÕõṌṍṎṏȬȭȮȯȰȱØøǾǿǪǫǬǭŌōṒṓṐṑỎỏȌȍȎȏƠơỚớỜờỠỡỞởỢợỌọỘộᶗƟɵṔṕṖṗⱣᵽᵱᶈƤƥPpʠɊɋŔŕŘřṘṙŖŗȐȑȒȓṚṛṜṝṞṟɌɍᵲᶉɼⱤɽɾᵳŚśṤṥŜŝŠšṦṧṠṡẛŞşṢṣṨṩȘșᵴᶊʂȿSsŤťTẗṪṫŢţṬṭȚțṰṱṮṯŦŧȾⱬᵵƫƬƭƮʈȶÚúÙùŬŭÛûǓǔŮůÜüǗǘǛǜǙǚǕǖŰűŨũṸṹŲųŪūṺṻỦủȔȕȖȗƯưỨứỪừỮữỬửỰựỤụṲṳṶṷṴṵɄʉᵾᶙṼṽṾṿᶌƲʋⱴẂẃẀẁŴŵWẘẄẅẆẇẈẉẌẍẊẋᶍÝýỲỳŶŷYẙŸÿỸỹẎẏȲȳỶỷỴỵʏɎɏƳƴŹźẐẑŽžŻżẒẓẔẕƵƶᵶᶎȤȥʐʑɀⱫⱬɐɑᶐɒẚÆæǼǽǢǣʙↃↄÐðȸʣʥʤƎǝƏəᶕƐɛᶓɘɚɜᶔɝɞʚɤʩℲⅎɡᵹɢʛᵷƔɣƢƣʜǶƕɦⱵⱶɧɪƖɩᵼʞʪʫʟɮƛʎɴŊŋŒœɶƆɔɷȢȣɸⱷȹKʻĸƦʀɹɺɻɿʁßƩʃᶋƪʅᶘʆſʨᵺƾʦʧʇᵫɄʉɥʮʯƜɯɰƱʊᵿɅʌʍƍƷʒǮǯƸƹᶚƺʓȜȝÞþǷƿƻƧƨƼƽƄƅɁɂʔʕʡʢʖǀǁǂǃʗʘʬʭЗзЧч";
	$EXCEPT_CHAR_REPLACE = "AaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAaAzaBbBbBbBbbbBbBbCcCcCcCcCcCcCcCccDdDdDdDdDdDdDdddDdDdddddEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeEeeFfffFfGgGgGgGgGgGgGgGggGgHhHhHhHhHhHhHhHhHhHhIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiJjJjJjjjjKkKkKkKkKkKkKkkLlLlLlLlLlLlLlLlLlLlLlLlLlLlMmMmMmMmmNnNnNnNnNnNnNnNnNnnNnNnNnnNnOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOoOocdePpPpPpppPpPpqQqRrRrRrRrRrRrRrRrRrRrrrrRrrrSsSsSsSsSsSsFSsSsSsSsSsssSsTtTtTtTtTtTtTtTtTtTzttTtTttUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuUuuuVvVvvVvvWwWwWwWwWwWwWwXxXxxYyYyYyYyYyYyYyYyYyYyyyyYyZzZzZzZzZzZzZzzzZzZzzZzaaqoaAaAaAaBCcDdddddEeEeaEeeeeeeegdyfFfgggggYyMmhHhhtthillzkkklBAAnNnEeeCcobbowpK'kRrjJyrbBEfLllllftwsttteVvyYYWwwUuuAamGEEEEEeeeeEEPPPpZZzbbbbCcCCCCClltlcOWMBbHh";
	
	$plattern = array();
	for($i=0;$i<mb_strlen($EXCEPT_CHAR, 'UTF-8');$i++) $plattern[]=$EXCEPT_CHAR[$i];

	$replacement = array();
	for($i=0;$i<mb_strlen($EXCEPT_CHAR, 'UTF-8');$i++) $plattern[]=$EXCEPT_CHAR[$i];

	while(strstr($str, "..")) $str = str_replace("..", ".", $str);

	$str = SubStr(str_replace($plattern, $replacement, $str), 0, 1000);

	$str = StrToLower(preg_replace("/\W/", "-", $str));

	while(strstr($str, "--")) $str = str_replace("--", "-", $str);

	return trim($str,'-');
}
function ws_delimagevariants($utvonal) {
	imgsizes();
	$elerhetoMeretek = globalisMemoria('elerhetoMeretek');
	$meretadatok = globalisMemoria('meretadatok') ;
	
	foreach($elerhetoMeretek as $meret) {
		if(!isset($meretadatok[$meret])) continue;
		$x = $meretadatok[$meret]['x'];
		$y = $meretadatok[$meret]['y'];
	
		$path = dirname($utvonal).'/';
		$fname = basename($utvonal);
		$ext = ws_ext($fname);
		$fname = ws_withoutext($fname);
	
		$fname = $fname.'_'.$x.'_'.$y.'.'.$ext;
		@unlink(FCPATH.$path.$fname); 
	}
}
// Email ellenőrzés
function isEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// kép nézet generálása
function ws_image($utvonal, $meret = 'big') {
	if(!$utvonal) return 'img/noimage.jpg';
	imgsizes();
	$elerhetoMeretek = globalisMemoria('elerhetoMeretek');
	$meretadatok = globalisMemoria('meretadatok') ;
	
	
	if(!in_array($meret, $elerhetoMeretek)) return false;
	if($meret=='full')return $utvonal;
	
	$x = $meretadatok[$meret]['x'];
	$y = $meretadatok[$meret]['y'];
	
	$path = dirname($utvonal).'/';
	$fname = basename($utvonal);
	$ext = ws_ext($fname);
	$fname = ws_withoutext($fname);
	
	$fname = $fname.'_'.$x.'_'.$y.'.'.$ext;
	
	
	if(file_exists(FCPATH.$path.$fname)) return $path.$fname;
	
	include_once(APPPATH.'libraries/Zebraimage.php');
				
	$image = new Zebra_Image();
	$image->source_path = FCPATH.$utvonal;
	$image->target_path  = FCPATH.$path.$fname;
	
	$mod = ZEBRA_IMAGE_NOT_BOXED;
	if(strpos($meret,'boxed')!==false)  $mod = ZEBRA_IMAGE_BOXED;
	
	$image->resize($x, $x, $mod);
				
	return $path.$fname;
	
}

function ws_hookFuttatas($belepesipont, $param) {
	ws_moduladatok();
	$hookBelepesiPontok = globalisMemoria('hookBelepesipontok');
	
	if(!isset($hookBelepesiPontok[$belepesipont])) return false;
	foreach($hookBelepesiPontok[$belepesipont] as $eleres) {
		$belepesipont = explode('/',$eleres );
		
		$modul = $belepesipont[0];
		$osztaly = $belepesipont[1];
		$metodus = $belepesipont[2];
		$file = FCPATH.'modules/'.$modul.'/'.$osztaly.'.php';
		if(file_exists($file)) {
			include_once($file);
			$o = new $osztaly() ;
			$o->{$metodus}($param);
		} else {
			die('Hook belépési pont nem létezik: '.$file);
		}
	}
	
}

function ws_ordernumber($id) {
	return beallitasOlvasas('rendelesazonosito.elotag').str_pad($id, 4, "0", STR_PAD_LEFT);
}
function imgsizes() {
	globalisMemoria('elerhetoMeretek',array('smallboxed', 'small', 'medium','mediumboxed', 'big', 'full'));
	globalisMemoria('meretadatok' ,array(
		'smallboxed' => array('x' => beallitasOlvasas('imgsize.smallboxed.x'), 'y' => beallitasOlvasas('imgsize.smallboxed.y')),
		'small' => array('x' => beallitasOlvasas('imgsize.small.x'), 'y' => beallitasOlvasas('imgsize.small.y')),
		'medium' => array('x' => beallitasOlvasas('imgsize.medium.x'), 'y' => beallitasOlvasas('imgsize.medium.y')),
		'mediumboxed' => array('x' => beallitasOlvasas('imgsize.mediumboxed.x'), 'y' => beallitasOlvasas('imgsize.mediumboxed.y')),
		'big' => array('x' => beallitasOlvasas('imgsize.big.x'), 'y' => beallitasOlvasas('imgsize.big.y'))));
}
// kép ellenőrzés
function imgcheck($field) {
	// never assume the upload succeeded
	if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
		return false;
	}

	$info = getimagesize($_FILES[$field]['tmp_name']);
	if ($info === FALSE) {
		return false;
	}

	if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
		return false;
	}
	return true;
}


//szöveg összehasonlítás

function cmpobj($a, $b)
{
    return strcmp($a->price, $b->price);
}

// folder tartalom törlése
function ws_delall($path) {
	$files = scandir ($path);// get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
	}
}

// image linkek
function linkExtractor($html){
 $linkArray = array();
 if(preg_match_all('/<img\s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>/i',$html,$matches,PREG_SET_ORDER)){
  foreach($matches as $match){
   @array_push($linkArray,array($match[1],$match[2]));
  }
 }
 return $linkArray;
}

// codeigniter példány
function getCI() {
	return get_instance();
}

// modul kinézet töltés
function modulView($modul,$file, $data = array()) {
	$ci = getCI();
	$modulViewFile = FCPATH.'modules/'.$modul.'/view/'.$modul.'_'.$file.'.php'; 
	if(@file_exists($modulViewFile)) {
		explode($data);
		ob_start();
		include (modulViewFile);
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}
	return '';
}
// tartalomkezekőben megjeleníthető adatok
function ws_tartalomkezeloatok() {
	global $tartalomkezeloAdatok;
	if(!empty($tartalomkezeloAdatok)) return $tartalomkezeloAdatok;
	ws_moduladatok();
	return $tartalomkezeloAdatok;
}
// beépülők
function ws_beepulok() {
	global $beepulok;
	if(empty($beepulok)) ws_moduladatok();
	return $beepulok;
}
function ws_temaadatok() {
	$temak = scandir(FCPATH.TEMAMAPPA);
	if($temak) {
		foreach($temak as $tema) {
			if($tema == '.' or $tema == '..') continue;
				
			$temaKonyvtar = FCPATH.TEMAMAPPA.'/'.$tema.'/';
			if(!@is_dir($temaKonyvtar)) continue;
			if(file_exists($temaKonyvtar.'tema_adat.php')) include($temaKonyvtar.'tema_adat.php');
		}
	}
	return $temaAdat;
}

// modul adatok
function ws_moduladatok() {
	global $modulAdatok;
	global $tartalomkezeloAdatok;
	global $beepulok;
	global $keresesiPontok;
	global $hookBelepesipontok;
	
	$modulok = scandir(FCPATH.'modules');
		
	if(!empty($modulAdatok)) return $modulAdatok;
	
	$modulAdatok = array();
	$beepulok = array();
	$hookBelepesipontok = array();
	$keresesiPontok = array();
	$tartalomkezeloAdatok = array();
	
	$modulok = scandir(FCPATH.'modules');
	if($modulok) {
		foreach($modulok as $modul) {
			if($modul == '.' or $modul == '..') continue;
				
			$modulKonyvtar = FCPATH.'modules/'.$modul.'/';
			if(!is_dir($modulKonyvtar)) continue;
			if(file_exists($modulKonyvtar.'moduladat.php')) include($modulKonyvtar.'moduladat.php');
				// szegmens routing
				
		}
	}
	
	return $modulAdatok; 
}
// modul adatok
function ws_moduladminadatok() {
	global $adminAdatok;
	
	
	$modulok = scandir(FCPATH.'modules');
		
	if(!empty($modulAdatok)) return $modulAdatok;
	$adminAdatok = array();
	
	$modulok = scandir(FCPATH.'modules');
	if($modulok) {
		foreach($modulok as $modul) {
			if($modul == '.' or $modul == '..') continue;
				
			$modulKonyvtar = FCPATH.'modules/'.$modul.'/';
			if(!is_dir($modulKonyvtar)) continue;
			if(file_exists($modulKonyvtar.'adminadat.php')) include($modulKonyvtar.'adminadat.php');
				// szegmens routing
				
		}
	}
	return $adminAdatok; 
}
// kiterjesztés eltávolsítása
function ws_withoutext($filename){
	return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
}

// widget betöltése
function widget($utvonal, $param = false) {
	$modulEleres = explode("/", $utvonal);
	$modul = $modulEleres[0];
	$osztaly = $modulEleres[1];
	$metodus = isset($modulEleres[2])?$modulEleres[2]:'index';
	$ut = FCPATH.'modules/'.$modul.'/'.$osztaly.'.php';
	if(!file_exists($ut)) return false;
	include_once(FCPATH.'modules/'.$modul.'/'.$osztaly.'.php');
	if(!class_exists($osztaly)) return false;
	$o = new $osztaly;
	
	if(!method_exists($o, $metodus)) return "Widget nem található: ".'modules/'.$modul.'/'.$osztaly.' / '.$metodus;
	
	if($param) {
		return $o->{$metodus}($param);
	
	} else {
		return $o->{$metodus}();
	
	}
	
	
}

// globálisan eléhető adatok
function globalisMemoria($kulcs, $ertek = null) {
	global $globalisMemoria;
	if(is_null($ertek)) {
		if(isset($globalisMemoria[$kulcs])) return $globalisMemoria[$kulcs] ;
		return false;
	}
	$globalisMemoria[$kulcs] = $ertek;
}

// rendszerüzenetek tárgya
function rendszerUzenetTargy($kulcs, $nyelv = false) {
	$ci = getCI();
	if(!$nyelv) $nyelv = $_SESSION['CMS_NYELV'];
	$sql = "SELECT * FROM ".DBP."email_sablonok WHERE kulcs = '$kulcs' AND nyelv = '$nyelv' LIMIT 1";
	
	$uzenet = $ci->Sql->sqlSor($sql);
	if(!isset($uzenet->targy)) return '#'.$kulcs.' rendszerüzenet nem található! ';
	return $uzenet->targy;
}

// rendszerüzenetek
function rendszerUzenet($kulcs, $nyelv = false) {
	$ci = getCI();
	if(!$nyelv) $nyelv = $_SESSION['CMS_NYELV'];
	$uzenet = $ci->Sql->sqlSor("SELECT * FROM ".DBP."email_sablonok WHERE kulcs = '$kulcs' AND nyelv = '$nyelv' LIMIT 1");
	if(!isset($uzenet->html)) return '#'.$kulcs.' rendszerüzenet nem található! ';
	return nl2br($uzenet->html);
}
// aktuális téma HTML mappa view-ok betöltéséhez
function ws_temahtml() {
	return beallitasOlvasas("FRONTENDTEMA").'/html/';
}
// tag ellenőrzése
function ws_belepesEllenorzes() {
	$ci = getCI();
	// van session?
	if(!$ci->session->userdata('__belepett_felhasznalo')) return false;
	$tag = globalisMemoria('felhsaznaloMunkamenet');
	if($tag) return $tag;
	
	//nincs még tagpéldány, létrehozzuk
	ws_autoload('felhasznalok');
	$tag = new Tag_osztaly($ci->session->userdata('__belepett_felhasznalo'));
	if(isset($tag->id)) return $tag;
	// nincs meg a tag
	$this->ci->delete_userdata('__belepett_felhasznalo');
	return false;
}
function ws_frontendMenupontok($csoport_id=0) {
	$ci=getCI();
	$url = $ci->uri->segment(1);
	if(globalisMemoria('aktivMenupont')!=false) $url = globalisMemoria('aktivMenupont');
	$lista = $ci->Sql->gets(DBP."frontendmenu", "WHERE frontendmenucsoport_id = $csoport_id ORDER BY SORREND");
	if($lista)foreach($lista as $k => $sor) if($sor->url == $url) $lista[$k]->aktiv=true; else $lista[$k]->aktiv = false;
	return $lista;
	
}
