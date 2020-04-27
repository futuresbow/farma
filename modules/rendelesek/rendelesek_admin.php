<?php

class Rendelesek_admin extends MY_Modul {
	
	
	public function szamlaletoltes () {
		$id = (int)$this->ci->uri->segment(4);
		
		$sor = $this->Sql->get($id, DBP.'szamlazas', 'id');
		if($sor){
			if(file_exists(SZAMLAMAPPA.'pdf/'.$sor->szamlanev.'.pdf')) {
				
				
				header("Content-type:application/pdf");
				header("Content-Disposition:attachment;filename={$sor->szamlanev}.pdf");

				readfile (SZAMLAMAPPA.'pdf/'.$sor->szamlanev.'.pdf');
				die();
			} else {
				die("Probléma maerült fel: a file nem található.");
			}
		} else {
			die('Nincs hozzáférésed ehhez a tartalomhoz');
		}
	}
	
	public function kimutatas () {
		globalisMemoria("Nyitott menüpont",'Kimutatás');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Megrendelések listája')));

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Kimutatás");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'rendelesek/rendelesletrehozas', 'felirat' => 'Új megrendelés'));

		$sql = "SELECT * FROM aruhazak ";
		if(@$_GET['sr']['aruhaz']>0) $sql .= " WHERE id = ".@$_GET['sr']['aruhaz'];
		$sql .= " ORDER BY nev ASC";
		$aruhazak = $this->sqlSorok ($sql);

		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim('Keresés');
		$doboz->HTMLHozzaadas( $this->ci->load->view( 
			beallitasOlvasas('ADMINTEMA').'/html/rendeles_kivonat_filter', 
			array('aruhazak' => $aruhazak) , 
			true
		));
		
		
		
		foreach($aruhazak as $aruhaz) {
		
			$doboz = $ALG->ujDoboz();
			$doboz->dobozCim('Áruház: '.$aruhaz->nev);
			$DBP = $aruhaz->prefix;
			
			$w = ' WHERE 1 = 1 ';
			
			$limit = 30;
			$start = (isset($_GET['start']))?(int)$_GET['start']:0;
			
			if(( @$_GET['sr']['email'] != '' )) {
				$w .= ' AND f.id = r.rendeles_felhasznalo_id AND f.email LIKE "'.$_GET['sr']['email'].'" ';
			}
			if(( @$_GET['sr']['tol'] != '' )) {
				$w .= ' AND f.id = r.rendeles_felhasznalo_id AND f.ido > "'.$_GET['sr']['tol'].'" ';
			}
			if(( @$_GET['sr']['ig'] != '' )) {
				$w .= ' AND f.id = r.rendeles_felhasznalo_id AND f.ido <= "'.$_GET['sr']['ig'].'" ';
			}
			
			
			
			$sql = 'SELECT COUNT(*) as ossz FROM '. $DBP.'rendelesek r , '.$DBP.'rendeles_felhasznalok f '.$w;
			
			//print $sql;
			
			$osszTalalat = $this->sqlSor($sql);
			$osszSzam = (int)($osszTalalat->ossz);
			$doboz->dobozCim('Áruház: '.$aruhaz->nev." ($osszSzam találat)");
			$lista = $this->sqlSorok('SELECT r.* FROM '. $DBP.'rendelesek r , '.$DBP.'rendeles_felhasznalok f '.$w.' ORDER BY r.ido DESC LIMIT '.$start.', '.$limit);

			$statuszopciok = '';

			$statuszArr = array();

			foreach($this->gets(DBP."rendeles_statusz", " ORDER BY sorrend ASC") as $sor)  {

				$statuszopciok .= '<option  value="'.$sor->id.'">'.$sor->nev.'</option>';

				$statuszArr[$sor->id] = $sor->nev;

				

			}

			foreach($lista as $sor) {

				$sor->statuszvaltoztatas = '<select ><option value="0">Válassz</option>'.$statuszopciok.'</select><button onclick="window.location.href=\''.ADMINURL.'rendelesek/statszbeallitas/'.$sor->id.'/\'+$(this).prev().val()">OK</button> <b>Státusz: '.$statuszArr[$sor->statusz].'</b>';

				$vevoRs = $this->Sql->sqlSor("SELECT * FROM ".DBP."rendeles_felhasznalok WHERE id = {$sor->rendeles_felhasznalo_id} LIMIT 1");

				$sor->vevo = $vevoRs->vezeteknev.' '.$vevoRs->keresztnev;

				$sor->osszar = ws_arformatum($sor->osszar).' Ft';

				$sor->ido = date('Y-m-d', strtotime($sor->ido));

			}

			// táblázat beállítás

			$tablazat = $ALG->ujTablazat();

			

			$keresoMezok = array(
				array('felirat' => 'Vevő E-mail címe', 'mezonev' => 'vemail'),
				array('felirat' => 'Rendelés azonosító', 'mezonev' => 'raz'),
				
			);
			
			$tablazat->adatBeallitas('keresoMezok', false);

			$tablazat->adatBeallitas('szerkeszto_url', 'rendelesek/szerkesztes/');

			$tablazat->adatBeallitas('torles_url', 'rendlesek/torles/');

			$tablazat->adatBeallitas('megjelenitettMezok', array('vevo' => 'Vevő', 'ido' => 'Dátum' ,'osszar' => 'Összeg (nettó)', 'statuszvaltoztatas' => 'Státsz',  'szerkesztes' => 'Szerkesztés'));

			$tablazat->adatBeallitas('lista', $lista);

			
			$tablazat->limit = $limit;
			$tablazat->start = $start;
			$tablazat->lapozo = true;
			
		}
		
		$ALG->tartalomDobozVege();

		return $ALG->kimenet();

	}
	public function lista () {		globalisMemoria("Nyitott menüpont",'Rendelések');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Megrendelések listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Rendelések");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'rendelesek/rendelesletrehozas', 'felirat' => 'Új megrendelés'));
		
		$ALG->tartalomDobozStart();
		
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';		$sr = $this->ci->input->get('sr');
		// keresések
		$keresestorles = false;
		if(isset($sr['keresoszo'])) if($sr['keresoszo']!='') {
			
			$mod = (int)$sr['keresomezo'];
			if($mod==0) $w = ' f.email LIKE "%'.$sr['keresoszo'].'%" ';
			if($mod==1) {
				$rid = $sr['keresoszo'];
				
				preg_match_all('!\d+!', $rid, $matches);
				$rid = (int)$matches[0][0];
				
				$w = ' r.id = '.$rid.' ';
			}
			$sql = "SELECT DISTINCT(r.id) FROM ".DBP."rendelesek r, ".DBP."rendeles_felhasznalok f WHERE f.id = r.rendeles_felhasznalo_id AND $w";
			
			
			$idArr = ws_valueArray($this->Sql->sqlSorok($sql), 'id');
			
			if($idArr) {
				$w = " WHERE  id IN (".implode(',', $idArr).") ";
				
			} else {
				$tabla = $ALG->ujTablazat();
				$tabla->keresoTorles();
				redirect(ADMINURL."rendelesek/lista?m=".urlencode("Nincs a keresésnek megfelelő találat!"));
				return;
			}
		}
		
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'rendelesek '.$w.' ORDER BY ido DESC LIMIT '.$start.', 30');
		$statuszopciok = '';
		$statuszArr = array();
		foreach($this->gets(DBP."rendeles_statusz", " ORDER BY sorrend ASC") as $sor)  {
			$statuszopciok .= '<option  value="'.$sor->id.'">'.$sor->nev.'</option>';
			$statuszArr[$sor->id] = $sor->nev;
			
		}
		foreach($lista as $sor) {
			$sor->statuszvaltoztatas = '<select ><option value="0">Válassz</option>'.$statuszopciok.'</select><button onclick="window.location.href=\''.ADMINURL.'rendelesek/statszbeallitas/'.$sor->id.'/\'+$(this).prev().val()">OK</button> <b>Státusz: '.$statuszArr[$sor->statusz].'</b>';
			$vevoRs = $this->Sql->sqlSor("SELECT * FROM ".DBP."rendeles_felhasznalok WHERE id = {$sor->rendeles_felhasznalo_id} LIMIT 1");
			$sor->vevo = $vevoRs->vezeteknev.' '.$vevoRs->keresztnev;
			$sor->osszar = ws_arformatum($sor->osszar).' Ft';
			$sor->ido = date('Y-m-d', strtotime($sor->ido));
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Vevő E-mail címe', 'mezonev' => 'vemail'),
			array('felirat' => 'Rendelés azonosító', 'mezonev' => 'raz'),
			
		);
		
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'rendelesek/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'rendlesek/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('vevo' => 'Vevő', 'ido' => 'Dátum' ,'osszar' => 'Összeg (nettó)', 'statuszvaltoztatas' => 'Státsz',  'szerkesztes' => 'Szerkesztés'));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
		
	}
	
	public function rendelesletrehozas() {
		$ci = getCI();
		if( !is_null($ci->input->post('felhasznalo_id'))) {
			var_dump($ci->input->post('felhasznalo_id'));
		
			if($ci->input->post('felhasznalo_id')==0) {
				$f = array('felhasznalo_id'=>0) ;
				$rfid = $this->Sql->sqlSave($f, DBP.'rendeles_felhasznalok');
			} else {
				$u = $this->Sql->get($ci->input->post('felhasznalo_id'), DBP.'felhasznalok', 'id');
				$rf = $this->Sql->get($u->id, DBP.'rendeles_felhasznalok', 'felhasznalo_id');
				if(isset($rf->id)) {
					// már rendelt
					$rfid = $rf->id;
				} else {
					// regisztrált de még nem rendelt
					$f = array('felhasznalo_id'=>$u->id, 'vezeteknev' => $u->vezeteknev,'keresztnev' => $u->keresztnev, 'email' => $u->email);
					$rfid = $this->Sql->sqlSave($f, DBP.'rendeles_felhasznalok');
				}
			}
			
			$statusz = $this->get(1, DBP."rendeles_statusz", 'alapertelmezett');
			$a = array('statusz' => $statusz->id, 'rendeles_felhasznalo_id' => $rfid);
			$rid = $this->Sql->sqlSave($a, DBP.'rendelesek');
			// rendelés sikeresen létrehozva, mehet a szerkesztés
			redirect(ADMINURL.'rendelesek/szerkesztes/'.$rid);
			
			return;
		}
		
		
		globalisMemoria('utvonal', array(array('url' => 'rendelesek/lista', 'felirat' => 'Megrendelések') , array('felirat'=> 'Megrendelés szerkesztése')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Megrendelés létrehozása");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'rendelesek/lista', 'felirat' => 'Megrendelések') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Vásárló kiválasztása', 2);
		
		$felhasznalok = $this->Sql->sqlSorok("SELECT CONCAT(vezeteknev, ' ', keresztnev) as nev, ".DBP."felhasznalok.* FROM ".DBP."felhasznalok ORDER BY nev ASC") ;
		$lista = array(0 => 'Nem regisztrált felhasználó');
		foreach($felhasznalok as $sor)  $lista[$sor->id] = $sor->nev." (".$sor->email.")";
		
		$select = new Legordulo(array('nevtomb' => '', 'mezonev' => 'felhasznalo_id', 'felirat' => 'Válassz felhasználót <smal><a href="'.ADMINURL.'felhasznalok/szerkesztes/0">Új felhasználó felvitele</a></smal>', 'opciok' => $lista));
		$doboz->szimplaInput($select);
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'rendelesek/lista',
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'Tovább',
				'link' => '',
				'osztaly' => 'btn-ok',
				
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
	}	
	public function megrendelesStatuszvaltozasHook($param) {
		// státuszváltozásos értesítések, stb...
		$rendeles = new Rendeles_osztaly;
		$rendeles->betoltesMegrendeles($param['rendeles_id']);
		if(isset($param['megjegyzes']))
		{
			$megjegyzes = $param['megjegyzes'];
		}
		else 
		{
			$megjegyzes = false;
		}
		
		//print $rendeles->id;
		$statusz = $this->get($rendeles->statusz, 'rendeles_statusz', 'id');		
		
		if(isset($param['szamlazas'])) {
			// készült számla már?
			if(ws_autoload('szamlak')) {
				
				$szamla = new Szamla_osztaly();
				$szamla->szamlazz($rendeles);
			}
			
			
		}
		
		
		$kod = $statusz->kod;
		switch($kod) {
			// rendelés leadása
			case 'LEA':

				
				$targy = rendszerUzenetTargy("rendeles_visszaigazolo_leadas");

				$uzenet = rendszerUzenet("rendeles_visszaigazolo_leadas");

				$adattabla = $rendeles->megrendelesAdatTablak();

		

		

				include(ROOTPATH.'modules/hirlevel/autoload.php');

				$level = new Levelkuldo_osztaly;

				$level->helyorzo('Teljes név', $rendeles->vevo->vezeteknev.' '.$rendeles->vevo->keresztnev);

				$level->helyorzo('Keresztnév', $rendeles->vevo->keresztnev);

				$level->helyorzo('Vezetéknév', $rendeles->vevo->vezeteknev);

				$level->helyorzo('Email', $rendeles->vevo->email);

				$level->helyorzo('Rendelés ID', ws_ordernumber($rendeles->id));
				if($megjegyzes)
				{
					$level->helyorzo('Megjegyzés', ($megjegyzes));
				}
				$level->rendszerlevelKeszites($uzenet.'<br><br>'.$adattabla);

				

				$level->levelKuldes($rendeles->vevo->email, $targy);
				$level->levelKuldes(beallitasOlvasas('admin_ertesites_email_cim'), 'WEBSHOP megrendelés érkezett');

				

				

			break;
			case 'FOG':
				
				// visszaigazolás elküldése
				
				$targy = rendszerUzenetTargy("rendeles_visszaigazolo_fogadva");
				$uzenet = rendszerUzenet("rendeles_visszaigazolo_fogadva");
				$adattabla = $rendeles->megrendelesAdatTablak();
		
		
				include(ROOTPATH.'modules/hirlevel/autoload.php');
				$level = new Levelkuldo_osztaly;
				$level->helyorzo('Teljes név', $rendeles->vevo->vezeteknev.' '.$rendeles->vevo->keresztnev);
				$level->helyorzo('Keresztnév', $rendeles->vevo->keresztnev);
				$level->helyorzo('Vezetéknév', $rendeles->vevo->vezeteknev);
				$level->helyorzo('Email', $rendeles->vevo->email);
				$level->helyorzo('Rendelés ID', ws_ordernumber($rendeles->id));				if($megjegyzes)
				{
					$level->helyorzo('Megjegyzés', ($megjegyzes));
				}
				$level->rendszerlevelKeszites($uzenet.'<br><br>'.$adattabla);
				
				$level->levelKuldes($rendeles->vevo->email, $targy);
				
				
			break;			
					case 'KESZ':
				
				// visszaigazolás elküldése
				
				$targy = rendszerUzenetTargy("rendeles_visszaigazolo_kesz");
				$uzenet = rendszerUzenet("rendeles_visszaigazolo_kesz");
				$adattabla = $rendeles->megrendelesAdatTablak();
		
				
				include(ROOTPATH.'modules/hirlevel/autoload.php');
				$level = new Levelkuldo_osztaly;
				$level->helyorzo('Teljes név', $rendeles->vevo->vezeteknev.' '.$rendeles->vevo->keresztnev);
				$level->helyorzo('Keresztnév', $rendeles->vevo->keresztnev);
				$level->helyorzo('Vezetéknév', $rendeles->vevo->vezeteknev);
				$level->helyorzo('Email', $rendeles->vevo->email);
				$level->helyorzo('Rendelés ID', ws_ordernumber($rendeles->id));				
				if($megjegyzes)
				{
					$level->helyorzo('Megjegyzés', ($megjegyzes));
				}
				$level->rendszerlevelKeszites($uzenet.'<br><br>'.$adattabla);				// számla csatolása?
				// készült már számla?
				$vanSzamla = $this->sqlSor("SELECT * FROM ".DBP."szamlazas WHERE rendeles_id = ".$rendeles->id." AND sztorno = 0 ");
				if(isset($vanSzamla->szamlanev)) {
					// csatoljuk
					$level->mail->addAttachment(FCPATH."data/pdf/".$vanSzamla->szamlanev.".pdf");
				}
				
				$level->levelKuldes($rendeles->vevo->email, $targy);
								
				
			break;			
		}
		
	}
	public function statszbeallitas() {
		
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		$statuszId = (int)(int)$ci->uri->segment(5);		if(!$statuszId) {
			redirect(ADMINURL.'rendelesek/lista?m='.urlencode("Sikeres státuszváltoztatás"));
			return;
		}
		if($this->ci->input->post('a')) {			$s = $this->ci->input->post('a');
			$statuszId = $s['termek_statuszid'];
			
			$rendeles = new Rendeles_osztaly(); 
			$rendeles->betoltesMegrendeles($id);
			if($rendeles->statusz!=$statuszId) {
			//if(true) {  // teszteléshez kikötve
				$a = array();
				$a['id'] = $rendeles->id;
				$a['statusz'] = $statuszId;
				$ci->Sql->sqlUpdate($a, DBP.'rendelesek', 'id');
				$ci->Sql->sqlSave($s, DBP.'rendeles_statuszvaltasok');
				
				$data = array('rendeles_id' => $rendeles->id , 'megjegyzes' => $s['megjegyzes_nyilvanos']);
				// számla?
				
				if(isset($_POST['szamla']['ok'])) {
					$data['szamlazas'] = true;
				}
				
				ws_hookFuttatas('rendeles.statuszvaltozas', $data);
			}			redirect(ADMINURL.'rendelesek/lista?m='.urlencode("Sikeres státuszváltoztatás"));
		}
		$rendeles = new Rendeles_osztaly(); 
		$rendeles->betoltesMegrendeles($id);
		

		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Rendelés státusz változtatás");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'rendelesek/lista', 'felirat' => 'Vissza a rendelésekhez') );

		

		$ALG->urlapStart(array('attr'=> ' id="rendelesForm" action="" enctype="multipart/form-data" method="post" '));

		

		$ALG->tartalomDobozStart();

		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( '', 3);

		

		$statuszok = $ci->Sql->gets(DBP.'rendeles_statusz', ' ORDER BY sorrend');
		$lista = array(); foreach($statuszok as $sor) $lista[$sor->id] = $sor->nev;
		
		

		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'termek_statuszid','felirat' => 'Státusz', 'attr' => '' , 'ertek' => $statuszId, 'opciok' => $lista ));

		$doboz->szimplaInput($select);
		
		$text1 = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'megjegyzes_privat','felirat' => 'Privát megjegyzés', 'attr' => ' ' , 'ertek' => '' ));
		$text2 = new Szovegdoboz(array('nevtomb' => 'a', 'mezonev' => 'megjegyzes_nyilvanos','felirat' => 'Nyilvános megjegyzés', 'attr' => ' ' , 'ertek' => '' ));
		$doboz->duplaInput($text1, $text2 );
		
		$statusz = $this->Sql->get($statuszId, 'rendeles_statusz', 'id');
		if(!isset($statusz->id)) {
			redirect(ADMINURL.'rendelesek/lista?m='.urlencode("Hibás státusz"));
			return;
		}
		if($statusz->szamlakeszites) {
			$pipa1 = new Jelolonegyzet(array('felirat' => 'Számla elkészítése','nevtomb' => 'szamla', 'mezonev' => 'ok', 'ertek' => 1,  'attr' => ' checked '  ));

			$doboz->dobozElemJelolonegyzetek(array($pipa1));

		}
		
		
		$ALG->tartalomDobozVege();

		$ALG->urlapGombok(array(

			0 => array(

				'tipus' => 'hivatkozas',

				'felirat' => 'Mégse',

				'link' => ADMINURL.'rendelesek/lista',

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
	public function szerkesztes() {
		
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'rendelesek/lista', 'felirat' => 'Megrendelések') , array('felirat'=> 'Megrendelés szerkesztése')));
		
		
		$rendeles = new Rendeles_osztaly(); 
		$rendeles->betoltesMegrendeles($id);
		
		if($ci->input->post('r')) {
			// státusz állítás hook
			$r = $ci->input->post('r');
			if($rendeles->statusz!=$r['statusz']) {
				$a = array();
				$a['id'] = $rendeles->id;
				$a['statusz'] = $r['statusz'];
				$ci->Sql->sqlUpdate($a, DBP.'rendelesek', 'id');
				
				ws_hookFuttatas('rendeles.statuszvaltozas', array('rendeles_id' => $rendeles->id ));
			}
			$v = (array)$ci->input->post('v');
			$v['id'] = $rendeles->rendeles_felhasznalo_id;
			$this->Sql->sqlUpdate($v, DBP.'rendeles_felhasznalok', 'id');
			
			redirect(ADMINURL.'rendelesek/lista');
			return ;
			
		}
		
		
		$rendeles->betoltesMegrendeles($id);
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Megrendelés adatai");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'rendelesek/lista', 'felirat' => 'Vissza a listához') );
		
		$ALG->urlapStart(array('attr'=> ' id="rendelesForm" action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( '', 3);
		
		$statuszok = $ci->Sql->gets(DBP.'rendeles_statusz', ' ORDER BY sorrend');
		$lista = array(); foreach($statuszok as $sor) $lista[$sor->id] = $sor->nev;
		
		$input1 = new Szovegmezo(array('nevtomb' => '', 'mezonev' => 'rendelesszam','felirat' => 'Rendelés száma', 'attr' => ' disabled' , 'ertek' => ws_ordernumber($rendeles->id) ));
		$select = new Legordulo(array('nevtomb' => 'r', 'mezonev' => 'statusz','felirat' => 'Státusz', 'attr' => '' , 'ertek' => $rendeles->statusz, 'opciok' => $lista ));
		
		$doboz->duplaInput($input1, $select);		
		$szamlak = $this->Sql->sqlSorok("SELECT * FROM ".DBP."szamlazas WHERE rendeles_id =  $id ");
		if($szamlak) {
			$doboz->HTMLHozzaadas("<b>Létrejött számlák:</b><br>");
			foreach($szamlak as $szamlasor) {
				$doboz->HTMLHozzaadas('<a target="_blank" href="'.ADMINURL.'rendelesek/szamlaletoltes/'.$szamlasor->id.'">'.$szamlasor->szamlanev.' letöltése</a>');
			}
		}
		$ALG->tartalomDobozVege();
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		
		$doboz->dobozCim( 'Termékek', 2);
		$termekek = $this->Sql->sqlSorok("SELECT DISTINCT(t.id), j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." ORDER BY nev ASC");
		$lista = array(0 => 'Válassz terméket');
		foreach($termekek as  $t) $lista[$t->id] = $t->nev." (".$t->ar." Ft)";
		$select = new Legordulo(array('attr' => ' onchange="aJs.termekHozzaadas('.$id.',this);" ', 'nevtomb' => '', 'mezonev' => 'termek_id', 'felirat' => 'Termék hozzáadása', 'opciok' => $lista));
		$doboz->szimplaInput($select);
		//$doboz->HTMLHozzaadas('<a href="javascript:void()" title="Termék hozzáadása" onclick="aJs.termekKereso();" class="btn">Termék hozzáadása...</a>');
		
		$doboz->ScriptHozzaadas('<div class="rendeltTermekekDiv"></div>');
		$doboz->ScriptHozzaadas('<script>$().ready(function(){ aJs.rendelesTermeklista('.$id.'); })</script>');
		
		/*
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$text = new Szovegdoboz(array('attr' => ' id="gyartoleiras" ', 'nevtomb' => 'a', 'mezonev' => 'leiras', 'felirat' => 'Leírás', 'ertek'=> @$sor->leiras));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($text);
		// WYSWYG editor (Jodit)
		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');
		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');
		$doboz->ScriptHozzaadas('<script> var editorGyarto = new Jodit("#gyartoleiras", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');
		
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'statusz', 'felirat' => 'Státusz', 'ertek'=> @$sor->statusz, 'opciok' => array(0=>'Kikapcsolva', 1=>'Bekapcsolva')));
		$file = new Filefeltolto(array('nevtomb' => '','tipus' => 'feltoltes', 'mezonev' => 'logokep', 'felirat' => 'Logó kép (jpg, png)'));
		
		$doboz->duplaInput($select, $file);
		
		*/
		
		$ALG->tartalomDobozVege();
		// felhasználói adatok
		$vasarlo = new Vasarlo_osztaly($rendeles->rendeles_felhasznalo_id);
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Személyes adatok', 3);
		
		$input1 = new Szovegmezo(array('attr' => '', 'nevtomb' => 'v', 'mezonev'=> 'vezeteknev', 'felirat' => 'Vezetéknév', 'ertek' => $vasarlo->legfrissebbErtek('vezeteknev') ));
		$input2 = new Szovegmezo(array('attr' => '','nevtomb' => 'v', 'mezonev'=> 'keresztnev', 'felirat' => 'Keresztnév', 'ertek' => $vasarlo->legfrissebbErtek('keresztnev') ));
		
		$doboz->duplaInput($input1,  $input2);
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Számlázási adatok ', 3);
		
		$input1 = new Szovegmezo(array('attr' => ' id="szaml_nev" ','nevtomb' => 'v', 'mezonev'=> 'szaml_nev', 'felirat' => 'Név', 'ertek' => $vasarlo->legfrissebbErtek('szaml_nev') ));
		
		$doboz->szimplaInput($input1);
		
		$input1 = new Szovegmezo(array('attr' => ' id="szaml_orszag" ','nevtomb' => 'v', 'mezonev'=> 'szaml_orszag', 'felirat' => 'Ország', 'ertek' => $vasarlo->legfrissebbErtek('szaml_orszag') ));
		$input2 = new Szovegmezo(array('attr' => ' id="szaml_telepules" ','nevtomb' => 'v', 'mezonev'=> 'szaml_telepules', 'felirat' => 'Település', 'ertek' => $vasarlo->legfrissebbErtek('szaml_telepules') ));
		
		$doboz->duplaInput($input1,  $input2);
		
		
		$input1 = new Szovegmezo(array('attr' => ' id="szaml_utca" ','nevtomb' => 'v', 'mezonev'=> 'szaml_utca', 'felirat' => 'Utca, házszám', 'ertek' => $vasarlo->legfrissebbErtek('szaml_utca') ));
		$input2 = new Szovegmezo(array('attr' => ' id="szaml_irszam" ','nevtomb' => 'v', 'mezonev'=> 'szaml_irszam', 'felirat' => 'Irányítószám', 'ertek' => $vasarlo->legfrissebbErtek('szaml_irszam') ));
		
		$doboz->duplaInput($input1,  $input2);
		
		
		$doboz->HTMLHozzaadas('<button class="btn btn-small" type="button" onclick="aJs.cimMasolas() ;" style="float:right">A szállítási és számlázási cím megegyezik.</button>');
		
		$doboz = $ALG->ujDoboz();
		
		$doboz->dobozCim( 'Szállítási adatok ', 3);
		$input1 = new Szovegmezo(array('attr' => ' id="szall_nev" ','nevtomb' => 'v', 'mezonev'=> 'szall_nev', 'felirat' => 'Név', 'ertek' => $vasarlo->legfrissebbErtek('szall_nev') ));
		
		$doboz->szimplaInput($input1);
		
		$input1 = new Szovegmezo(array('attr' => ' id="szall_orszag" ','nevtomb' => 'v', 'mezonev'=> 'szall_orszag', 'felirat' => 'Ország', 'ertek' => $vasarlo->legfrissebbErtek('szall_orszag') ));
		$input2 = new Szovegmezo(array('attr' => ' id="szall_telepules" ','nevtomb' => 'v', 'mezonev'=> 'szall_telepules', 'felirat' => 'Település', 'ertek' => $vasarlo->legfrissebbErtek('szall_telepules') ));
		
		$doboz->duplaInput($input1,  $input2);
		
		
		$input1 = new Szovegmezo(array('attr' => ' id="szall_utca" ','nevtomb' => 'v', 'mezonev'=> 'szall_utca', 'felirat' => 'Utca, házszám', 'ertek' => $vasarlo->legfrissebbErtek('szall_utca') ));
		$input2 = new Szovegmezo(array('attr' => ' id="szall_irszam" ','nevtomb' => 'v', 'mezonev'=> 'szall_irszam', 'felirat' => 'Irányítószám', 'ertek' => $vasarlo->legfrissebbErtek('szall_irszam') ));
		
		$doboz->duplaInput($input1,  $input2);
		
		
		$ALG->tartalomDobozVege();
	
		
		
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'rendelesek/lista',
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
	function termekhozzadas() {
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// termék
		$tid = (int)$this->ci->input->get('tid');
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		
		$termek = new Termek_osztaly($tid);
		
		if(!$termek) return 0;
		
		$rendelesTermek = array(
			'nev' => $termek->jellemzo('Név'), 
			'termek_id' => $termek->id,
			'cikkszam' => $termek->cikkszam,
			'ar' => $termek->ar,
			'aktiv' => $termek->aktiv,
			'afa' => $termek->afa,
			'rendeles_id' => $rid,
			);
		
		$this->ci->Sql->sqlSave($rendelesTermek, DBP.'rendeles_termekek');
		return 1;
		
		
	}
	function termeklista() {
		// ajaxos terméklista az admin rendelés szerkesztő oldalra
		
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		
		
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		$rendeles = new Rendeles_osztaly();
		$rendeles->betoltesMegrendeles($rid);
		$ci = getCI();
		$lista = $rendeles->termekLista;
		$modositok = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."rendeles_armodositok WHERE rendeles_id = ".$rid);
		$modositoHTLM = '';
		$modositoNevek = array('szallitasmod' => 'Szállítási mód', 'fizetesmod' => 'Fizetési mód', 'kupon' => 'Kupon','kedvezmeny' => 'Kedvezmény', 'egyeb' => 'Egyéb költség');
		
		if($modositok) {
			$ALG = new Adminlapgenerator;
		
			foreach($modositok as $m) {
				
				$doboz = $ALG->ujDoboz();
				$doboz->dobozCim( $modositoNevek[$m->tipus], 3);
				switch($m->tipus) {
					case 'szallitasmod':
						$lgListaArr = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."szallitasmodok ORDER BY id ASC");
						$lgLista = array();
						foreach($lgListaArr as $lgSor) $lgLista[$lgSor->kod] = $lgSor->nev;
						
						$select = new Legordulo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ', 'nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'kod','felirat' => 'Típus', 'ertek' =>$m->kod, 'opciok' => $lgLista ));
						$input = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ar','felirat' => 'Szállítás ára ('.BASE_CURR.')', 'ertek' => $m->ar ));
				
						$doboz->duplaInput( $select,$input);
						
						$input1 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ingyeneslimitar','felirat' => 'Ingyenes limitár ('.BASE_CURR.') <small>Ennyi felett 0</small>', 'ertek' => $m->ingyeneslimitar ));
						$input2 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'sorrend','felirat' => 'Sorrend a visszaigazolón', 'ertek' => $m->sorrend ));
				
						$doboz->duplaInput( $input1,$input2);
			
						
					break;
					case 'fizetesmod':
						$lgListaArr = $ci->Sql->sqlSorok("SELECT * FROM ".DBP."fizetesmodok ORDER BY id ASC");
						$lgLista = array();
						foreach($lgListaArr as $lgSor) $lgLista[$lgSor->kod] = $lgSor->nev;
						
						$select = new Legordulo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ', 'nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'kod','felirat' => 'Típus', 'ertek' =>$m->kod, 'opciok' => $lgLista ));
						$input = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ar','felirat' => 'Költség ('.BASE_CURR.')', 'ertek' => $m->ar ));
				
						$doboz->duplaInput( $select,$input);
						
						$input1 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ingyeneslimitar','felirat' => 'Ingyenes limitár ('.BASE_CURR.') <small>Ennyi felett 0</small>', 'ertek' => $m->ingyeneslimitar ));
						$input2 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'sorrend','felirat' => 'Sorrend a visszaigazolón', 'ertek' => $m->sorrend ));
				
						$doboz->duplaInput( $input1,$input2);
			
						
					break;
					case 'kedvezmeny':
						
						$input1 = new Szovegmezo(array('attr' => '  onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'nev','felirat' => 'Megnevezés', 'ertek' => $m->nev ));
						$input2 = new Szovegmezo(array('attr' => ' readonly onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'kod','felirat' => 'KÓD (3 karakter)', 'ertek' => $m->kod ));
						$doboz->duplaInput( $input1,$input2);
						
						
						$input1 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ar','felirat' => 'Költség ('.BASE_CURR.', összeg vagy százalék, lehet negatív)', 'ertek' => $m->ar ));
						$input2 = new Legordulo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'mukodesimod','felirat' => 'Működés', 'ertek' => $m->mukodesimod, 'opciok' => array('0' => 'Hozzáadódik az árhoz', '1' => 'X% adódik az árhoz') ));
						
						$doboz->duplaInput( $input1,$input2);
						
						$input2 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'sorrend','felirat' => 'Sorrend a visszaigazolón', 'ertek' => $m->sorrend ));
				
						$doboz->duplaInput( $input2);
			
						
					break;
					
					
					
					case 'kupon':

						

						$input1 = new Szovegmezo(array('attr' => '  onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'nev','felirat' => 'Megnevezés', 'ertek' => $m->nev ));

						$input2 = new Szovegmezo(array('attr' => ' readonly onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'kod','felirat' => 'KÓD (3 karakter)', 'ertek' => $m->kod ));

						$doboz->duplaInput( $input1,$input2);

						

						

						$input1 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ar','felirat' => 'Költség ('.BASE_CURR.', összeg vagy százalék, lehet negatív)', 'ertek' => $m->ar ));

						$input2 = new Legordulo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'mukodesimod','felirat' => 'Működés', 'ertek' => $m->mukodesimod, 'opciok' => array('0' => 'Hozzáadódik az árhoz', '1' => 'X% adódik az árhoz') ));

						

						$doboz->duplaInput( $input1,$input2);

						

						$input2 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'sorrend','felirat' => 'Sorrend a visszaigazolón', 'ertek' => $m->sorrend ));

				

						$doboz->duplaInput( $input2);

			

						

					break;
					case 'egyeb':
						
						$input1 = new Szovegmezo(array('attr' => '  onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'nev','felirat' => 'Megnevezés', 'ertek' => $m->nev ));
						$input2 = new Szovegmezo(array('attr' => ' maxlength="3" onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'kod','felirat' => 'KÓD (3 karakter)', 'ertek' => $m->kod ));
						$doboz->duplaInput( $input1,$input2);
						
						
						$input1 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'ar','felirat' => 'Költség ('.BASE_CURR.', összeg vagy százalék, lehet negatív)', 'ertek' => $m->ar ));
						$input2 = new Legordulo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'mukodesimod','felirat' => 'Működés', 'ertek' => $m->mukodesimod, 'opciok' => array('0' => 'Hozzáadódik az árhoz', '1' => 'X% adódik az árhoz') ));
						
						$doboz->duplaInput( $input1,$input2);
						
						$input2 = new Szovegmezo(array('attr' => ' onchange="aJs.rendelesArmodositoModositas('.$rid.')"  ','nevtomb' => 'ma['.$m->id.']', 'mezonev' => 'sorrend','felirat' => 'Sorrend a visszaigazolón', 'ertek' => $m->sorrend ));
				
						$doboz->duplaInput( $input2);
			
						
					break;
				}
			
				
				$modositoHTLM = $ALG->tartalomKimenet(); 
			}
		}
		
		// frissítsük az árakat
		$a = array('id' => $rendeles->id, 'osszar' => $rendeles->megrendelesOsszar(), 'osszafa' => $rendeles->megrendelesOsszarAfa(),  'osszbrutto' => $rendeles->megrendelesOsszarBrutto() );
		$this->Sql->sqlUpdate( $a , 'rendelesek');
				
		$ci->load->view(ADMINTEMPLATE.'html/rendeles_termeklista.php', array('modositoHTLM' => $modositoHTLM, 'modositoNevek' => $modositoNevek, 'lista' => $lista, 'rendeles' => $rendeles));
		
	}
	function armodositotorles() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// ármódósító azonosító
		$mid = (int)$ci->input->get('mid');
		
		$ci->db->query("DELETE FROM ".DBP."rendeles_armodositok WHERE id = $mid LIMIT 1");
		$this->termeklista();
	}
	function armodositomodositas() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		$a = $ci->input->post('ma');
		foreach($a as $amid => $adat) {
			$am = $ci->Sql->get($amid, DBP.'rendeles_armodositok', 'id');
			switch($am->tipus) {
				case 'szallitasmod':
					$adat['id'] = $amid;
					if($am->kod!=$adat['kod']) {
						$ujam = $ci->Sql->sqlSor("SELECT * FROM ".DBP."szallitasmodok WHERE kod = '{$adat['kod']}' LIMIT 1");
						
						$adat['nev'] = $ujam->nev;
						$adat['ar'] = $ujam->ar;
						$adat['ingyeneslimitar'] = $ujam->ingyeneslimitar;
						
					} else {
						
					}
					$ci->Sql->sqlUpdate($adat, 'rendeles_armodositok', 'id');
					
				break;
				case 'fizetesmod':
					$adat['id'] = $amid;
					if($am->kod!=$adat['kod']) {
						$ujam = $ci->Sql->sqlSor("SELECT * FROM ".DBP."fizetesmodok WHERE kod = '{$adat['kod']}' LIMIT 1");
						
						$adat['nev'] = $ujam->nev;
						$adat['ar'] = $ujam->ar;
						$adat['ingyeneslimitar'] = $ujam->ingyeneslimitar;
						
					} else {
						
					}
					$ci->Sql->sqlUpdate($adat, DBP.'rendeles_armodositok', 'id');
					
				break;
				case 'kedvezmeny':
					$adat['id'] = $amid;
					$ci->Sql->sqlUpdate($adat, DBP.'rendeles_armodositok', 'id');
					
				break;				case 'kupon':
					$adat['id'] = $amid;
					$ci->Sql->sqlUpdate($adat, DBP.'rendeles_armodositok', 'id');
					
				break;
				case 'egyeb':
					$adat['id'] = $amid;
					$ci->Sql->sqlUpdate($adat, DBP.'rendeles_armodositok', 'id');
					
				break;
			}
		}
	}
	function koltseghozzaadas() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		$tipus = $ci->input->get('koltsegtipus');
		switch ($tipus) {
			case 'szallitasmod':
				$a = (array)$ci->Sql->sqlSor("SELECT * FROM ".DBP."szallitasmodok ORDER BY id ASC LIMIT 1");
				$a['rendeles_id'] = $rid;
				$a['tipus'] = 'szallitasmod';
				unset($a['statusz']);
				unset($a['szallitasiido']);
				$ci->Sql->sqlSave($a, DBP.'rendeles_armodositok', 'id');
			break;
			case 'fizetesmod':
				$a = (array)$ci->Sql->sqlSor("SELECT * FROM ".DBP."fizetesmodok ORDER BY id ASC LIMIT 1");
				$a['rendeles_id'] = $rid;
				$a['tipus'] = 'fizetesmod';
				unset($a['statusz']);
				$ci->Sql->sqlSave($a, DBP.'rendeles_armodositok', 'id');
			break;
			case 'kedvezmeny':
				$a['rendeles_id'] = $rid;
				$a['tipus'] = 'kedvezmeny';
				$a['nev'] = '10% kedvezmény';
				$a['kod'] = 'KED';
				$a['ar'] = -10;
				$a['mukodesimod'] = 1;
				$a['ingyeneslimitar'] = 0;
				$a['extrakalkulacio'] = 0;
				
				$ci->Sql->sqlSave($a, DBP.'rendeles_armodositok', 'id');
			break;
			case 'egyeb':
				$a['rendeles_id'] = $rid;
				$a['tipus'] = 'egyeb';
				$a['kod'] = 'EGY';
				$a['nev'] = 'Biztosítási költség';
				$a['ar'] = 20;
				$a['mukodesimod'] = 1;
				$a['ingyeneslimitar'] = 0;
				$a['extrakalkulacio'] = 0;
				
				$ci->Sql->sqlSave($a, DBP.'rendeles_armodositok', 'id');
			break;
		}
		$this->termeklista();
	}
	function termekdarabmodositas() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// termék
		$tid = (int)$this->ci->input->get('tid');
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		$mod = (int)$this->ci->input->get('mod');
		
		$sor = $ci->Sql->get($tid, DBP.'rendeles_termekek', 'id');
		$sor->darab += $mod;
		if($sor->darab==0) {
			// törlés
			$ci->db->query("DELETE FROM ".DBP."rendeles_termekek WHERE id = ".$tid);
		} else {
			$a = array('id' => $sor->id, 'darab' => $sor->darab);
			$ci->Sql->sqlUpdate($a, DBP.'rendeles_termekek', 'id');
			
		}
		$this->termeklista();
	}
	function termekvaltozatmodositas() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// termék
		$tid = (int)$this->ci->input->get('tid');
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		// változat id
		$vid = (int)$this->ci->input->get('vid');
		
		// változat betölt
		$valtozat = $ci->Sql->sqlSor("SELECT * FROM ".DBP."termek_armodositok WHERE id = ".$vid." AND nyelv = '".CMS_NYELV."' ");
		if(!$valtozat) return;
		
		$tipus = $valtozat->tipus;
		
		// korábbi változatot törlöm
		$ci->db->query("DELETE FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = $tid AND tipus = $tipus ");
		
		//új változat:
		$valtozat = $ci->Sql->sqlSor("SELECT * FROM ".DBP."termek_armodositok WHERE id = ".$vid." AND nyelv = '".CMS_NYELV."' ");
		if($valtozat) {
			$a = array(
				'rendeles_termek_id' => $tid,
				'termek_armodositok_id' => $valtozat->id,
				'tipus' => $tipus,
				'ar' => $valtozat->ar,
				'nev' => $valtozat->nev,
				'afa' => $valtozat->afa,
				'nyelv' => CMS_NYELV,
			);
			$ci->Sql->sqlSave($a, DBP.'rendeles_termek_armodositok');
		}
		
		$this->termeklista();
	}
	
	function rendelesvaltozattorles() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// termék
		$tid = (int)$this->ci->input->get('tid');
		// változat id
		$vid = (int)$this->ci->input->get('vid');
		
		
		$ci->db->query("DELETE FROM ".DBP."rendeles_termek_armodositok WHERE id = $vid ");
		
		$this->termeklista();
	}
	
	function termekopciomodositas() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// termék
		$tid = (int)$this->ci->input->get('tid');
		// termékek bootstrap
		include_once(ROOTPATH.'modules/termek/autoload.php');
		// változat id
		$oid = (int)$this->ci->input->get('oid');
		
		
		
		//új változat:
		$opcio = $ci->Sql->sqlSor("SELECT * FROM ".DBP."termek_armodositok WHERE id = ".$oid." AND nyelv = '".CMS_NYELV."' ");
		
		// ha már létezik, kilépünk
		$sql = "SELECT id FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = $tid AND termek_armodositok_id = {$opcio->id} ";
		$van = $ci->Sql->sqlSor($sql);
		if(isset($van->id)) {
			$this->termeklista();
			return;
		}
		
		
		if($opcio) {
			
			$a = array(
				'rendeles_termek_id' => $tid,
				'termek_armodositok_id' => $opcio->id,
				'tipus' => 1,
				'ar' => $opcio->ar,
				'nev' => $opcio->nev,
				'afa' => $opcio->afa,
				'nyelv' => CMS_NYELV,
			);
			$ci->Sql->sqlSave($a, DBP.'rendeles_termek_armodositok');
		}
		
		$this->termeklista();
	}
	
	function termekopciotorles() {
		$ci = getCI();
		// rendelés azonosító
		$rid = (int)$this->ci->uri->segment(4);
		// termék
		$tid = (int)$this->ci->input->get('tid');
		// változat id
		$oid = (int)$this->ci->input->get('oid');
		
		$ci->db->query("DELETE FROM ".DBP."rendeles_termek_armodositok WHERE id = ".$oid);
		
		
		
		$this->termeklista();
	}
	
}
