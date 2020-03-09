<?php

class Hirlevel_admin extends MY_Modul {
	
	public $hirlevelStatuszNevek = array(0 => 'előkészítés alatt', 1=> 'kiküldésre vár', 2=> 'kiküldve', 4 => 'törölve');
		
	public function hirlevellista () {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('felirat' => 'Hírlevelek listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Hírlevél létrehozása - kiküldése");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'hirlevel/hirlevelszerkesztes/0', 'felirat' => 'Új hírlevél'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'hirlevelek '.$w.' ORDER BY ido DESC LIMIT '.$start.', 30');
		
		foreach($lista as $k => $v) {
			$lista[$k]->statusznev = $this->hirlevelStatuszNevek[$v->statusz];
			$lista[$k]->elonezet = '<a href="'.ADMINURL.'hirlevel/elonezet/'.$v->id.'?ajax=1" target="_blank" >előnézet</a>';
			$lista[$k]->tesztlevel = '<a href="'.ADMINURL.'hirlevel/tesztlevel/'.$v->id.'?ajax=1" target="_blank" >küldés</a>';
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'hirlevel/hirlevelszerkesztes/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('targy' => 'targy', 'ido' => 'Létrehozva','idozitve' => 'Időzítve','statusznev' => 'Státusz','szerkesztes' => 'Szerkesztés','elonezet' => 'Előnézet','tesztlevel' => 'Teszt'));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
	}
	public function sablonlista () {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('felirat' => 'Email sablonok listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "E-mail sablonok");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'hirlevel/sablonszerkesztes/0', 'felirat' => 'Új sablon'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'email_sablonok '.$w.' ORDER BY targy ASC LIMIT '.$start.', 30');
		
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'hirlevel/sablonszerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'hirlevel/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('targy' => 'targy', 'kulcs' => 'Azonosító', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function temaszerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		if(isset($_POST['html'])) file_put_contents(FCPATH.'assets/email/index.html',$_POST['html'] );
		
		globalisMemoria('utvonal', array(array('felirat'=> 'E-mail kinézet szerkesztő')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Email template szerkesztése");
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Előnézet', 2);
		$doboz->HTMLHozzaadas('<p>A témában a következő behelyettesí jelölőket lehet használni:<br>{{Böngésző URL}}, {{Jogi szöveg}}, {{Levél tartalom}}</p>');
		$doboz->HTMLHozzaadas('<iframe style="width:100%;height: 500px;border:1px solid #aaa;box-shadow: 2px 2px 7px #555;" src="'.base_url().'assets/email/index.html"></iframe>');
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'HTML szerkesztő', 3);
		$html = new Szovegdoboz(array('nevtomb' => '', 'mezonev' => 'html', 'ertek' => htmlspecialchars( file_get_contents(FCPATH.'assets/email/index.html')), 'attr' => ' id="editorarea" style="height:600px;" ' ));
		$doboz->szimplaInput($html);
		$ALG->tartalomHozzaadas('<script language="Javascript" type="text/javascript" src="'.base_url().TEMAMAPPA.'/'.ADMINTEMPLATE.'js/edit_area/edit_area_full.js"></script>
	<script language="Javascript" type="text/javascript">
		// initialisation
		editAreaLoader.init({
			id: "editorarea"	// id of the textarea to transform		
			,start_highlight: true	// if start with highlight
			,allow_resize: "both"
			,allow_toggle: true
			,word_wrap: true
			,language: "en"
			,syntax: "php"	
		});
		</script>');
		$ALG->tartalomDobozVege();
		
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'submit',
				'felirat' => 'Frissítés',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			),
		));
		$ALG->urlapVege();
		
		return $ALG->kimenet();
	}
	
	
	public function elonezet() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		include('autoload.php');
		$levelezo = new Levelkuldo_osztaly();
		$csereErtekek = array(
			'Terméklista' => '', 'Böngésző URL' => ADMINURL.'hirlevel/elonezet/'.$id, 'Keresztnév' => 'Elek',  'Jogi szöveg' => 'Ha nem akarsz több ilyen levelet kapni, kattints <a href="https://hu.wikipedia.org/wiki/Ombudsman">IDE</a>',
			'Keresztnév' => 'Elek','Vezetéknévnév' => 'Teszt', 'Teljes név' => 'Teszt Elek',
		);
		$levelezo->helyorzok($csereErtekek);
		
		$level = $levelezo->hirleveleloKeszites($id);
		
		print $levelezo->hirleveleloKeszites($id);
	}
	public function tesztlevel() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		include('autoload.php');
		$levelezo = new Levelkuldo_osztaly();
		$csereErtekek = array(
			'Terméklista' => '', 'Böngésző URL' => ADMINURL.'hirlevel/elonezet/'.$id, 'Keresztnév' => 'Elek',  'Jogi szöveg' => 'Ha nem akarsz több ilyen levelet kapni, kattints <a href="https://hu.wikipedia.org/wiki/Ombudsman">IDE</a>',
			'Keresztnév' => 'Elek','Vezetéknévnév' => 'Teszt', 'Teljes név' => 'Teszt Elek',
		);
		$levelezo->helyorzok($csereErtekek);
		
		$levelezo->hirleveleloKeszites($id);
		
		$levelezo->hirlevelKuldes(beallitasOlvasas('hirlevel.teszt.emailcimek'));
		
	
		
		//redirect(ADMINURL.'hirlevel/hirlevellista?m='.urlencode('Tesztlevél kiküldve ('.beallitasOlvasas('hirlevel.teszt.emailcimek').')'));
	}
	public function hirlevelszerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'hirlevel/hirlevellista', 'felirat' => 'Hírlevelek') , array('felirat'=> 'Hírlevél szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'hirlevelek');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'hirlevelek');
					
			}
			$p = '';
			
			
			redirect(ADMINURL.'hirlevel/hirlevellista?m='.urlencode(($p=='')?'Sikeres módosítás.':$p));
		}
		
		$sor = $this->Sql->get($id, DBP.'hirlevelek', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Hírlevél szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'hirlevel/hirlevellista', 'felirat' => 'Hírlevelek listája') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Hírlevél létrehozása', 2);
		$doboz->HTMLHozzaadas('<p>A levélben különböző behelyettesí jelölőket lehet használni, például {{Teljes név}}, {{Email}}, {{Keresztnév}}, {{Vezetéknév}}</p>');
		
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'targy', 'felirat' => 'Tárgy', 'ertek'=> @$sor->targy));
		$text = new Szovegdoboz(array('attr' => ' id="leiras" ', 'nevtomb' => 'a', 'mezonev' => 'tartalom', 'felirat' => 'Tartalom', 'ertek'=> @$sor->tartalom));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($text);
		
		$select = new Legordulo(array('opciok'=>$this->hirlevelStatuszNevek, 'nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'statusz', 'ertek' => @$sor->ertek));
		$input1 = new Szovegmezo(array('attr' => ' id="datum" ', 'nevtomb' => 'a', 'mezonev' => 'idozitve', 'felirat' => 'Időzítés (ÉÉÉÉ-HH-NN ÓÓ:PP)', 'ertek'=> @$sor->idozitve));
		
		
		
		$doboz->duplaInput($select, $input1);
		include_once(FCPATH.'modules/termek/autoload.php');
		$termekek = $this->Sql->sqlSorok('SELECT t.id FROM '.DBP.'termekek t, '.DBP.'jellemzok j WHERE j.termek_jellemzo_id = "'.beallitasOlvasas('termeknev.termekjellemzo_id').'" AND j.termek_id = t.id ORDER By ertek_2 ASC  ');
		$opcioLista = array('0' => 'Válassz terméket');
		foreach($termekek as $termek) {
			$t = new Termek_osztaly($termek->id);
			
			$opcioLista[$t->id] = $t->cikkszam.' - '.$t->jellemzo('Név').' ('.$t->ar.' '.$t->penznem.')';
		}
		$select = new Legordulo(array('attr' => ' onchange="$(\'#termek_idk\').val($(\'#termek_idk\').val()+$(this).val()+\', \');" ', 'opciok'=>$opcioLista, 'nevtomb' => '', 'mezonev' => '', 'felirat' => 'Termék hozzáadása a hírlevélhez', 'ertek' => '0'));
		$input1 = new Szovegmezo(array('attr' => ' id="termek_idk" ', 'nevtomb' => 'a', 'mezonev' => 'termeklista', 'felirat' => 'Termék azonosító lista', 'ertek'=> @$sor->termeklista));
		
		
		
		$doboz->szimplaInput($select);
		$doboz->szimplaInput($input1);
		
		// WYSWYG editor (Jodit)
		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');
		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');
		$doboz->ScriptHozzaadas('<script> var editor = new Jodit("#leiras", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');
		
		
		
		
		
		$ALG->tartalomDobozVege();
		$gombok = array();
		if(isset($sor->id)) {
			$gombok[] = array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Teszt küldés',
				'link' => ADMINURL.'hirlevel/tesztlevel/'.$sor->id,
				'onclick' => ""
			);
		}
		$gombok[] = array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'hirlevel/hirlevellista',
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			);
		$gombok[] = array(
				'tipus' => 'submit',
				'felirat' => 'Mentés',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			);
		$ALG->urlapGombok($gombok);
		$ALG->urlapVege();
		return $ALG->kimenet();
		
		
	}
	
	public function sablonszerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'hirlevel/sablonlista', 'felirat' => 'Email sablonok') , array('felirat'=> 'E-mail sablon szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'email_sablonok');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'email_sablonok');
					
			}
			$p = '';
			
			
			redirect(ADMINURL.'hirlevel/sablonlista?m='.urlencode(($p=='')?'Sikeres módosítás.':$p));
		}
		
		$sor = $this->Sql->get($id, DBP.'email_sablonok', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Sablon szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'hirlevel/sablonlista', 'felirat' => 'Email sablonok') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Sablon adatai', 2);
		$doboz->HTMLHozzaadas('<p>A sablonok a felhasználás helyétől függően különböző behelyettesí jelölőket llehet használni, például {{Teljes név}}, {{Email}}, {{Rendelés adatok}}</p>');
		
		$input1 = new Szovegmezo(array('attr' => ($id!=0)?' disabled ':'', 'nevtomb' => 'a', 'mezonev' => 'kulcs', 'felirat' => 'Azonosító kulcs', 'ertek'=> @$sor->kulcs));
		$doboz->duplaInput($input1, false);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'targy', 'felirat' => 'Tárgy', 'ertek'=> @$sor->targy));
		$text = new Szovegdoboz(array('attr' => ' id="#leiras" ', 'nevtomb' => 'a', 'mezonev' => 'html', 'felirat' => 'HTML', 'ertek'=> @$sor->html));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($text);
		// WYSWYG editor (Jodit)
		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');
		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');
		$doboz->ScriptHozzaadas('<script> var editorGyarto = new Jodit("#leiras", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');
		
		
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'hirlevel/sablonlista',
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
		$id = (int)$ci->uri->segment(4);
		
		$this->db->query("DELETE FROM ".DBP."email_sablonok WHERE id =  ".$id);
		redirect(ADMINURL.'hirlevel/sablonlista?m='.urlencode('Sikeres törlés!'));
		return;
	}
}
