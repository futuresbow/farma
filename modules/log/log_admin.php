<?php

class Log_admin extends MY_Modul {
	
	
	public function kibont () {				globalisMemoria("Nyitott menüpont",'Naplóbejegyzések');		globalisMemoria('utvonal', array(array('felirat' => 'Log lista')));		$ALG = new Adminlapgenerator;				$ALG->adatBeallitas('lapCim', "Log bejegyzések");		$ALG->adatBeallitas('szelessegOsztaly', "full-width");				$ALG->tartalomDobozStart();				$sessionid = $this->ci->uri->segment(4);		$sql = "SELECT * FROM ".DBP."naplobejegyzesek  WHERE sessionid = '{$sessionid}' ORDER BY ido DESC ";		$lista = $this->sqlSorok($sql);				$user = NULL;		$elemek = $this->getsIdArr(DBP.'naploelemek','id');				foreach($lista as $k => $sor) {						if($sor->felhasznaloid != 0) {				if(!$user) {					$user = $this->get($sor->felhasznaloid,DBP."felhasznalok" , 'id');				}				if($user) {					$sor->usernev = $user->vezeteknev." ".$user->keresztnev;					$sor->email = $user->email;									} else {					$sor->usernev = '';					$sor->email = '';									}			}			$elemid = $sor->naploelemid;			$nev = $elemek[$elemid]->nev;			$tabla = $elemek[$elemid]->tabla;						$lista[$k]->nev= $nev;			if($tabla!='') $lista[$k]->nev .= " (".$tabla.":".$sor->mentetid.")<br>";			if($sor->uzenet!='') $lista[$k]->nev .= $sor->uzenet;								}		// táblázat beállítás		$tablazat = $ALG->ujTablazat();						$keresoMezok = false;		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Esemény','usernev' => 'Felhasználó','email' => 'E-mail','ido' => 'Időpont' ));		$tablazat->adatBeallitas('lista', $lista);						$ALG->tartalomDobozVege();		return $ALG->kimenet();	}	public function lista () {		globalisMemoria("Nyitott menüpont",'Naplóbejegyzések');
		globalisMemoria('utvonal', array(array('felirat' => 'Log lista')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Log bejegyzések");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
				$elemek = $this->getsIdArr(DBP.'naploelemek','id');
		$sql = 'SELECT sessionid FROM '.DBP.'naplobejegyzesek '.$w.'  GROUP BY sessionid  LIMIT 50 ';		print $sql;		$lista = $this->sqlSorok($sql);				
		foreach($lista as $k => $sor) {						$sql = "SELECT * FROM ".DBP."naplobejegyzesek WHERE sessionid = '{$sor->sessionid}' ORDER BY ido DESC LIMIT 1";			$lista[$k] = $sor = $this->sqlSor($sql);			$nev = $elemek[$sor->naploelemid]->nev;			$tabla = $elemek[$sor->naploelemid]->tabla;			$lista[$k]->nev= $nev." (".$tabla.")";			$lista[$k]->kibont = '<a href="'.ADMINURL.'log/kibont/'.$sor->sessionid.'" >Kibont</a>';
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);

		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Esemény','kibont' => 'Kibontás' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'seo/lista', 'felirat' => 'Seo adatok') , array('felirat'=> 'SEO szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$this->Sql->sqlSave($a, DBP.'seo');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'seo');
					
			}
			redirect(ADMINURL.'seo/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, DBP.'seo', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Seo beállítások");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'seo/lista', 'felirat' => 'Seo beállítások') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Szállítási mód jellemzői', 2);
		
		$urlek = $this->ci->Sql->sqlSorok("SELECT DISTINCT(url) FROM ".DBP."oldalak ORDER BY url ASC ");
		$urltomb = array();
		foreach($urlek as $url) $urltomb[$url->url] = $url->url;
		$input1 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'url', 'felirat' => 'URL(hagyd üresen, ha a főoldalra vonatkozik)', 'ertek'=> @$sor->url, 'opciok' => $urltomb ));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'cim', 'attr' => ' onkeyup="$(\'.seo-title\').html(this.value);" ', 'felirat' => 'SEO Title', 'ertek'=> @$sor->cim));
		
		$doboz->duplaInput($input1, $input2);
		
		$input1 = new Szovegdoboz(array('nevtomb' => 'a','attr' => ' onkeyup="$(\'.seo-description\').html(this.value);" ', 'mezonev' => 'leiras', 'felirat' => 'SEO description', 'ertek'=> @$sor->leiras));
		$doboz->szimplaInput($input1);		$input1 = new Szovegdoboz(array('nevtomb' => 'a','attr' => 'id="szoveg"', 'mezonev' => 'hosszuleiras', 'felirat' => 'SEO hosszú leírás', 'ertek'=> @$sor->hosszuleiras));		$doboz->szimplaInput($input1);
		// WYSWYG editor (Jodit)		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');		$doboz->ScriptHozzaadas('<script> var editorGyarto = new Jodit("#szoveg", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');		
		
		$ALG->tartalomDobozVege();
		$ALG->tartalomDobozStart();
		$ALG->tartalom[] = $this->ci->load->view(ADMINTEMPLATE.'html/seo_elonezet', array('sor' => @$sor), true);
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'seo/lista',
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
		
		$this->db->query("DELETE FROM ".DBP."seo WHERE id =  ".$id);
		redirect(ADMINURL.'seo/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
}
