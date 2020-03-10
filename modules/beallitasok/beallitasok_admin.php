<?php

class Beallitasok_admin extends MY_Modul{
	var $data = array();
	
	public function __construct() {
		parent::__construct();
		
	}
	public function adminmenuszerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('url' => 'beallitasok/adminmenulista','felirat' => 'Menüpontok listája'),array('felirat' => 'Adminmenü szerkesztés')));
		
		$id = (int)$this->ci->uri->segment(4);
		
		if($this->ci->input->post('a')) {
			$a = $this->ci->input->post('a');
			
			if($id==0) {
				$this->sqlSave($a, 'adminmenu');
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, 'adminmenu', 'id');
			}
			redirect(ADMINURL.'beallitasok/adminmenulista?m=Sikeres módosítás');
			return;
		}
		
		
		$sor = $this->Sql->get($id, 'adminmenu', 'id');		
		
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Menüpont szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'beallitasok/adminmenulista', 'felirat' => 'Vissza'));
		$ALG->urlapStart(array('attr' => 'method="post" '));
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$input1 = new Szovegmezo(array('felirat' => 'Menüpont felirat', 'nevtomb' => 'a', 'mezonev' => 'felirat', 'ertek' => @$sor->felirat));
		$input2 = new Szovegmezo(array('felirat' => 'Elérés (ha van almenü, hagyd üresen)', 'nevtomb' => 'a', 'mezonev' => 'modul_eleres', 'ertek' => @$sor->modul_eleres));
		$doboz->duplaInput($input1, $input2);
		
		$szulolista = array(0 => 'Főmenüpont' );
		$lista2 = $this->Sql->fieldKeyArray('SELECT id, felirat FROM adminmenu WHERE szulo_id = 0 ORDER BY felirat ASC', 'felirat', 'id');
		if($lista2) foreach($lista2 as $k => $v) $szulolista[ $k] = $v;
		
		$select = new Legordulo(array('felirat' => 'Szülőelem', 'nevtomb' => 'a', 'mezonev' => 'szulo_id', 'opciok' => $szulolista,'ertek' => @$sor->szulo_id)); 
		$input1 = new Szovegmezo(array('felirat' => 'Sorrend', 'nevtomb' => 'a', 'mezonev' => 'sorrend', 'ertek' => @$sor->sorrend));
		
		
		$doboz->duplaInput($select, $input1);		
		$jogValaszto = array();
		$jogok = explode(",", JOG_LISTA);
		foreach($jogok as $jSor) {
			$jSor = explode(":", $jSor);
			$jogValaszto[$jSor[0]] = $jSor[1];
		}
		$doboz->HTMLHozzaadas($this->ci->load->view(ADMINTEMPLATE."html/jogkorvalaszto", array('jogValaszto' => $jogValaszto, 'sor' => @$sor),true));
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégsem',
				'link' => ADMINURL.'beallitasok/adminmenulista',
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
	
	public function menuszerkesztes($csoport_id = 0) {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('url' => 'beallitasok/menulista','felirat' => 'Menüpontok listája'),array('felirat' => 'Frontend menü szerkesztés')));
		
		$id = (int)$this->ci->uri->segment(4);
		$urlcsoport_id = (int)$this->ci->uri->segment(5);
		if($urlcsoport_id==0 and $csoport_id==0) {
			redirect(ADMINURL.'beallitasok/menuszerkesztes');
			return;
		}
		if($this->ci->input->post('a')) {
			$a = $this->ci->input->post('a');
			
			if($id==0) {
				$this->sqlSave($a, DBP.'frontendmenu');
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, DBP.'frontendmenu', 'id');
			}
			redirect(ADMINURL.'beallitasok/menulista?m=Sikeres módosítás');
			return;
		}
		
		
		$sor = $this->Sql->get($id, DBP.'frontendmenu', 'id');
		
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Menüpont szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'beallitasok/menulista', 'felirat' => 'Vissza'));
		$ALG->urlapStart(array('attr' => 'method="post" '));
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		
		
		
		$csoportlista = array();

		$lista3 = $this->Sql->fieldKeyArray('SELECT id, nev FROM '.DBP.'frontendmenucsoportok  ORDER BY nev ASC', 'nev', 'id');

		if($lista3) foreach($lista3 as $k => $v) $csoportlista[ $k] = $v;

		
		if(isset($sor->frontendmenucsoport_id)) $csoport_id = $sor->frontendmenucsoport_id;
		$select = new Legordulo(array('felirat' => 'Menücsoport', 'nevtomb' => 'a', 'mezonev' => 'frontendmenucsoport_id', 'opciok' => $csoportlista,'ertek' => $csoport_id)); 

		
		

		

		$doboz->szimplaInput($select);

		

		
		
		
		$input1 = new Szovegmezo(array('felirat' => 'Menüpont felirat', 'nevtomb' => 'a', 'mezonev' => 'felirat', 'ertek' => @$sor->felirat));
		$input2 = new Szovegmezo(array('felirat' => 'URL', 'nevtomb' => 'a', 'mezonev' => 'url', 'ertek' => @$sor->modul_eleres));
		$doboz->duplaInput($input1, $input2);
		
		$szulolista = array(0 => 'Főmenüpont' );
		$lista2 = $this->Sql->fieldKeyArray('SELECT id, felirat FROM '.DBP.'frontendmenu WHERE szulo_id = 0 ORDER BY felirat ASC', 'felirat', 'id');
		if($lista2) foreach($lista2 as $k => $v) $szulolista[ $k] = $v;
		
		$select = new Legordulo(array('felirat' => 'Szülőelem', 'nevtomb' => 'a', 'mezonev' => 'szulo_id', 'opciok' => $szulolista,'ertek' => @$sor->szulo_id)); 
		$select1 = new Legordulo(array('felirat' => 'Státusz', 'nevtomb' => 'a', 'mezonev' => 'statusz', 'opciok' => array('1'=> 'Bekapcsolva', '0' => 'Kikapcsolva'),'ertek' => @$sor->statsz)); 
		
		
		$doboz->duplaInput($select, $select1);
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégsem',
				'link' => ADMINURL.'beallitasok/menulista',
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
	public function menulista() {
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('felirat' => 'Frontend menüpontok listája')));
		
		if(isset($_POST['ujcsoport'])) if(trim($_POST['ujcsoport'])!='') {
			$a = array('nev' => $_POST['ujcsoport']);
			$id = $this->Sql->sqlSave($a, 'frontendmenucsoportok');
			return $this->menuszerkesztes($id);
			
		}
		
		if($this->ci->input->post('ddsorrend')!='') {

			$arr = explode(',', trim($this->ci->input->post('ddsorrend'), ','));

			foreach($arr as $k =>  $id) {

				$id = (int)$id;
				$a = array('id' => $id,'sorrend' => ($k*10),  'felirat' => $_POST['sfelirat'][$id]);
				$this->Sql->sqlUpdate($a, DBP.'frontendmenu');
				
			}

			redirect(ADMINURL.'beallitasok/menulista?m='.urlencode("Módosítások elmentve."));

			return;

		}
		if(!empty($this->ci->input->post('sfelirat'))) {
			foreach($this->ci->input->post('sfelirat') as $id => $sor) {
				$id = (int)$id;
				$a = array('id' => $id, 'felirat' => $_POST['sfelirat'][$id]);
				$this->Sql->sqlUpdate($a, DBP.'frontendmenu');
			}
		}

		$ALG = new Adminlapgenerator;

		$sql = "SELECT * FROM ".DBP."frontendmenucsoportok ORDER BY nev ASC";
		$csoportok = $this->Sql->sqlSorok($sql);
		$opciok = array();
		if($csoportok) {
			foreach($csoportok as $cs) $opciok[$cs->id] = $cs->nev;
		}
		$menucsoportId = (isset($_SESSION['menucsoportId'])?$_SESSION['menucsoportId']: $csoportok[0]->id);
		if(isset($_POST['csoport'])) $menucsoportId = (int) $_POST['csoport'];
		
		$_SESSION['menucsoportId'] = $menucsoportId;
		
		
		$ALG->adatBeallitas('lapCim', "Frontend menüpontok");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'beallitasok/menuszerkesztes/0/'.$menucsoportId, 'felirat' => 'Új menüpont'));

		
		
		$ALG->tartalomDobozStart();

		
		$ALG->urlapStart(array('attr' => 'method="post" '));
		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Menücsoport kiválasztása', 2);

		
		$gordulo1 = new Legordulo(array('felirat' => 'Kiválasztott menücsoport','opciok' => $opciok,'nevtomb' => '', 'mezonev' => 'csoport', 'ertek' =>$menucsoportId ));

		$input1 = new Szovegmezo(array('felirat' => 'Vagy új csoport',  'tipus' => 'szoveg' ,'nevtomb' => '', 'mezonev' => 'ujcsoport', 'ertek' => '' )) ;

		$doboz->duplaInput($gordulo1, $input1);
		
		
		
		$ALG->tartalomDobozVege();
		
		$ALG->urlapGombok(array(

			0 => array(
				'tipus' => 'submit',
				'felirat' => 'Menücsoport választás',
				'link' => '',
				'osztaly' => 'btn-ok',
				'attr' => ' style="margin-right: 20px" '
			),

		));
		
		

		$ALG->urlapVege();
		
		
		
		
		
		
		$ALG->urlapStart(array('attr' => 'method="post" '));
		

		$ALG->tartalomDobozStart();
		
		
		
		
		
		
		
		
		
		
		

		// táblázat adatok összeállítása

		$kimenet = array();

		$lista = $this->ci->Sql->gets(DBP."frontendmenu", " WHERE frontendmenucsoport_id = $menucsoportId AND szulo_id = 0 ORDER BY sorrend ASC");

		if($lista)foreach($lista as $sor) {

			$sor->szulo_felirat = '---';
			$sor->felirat = '<div class="input-container "><input class="sliderinput" value="'.$sor->felirat.'" type="text" name="sfelirat['.$sor->id.']" /></div>';


			$kimenet[] = $sor;

			$alLista = $this->ci->Sql->gets(DBP."frontendmenu", " WHERE szulo_id = {$sor->id} ORDER BY sorrend ASC");

			if($alLista) foreach($alLista as $alSor) {

				$alSor->mezoSzin = '#FFFBFE';

				$alSor->szulo_felirat = $sor->felirat;
				$sor->felirat = '<div class="input-container "><input class="sliderinput" value="'.$alSor->felirat.'" type="text" name="sfelirat['.$alSor->id.']" /></div>';

				$kimenet[] =  $alSor;

			}

		}

		

		// táblázat beállítás

		$tablazat = $ALG->ujTablazat();

		

		$keresoMezok = array(

			array('felirat' => 'Felirat', 'mezonev' => 'felirat'),

			array('felirat' => 'Modul útvonal', 'mezonev' => 'modul_eleres'),

		);

		

		$tablazat->adatBeallitas('keresoMezok', false);

		$tablazat->adatBeallitas('szerkeszto_url', 'beallitasok/menuszerkesztes/');

		$tablazat->adatBeallitas('torles_url', 'beallitasok/menutorles/');

		$tablazat->adatBeallitas('megjelenitettMezok', array('felirat' => 'Menüpont', 'szulo_felirat' => 'Szülő elem',  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));

		$tablazat->adatBeallitas('lista', $kimenet);

		

		$tablazat->sorrendezheto();

		// táblázat beállítás vége

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
		

		return $ALG->kimenet();

	}

	
	
	public function adminmenulista() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('felirat' => 'Menüpontok listája')));
		
		if($this->ci->input->get('sorrend')!='') {
			$arr = explode(',', trim($this->ci->input->get('sorrend'), ','));
			foreach($arr as $k =>  $id) {
				$id = (int)$id;
				$this->ci->db->query("UPDATE adminmenu SET sorrend = ".($k*10)." WHERE id = ".$id);
				
			}
			redirect(ADMINURL.'beallitasok/adminmenulista?m='.urlencode("Sorrend módosítva."));
			return;
		}
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Adminisztrációs menüpontok");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'beallitasok/adminmenuszerkesztes/0', 'felirat' => 'Új menüpont'));
		
		$ALG->tartalomDobozStart();

		// táblázat adatok összeállítása
		$kimenet = array();
		$lista = $this->ci->Sql->gets("adminmenu", " WHERE szulo_id = 0 ORDER BY sorrend ASC");
		foreach($lista as $sor) {
			$sor->szulo_felirat = '---';
			if($sor->modul_eleres=='') $sor->modul_eleres = '---';
			$kimenet[] = $sor;
			$alLista = $this->ci->Sql->gets("adminmenu", " WHERE szulo_id = {$sor->id} ORDER BY sorrend ASC");
			if($alLista) foreach($alLista as $alSor) {
				$alSor->mezoSzin = '#FFFBFE';
				$alSor->szulo_felirat = $sor->felirat.' <i class="fas fa-level-up-alt"></i>';
				$kimenet[] =  $alSor;
			}
		}
		
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = array(
			array('felirat' => 'Felirat', 'mezonev' => 'felirat'),
			array('felirat' => 'Modul útvonal', 'mezonev' => 'modul_eleres'),
		);
		
		$tablazat->adatBeallitas('keresoMezok', false);
		$tablazat->adatBeallitas('szerkeszto_url', 'beallitasok/adminmenuszerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'beallitasok/adminmenutorles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('felirat' => 'Menüpont', 'szulo_felirat' => 'Szülő elem', 'modul_eleres' => 'Modul-metódus','sorrend' => 'Sorrend', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $kimenet);
		$tablazat->sorrendezheto();
		
		
		// táblázat beállítás vége
		$ALG->tartalomDobozVege();
		
		return $ALG->kimenet();
	}
	public function menutorles() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$id = (int)$this->ci->uri->segment(4);
		$sor = $this->ci->Sql->gets(DBP.'frontendmenu', " WHERE szulo_id = $id ");
		if(!empty($sor)) {
			redirect(ADMINURL.'beallitasok/menulista?m='.urlencode("A törlendő menüpont almenüvel rendelkezik, előbb azt kell törölni!"));
			
		}
		$this->ci->db->query("DELETE FROM ".DBP."frontendmenu WHERE id = $id");
		redirect(ADMINURL.'beallitasok/menulista?m='.urlencode("A törlés sikeres!"));
			
	}	public function adminmenutorles() {		globalisMemoria("Nyitott menüpont",'Beállítások');
		$id = (int)$this->ci->uri->segment(4);
		$sor = $this->ci->Sql->gets('adminmenu', " WHERE szulo_id = $id ");
		if(!empty($sor)) {
			redirect(ADMINURL.'beallitasok/adminmenulista?m='.urlencode("A törlendő menüpont almenüvel rendelkezik, előbb azt kell törölni!"));
			
		}
		$this->ci->db->query("DELETE FROM adminmenu WHERE id = $id");
		redirect(ADMINURL.'beallitasok/adminmenulista?m='.urlencode("A törlés sikeres!"));
			
	}
	
	public function altalanos() {		globalisMemoria("Nyitott menüpont",'Beállítások');
		globalisMemoria('utvonal', array(array('felirat' => 'Általános beállítások')));
		
		
		if($this->ci->input->post('a')) {
			$a = $this->ci->input->post('a');
			
			foreach($a as $k => $v) {
				$a = array('kulcs' => $k, 'ertek' => $v);
				$letezik = $this->Sql->sqlSor("SELECT id FROM ".DBP."settings WHERE kulcs = '$k' LIMIT 1");
				if(isset($letezik->id)) {
					$a['id'] = $letezik->id;
					$this->Sql->sqlUpdate($a, 'settings');
				} else {
					$this->Sql->sqlSave($a, 'settings');
				}
			}
			$cbarr = array(
				"admin_ertesites_rendelesrol",
				"admin_ertesites_velemenyrol",
				"admin_ertesites_ertekelesrol",
				"admin_belso_ertesites_rendelesrol",
				"admin_belso_ertesites_velemenyrol",
				"admin_belso_ertesites_ertekelesrol",
				"aruhaz_deviza_jeloles_arutan",
				
				"kosar_betus_iranyitoszam",
			);
			$cb = $this->ci->input->post('cb');			
			foreach($cbarr as $kulcs) {
				$a = array('kulcs' => $kulcs, 'ertek' => 0);
				$letezik = $this->Sql->sqlSor("SELECT id FROM ".DBP."settings WHERE kulcs = '$kulcs' LIMIT 1");
				
				if(isset($cb[$kulcs])) {
					$a['ertek']='1'; 
				}				
				
				if(isset($letezik->id)) {
					$a['id'] = $letezik->id;
					$this->Sql->sqlUpdate($a, DBP.'settings');
				} else {
					$this->Sql->sqlSave($a, DBP.'settings');
				}
			}			
			
		}
		
		
		$ALG = new Adminlapgenerator;
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		$ALG->adatBeallitas('lapCim', "Beállítások");
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Általános beállítások', 2);
		$doboz->HTMLHozzaadas("Az áruház alapvető beállításait találja ezen a lapon.");
		
		$input1 = new Szovegmezo(array('felirat' => 'Áruház neve','kotelezo' => 1,  'tipus' => 'szoveg','attr' => ' maxlength="100" ','nevtomb' => 'a', 'mezonev' => 'aruhaznev', 'ertek' => beallitasOlvasas('aruhaznev'))) ;
		
		
		$doboz->szimplaInput($input1);
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Megrendelési értesítések');
		$doboz->dobozElem( '<h4>E-mail értesítések</h4>');
		
		$input1 = new Szovegmezo(array('felirat' => 'Feladó neve','kotelezo' => 1,  'tipus' => 'szoveg','attr' => ' maxlength="100" ','nevtomb' => 'a', 'mezonev' => 'admin_ertesites_email_felado', 'ertek' => beallitasOlvasas('admin_ertesites_email_felado'))) ;
		$input2 = new Szovegmezo(array('felirat' => 'E-mail cím','kotelezo' => 1,  'tipus' => 'szoveg','attr' => ' maxlength="150" ','nevtomb' => 'a', 'mezonev' => 'admin_ertesites_email_cim', 'ertek' => beallitasOlvasas('admin_ertesites_email_cim'))) ;
		
		$doboz->duplaInput($input1, $input2);
		
		//$input1 = new Szovegmezo(array('felirat' => 'Hírlevél teszteléshez E-mail címek (vesszővel elválasztva)','tipus' => 'szoveg','nevtomb' => 'a', 'mezonev' => 'hirlevel.teszt.emailcimek', 'ertek' => beallitasOlvasas('hirlevel.teszt.emailcimek'))) ;
		
		//$doboz->szimplaInput($input1, $input2);
		
		$pipa1 = new Jelolonegyzet(array('felirat' => 'E-mail értesítése rendelésről','nevtomb' => 'cb', 'mezonev' => 'admin_ertesites_rendelesrol', 'ertek' => 1, 'attr' => (beallitasOlvasas('admin_ertesites_rendelesrol')=='1')?' checked ':'' ));
		//$pipa2 = new Jelolonegyzet(array('felirat' => 'E-mail értesítése új véleményről','nevtomb' => 'cb', 'mezonev' => 'admin_ertesites_velemenyrol', 'ertek' => 1, 'attr' => (beallitasOlvasas('admin_ertesites_velemenyrol')=='1')?' checked ':'' ));
		//$pipa3 = new Jelolonegyzet(array('felirat' => 'E-mail értesítése új értékelésről','nevtomb' => 'cb', 'mezonev' => 'admin_ertesites_ertekelesrol', 'ertek' => 1, 'attr' => (beallitasOlvasas('admin_ertesites_ertekelesrol')=='1')?' checked ':'' ));
		
		$doboz->dobozElemJelolonegyzetek(array($pipa1));
		
		
		/*
		$doboz->dobozElem( '<h4>Belső admin értesítések</h4>');
		
		$pipa1 = new Jelolonegyzet(array('felirat' => 'Adminon belüli értesítés rendelésről','nevtomb' => 'cb', 'mezonev' => 'admin_belso_ertesites_rendelesrol', 'ertek' => 1, 'attr' => (beallitasOlvasas('admin_belso_ertesites_rendelesrol')=='1')?' checked ':'' ));
		$pipa2 = new Jelolonegyzet(array('felirat' => 'Adminon belüli értesítés új véleményről','nevtomb' => 'cb', 'mezonev' => 'admin_belso_ertesites_velemenyrol', 'ertek' => 1,  'attr' => (beallitasOlvasas('admin_belso_ertesites_velemenyrol')=='1')?' checked ':''));
		$pipa3 = new Jelolonegyzet(array('felirat' => 'Adminon belüli értesítés új értékelésről','nevtomb' => 'cb', 'mezonev' => 'admin_belso_ertesites_ertekelesrol', 'ertek' => 1,  'attr' => (beallitasOlvasas('admin_belso_ertesites_ertekelesrol')=='1')?' checked ':'' ));
		
		$doboz->dobozElemJelolonegyzetek(array($pipa1, $pipa2, $pipa3));		*/
		
		$ALG->tartalomDobozVege();
		
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Áruház beállítások', 2);
		//$gordulo1 = new Legordulo(array('felirat' => 'Alapértelmezett devize','opciok' => array('HUF' => 'Magyar forint'),'nevtomb' => 'a', 'mezonev' => 'aruhaz_alapdeviza', 'ertek' => beallitasOlvasas('aruhaz_alapdeviza')));
		//$doboz->duplaInput($gordulo1);
		$input1 = new Szovegmezo(array('felirat' => 'Szamlazz.hu felhasználó', 'tipus' => 'szoveg','attr' => '  ','nevtomb' => 'a', 'mezonev' => 'szamlazz_user', 'ertek' => beallitasOlvasas('szamlazz_user'))) ;
		$input2 = new Szovegmezo(array('felirat' => 'Szamlazz.hu jelszó', 'tipus' => 'jelszo','attr' => '  ','nevtomb' => 'a', 'mezonev' => 'szamlazz_jelszo', 'ertek' => beallitasOlvasas('szamlazz_jelszo'))) ;
		$doboz->duplaInput($input1,$input2);
				$input1 = new Szovegmezo(array('felirat' => 'Cég számlaszáma', 'tipus' => 'szoveg','attr' => '  ','nevtomb' => 'a', 'mezonev' => 'ceg_szamlaszam', 'ertek' => beallitasOlvasas('ceg_szamlaszam'))) ;
		$doboz->szimplaInput($input1);

		//$pipa1 = new Jelolonegyzet(array('felirat' => 'Deviza jelölése az ár után','nevtomb' => 'cb', 'mezonev' => 'aruhaz_deviza_jeloles_arutan', 'ertek' => 1,  'attr' => (beallitasOlvasas('aruhaz_deviza_jeloles_arutan')=='1')?' checked ':''  ));
		$pipa2 = new Jelolonegyzet(array('felirat' => 'Külföldi irányítószám engedélyezése','nevtomb' => 'cb', 'mezonev' => 'kosar_betus_iranyitoszam', 'ertek' => 1, 'attr' => (beallitasOlvasas('kosar_betus_iranyitoszam')=='1')?' checked ':'' ));

		//$pipa2 = new Jelolonegyzet(array('felirat' => 'E-mail értesítése új véleményről','nevtomb' => 'cb', 'mezonev' => 'admin_ertesites_velemenyrol', 'ertek' => 1, 'attr' => (beallitasOlvasas('admin_ertesites_velemenyrol')=='1')?' checked ':'' ));

		//$pipa3 = new Jelolonegyzet(array('felirat' => 'E-mail értesítése új értékelésről','nevtomb' => 'cb', 'mezonev' => 'admin_ertesites_ertekelesrol', 'ertek' => 1, 'attr' => (beallitasOlvasas('admin_ertesites_ertekelesrol')=='1')?' checked ':'' ));

		$doboz->dobozElemJelolonegyzetek(array($pipa1,$pipa2));

		

		
		//$gordulo1 = new Legordulo(array('felirat' => 'Árak megjelenítési módja','opciok' => array('b' => 'Brutto', 'n' => 'Netto', 'bn' => 'Brutto + Netto'),'nevtomb' => 'a', 'mezonev' => 'aruhaz_armegjelenites', 'ertek' => beallitasOlvasas('aruhaz_armegjelenites')));
		//$input1 = new Szovegmezo(array('felirat' => 'Tizedesjegyek',  'tipus' => 'szoveg','attr' => ' maxlength="1" ','nevtomb' => 'a', 'mezonev' => 'aruhaz_armegjelenites_tizedesek', 'ertek' => beallitasOlvasas('aruhaz_armegjelenites_tizedesek'))) ;
		//$doboz->duplaInput($gordulo1, $input1);
		// termékeknél opciózás kikapcsolása
		$gordulo1 = new Legordulo(array('felirat' => 'Változatok-opciók felvitele a termékekhez','opciok' => array('0' => 'Kikapcsolva', '1' => 'Bekapcsolva'),'nevtomb' => 'a', 'mezonev' => 'termek_valtozat_opcio_engedelyezes', 'ertek' => beallitasOlvasas('termek_valtozat_opcio_engedelyezes')));		
		
		$doboz->szimplaInput($gordulo1, $input1);
		
		$ALG->tartalomDobozVege();
		
		
		
		/*************  Karbantartás  **************/
		
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		
		$doboz->dobozCim( 'Működés', 3);
		$input1 = new Legordulo(array('felirat' => 'Karbantartás bekapcsolása', 'nevtomb' => 'a', 'mezonev' => 'oldal_karbantartas', 'ertek' => beallitasOlvasas('oldal_karbantartas'), 'opciok' => array(0 => 'Kikapcsolva', 1=> 'Bekapcsolva'))) ;
		$doboz->szimplaInput($input1);
		
		
		$text1 = new Szovegdoboz(array('felirat' => 'Tájékoztató szöveg', 'helyorzo' => '', 'nevtomb' => 'a', 'mezonev' => 'oldal_karbantartas_tajekoztato', 'ertek' => beallitasOlvasas('oldal_karbantartas_tajekoztato'))) ;
		$doboz->szimplaInput($text1);
				$input1 = new Szovegmezo(array('felirat' => 'Kimenő SMTP kiszolgáló', 'nevtomb' => 'a', 'mezonev' => 'SMTP_host', 'ertek' => beallitasOlvasas('SMTP_user'))) ;

		$doboz->szimplaInput($input1);

		$input1 = new Szovegmezo(array('felirat' => 'Kimenő SMTP felhasználó', 'nevtomb' => 'a', 'mezonev' => 'SMTP_user', 'ertek' => beallitasOlvasas('SMTP_user'))) ;

		$doboz->szimplaInput($input1);

				$input1 = new Szovegmezo(array('felirat' => 'Kimenő SMTP jelszó', 'nevtomb' => 'a', 'mezonev' => 'SMTP_password', 'ertek' => beallitasOlvasas('SMTP_password'))) ;

		$doboz->szimplaInput($input1);

				$input1 = new Szovegmezo(array('felirat' => 'Küldő E-mail címe', 'nevtomb' => 'a', 'mezonev' => 'Mail_sender_email', 'ertek' => beallitasOlvasas('Mail_sender_email'))) ;

		$doboz->szimplaInput($input1);

		$gordulo1 = new Legordulo(array('felirat' => 'Naplózás','opciok' => array('0' => 'Bekapcsolva', '1' => 'Kikapcsolva'),'nevtomb' => 'a', 'mezonev' => 'log_kikapcsolva', 'ertek' => beallitasOlvasas('log_kikapcsolva')));

		
		$doboz->duplaInput($gordulo1);

		$ALG->tartalomDobozVege();
		
		
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL,
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
	
}
