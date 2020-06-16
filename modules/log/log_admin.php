<?php

class Log_admin extends MY_Modul {
	
	
	public function kibont () {
		globalisMemoria('utvonal', array(array('felirat' => 'Log lista')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Log bejegyzések");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		
		$sql = 'SELECT sessionid FROM '.DBP.'naplobejegyzesek '.$w.'  GROUP BY sessionid  LIMIT 50 ';
		foreach($lista as $k => $sor) {
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
	
	public function szerkesztes() {
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
		$doboz->szimplaInput($input1);
		// WYSWYG editor (Jodit)
		
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