<?php

class Kinezetielemek_admin extends MY_Modul {
		// oldal tartalom név visszaadása
	
	function megjelenitesindex_ellenorzes($adat) {
		$param = unserialize($adat['parameter']);
		
		$elem = $lista = $this->ci->Sql->get( $param['kinezetielemek_id'], DBP."kinezetielemek", " id ");
		if(isset($elem->nev)) $adat['elemnev'] = $elem->nev; else return false;
		return $adat;
	}
	
	public function megjelenitesindex_beallito  ($parameter, $ALG) {
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Kinézeti elem kiválasztása', 2);
		
		$lista = $this->ci->Sql->gets(DBP."kinezetielemek", " ORDER BY nev ASC");
		$opciok = array(0 => 'Nincs kiválasztva');

		if($lista) foreach($lista as  $sor) {

			$opciok[$sor->id] = $sor->nev; 

		}

		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'kinezetielemek_id', 'opciok' => $opciok, 'ertek' => (isset($param['kinezetielemek_id']))?(int)$param['kinezetielemek_id']:0, 'felirat' => 'Válaszd ki az elemet'));

		$doboz->szimplaInput($select);
		return true;
	}
	
	public function lista () {
		globalisMemoria('utvonal', array(array('felirat' => 'Kinézeti elemek listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Kinézeti elemek");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'kinezetielemek/szerkesztes/0', 'felirat' => 'Új html elem felvitele'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$lista = $this->sqlSorok('SELECT * FROM kinezetielemek '.$w.' ORDER BY nev ASC ');
		foreach($lista as $sor) {
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'kinezetielemek/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'kinezetielemek/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('cellaAttr', array('alapertelmezett' => ' style="text-align:center" ' ));
		
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'kinezetielemek/lista', 'felirat' => 'Kinézeti elemek') , array('felirat'=> 'HTML elem szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$this->Sql->sqlSave($a, DBP.'kinezetielemek');
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'kinezetielemek');
					
			}
			redirect(ADMINURL.'kinezetielemek/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
		}
		
		$sor = $this->Sql->get($id, DBP.'kinezetielemek', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "HTML elem szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'kinezetielemek/lista', 'felirat' => 'Vissza') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Kinézeti elem', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		
		
		$doboz->szimplaInput($input1);
		$html = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'html', 'ertek' => htmlspecialchars( @$sor->html), 'attr' => ' id="editorarea" style="height:600px;" ' ));

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
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'kinezetielemek/lista',
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
		
		$this->db->query("DELETE FROM ".DBP."kinezetielemek WHERE id =  ".$id);
		redirect(ADMINURL.'kinezetielemek/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	
}
