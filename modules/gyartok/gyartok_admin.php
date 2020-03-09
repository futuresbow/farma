<?php

class Gyartok_admin extends MY_Modul {
	
	
	public function lista () {		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Fizetési módok listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Gyártók");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'gyartok/szerkesztes/0', 'felirat' => 'Új gyártó'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'gyartok '.$w.' ORDER BY nev ASC LIMIT '.$start.', 30');
		foreach($lista as $sor) {
			
			$sor->statusznev = $sor->statusz==0?' Aktív ':' Nem aktív ';
			if($sor->logo) $sor->logo = '<img src="'.base_url().ws_image($sor->logo, 'smallboxed').'" >';
			
			
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'gyartok/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'gyartok/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'logo' => 'Logó','statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Termékek');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'gyartok/lista', 'felirat' => 'Fizetési módok') , array('felirat'=> 'Fizetési mód szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'gyartok');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a,DBP. 'gyartok');
					
			}
			$p = '';
			
			if($_FILES['logokep']['name']!='') {
				if(imgcheck('logokep')) {
					$filenev = 'logo_'.$id.'.'.ws_ext($_FILES['logokep']['name']);
					$path = 'assets/gyartok/';
					if(move_uploaded_file($_FILES['logokep']['tmp_name'],FCPATH.$path.$filenev )) {
						// all is fine...
						$a['logo'] = $path.$filenev;
						
						$this->Sql->sqlUpdate($a,DBP.'gyartok' );
						ws_delimagevariants($path.$filenev);
					} else {
						$p = urlencode("Hiba a kép feltöltésénél!");
					}
				} else $p = urlencode("Hiba a kép feltöltésénél!");
			}
			
			redirect(ADMINURL.'gyartok/lista?m='.urlencode(($p=='')?'Sikeres módosítás.':$p));
		}
		
		$sor = $this->Sql->get($id, DBP.'gyartok', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Gyártó szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'gyartok/lista', 'felirat' => 'Gyártók') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Gyártó adatai', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$text = new Szovegdoboz(array('attr' => ' id="gyartoleiras" ', 'nevtomb' => 'a', 'mezonev' => 'leiras', 'felirat' => 'Leírás', 'ertek'=> @$sor->leiras));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($text);
		// WYSWYG editor (Jodit)
		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');
		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');
		$doboz->ScriptHozzaadas('<script> var editorGyarto = new Jodit("#gyartoleiras", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');
		
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Bekapcsolva', 1=>'Kikapcsolva')));
		$file = new Filefeltolto(array('attr' => '', 'nevtomb' => '','tipus' => 'feltoltes', 'mezonev' => 'logokep', 'felirat' => 'Logó kép (jpg, png)'));
		
		$doboz->duplaInput($select, $file);
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'gyartok/lista',
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
		
		$this->db->query("DELETE FROM ".DBP."gyartok WHERE id =  ".$id);
		redirect(ADMINURL.'gyartok/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
}
