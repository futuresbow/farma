<?php

class Oldalak_admin extends MY_Modul {
	
	public function tartalomepito_uj() {
		$ci = getCI();
		globalisMemoria("Nyitott menüpont",'Oldalak');
		$id = (int)$ci->uri->segment(4);

		globalisMemoria('utvonal', array(array('felirat'=> 'Oldaltartalom szerkesztése')));

		//globalisMemoria('headerScripts', '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>');
		$data = array();
		$data['oldal'] = $ci->Sql->get($id, DBP."oldal_urlek" , "id");
		$data['lista'] = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."oldalak WHERE url = '".$data['oldal']->url."'");
		return $this->load->view(ADMINTEMPLATE.'html/tartalomepito', $data, true);
	}
	
	public function urllista() {
		
		globalisMemoria("Nyitott menüpont",'Oldalak');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Elérhető URL-ek listája')));

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Elérhető URL-ek");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'oldalak/urlszerkesztes/0', 'felirat' => 'Új URL'));

		

		$ALG->tartalomDobozStart();

		

		// táblázat adatok összeállítása

		$adatlista = array();

		$start = 0;

		$w = '';

		

		$lista = $this->sqlSorok('SELECT * FROM oldal_urlek '.$w.' ORDER BY nev ASC LIMIT '.$start.', 30');


		// táblázat beállítás

		$tablazat = $ALG->ujTablazat();

		

		$keresoMezok = array(

			array('felirat' => 'Megnevezés', 'mezonev' => 'nev'),

			array('felirat' => 'Kód', 'mezonev' => 'kod'),

			

		);

		$keresoMezok = false;

		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'oldalak/urlszerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'oldalak/urltorles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('url' => 'URL', 'nev' => 'Név', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);		

		$ALG->tartalomDobozVege();
	
		return $ALG->kimenet();

		
	}
	
	
	public function urlszerkesztes() {
		globalisMemoria("Nyitott menüpont",'Oldalak');
		$ci = getCI();

		$id = (int)$ci->uri->segment(4);

		globalisMemoria('utvonal', array(array('url' => 'oldalak/urllista', 'felirat' => 'Elérhető URL-ek') , array('felirat'=> 'Fizetési mód szerkesztése')));

		$sor = $this->Sql->get($id, DBP.'oldal_urlek', 'id');


		if($ci->input->post('a')) {

			$a = $ci->input->post('a');
			print_r($a);
			var_dump($id);
			
			if($id != 0) if($a['url']!=$sor->url) {
				print 'ajajjajj';
				$this->db->query("UPDATE oldalak SET url = '{$a['url']}' WHERE url = '{$sor->url}' ");
			}

			if($id == 0) {

				$this->Sql->sqlSave($a, DBP.'oldal_urlek');

			} else {

				$a['id'] = $id;

				$this->Sql->sqlUpdate($a, DBP.'oldal_urlek');

					

			}

			redirect(ADMINURL.'oldalak/urllista?m='.urlencode("A módosítások rögzítésre kerültek."));

		}

		

		$sor = $this->Sql->get($id, DBP.'oldal_urlek', 'id');

		

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Elérhető URL-ek");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'oldalak/urllista', 'felirat' => 'Elérhető URL-ek') );

		

		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));

		

		$ALG->tartalomDobozStart();

		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'URL adatai', 2);

		

		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));

		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'url', 'felirat' => 'SLUG <small>adomain mögötti rész, pl. http://valami.hu/<b>rolunk</b>. ***-gal jelölje az olyan tartalmat, amikor nincs értelmezhető url, pl.: http://valami.hu/hdjksa </small>', 'ertek'=> @$sor->url));

		

		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($input2);
		
		$aktivtema = false;
		$frontendtema = beallitasOlvasas('FRONTENDTEMA');
		if(file_exists(FCPATH.TEMAMAPPA.'/'.$frontendtema.'/tema_adat.php')) {
			include(FCPATH.TEMAMAPPA.'/'.$frontendtema.'/tema_adat.php');
			if(isset($temaAdat)) {
				if(isset($temaAdat[0]['layout'])) {
					$elrendezesek = $temaAdat[0]['layout'];
					
					$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'layout', 'felirat' => 'Elrendezés', 'ertek'=> @$sor->layout, 'opciok' => $elrendezesek));
					$doboz->szimplaInput($select);
				}
			}
		}
		
		
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'seo_title', 'felirat' => 'Alapértelmezett SEO cím', 'ertek'=> @$sor->seo_title));
		$input2 = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'seo_description', 'felirat' => 'SEO leírás', 'ertek'=> @$sor->seo_description));

		

		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($input2);

		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(

			0 => array(

				'tipus' => 'hivatkozas',

				'felirat' => 'Mégse',

				'link' => ADMINURL.'oldalak/urllista',

				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"

			),

			1 => array(

				'tipus' => 'submit',

				'felirat' => 'Mentés',

				'link' => '',

				'osztaly' => 'btn-ok',

				

			),

		));

		$ALG->urlapVege();

		return $ALG->kimenet();

		

		

	}

	public function urltorles() {

		$ci = getCI();

		$id = (int)$ci->uri->segment(4);

		$sor = $this->Sql->get($id, DBP."oldal_urlek", 'id');
		

		$this->db->query("DELETE FROM ".DBP."oldalak WHERE url =  '{$sor->url}'");
		
		$this->db->query("DELETE FROM ".DBP."oldal_urlek WHERE id =  ".$id);

		redirect(ADMINURL.'oldalak/urllista?m='.urlencode('Sikeres törlés!'));

		return;

	}
	public function tartalomepito() {		globalisMemoria("Nyitott menüpont",'Oldalak');
		$ci = getCI();

		$id = (int)$ci->uri->segment(4);
				$oldal = $ci->Sql->sqlSor("SELECT  * FROM ".DBP."oldal_urlek WHERE id = $id LIMIT 1");
		if(!$oldal->id) {
			redirect(ADMINURL.'oldalak/urllista');
			return;
		}
		$link = ADMINURL.'oldalak/tartalomepito/'.$id;
		globalisMemoria('utvonal', array(array('felirat' => $oldal->nev.'-oldal tartalmak')));
		
		if($this->ci->input->get('sorrend')!='') {
			$arr = explode(',', trim($this->ci->input->get('sorrend'), ','));
			foreach($arr as $k =>  $id) {
				$id = (int)$id;
				$this->ci->db->query("UPDATE ".DBP."oldalak SET sorrend = ".($k*10)." WHERE id = ".$id);
				
			}
			redirect($link.'?m='.urlencode("Sorrend módosítva."));
			return;
		}
		
		
		$ALG = new Adminlapgenerator;
		
		$data['moduleleresek'] = ws_tartalomkezeloatok();
		
		
		
		$ALG->adatBeallitas('lapCim', "Dinamikus oldallapok");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'oldalak/szerkesztes/0/'.$id, 'felirat' => 'Új oldaltartalom'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		
		$segmensek = $this->sqlSorok('SELECT distinct(url) FROM oldalak WHERE url = "'.$oldal->url.'" ORDER BY url ASC ');
		if($segmensek) foreach($segmensek as $szegmenssor) { $urlSzegmens = $szegmenssor->url;
			$lista = $this->sqlSorok('SELECT * FROM oldalak WHERE url = "'.$urlSzegmens.'" ORDER BY url ASC, sorrend ASC ');			
			
			if($lista)foreach($lista as  $k => $sor) {
				
				$lista[$k]->moduleleres = $data['moduleleresek'][$lista[$k]->moduleleres]['cim'];
				if($lista[$k]->elemnev!='') $lista[$k]->moduleleres = $lista[$k]->elemnev;
				$lista[$k]->tartalomszerkeszteslink = '<a href="'.ADMINURL.'oldalak/tartalomszerkesztes/'.$id.'/'.$lista[$k]->id.'">tartalmi elem szerkesztése</a>';
			}
			// táblázat beállítás
			$tablazat = $ALG->ujTablazat();
			
			$keresoMezok = false;
			
			$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
			$tablazat->adatBeallitas('szerkeszto_url', 'oldalak/szerkesztes/'.$id.'/');
			$tablazat->adatBeallitas('torles_url', 'oldalak/torles/'.$id.'/');
			$tablazat->adatBeallitas('megjelenitettMezok', array('moduleleres' => 'Tartalom','sorrend' => 'Sorrend',   'torles' => 'Törlés',  'tartalomszerkeszteslink' => 'Tartalom szerkesztése' ));
			$tablazat->adatBeallitas('lista', $lista);
			if($urlSzegmens=='***') $urlSzegmens = 'none';
			$tablazat->sorrendezheto('id_'.$urlSzegmens);
			
			// táblázat beállítás vége
		}
		$ALG->tartalomDobozVege();
		
		return $ALG->kimenet();
	}
	
	public function tartalomszerkesztes() {		globalisMemoria("Nyitott menüpont",'Oldalak');
		$ci = getCI();
		$id = (int)$ci->uri->segment(5);
		$urlid = (int)$ci->uri->segment(4);
		$url = $this->Sql->get($urlid, DBP.'oldal_urlek' , 'id');
		
		
		$oldal = $ci->Sql->sqlSor("SELECT u.* FROM ".DBP."oldalak o, oldal_urlek u WHERE o.id = $id AND o.url = u.url LIMIT 1");
		
		
		// csak a paraméterek jönnek ha jön valami a tömbben
		if($this->input->post('a')) {			// címet kellene szerezni a bejegyzéshez:
			$elem = $this->Sql->get($id, DBP.'oldalak', 'id');
			$modulEleres = explode('/', $elem->moduleleres);
			$tartalombeallitas = true;
			if(!isset($modulEleres[0])) $tartalombeallitas = false;
			if(!isset($modulEleres[2])) $modulEleres[2] = 'index';
			if(!isset($modulEleres[1])) $modulEleres[1] = $modulEleres[0];

		

			$modul = trim($modulEleres[0]);
			$osztaly = trim($modulEleres[0].'_admin');
			$metodus = trim($modulEleres[1].(isset($modulEleres[2])?$modulEleres[2]:'index').'_ellenorzes');

			$elemnev = '';
			
			$a = array(
				'id' => $id, 
				'parameter' => serialize($this->input->post('a')),
				'elemnev' => '',
			);
			
			if(!file_exists(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php')) {
				$tartalombeallitas = false;
			} else {
				include_once(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php');
				$o = new $osztaly;
				// ha van ellenőrző metódus, lefuttatjuk, ha nincs, akkor mehet a mentés
				if(method_exists($o, $metodus)) {
					$a = $o->{$metodus}($a);
				} 
				
			}	

		

		

			// update és vissza a listába			
			if($a) {
				$this->Sql->sqlUpdate($a, DBP.'oldalak','id' );
				redirect(ADMINURL.'oldalak/tartalomepito/'.$oldal->id.'?m='.urlencode("Tartalom beállítása sikerült"));
				return;
			}
		}
		
		
		
		$data['moduleleresek'] = ws_tartalomkezeloatok();
		$moduleleres = array();
		foreach($data['moduleleresek'] as $k => $v ) $moduleleres[$k] = $v['cim'];
		
		globalisMemoria('utvonal', array(array('url' => 'oldalak/tartalomepito/'.$oldal->id, 'felirat' => ' tartalmak') , array('felirat'=> 'Oldal építőelemeinek szerkesztése')));
		$sor = $this->Sql->get($id, DBP.'oldalak', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Oldal elem szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'oldalak/tartalomepito/'.$oldal->id, 'felirat' => 'Vissza') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		
		// mindig az aktuális modulbeállítást keressük.
		$elem = $this->Sql->get($id, DBP.'oldalak', 'id');
		$modulEleres = explode('/', $elem->moduleleres);
		
		$tartalombeallitas = true;
		
		// ha csak annyi az elérés hogy pl. slider, és nincs osztály metódus,
		// akkor a modules/slider/slider.php index metódusát futtatja a frontend
		// és a modules/slieder/slider_admin.php sliderindex_beallito metódusa lesz a beállító
		//
		
		
		if(!isset($modulEleres[0])) $tartalombeallitas = false;
		if(!isset($modulEleres[2])) $modulEleres[2] = 'index';
		if(!isset($modulEleres[1])) $modulEleres[1] = $modulEleres[0];
		
		$modul = trim($modulEleres[0]);
		$osztaly = trim($modulEleres[0].'_admin');
		$metodus = trim($modulEleres[1].(isset($modulEleres[2])?$modulEleres[2]:'index').'_beallito');
		
		if(!file_exists(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php')) {
			$tartalombeallitas = false;
		} else {
		
			include_once(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php');
			$o = new $osztaly;
			
			
			if(!method_exists($o, $metodus)) $tartalombeallitas = false;
			//print $osztaly.'  osztály:' .ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php'."\n";
			//var_dump($tartalombeallitas);
			//print "\n". $metodus;
			//exit;
		}	
		
		
		if($tartalombeallitas == false) {
			$doboz = $ALG->ujDoboz();
			$doboz->dobozCim( 'Nincs beállítási lehetőség a tartalomnál.', 2);
			$doboz->HTMLHozzaadas('<p>Fejlesztőknek: '.$modul.' modul '.$osztaly.' osztáy '. $metodus.' beállító metódus nincs implementálva</p>');
		
		} else {
			// jön a varázslás: indítjuk a modul admin osztályának a fronted modulra vonatkozó beállítását:
			// paraméterek: unserializást paramétermező oldalak.parameter, és az adminoldal view komponense: ALG.
			// így hozzáteszi a kérdéses formokat a beállító az ALG-n keresztül a laphoz
			$o->$metodus(@unserialize($elem->parameter), $ALG);
			 
		}
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'oldalak/tartalomepito/'.$oldal->id,
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'Mentés',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
		
		
		
	}
	public function torles() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(5);		$urlid = (int)$ci->uri->segment(4);
		$url = $this->Sql->get($urlid, DBP.'oldal_urlek' , 'id');
		
		$data['moduleleresek'] = ws_tartalomkezeloatok();

		$sor = $this->Sql->get($id, DBP.'oldalak', 'id');
		if($sor->torolheto==0) {
			
			redirect(ADMINURL.'oldalak/tartalomepito/'.$urlid.'?m='.urlencode('A tartalom nem tötölhető, mert a rendszer működéséhez szükséges.'));
		}
		$this->ci->db->query("DELETE FROM ".DBP."oldalak WHERE id = ".(int)$id." LIMIT 1");
		redirect(ADMINURL.'oldalak/tartalomepito/'.$urlid.'?m='.urlencode('Sikeres törlés.'));
		
	}
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Oldalak');
		$ci = getCI();		$tag = ws_belepesEllenorzes();
		
		
		$id = (int)$ci->uri->segment(4);
		$urlid = (int)$ci->uri->segment(5);		$url = $this->Sql->get($urlid, DBP.'oldal_urlek' , 'id');
		$data['moduleleresek'] = ws_tartalomkezeloatok();
		$moduleleres = array();		$i = 0;
		foreach($data['moduleleresek'] as $k => $v ) {
			if(isset($v['jogkorok'])) {
				if(!$tag->is($v['jogkorok'])) continue;
			}
			$moduleleres[$k] = $v['cim'];			$i++;
		}
		
		globalisMemoria('utvonal', array(array('url' => 'oldalak/tartalomepito/'.$urlid, 'felirat' => $url->nev.' lap elemei') , array('felirat'=> 'Tartalomi elem kiválasztása')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;			if($a['url']=='Főoldal') $a['url'] = '';
			if($a['url']=='Nem meghatározott URL') $a['url'] = '***';
			
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'oldalak');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'oldalak');
					
			}			// ha van beállító, ugorjon oda egyből. 
			$modulEleres = explode('/', $a['moduleleres']);
			
			if(!isset($modulEleres[0])) $tartalombeallitas = false;

			if(!isset($modulEleres[2])) $modulEleres[2] = 'index';

			if(!isset($modulEleres[1])) $modulEleres[1] = $modulEleres[0];

			

			$modul = trim($modulEleres[0]);

			$osztaly = trim($modulEleres[0].'_admin');

			$metodus = trim($modulEleres[1].(isset($modulEleres[2])?$modulEleres[2]:'index').'_beallito');

			
			$tartalombeallitas = true;
			if(!file_exists(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php')) {

				$tartalombeallitas = false;

			} else {
				include_once(ROOTPATH.'modules/'.$modul.'/'.$osztaly.'.php');

				$o = new $osztaly;

				

				

				if(!method_exists($o, $metodus)) $tartalombeallitas = false;
			}
			if($tartalombeallitas) {
				redirect(ADMINURL.'oldalak/tartalomszerkesztes/'.$urlid.'/'.$id.'?m='.urlencode(($p=='')?'Sikeres tartalom hozzáadás.':$p));
				return;
			} else {			
				redirect(ADMINURL.'oldalak/tartalomepito/'.$urlid.'?m='.urlencode(($p=='')?'Sikeres módosítás.':$p));				return;
			}
		}
		
		$sor = $this->Sql->get($id, DBP.'oldalak', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Oldal elem szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'oldalak/tartalomepito/'.$urlid, 'felirat' => 'Tartalmak listája') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Oldal adatai', 2);
		if(!isset($sor->url)) {
			$sor = new stdClass();
			$sor->url = $url->url;
			if($sor->url == '') $sor->url = 'Főoldal';
			if($sor->url == '***') $sor->url = 'Nem meghatározott URL';
			
		}
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'url', 'felirat' => 'Slug (nem szerkeszthető)', 'ertek'=> @$sor->url, 'attr' => ' readonly '));
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'moduleleres', 'felirat' => 'Tartalom kiválasztása', 'ertek'=> @$sor->moduleleres, 'opciok' => $moduleleres));
		
		$doboz->duplaInput($input1, $select);
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'oldalak/tartalomepito/'.$urlid,
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'Mentés',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
		
		
	}
	
	public function szerkesztes_old() {
		$ci = getCI();
		$modulAdatok = ws_moduladatok();
		$data['tid'] = $id = (int)$ci->uri->segment(4);
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a');
			
			if($id==0) {
				$id = $this->sqlSave($a, 'oldalak');
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, 'oldalak', 'id');
			}
			
			redirect(ADMINURL.'oldalak/lista');
		}
		
		
		
		$data['sor'] = $this->get($id, 'oldalak', 'id');
		$data['moduleleresek'] = ws_tartalomkezeloatok();
		
		return $ci->load->view(ADMINTEMPLATE.'html/oldalak_szerkesztes', $data, true);
		
	}
}
