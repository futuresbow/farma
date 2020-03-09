<?php

class Post_admin extends MY_Modul{
	var $data = array();
	
	public function postmegjelenitesindex_ellenorzes($adat) {
		
		$param = unserialize($adat['parameter']);
		$b = $_POST['b'];
		$a = $_POST['a'];
		
		$tag = ws_belepesEllenorzes();
		$b['felhasznalo_id'] = $tag->id;
			
		
		if($a['post_id']=="0" ) {
			$id = $this->Sql->sqlSave($b, DBP.'post');
			$param['post_id'] = $id;
			
		} else {
			if($b['id']==$a['post_id']) {
			
				$this->Sql->sqlUpdate($b,DBP. 'post' , 'id');
			}
			$id = $a['post_id'];
			$param['post_id'] = $id;
				
				
		}
		$adat['parameter'] = serialize($param);
		$elem = $this->ci->Sql->get( $param['post_id'], DBP."post", " id ");
		
		
		if(isset($elem->cim)) $adat['elemnev'] = $elem->cim." - bejegyzés"; else return false;
		
		
		
		return $adat;
	}
	
	public function blogoldalindex_ellenorzes($adat) {
		$param = unserialize($adat['parameter']);
		$elem = $this->ci->Sql->get( $param['kategoria_id'], DBP."post_kategoriak", " id ");
		
		
		if(isset($elem->kategorianev)) $adat['elemnev'] = $elem->kategorianev." - blogoldal"; else return false;
		
		
		
		return $adat;
	}
	
	public function blogoldalindex_beallito($param, $ALG) {
		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Blog kategória kiválasztása', 2);
		
		$lista = $this->Sql->gets(DBP."post_kategoriak", "ORDER BY kategorianev ASC");

		$opciok = array(0 => 'Összes kategória');

		if($lista) foreach($lista as  $sor) {

			$opciok[$sor->id] = $sor->kategorianev; 

		}
		$select = new Legordulo(array('nevtomb' => 'a', 'attr' => '','mezonev' => 'kategoria_id', 'opciok' => $opciok, 'ertek' => (isset($param['kategoria_id']))?(int)$param['kategoria_id']:0, 'felirat' => 'Válaszd ki a kategóriát'));
		$doboz->szimplaInput($select);
		
		return true;
		
	}
	public function postmegjelenitesindex_beallito($param, $ALG) {
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Bejegyzés kiválasztása', 2);
		$lista = $this->Sql->gets(DBP."post", "ORDER BY id DESC");
		$opciok = array(0 => 'Új szöveg');
		if($lista) foreach($lista as  $sor) {
			$opciok[$sor->id] = $sor->cim; 
		}
		$select = new Legordulo(array('nevtomb' => 'a', 'attr' => 'onchange="if($(this).val()!=\'0\')$(this).parents(\'form\').submit();" ','mezonev' => 'post_id', 'opciok' => $opciok, 'ertek' => (isset($param['post_id']))?(int)$param['post_id']:0, 'felirat' => 'Válaszd ki a bejegyzést'));
		$doboz->szimplaInput($select);		if(isset($param['post_id'])) {
			$sor = $this->Sql->get((int)$param['post_id'], DBP."post", "id");
			$id = (int)$param['post_id'];
			
		} else {
			$sor = new stdClass();
			$id = 0;
		}
		
		$doboz->HTMLHozzaadas("<b>Vagy szerkeszd meg a szövegeket:</b><br><input type=\"hidden\" name=\"b[id]\" value=\"".$id."\" >");
		
		


		$input1 = new Szovegmezo(array('attr' => '', 'nevtomb' => 'b', 'mezonev' => 'cim', 'felirat' => 'Cím', 'ertek'=> @$sor->cim));

		$text = new Szovegdoboz(array('attr' => ' id="bevezeto" ', 'nevtomb' => 'b', 'mezonev' => 'bevezeto', 'felirat' => 'Bevezető', 'ertek'=> @$sor->bevezeto));

		$text2 = new Szovegdoboz(array('attr' => ' id="szoveg" ', 'nevtomb' => 'b', 'mezonev' => 'szoveg', 'felirat' => 'Leírás', 'ertek'=> @$sor->szoveg));

		

		$doboz->szimplaInput($input1);

		$doboz->szimplaInput($text);

		$doboz->szimplaInput($text2);

		// WYSWYG editor (Jodit)

		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');

		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');

		$doboz->ScriptHozzaadas('<script> var editorGyarto = new Jodit("#szoveg", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');

		

		$opciok = array();

		$nyelvek = beallitasOlvasas('nyelvek');

		$nyelvek = explode(',', $nyelvek);

		foreach($nyelvek as $nyelv) $opciok[$nyelv] = $nyelv;

		

		$select = new Legordulo(array('nevtomb' => 'b', 'mezonev' => 'nyelv', 'felirat' => 'Nyelv', 'ertek'=> @$sor->nyelv, 'opciok' => $opciok));

		
		

		$doboz->szimplaInput($select);

		$doboz->dobozCim('SEO beállítások');
		$input1 = new Szovegmezo(array('attr' => '','nevtomb' => 'b', 'mezonev' => 'seo_title', 'felirat' => 'SEO Title', 'ertek'=> @$sor->seo_title));
		$text = new Szovegdoboz(array('attr' => '', 'nevtomb' => 'b', 'mezonev' => 'seo_description', 'felirat' => 'SEO Description', 'ertek'=> @$sor->seo_description));
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput( $text);
		

		

		
		return true;
	}
	
	public function lista() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Bejegyzések listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Bejegyzések");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'post/szerkesztes/0', 'felirat' => 'Új Bejegyzések'));
		
		$ALG->tartalomDobozStart();
		$lista = $this->gets(DBP.'post', "ORDER BY id DESC ");
		if($lista)foreach($lista as $k => $sor) {
			
			if($sor->fokep!='') {
				$lista[$k]->kep = '<img src="'.base_url().ws_image($sor->fokep, 'smallboxed').'" >';
			
			} else {
				$lista[$k]->kep='';
			}
			
			$kategoriak = $this->Sql->sqlSorok("SELECT * from ".DBP."post_kategoriak k, ".DBP."postxkategoria x 
			WHERE x.post_id = {$sor->id} AND x.kategoria_id = k.id ORDER BY kategorianev ASC");
			$katnevarr = array();
			if($kategoriak) foreach($kategoriak as $katsor) $katnevarr[] = $katsor->kategorianev;
			$lista[$k]->kategoriak = implode(', ', $katnevarr);
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'post/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'post/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('kep' => '', 'cim' => 'Cím', 'nyelv' => 'nyelv', 'kategoriak' => 'Kategóriák' ,  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
	}
	public function kategorialista() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		
		globalisMemoria('utvonal', array(array('felirat' => 'Bejegyzés kategóriák listája')));
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Bejegyzés kategóriák");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'post/katszerkesztes/0', 'felirat' => 'Új kategória'));
		
		$ALG->tartalomDobozStart();
		$lista = $this->gets('post_kategoriak', "ORDER BY kategorianev ASC");
		
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'post/katszerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'post/kattorles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('kategorianev' => 'Név', 'nyelv' => 'nyelv',  'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		
		
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
	}
	
	public function katszerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'post/kategorialista', 'felirat' => 'Bejegyzés kategóriák') , array('felirat'=> 'Kategória szerkesztése')));
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'post_kategoriak');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'post_kategoriak');
					
			}
			$p = '';
			
			
			redirect(ADMINURL.'post/kategorialista?m='.urlencode(($p=='')?'Sikeres módosítás.':$p));
		}
		
		$sor = $this->Sql->get($id, DBP.'post_kategoriak', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Bejegyzés kategória szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'post/kategorialista', 'felirat' => 'Bejegyzés kategóriák listája') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Kategória adatai', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'kategorianev', 'felirat' => 'Cím', 'ertek'=> @$sor->kategorianev));
		$text = new Szovegdoboz(array('attr' => ' id="szoveg" ', 'nevtomb' => 'a', 'mezonev' => 'leiras', 'felirat' => 'Leírás', 'ertek'=> @$sor->leiras));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($text);
		// WYSWYG editor (Jodit)
		$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">');
		$doboz->ScriptHozzaadas('<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>');
		$doboz->ScriptHozzaadas('<script> var editorGyarto = new Jodit("#szoveg", { "buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"});</script>');
		
		$opciok = array();
		$nyelvek = beallitasOlvasas('nyelvek');
		$nyelvek = explode(',', $nyelvek);
		foreach($nyelvek as $nyelv) $opciok[$nyelv] = $nyelv;
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'nyelv', 'felirat' => 'Nyelv', 'ertek'=> @$sor->nyelv, 'opciok' => $opciok));
		
		$doboz->duplaInput($select);
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'post/kategorialista',
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
	
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'post/lista', 'felirat' => 'Fizetési módok') , array('felirat'=> 'Fizetési mód szerkesztése')));
		
		if($ci->input->post('a')) {			
			$a = $ci->input->post('a') ;
			$tag = ws_belepesEllenorzes();
			$a['felhasznalo_id'] = $tag->id;
			if($id == 0) {
				
				$id = $this->Sql->sqlSave($a, DBP.'post');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'post');
					
			}
			$p = '';
			$meglevoKategoriak = $this->ci->Sql->sqlSorok("SELECT * FROM ".DBP."postxkategoria WHERE post_id = $id ");
			$katLista = array();
			if($meglevoKategoriak) foreach($meglevoKategoriak as $meglevo) $katLista[$meglevo->kategoria_id] = $meglevo;
			
			if($this->ci->input->post('k')) {
				$k = $this->ci->input->post('k');
				foreach($k as $kategoria_id) {
					if(isset($katLista[$kategoria_id])) {
						// már fenn van, nincs dolgunk vele
						unset($katLista[$kategoria_id]);
					} else {
						$ac = array('kategoria_id' => $kategoria_id , 'post_id' => $id);
						$this->ci->Sql->sqlSave($ac, DBP.'postxkategoria');
						
					}
				}
				
			}
			if(!empty($katLista)) foreach($katLista as $kat) $this->ci->db->query("DELETE FROM ".DBP."postxkategoria WHERE id = ".$kat->id);
			
			
			if($_FILES['logokep']['name']!='') {
				if(imgcheck('logokep')) {
					$filenev = DBP.'fokep_'.$id.'.'.ws_ext($_FILES['logokep']['name']);
					$path = 'assets/post/';
					if(move_uploaded_file($_FILES['logokep']['tmp_name'],FCPATH.$path.$filenev )) {
						// all is fine...
						$a['fokep'] = $path.$filenev;
						
						include_once(APPPATH.'libraries/Zebraimage.php');
						
						
						$image = new Zebra_Image();
						$image->source_path = FCPATH.$a['fokep'];
						$image->target_path  = FCPATH.$a['fokep'];
						
						$mod = ZEBRA_IMAGE_CROP_CENTER;
						
						$image->resize(720, 480, $mod);
						
						$this->Sql->sqlUpdate($a,DBP.'post' );
						
					} else {
						$p = urlencode("Hiba a kép feltöltésénél!");
					}
				} else $p = urlencode("Hiba a kép feltöltésénél!");
				
				
				
			}
				
				
			if($_POST['kepurl']!='') {
					$url = $_POST['kepurl'];
					
					$eredetiNev = basename($url);
					$filenev = 'fokep_'.$id.'.'.ws_ext($eredetiNev);

					$path = 'assets/post/';
					$kep = file_get_contents($url);
					
					if(file_put_contents(FCPATH.$path.$filenev, $kep )) {

						// all is fine...

						$a['fokep'] = $path.$filenev;

						

						include_once(APPPATH.'libraries/Zebraimage.php');

						

						

						$image = new Zebra_Image();

						$image->source_path = FCPATH.$a['fokep'];

						$image->target_path  = FCPATH.$a['fokep'];

						

						$mod = ZEBRA_IMAGE_CROP_CENTER;

						

						$image->resize(1000, 500, $mod);

						

						$this->Sql->sqlUpdate($a,DBP.'post' );

						

					} else {

						$p = urlencode("Hiba a kép feltöltésénél!");

					}
				}
			redirect(ADMINURL.'post/lista?m='.urlencode(($p=='')?'Sikeres módosítás.':$p));
		}
		
		$sor = $this->Sql->get($id, DBP.'post', 'id');
		
		$ALG = new Adminlapgenerator;
		
		$ALG->adatBeallitas('lapCim', "Bejegyzés szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'post/lista', 'felirat' => 'Bejegyzések listája') );
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Bejegyzés adatai', 2);
		
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'cim', 'felirat' => 'Cím', 'ertek'=> @$sor->cim));
		$text = new Szovegdoboz(array('attr' => ' id="bevezeto" ', 'nevtomb' => 'a', 'mezonev' => 'bevezeto', 'felirat' => 'Bevezető', 'ertek'=> @$sor->bevezeto));
		$text2 = new Szovegdoboz(array('attr' => ' id="szoveg" ', 'nevtomb' => 'a', 'mezonev' => 'szoveg', 'felirat' => 'Leírás', 'ertek'=> @$sor->szoveg));
		
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput($text);
		$doboz->szimplaInput($text2);
		// WYSWYG editor (Jodit)
		$doboz->jodit();
		
		$opciok = array();
		$nyelvek = beallitasOlvasas('nyelvek');
		$nyelvek = explode(',', $nyelvek);
		foreach($nyelvek as $nyelv) $opciok[$nyelv] = $nyelv;
		
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'nyelv', 'felirat' => 'Nyelv', 'ertek'=> @$sor->nyelv, 'opciok' => $opciok));
		
		
		$doboz->szimplaInput($select);		
		$file = new Filefeltolto(array('nevtomb' => '','tipus' => 'feltoltes', 'mezonev' => 'logokep', 'felirat' => 'Főkép (jpg, png)'));
		$input1 = new Szovegmezo(array('nevtomb' => '', 'mezonev' => 'kepurl', 'felirat' => 'vagy kép URL', 'ertek'=> ''));

		$doboz->duplaInput($file, $input1);
		
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim('SEO beállítások');
		$input1 = new Szovegmezo(array('attr' => '','nevtomb' => 'a', 'mezonev' => 'seo_title', 'felirat' => 'SEO Title', 'ertek'=> @$sor->seo_title));
		$text = new Szovegdoboz(array('attr' => '', 'nevtomb' => 'a', 'mezonev' => 'seo_description', 'felirat' => 'SEO Description', 'ertek'=> @$sor->seo_description));
		$doboz->szimplaInput($input1);
		$doboz->szimplaInput( $text);
		
		$katlista = $this->ci->Sql->gets(DBP.'post_kategoriak', " ORDER BY kategorianev ASC ");
		$jeloltek = $this->ci->Sql->sqlSorok("SELECT * FROM ".DBP."postxkategoria WHERE post_id = ".$id);
		$checkedArr = array();
		if($jeloltek) foreach($jeloltek as $jSor) $checkedArr[$jSor->kategoria_id] = 1;		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Bejegyzés kategóriák', 2);
		
		for($i = 0; $i < count($katlista); $i += 2) {
			$sor = $katlista[$i];
			$input1 = new Jelolonegyzet(array( 'attr' => ((isset($checkedArr[$sor->id]))?' checked ':''), 'nevtomb' => 'k', 'mezonev' => '', 'felirat' => $sor->kategorianev, 'ertek'=> @$sor->id));
			
			if(isset($katlista[$i+1])) {
				$sor = $katlista[$i+1];
				$input2 = new Jelolonegyzet(array('attr' => ((isset($checkedArr[$sor->id]))?' checked ':''), 'nevtomb' => 'k', 'mezonev' => '', 'felirat' => $sor->kategorianev, 'ertek'=> @$sor->id));
			} else {
				$input2 = false;
			}
			$doboz->duplaInput($input1, $input2);
		}
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'post/lista',
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
		
		$this->db->query("DELETE FROM ".DBP."post WHERE id =  ".$id);
		$this->db->query("DELETE FROM ".DBP."postxkategoria WHERE post_id =  ".$id);
		$filenev = 'fokep_'.$id.'.jpg';
		$path = 'assets/post/';
		@unlink(FCPATH.$path.$filenev);
		$filenev = 'fokep_'.$id.'.png';
		@unlink(FCPATH.$path.$filenev);
		
		
		redirect(ADMINURL.'post/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	public function del_szerkesztes() {
		$ci = getCI();
		$this->data['tid'] = $id = (int)$ci->uri->segment(4);
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a');
			if($id==0) {
				$id = $this->sqlSave($a, DBP.'post');
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, DBP.'post', 'id');
			}
			
			redirect(ADMINURL.'post/lista');
		}
		
		
		
		$this->data['sor'] = $this->get($id, 'post', 'id');
		
		return $ci->load->view(ADMINTEMPLATE.'html/post_szerkesztes', $this->data, true);
		
	}
	
	// képfeltöltés
	public function imageupload() {
		$tid = $this->ci->uri->segment(4);
		@mkdir(FCPATH.'termekkepek/t_'.$tid,0777);
		@mkdir(FCPATH.'termekkepek/t_'.$tid.'/th',0777);
		$filename = DBP.strToUrl(ws_withoutext($_FILES['file']['name'])).'.'.strtolower(ws_ext($_FILES['file']['name']));
		$location = 'termekkepek/t_'.$tid.'/'.$filename;
		$thmblocation = 'termekkepek/t_'.$tid.'/th/'.$filename;
		
		$uploadOk = 1;
		$imageFileType = pathinfo( $_FILES['file']['name'],PATHINFO_EXTENSION);

		// Check image format
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			$uploadOk = 0;
		}
		
		if($uploadOk == 0){
			echo 0;
		}else{
			 /* Upload file */
			 if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				 // értelmesre méretezzük, max szélesség 800
				include(APPPATH.'libraries/Zebraimage.php');
				$image = new Zebra_Image();
				$image->source_path = $location;
				$image->target_path  = $location;
				$image->resize(800, 600, ZEBRA_IMAGE_NOT_BOXED, -1);
				
				$image->target_path  = $thmblocation;
				$image->resize(200, 200, ZEBRA_IMAGE_BOXED, -1);
				
				
				$this->keplista();
			}else{
				echo 0;
			}
		}
		
	}
	// adott levél kéének törlése
	function keptorles() {
		$tid = $this->uri->segment(4);
		$kep = $_POST['kep'];
		
		$location  = FCPATH.'termekkepek/t_'.$tid.'/'.$kep;
		$location2 = FCPATH.'termekkepek/t_'.$tid.'/th/'.$kep;
		unlink ($location);
		unlink ($location2);
	}
	// adott levél képeinek listázása
	function keplista() {
		
		$tid = $this->ci->uri->segment(4);
		
		$location = FCPATH.'termekkepek/t_'.$tid.'/';
		print json_encode(@scandir($location));
	}
}

