<?php

class Felhasznalok_admin extends MY_Modul {
	
	
	public function vasarlolista () {
				globalisMemoria("Nyitott menüpont",'Felhasználók');		globalisMemoria('utvonal', array(array('felirat' => 'Felhasználók listája')));		$ALG = new Adminlapgenerator;				$ALG->adatBeallitas('lapCim', "Vásárlók");		$ALG->adatBeallitas('szelessegOsztaly', "full-width");						$ALG->tartalomDobozStart();				// táblázat adatok összeállítása		$adatlista = array();		$start = 0;		$w = '';		$keresestorles = false;		if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {						$mod = (int)$sr['keresomezo'];			if($mod==0) $w = ' nev LIKE "%'.$sr['keresoszo'].'%" ';			if($mod==1) $w = ' email LIKE "%'.$sr['keresoszo'].'%" ';						$sql = "SELECT DISTINCT(t.id) FROM ".DBP."rendeles_felhasznalok WHERE $w";			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');			if($idArr) {				$w = " WHERE id IN (".implode(',', $idArr).") ";							} else {				$tabla = $ALG->ujTablazat();				$tabla->keresoTorles();				redirect(ADMINURL."felhasznalok/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));				return;			}		}				$lista = $this->sqlSorok('SELECT CONCAT( vezeteknev, " ", keresztnev) as nev, '.DBP.'rendeles_felhasznalok.* FROM '.DBP.'rendeles_felhasznalok '.$w.' GROUP BY email ORDER BY nev ASC LIMIT '.$start.', 30');		foreach($lista as $sor) {			$sql = "SELECT id FROM ".DBP."felhasznalok WHERE email = '{$sor->email}' LIMIT 1 ";			$reg = $this->Sql->sqlSor($sql);			$sor->regisztralt = ($reg)?'<a href="'.ADMINURL.'felhasznalok/szerkesztes/'.$reg->id.'" target="_blank" >IGEN</a>':'nem';						$sql = "SELECT COUNT(id) as ossz FROM ".DBP."rendeles_felhasznalok WHERE email = '{$sor->email}'  ";			$ossz = $this->Sql->sqlSor($sql);						$sor->rendelesSzam = '<a href="'.ADMINURL.'rendelesek/lista?sr%5Bkeresomezo%5D=0&sr%5Bkeresoszo%5D='.$sor->email.'">'.$ossz->ossz.' megrendelés</a>';								}		// táblázat beállítás		$tablazat = $ALG->ujTablazat();				$keresoMezok = array(			array('felirat' => 'Név', 'mezonev' => 'nev'),			array('felirat' => 'E-mail', 'mezonev' => 'email'),					);		$keresoMezok = false;		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);		$tablazat->adatBeallitas('szerkeszto_url', 'felhasznalok/szerkesztes/');		$tablazat->adatBeallitas('torles_url', 'felhasznalok/torles/');		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'email' => 'E-mail','regisztralt' => 'Regisztrált','rendelesSzam' => 'Rendelések száma' ));		$tablazat->adatBeallitas('lista', $lista);						$ALG->tartalomDobozVege();		return $ALG->kimenet();		
	}
	public function lista () {		globalisMemoria("Nyitott menüpont",'Felhasználók');
		globalisMemoria('utvonal', array(array('felirat' => 'Felhasználók listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Felhasználók");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'felhasznalok/szerkesztes/0', 'felirat' => 'Új felhasználó'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		$keresestorles = false;		$sr = @$_GET['sr'];				if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {
			
			$mod = (int)$sr['keresomezo'];
			if($mod==0) $w = ' ( vezeteknev LIKE "%'.$sr['keresoszo'].'%"  OR keresztnev LIKE "%'.$sr['keresoszo'].'%" ) ';
			if($mod==1) $w = ' email LIKE "%'.$sr['keresoszo'].'%" ';
			
			$sql = "SELECT DISTINCT(id) FROM ".DBP."felhasznalok WHERE $w";			
			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');
			if($idArr) {
				$w = " WHERE id IN (".implode(',', $idArr).") ";
				
			} else {
				$tabla = $ALG->ujTablazat();
				$tabla->keresoTorles();
				redirect(ADMINURL."felhasznalok/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
				return;
			}
		}
		$limit = 30;		$start = (isset($_GET['start']))?(int)$_GET['start']:0;		$sql = 'SELECT COUNT('.DBP.'felhasznalok.id) as ossz FROM '.DBP.'felhasznalok '.$w.' ';		$osszTalalat = $this->sqlSor($sql);		$osszSzam = (int)($osszTalalat->ossz);				$lista = $this->sqlSorok('SELECT CONCAT( vezeteknev, " ", keresztnev) as nev, '.DBP.'felhasznalok.* FROM '.DBP.'felhasznalok '.$w.' ORDER BY nev ASC LIMIT '.$start.', '.$limit);
		foreach($lista as $sor) {
			
			$sor->statusznev = $sor->statusz==0?' Kikapcsolva ':' Bekapcsolva ';
			
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Név', 'mezonev' => 'nev'),
			array('felirat' => 'E-mail', 'mezonev' => 'email'),
			
		);
		//$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'felhasznalok/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'felhasznalok/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'email' => 'E-mail', 'statusznev' => 'Státusz' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);				$tablazat->limit = $limit;		$tablazat->start = $start;		$tablazat->lapozo = true;				$tablazat->ossz = $osszSzam;
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function szerkesztes() {						globalisMemoria("Nyitott menüpont",'Felhasználók');
				$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'felhasznalok/lista', 'felirat' => 'Felhasználók') , array('felirat'=> 'Felhasználó szerkesztése')));
		$hiba = false;
		$urlapHiba = array();
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			
			if($a['jelszo']=='' ) {
				if($id == 0) {
					$hiba = true;
					$urlapHiba['jelszo'] = 'Adj meg egy jelszót';
				} else {
					unset($a['jelszo']);
				}
			} else {
				$a['jelszo']= md5(PASSWORD_SALT.$a['jelszo']);
			}
			if($a['vezeteknev']=='') {
				$hiba = true;
				$urlapHiba['vezeteknev'] = 'Név hiányzik';
			}
			if($a['keresztnev']=='') {
				$hiba = true;
				$urlapHiba['keresztnev'] = 'Név hiányzik';
			}
			if(!isEmail($a['email'])) {
				$hiba = true;
				$urlapHiba['email'] = 'Nem megfelelő E-mail.';
			}
			
			if(!$hiba) {
				if($id == 0) {
					$this->Sql->sqlSave($a, DBP.'felhasznalok');
				} else {
					$a['id'] = $id;
					$this->Sql->sqlUpdate($a, DBP.'felhasznalok');
					
				}
				redirect(ADMINURL.'felhasznalok/lista?m='.urlencode("A módosítások rögzítésre kerültek."));
				return;
			} else {
				
			}
		}
		
		$sor = $this->Sql->get($id, DBP.'felhasznalok', 'id');
		if($hiba===true) {
			$sor = (object)$a;
		}
		if(!is_object($sor)) $sor = new stdClass();
		$sor->jelszo = '';
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Felhasználók");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'felhasznalok/lista', 'felirat' => 'Felhasználók listája') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Felhasználói adatok', 2);
		$doboz->adatBeallitas('urlapHiba', $urlapHiba);
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'vezeteknev', 'felirat' => 'Vezetéknév', 'ertek'=> @$sor->vezeteknev));
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'keresztnev', 'felirat' => 'Keresztnév', 'ertek'=> @$sor->keresztnev));
		
		$doboz->duplaInput($input1, $input2);
		
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'email', 'felirat' => 'E-mail', 'ertek'=> @$sor->email));
		
		$doboz->szimplaInput($input2);
		
		$input2 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'jelszo', 'felirat' => 'Jelszó '.(isset($sor->id)?' (hagyd üresen, ha nem változik)':''), 'ertek'=> @$sor->jelszo));
		
		$doboz->szimplaInput($input2);
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));		$select2 = false;
				$tag = ws_belepesEllenorzes();		if($tag->is(JOG_SUPERADMIN)) {
			$jogValaszto = array();			$jogok = explode(",", JOG_LISTA);			foreach($jogok as $jSor) {				$jSor = explode(":", $jSor);				$jogValaszto[$jSor[0]] = $jSor[1];			}
					$select2 = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'adminjogok', 'felirat' => 'Hozzáférési szint', 'ertek'=> @$sor->adminjogok, 'opciok' => $jogValaszto));		}		$doboz->duplaInput($select, $select2);
			
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'felhasznalok/lista',
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
		
		$this->db->query("DELETE FROM ".DBP."felhasznalok WHERE id =  ".$id);
		redirect(ADMINURL.'felhasznalok/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	public function kilepes() {
		$ci = getCI();
		ws_autoload('felhasznalok');
		$tag = new Tag_osztaly($this->ci->session->userdata('__belepett_felhasznalo'));
		$log = $tag->vezeteknev.' '.$tag->keresztnev." az adminról kilépett.";
		ws_log('felhasznalo', $log);
			
		$ci->session->unset_userdata('__belepett_felhasznalo');
		redirect(base_url());
	}
}
