<?php
class Slider_admin extends MY_Modul {
	function slidermegjelenitesindex_ellenorzes($adat) {
		$param = unserialize($adat['parameter']);
		$elem = $lista = $this->ci->Sql->get( $param['slider_id'], DBP."sliderek", " id ");
		if(isset($elem->nev)) $adat['elemnev'] = $elem->nev; else return false;
		return $adat;
	}
	// oldal tartalom beállító
	function slidermegjelenitesindex_beallito($param, $ALG) {
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Slider kiválasztása', 2);
		$sliderek = $this->Sql->gets(DBP."sliderek", "ORDER BY id DESC");
		$opciok = array(0 => 'Nincs kiválasztva');
		if($sliderek) foreach($sliderek as  $slider) {
			$opciok[$slider->id] = $slider->nev; 
		}
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'slider_id', 'opciok' => $opciok, 'ertek' => (isset($param['slider_id']))?(int)$param['slider_id']:0, 'felirat' => 'Válaszd ki a slidert'));
		$doboz->szimplaInput($select);
		return true;
	}
	public function torles() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		$this->db->query("DELETE FROM ".DBP."slider_kepek WHERE slider_id =  ".$id);
		$this->db->query("DELETE FROM ".DBP."sliderek WHERE id =  ".$id);
		redirect(ADMINURL.'slider/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	// sliderek listája
	function lista() {
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		globalisMemoria('utvonal', array(array('felirat' => 'Slider-ek listája')));
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Slider-ek");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'slider/szerkesztes/0', 'felirat' => 'Új slider'));
		$ALG->tartalomDobozStart();
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'sliderek '.$w.' ORDER BY nev ASC ');
		foreach($lista as $sor) {
			$kep = $this->ci->Sql->sqlSor(' SELECT * FROM '.DBP.'slider_kepek WHERE slider_id = '.$sor->id.' ORDER BY sorrend ASC LIMIT 1');
			if($kep) {
				$sor->logo = '<img style="border: 1px solid #aaa" src="'.base_url().ws_image($kep->kep, 'smallboxed').'" >';
			} else {
				$sor->logo = '<div style="width:80px;height:80px;text-align:center;line-height:80px;border: 1px solid #aaa">nincs kép</div>';
			}
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'slider/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'slider/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'logo' => 'Logó', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
	}
	// slider szerkesztés
	function szerkesztes() {
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'slider/lista', 'felirat' => 'Slider-ek listája') , array('felirat'=> 'Slider szerkesztése')));
		if(isset($_FILES['file'])) if($_FILES['file']['name']!='' and $id != 0) {
				include_once(APPPATH.'libraries/Zebraimage.php');
				$fname = $_FILES['file']['name'];
				$ext = ws_ext($fname);
				if(strtolower($ext)!='jpg' and strtolower($ext)!='jpeg') return 0;
				$fname = $id.'_'.ws_withoutext($fname);
				$image = new Zebra_Image();
				$image->source_path = $_FILES['file']['tmp_name'];
				$image->target_path  = FCPATH.'assets/slider/'.$fname.'.jpg';
				$mod = ZEBRA_IMAGE_CROP_CENTER;
				$image->resize(1180, 400, $mod);
				$a = array('slider_id' => $id, 'kep' =>'assets/slider/'.$fname.'.jpg');
				$this->ci->Sql->sqlSave($a, DBP.'slider_kepek', 'id');
				$lista = $this->ci->Sql->gets(DBP.'slider_kepek', ' ORDER BY sorrend ASC ');
				if(!empty($lista)) {
					foreach($lista as $k => $kepSor) {
						$lista[$k]->kep = '<a href="'.base_url().$kepSor->kep.'" title="" target="_blank" class="pic-container" style="background-image: url(\''.base_url().ws_image($kepSor->kep, 'medium').'\');"></a>';
						$lista[$k]->leiras = '<div class="input-container "><input class="sliderinput" value="'.$kepSor->leiras.'" type="text" name="sleiras['.$kepSor->id.']" /></div>';
					}
					// táblázat beállítás
					$tablazat = new ALGTablazat();
					$tablazat->adatBeallitas('keresoMezok', false);
					//$tablazat->adatBeallitas('szerkeszto_url', 'beallitasok/menuszerkesztes/');
					//$tablazat->adatBeallitas('torles_url', 'beallitasok/menutorles/');
					$tablazat->adatBeallitas('megjelenitettMezok', array('kep' => 'Kép', 'leiras' => 'Leírás', 'sorrend' => 'Sorrend'));
					$tablazat->adatBeallitas('lista', $lista);
					$tablazat->sorrendezheto();
					return $tablazat->kimenet();
				}
				return '';
			}
		if($ci->input->post('ddsorrend')) {
			$arr = explode(',',$ci->input->post('ddsorrend'));
			if(!empty($arr)) {
				foreach($arr as $k => $kepId) {
					if(!is_numeric(trim($kepId))) continue;
					$sql = "UPDATE ".DBP."slider_kepek SET sorrend = ".($k*10)." WHERE id = $kepId  ";
					$ci->db->query($sql);
				}
			}
		}
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'sliderek');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'sliderek');
			}
			$p = '';
			if($this->ci->input->post('kepsortorles')) {
				$keptorlesek = $this->ci->input->post('kepsortorles');
				foreach($keptorlesek as $kid => $kepsor) {
					$this->ci->db->query("DELETE FROM ".DBP."slider_kepek WHERE id = $kid LIMIT 1");
				}
			}
			if($this->ci->input->post('kepsor')) {
				$kepsorok = $this->ci->input->post('kepsor');
				foreach($kepsorok as $kid => $kepsor) {
					$kepsor['id'] = $kid;
					$this->ci->Sql->sqlUpdate($kepsor, DBP.'slider_kepek');
				}
			}
			if($this->ci->input->post('t')) {
				$kepsorok = $this->ci->input->post('t');
				foreach($kepsorok as $kid => $kepsor) {
					$kep = $this->ci->db->query("SELECT *  FROM ".DBP."slider_kepek WHERE id = ".$kid." LIMIT 1");
					$this->ci->db->query("DELETE FROM ".DBP."slider_kepek WHERE id = ".$kid." LIMIT 1");
				}
			}
			if($this->ci->input->post('sleiras')) {
				$sleiras = $this->ci->input->post('sleiras');
				foreach($sleiras as $kid => $leiras) {
					$a = array('id' => $kid, 'leiras' => $leiras);
					$this->ci->Sql->sqlUpdate($a, DBP.'slider_kepek');
				}
			}
			if(!$ci->input->post('ddsorrend')) redirect(ADMINURL.'slider/lista?m='.'Sikeres módosítás.');
		}
		$sor = $this->Sql->get($id, DBP.'sliderek', 'id');
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Slider szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'slider/lista', 'felirat' => 'Slider lista') );
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		$ALG->tartalomDobozStart();
		if($id!=0) {
			$doboz = $ALG->ujDoboz();
			$doboz->dobozCim( 'Slider képek feltöltése', 3);
			/*
			$input1 = new Filefeltolto(array('nevtomb' => 'fileok', 'mezonev' => '', 
			'felirat' => 'Kép (többet is kiválaszthatsz.)', 'gombfelirat' => 'Feltöltés',
			'attr' => ' multiple  '));
			$doboz->szimplaInput($input1);
			*/
			$ajaxFeltolto = new Ajaxfeltolto(array('mezonev' => '', 'nevtomb' => 'fileok', 'id' => $id, 'url' => ADMINURL.'slider/szerkesztes/'.$id) );
			$doboz->szimplaInput($ajaxFeltolto);
			$lista = $this->ci->Sql->gets(DBP.'slider_kepek', ' ORDER BY sorrend ASC ');
			if(!empty($lista)) {
				foreach($lista as $k => $kepSor) {
					$lista[$k]->kep = '<a href="'.base_url().$kepSor->kep.'" title="" target="_blank" class="pic-container" style="background-image: url(\''.base_url().ws_image($kepSor->kep, 'medium').'\');"></a>';
					$lista[$k]->leiras = '<div class="input-container "><input class="sliderinput" value="'.$kepSor->leiras.'" type="text" name="sleiras['.$kepSor->id.']" /></div>';
					$lista[$k]->torlo = '<input type="checkbox" name="t['.$kepSor->id.']" value="'.$kepSor->id.'"> - törlés';
				}
				// táblázat beállítás
				$ALG->tartalomHozzaadas('<div class="ajaxVisszairas">');
				$tablazat = $ALG->ujTablazat();
				$ALG->tartalomHozzaadas('</div>');
				$tablazat->adatBeallitas('keresoMezok', false);
				//$tablazat->adatBeallitas('szerkeszto_url', 'beallitasok/menuszerkesztes/');
				//$tablazat->adatBeallitas('torles_url', 'beallitasok/menutorles/');
				$tablazat->adatBeallitas('megjelenitettMezok', array('kep' => 'Kép', 'leiras' => 'Leírás','torlo' => 'Törlés','sorrend' => 'Sorrend'));
				$tablazat->adatBeallitas('lista', $lista);
				$tablazat->sorrendezheto();
				// táblázat beállítás vége
				//$doboz = $ALG->ujDoboz();
				//$doboz->dobozCim( 'Feltöltött képek', 3);
				//$doboz->ScriptHozzaadas($this->ci->load->view(beallitasOlvasas('ADMINTEMA').'/html/slider_lista', array('lista' => $lista), true));
				// TODO sortable-re megcsinálni
				//$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">');
				//$doboz->ScriptHozzaadas('<script>$( function() { alert("ok");$( ".sortable" ).sortable(); $( ".sortable" ).disableSelection(); } );</script>');
			}  else {
				$ALG->tartalomHozzaadas('<div class="ajaxVisszairas">');
				$ALG->tartalomHozzaadas('</div>');
			}
		}
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'Slider adatai', 2);
		$input1 = new Szovegmezo(array('nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$doboz->szimplaInput($input1);
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'slider/lista',
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'Slider mentése',
				'link' => '',
				'osztaly' => 'btn-ok',
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
	}
} 
