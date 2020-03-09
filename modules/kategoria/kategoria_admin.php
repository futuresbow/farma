<?php

class Kategoria_admin extends MY_Modul{
	var $data = array();
	
	public function lista() {		globalisMemoria("Nyitott menüpont",'Termékek');
		globalisMemoria('utvonal', array(array('felirat' => 'Kategóriák')));				$rendezeshiba = false;
		if(isset($_GET['mibe'])) {						$mibe = (int)$_GET['mibe'];			$mit = (int)$_GET['mit'];						// saját gyerekbe mentés ellenőrzés			if(!$this->sajatGyermekElem($mit, $mibe)){							$sql = "SELECT * FROM ".DBP."kategoriak WHERE szulo_id = $mibe ORDER BY sorrend ASC";				$alLista = $this->Sql->sqlSorok($sql);								//$this->db->query("UPDATE kategoriak SET szulo_id = $mibe, sorrend = 0 WHERE id = $mit");									if($alLista) {					foreach($alLista as $k => $sor) {						//$this->db->query("UPDATE kategoriak SET sorrend = ".( ($k+1) * 10)." WHERE id = ".$sor->id);					}				}			} else {				$rendezeshiba = true;			}		}		if(isset($_GET['kov'])) {			$kov = (int)$_GET['kov'];			$mit = (int)$_GET['mit'];						// saját gyerekbe mentés ellenőrzés			if(!$this->sajatGyermekElem($mit, $kov)){				$sql = "SELECT * FROM ".DBP."kategoriak WHERE id = $kov LIMIT 1";				$kovSor = $this->Sql->sqlSor($sql);								$sql = "SELECT * FROM ".DBP."kategoriak WHERE id = {$kovSor->szulo_id} LIMIT 1";				$szulo = $this->Sql->sqlSor($sql);				if(isset($szulo->id)) {					$szuloid = $szulo->id;				} else {					$szuloid = 0;				}								$sql = "SELECT * FROM ".DBP."kategoriak WHERE szulo_id = $szuloid ORDER BY sorrend ASC";				$alLista = $this->Sql->sqlSorok($sql);																if($alLista) {					$k = 0;					foreach($alLista as $sor) {						if($sor->id==$mit) continue;						if($sor->id == $kov){							$sql = "UPDATE ".DBP."kategoriak SET szulo_id = $szuloid, sorrend = ".( ($k+1) * 10)." WHERE id = $mit";							$this->db->query($sql);							$k++;						}						$sql = "UPDATE ".DBP."kategoriak SET sorrend = ".( ($k+1) * 10)." WHERE id = ".$sor->id;													$this->db->query($sql);						$k++;					}				}			} else {				$rendezesihiba = true;			}		}		if(isset($_GET['elo'])) {			$elo = (int)$_GET['elo'];			$mit = (int)$_GET['mit'];						// saját gyerekbe mentés ellenőrzés			if(!$this->sajatGyermekElem($mit, $elo)){				$sql = "SELECT * FROM ".DBP."kategoriak WHERE id = $elo LIMIT 1";				$kovSor = $this->Sql->sqlSor($sql);								$sql = "SELECT * FROM ".DBP."kategoriak WHERE id = {$kovSor->szulo_id} LIMIT 1";				$szulo = $this->Sql->sqlSor($sql);				if(isset($szulo->id)) {					$szuloid = $szulo->id;				} else {					$szuloid = 0;				}								$sql = "SELECT * FROM ".DBP."kategoriak WHERE szulo_id = $szuloid ORDER BY sorrend ASC";				$alLista = $this->Sql->sqlSorok($sql);																if($alLista) {					$k = 0;					foreach($alLista as $sor) {						if($sor->id==$mit) continue;												$sql = "UPDATE ".DBP."kategoriak SET sorrend = ".( ($k+1) * 10)." WHERE id = ".$sor->id;												$this->db->query($sql);						$k++;																		if($sor->id == $elo){							$sql = "UPDATE ".DBP."kategoriak SET szulo_id = $szuloid, sorrend = ".( ($k+1) * 10)." WHERE id = $mit";							$this->db->query($sql);														$k++;						}																	}				}			} else {				$rendezesihiba = true;			}		}				if($rendezeshiba) globalisMemoria('adminUzenet',"Nem lehetséges a kategóriát önmagába helyezni." );						$ci = getCI();
		$this->data['lista'] = $ci->Sql->kategoriaFa(0);
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Kategóriák");
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'kategoria/szerkesztes/0', 'felirat' => 'Új kategória'));
		
		
		$ALG->tartalomDobozStart();
		
		
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim('Létrehozott kategóriák', 3);
		
		
				$ALG->tartalomHozzaadas($ci->load->view(ADMINTEMPLATE.'html/kategoria_lista', $this->data, true));
		
		
		
		
		
		$ALG->tartalomDobozVege();
		$ALG->urlapGombok(array(
			0 => array(
				'osztaly' => 'btn-ok',
				'tipus' => 'hivatkozas',
				'felirat' => 'Új kategória',
				'link' => ADMINURL.'kategoria/szerkesztes/0',
			)
		));
		return $ALG->kimenet();
		
	}		public function sajatGyermekElem($mit, $mibe) {		$sajatGyerek = false;				if($mibe==0) return false; // főkategória lesz, mehet		if($mibe==$mit) return true; // önmagába köti				$sql = "SELECT id, szulo_id FROM ".DBP."kategoriak WHERE id = $mibe";		$rs = $this->Sql->sqlSor($sql);				if($rs->szulo_id==0) return false; // végigért, nincs gond		return $this->sajatGyermekElem($mit, $rs->szulo_id); // rekurzívan nézzük tovább	}	
	public function torol() {
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		$van = $this->Sql->get($id, DBP."kategoriak", 'szulo_id');
		if($van) {
			redirect(ADMINURL.'kategoria/lista?c=hiba&m='.urlencode('A kategória nem törölhető, mert van alkategóriája!'));
			return;
		}
		
		$van = $this->Sql->get($id, DBP."termekxkategoria", 'kategoria_id');
		if($van) {
			redirect(ADMINURL.'kategoria/lista?c=hiba&m='.urlencode('A kategória nem törölhető, mert termék van hozzárendelve'));
			return;
		}
		$this->db->query("DELETE FROM ".DBP."kategoriak WHERE id =  ".$id);
		redirect(ADMINURL.'kategoria/lista?m='.urlencode('Sikeres törlés!'));
		return;
	}
	public function szerkesztes() {		globalisMemoria("Nyitott menüpont",'Termékek');
		
		globalisMemoria('utvonal', array(array('url' => 'kategoria/lista', 'felirat' => 'Kategóriák'), array( 'felirat' => 'Kategória szerkesztés')));
		
		$ci = getCI();
		$id = (int)$ci->uri->segment(4);
		
		if($ci->input->post('a')) {
			$a = $ci->input->post('a');
			if($id==0) {
				$id = $this->sqlSave($a, DBP.'kategoriak');								$a['id'] = $id;
			} else {
				$a['id'] = $id;
				$this->sqlUpdate($a, DBP.'kategoriak', 'id');
			}
			
			// kategoriakepek
			if($_FILES['kep']['name']!='') {
				if(imgcheck('kep')) {

					$filenev = 'kategoriakep_'.$id.'_'.rand(10,90).'.'.ws_ext($_FILES['kep']['name']);
					$path = 'assets/kategoriakepek/';
					if(move_uploaded_file($_FILES['kep']['tmp_name'],FCPATH.$path.$filenev )) {						

						// all is fine...
						$a['kep'] = $path.$filenev;						$this->sqlUpdate($a, DBP.'kategoriak', 'id');
						
						include_once(APPPATH.'libraries/Zebraimage.php');
						
						
						$image = new Zebra_Image();
						$image->source_path = FCPATH.$a['kep'];
						$image->target_path  = FCPATH.$a['kep'];
						
						$mod = ZEBRA_IMAGE_CROP_CENTER;
						
						$image->resize(600, 600, $mod);
						
						$this->Sql->sqlUpdate($a,'kategoriak' );
						
					} else {
						$p = urlencode("Hiba a kép feltöltésénél! (írási hiba)");
					}
				} else $p = urlencode("Hiba a kép feltöltésénél! (képhiba)");
			}
			redirect(ADMINURL.'kategoria/lista?m='.('Sikeres módosítás. '.$p));
		}
		
		$this->data['lista'] = $ci->Sql->kategoriaFa(0);
		$sor = $this->data['sor'] = $this->get($id, DBP.'kategoriak', 'id');
		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Kategória szerkesztése");
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		$ALG->tartalomDobozStart();
		
		$doboz = $ALG->ujDoboz();
		$doboz->dobozCim('Kategória adatai');
		$input1 = new Szovegmezo(array('felirat' => 'Kategória neve', 'ertek' => @$sor->nev, 'nevtomb' => 'a', 'mezonev' => 'nev'));
		$input2 = new Szovegmezo(array('felirat' => 'Kategória elérés url szegmens (slug)', 'ertek' => @$sor->slug, 'nevtomb' => 'a', 'mezonev' => 'slug'));
		
		$doboz->duplaInput($input1, $input2)  ;
		
		$input1 = new Filefeltolto(array('felirat' => 'Kategória kép', 'nevtomb' => '', 'mezonev' => 'kep'));
		$input2 = new Szovegmezo(array('felirat' => 'Sorrend (egész szám)', 'ertek' => @$sor->sorrend, 'nevtomb' => 'a', 'mezonev' => 'sorrend'));
		
		$doboz->duplaInput($input1, $input2)  ;
		
		if(@$sor->kep!='') {
			$doboz = $ALG->ujDoboz();
			$doboz->dobozCim('Jelenlegi kategória kép');
			$doboz->HTMLHozzaadas('<center><img width="33%" src="'.base_url().$sor->kep.'" ></center>');
		}
		
		$ALG->tartalomHozzaadas($ci->load->view(ADMINTEMPLATE.'html/kategoria_szerkesztes', $this->data, true));
		
		
		$ALG->tartalomDobozVege();
		
		
		$ALG->urlapGombok(array(
			0 => array(
				'tipus' => 'hivatkozas',
				'felirat' => 'Mégse',
				'link' => ADMINURL.'kategoria/lista',
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
