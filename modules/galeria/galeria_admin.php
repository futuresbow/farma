<?php
class Galeria_admin extends MY_Modul {
	function galeriamegjelenitesindex_ellenorzes($adat) {
		$param = unserialize($adat['parameter']);
		$elem = $lista = $this->ci->Sql->get( $param['galeria_id'], DBP."galeriak", " id ");
		if(isset($elem->nev)) $adat['elemnev'] = $elem->nev; else return false;
		return $adat;
	}
	// oldal tartalom beállító
	function galeriamegjelenitesindex_beallito($param, $ALG) {
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'galeria kiválasztása', 2);
		$galeriak = $this->Sql->gets(DBP."galeriak", "ORDER BY id DESC");
		$opciok = array(0 => 'Nincs kiválasztva');
		if($galeriak) foreach($galeriak as  $galeria) {
			$opciok[$galeria->id] = $galeria->nev; 
		}
		$select = new Legordulo(array('nevtomb' => 'a', 'mezonev' => 'galeria_id', 'opciok' => $opciok, 'ertek' => (isset($param['galeria_id']))?(int)$param['galeria_id']:0, 'felirat' => 'Válaszd ki a galeriat'));
		$doboz->szimplaInput($select);
		return true;
	}
	public function torles() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		$this->db->query("DELETE FROM ".DBP."galeria_kepek WHERE galeria_id =  ".$id);
		$this->db->query("DELETE FROM ".DBP."galeriak WHERE id =  ".$id);
		redirect(ADMINURL.'galeria/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	// galeriak listája
	function lista() {
		globalisMemoria("Nyitott menüpont",'');
		globalisMemoria('utvonal', array(array('felirat' => 'Galériák listája')));
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Galériák");
		$ALG->adatBeallitas('szelessegOsztaly', "full-width");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'galeria/szerkesztes/0', 'felirat' => 'Új galeria'));
		$ALG->tartalomDobozStart();
		// táblázat adatok összeállítása
		$adatlista = array();
		$start = 0;
		$w = '';
		$lista = $this->sqlSorok('SELECT * FROM '.DBP.'galeriak '.$w.' ORDER BY nev ASC ');
		foreach($lista as $sor) {
			$kep = $this->ci->Sql->sqlSor(' SELECT * FROM '.DBP.'galeria_kepek WHERE galeria_id = '.$sor->id.' ORDER BY sorrend ASC LIMIT 1');
			if($kep) {
				$sor->logo = '<img style="border: 1px solid #aaa" src="'.base_url().ws_image($kep->kep, 'mediumboxed').'" >';
			} else {
				$sor->logo = '<div style="width:180px;height:180px;text-align:center;line-height:180px;border: 1px solid #aaa">nincs kép</div>';
			}
		}
		// táblázat beállítás
		$tablazat = $ALG->ujTablazat();
		$keresoMezok = false;
		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);
		$tablazat->adatBeallitas('szerkeszto_url', 'galeria/szerkesztes/');
		$tablazat->adatBeallitas('torles_url', 'galeria/torles/');
		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'logo' => 'Logó', 'szerkesztes' => 'Szerkesztés',  'torles' => 'Törlés' ));
		$tablazat->adatBeallitas('lista', $lista);
		$ALG->tartalomDobozVege();
		return $ALG->kimenet();
	}
	// galeria szerkesztés
	function szerkesztes() {
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		globalisMemoria('utvonal', array(array('url' => 'galeria/lista', 'felirat' => 'Galériák listája') , array('felirat'=> 'galeria szerkesztése')));
		if(isset($_FILES['file'])) if($_FILES['file']['name']!='' and $id != 0) {
				include_once(APPPATH.'libraries/Zebraimage.php');
				$fname = $_FILES['file']['name'];
				$ext = ws_ext($fname);
				if(strtolower($ext)!='jpg' and strtolower($ext)!='jpeg') return 0;
				$fname = $id.'_'.strToUrl(ws_withoutext($fname)).'_'.rand(111,999);
				$image = new Zebra_Image();
				$image->source_path = $_FILES['file']['tmp_name'];
				$image->target_path  = FCPATH.'assets/galeria/'.$fname.'.jpg';
				$mod = ZEBRA_IMAGE_NOT_BOXED;
				$image->resize(1000, 800, $mod);
				$a = array('galeria_id' => $id, 'kep' =>'assets/galeria/'.$fname.'.jpg');
				$this->ci->Sql->sqlSave($a, DBP.'galeria_kepek', 'id');
				
				// képek visszaadása
				$lista = $this->ci->Sql->gets(DBP.'galeria_kepek', ' ORDER BY sorrend ASC ');
				if(!empty($lista)) {
					foreach($lista as $k => $kepSor) {
						$lista[$k]->kep = '<a href="'.base_url().$kepSor->kep.'" title="" target="_blank" class="pic-container" style="width:180px;height:180px;background-image: url(\''.base_url().ws_image($kepSor->kep, 'medium').'\');"></a>';
						$lista[$k]->leiras = '<div class="input-container "><textarea class="galeriainput" type="text" name="sleiras['.$kepSor->id.']" style="width:240px;height:180px;">'.$kepSor->leiras.'</textarea></div>';
						$lista[$k]->torlo = '<input type="checkbox" name="t['.$kepSor->id.']" value="'.$kepSor->id.'"> - törlés';
				
					}
					// táblázat beállítás
					$tablazat = new ALGTablazat();
					$tablazat->adatBeallitas('keresoMezok', false);
					//$tablazat->adatBeallitas('szerkeszto_url', 'beallitasok/menuszerkesztes/');
					//$tablazat->adatBeallitas('torles_url', 'beallitasok/menutorles/');
					$tablazat->adatBeallitas('megjelenitettMezok', array('kep' => 'Kép', 'leiras' => 'Leírás', 'torlo' => 'Törlés'));
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
					$sql = "UPDATE ".DBP."galeria_kepek SET sorrend = ".($k*10)." WHERE id = $kepId  ";
					$ci->db->query($sql);
				}
			}
		}
		if($ci->input->post('a')) {
			$a = $ci->input->post('a') ;
			if($id == 0) {
				$id = $this->Sql->sqlSave($a, DBP.'galeriak');
				$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->Sql->sqlUpdate($a, DBP.'galeriak');
			}
			$p = '';
			if($this->ci->input->post('kepsortorles')) {
				$keptorlesek = $this->ci->input->post('kepsortorles');
				foreach($keptorlesek as $kid => $kepsor) {
					$this->ci->db->query("DELETE FROM ".DBP."galeria_kepek WHERE id = $kid LIMIT 1");
				}
			}
			if($this->ci->input->post('kepsor')) {
				$kepsorok = $this->ci->input->post('kepsor');
				foreach($kepsorok as $kid => $kepsor) {
					$kepsor['id'] = $kid;
					$this->ci->Sql->sqlUpdate($kepsor, DBP.'galeria_kepek');
				}
			}
			if($this->ci->input->post('t')) {
				$kepsorok = $this->ci->input->post('t');
				foreach($kepsorok as $kid => $kepsor) {
					$kep = $this->ci->db->query("SELECT *  FROM ".DBP."galeria_kepek WHERE id = ".$kid." LIMIT 1");
					$this->ci->db->query("DELETE FROM ".DBP."galeria_kepek WHERE id = ".$kid." LIMIT 1");
				}
			}
			if($this->ci->input->post('sleiras')) {
				$sleiras = $this->ci->input->post('sleiras');
				foreach($sleiras as $kid => $leiras) {
					$a = array('id' => $kid, 'leiras' => $leiras);
					$this->ci->Sql->sqlUpdate($a, DBP.'galeria_kepek');
				}
			}
			if(!$ci->input->post('ddsorrend')) redirect(ADMINURL.'galeria/lista?m='.'Sikeres módosítás.');
		}
		$sor = $this->Sql->get($id, DBP.'galeriak', 'id');
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "galeria szerkesztése");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'galeria/lista', 'felirat' => 'galeria lista') );
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		$ALG->tartalomDobozStart();
		if($id!=0) {
			$doboz = $ALG->ujDoboz();
			$doboz->dobozCim( 'galéria képek feltöltése', 3);
			/*
			$input1 = new Filefeltolto(array('nevtomb' => 'fileok', 'mezonev' => '', 
			'felirat' => 'Kép (többet is kiválaszthatsz.)', 'gombfelirat' => 'Feltöltés',
			'attr' => ' multiple  '));
			$doboz->szimplaInput($input1);
			*/
			$ajaxFeltolto = new Ajaxfeltolto(array('multiple' => 1, 'attr' => ' multiple=multiple ', 'mezonev' => '', 'nevtomb' => 'fileok', 'id' => $id, 'url' => ADMINURL.'galeria/szerkesztes/'.$id) );
			$doboz->szimplaInput($ajaxFeltolto);
			$lista = $this->ci->Sql->gets(DBP.'galeria_kepek', ' ORDER BY sorrend ASC ');
			if(!empty($lista)) {
				foreach($lista as $k => $kepSor) {
					$lista[$k]->kep = '<a href="'.base_url().$kepSor->kep.'" title="" target="_blank" class="pic-container" style="height:180px;width:180px;background-image: url(\''.base_url().ws_image($kepSor->kep, 'medium').'\');"></a>';
					$lista[$k]->leiras = '<div class="input-container "><textarea class="galeriainput" style="height:180px;width:240px;" name="sleiras['.$kepSor->id.']" >'.$kepSor->leiras.'</textarea></div>';
					$lista[$k]->torlo = '<input type="checkbox" name="t['.$kepSor->id.']" value="'.$kepSor->id.'"> - törlés';
				}
				// táblázat beállítás
				$ALG->tartalomHozzaadas('<div class="ajaxVisszairas">');
				$tablazat = $ALG->ujTablazat();
				$ALG->tartalomHozzaadas('</div>');
				$tablazat->adatBeallitas('keresoMezok', false);
				//$tablazat->adatBeallitas('szerkeszto_url', 'beallitasok/menuszerkesztes/');
				//$tablazat->adatBeallitas('torles_url', 'beallitasok/menutorles/');
				$tablazat->adatBeallitas('megjelenitettMezok', array('kep' => 'Kép', 'leiras' => 'Leírás','torlo' => 'Törlés'));
				$tablazat->adatBeallitas('lista', $lista);
				$tablazat->sorrendezheto();
				// táblázat beállítás vége
				//$doboz = $ALG->ujDoboz();
				//$doboz->dobozCim( 'Feltöltött képek', 3);
				//$doboz->ScriptHozzaadas($this->ci->load->view(beallitasOlvasas('ADMINTEMA').'/html/galeria_lista', array('lista' => $lista), true));
				// TODO sortable-re megcsinálni
				//$doboz->ScriptHozzaadas('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">');
				//$doboz->ScriptHozzaadas('<script>$( function() { alert("ok");$( ".sortable" ).sortable(); $( ".sortable" ).disableSelection(); } );</script>');
			}  else {
				$ALG->tartalomHozzaadas('<div class="ajaxVisszairas">');
				$ALG->tartalomHozzaadas('</div>');
			}
		}
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim( 'galeria adatai', 2);
		$input1 = new Szovegmezo(array('attr' => '','nevtomb' => 'a', 'mezonev' => 'nev', 'felirat' => 'Megnevezés', 'ertek'=> @$sor->nev));
		$doboz->szimplaInput($input1);
		
		$input1 = new Filefeltolto(array('nevtomb' => 'a', 'mezonev' => 'kep', 'felirat' => 'Galéria főkép', 'ertek'=> @$sor->kep));
		$doboz->szimplaInput($input1);
		if(@$sor->kep!='') {
			$doboz->HTMLHozzaadas('<center><img src="'.base_url().ws_image($kepSor->kep, 'medium').'" /></center>');
		}
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'galeria/lista',
				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"
			),
			1 => array(
				'tipus' => 'submit',
				'felirat' => 'galéria mentése',
				'link' => '',
				'osztaly' => 'btn-ok',
			),
		));
		$ALG->urlapVege();
		return $ALG->kimenet();
	}
} 
