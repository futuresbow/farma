<?php
class Import_admin extends MY_Modul {
	var $data = array();
	
	public function index() {
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$limit = 100;

		globalisMemoria('utvonal', array(array('felirat' => 'Tartmék importálás')));

		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Importálás");
		
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'import/start/1', 'felirat' => 'IMPORT INDÍTÁSA AZ IDEIGLENES TÁRBA'));
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Utolsó importálás', 2);

		
		$input = new Jelolonegyzet(array('nevtomb' => '', 'mezonev' => 'torles', 'felirat' => 'Az forrásból lekerült termékek törlése', 'ertek'=> 1));
		
		$rs = $this->Sql->sqlSor("SELECT COUNT(*) as ossz FROM ".DBP."tmp_termekek ");
		
		$doboz->HTMLHozzaadas("<b>Szinkronizálásra váró termékek száma: ".$rs->ossz."</b>");
		$doboz->szimplaInput($input);
		
		$doboz->HTMLHozzaadas("<b>Eltérő rekordok</b><br>");
		
		$jellemzok = $this->getIdsArr("");
		
		$updateTabla = array();
		$ujakTabla = array();
		$rs = $this->Sql->sqlSor("SELECT id FROM ".DBP."tmp_termekek LIMIT $limit");
		foreach($rs as $ujTermek) {
			$tmpTermek = $this->sqlSor("SELECT * FROM ".DBP."tmp_termekek WHERE id = '{$ujTermek->id}' LIMIT 1");
			$van = $this->sqlSor("SELECT id FROM ".DBP."termekek WHERE cikkszam = '{$ujTermek->cikkszam}' LIMIT 1");
			
			if($van) {
				
			}	
			
		}
		
		
		
		$ALG->tartalomDobozVege();

		$ALG->urlapGombok(array(

			0 => array(

				'tipus' => 'hivatkozas',

				'felirat' => 'Mégse',

				'link' => ADMINURL.'import/index?tmp_torles',

				'onclick' => "if(confirm('Biztos vagy benne?')==false) return false;"

			),

			1 => array(

				'tipus' => 'submit',

				'felirat' => 'Szinkronizálás indítása',

				'link' => ADMINURL.'import/szinkronizalas',

				'osztaly' => 'btn-ok',

				

			),

		));

		$ALG->urlapVege();
		
		$ALG->tartalomDobozVege();

		return $ALG->kimenet();
		
		
	}
	public function start() {
		
		ws_autoload('termek');
		// implementálni lehet itt a kül. forrásokat, ez most csak egy példa az import/update-ra
		
		$xml = simplexml_load_file(FCPATH.'assets/feed/files-products-xml-standard-product-2501-hu.xml');
		/*
		//táblák felszabadítása
		$tablak = array();
		$rs = $this->sqlSorok("SHOW TABLES ");
		foreach($rs as $sor) {
			$tabla = current($sor);
			if(strpos($tabla, 'tmp_')===0) $tablak[] = current($sor);
		}
		print( "'".implode("','",$tablak))."'";
		exit;
		*/
		$tablak = array('tmp_jellemzok','tmp_termek_armodositok','tmp_termek_cimkek','tmp_termek_kepek','tmp_termek_keszletek','tmp_termekek','tmp_termekxcimke','tmp_termekxkategoria');
		foreach($tablak as $tabla) $this->db->query("TRUNCATE ".DBP."$tabla");
		
				
		foreach($xml as $sor) {
			$t = array();
			$t['cikkszam'] = 'imp'.$sor->id;
			$t['ar'] = ((float)$sor->price)*300;
			$t['aktiv'] = 1;
			
			$sql = "SELECT * FROM ".DBP."tmp_termekek WHERE cikkszam = '{$t['cikkszam']}' LIMIT 1";
			$van = $this->Sql->sqlSor($sql);
			if($van) {
				// update
				$t['id'] = $van->id;
				$this->Sql->sqlUpdate($t, DBP.'tmp_termekek');
				
			} else {
				$t['id'] = $this->Sql->sqlSave($t, DBP.'tmp_termekek');
				
			}
			
			// kategórizálás, most csak egyszerűen beteszem egy főkategória alá
			$sql = "SELECT * FROM ".DBP."kategoriak WHERE slug = 'importkategoria' ";
			$vanKat = $this->Sql->sqlSor($sql);
			
			if($vanKat) {
				$katId = $vanKat->id;
				$vanKatXTerm = $this->Sql->sqlSor("SELECT * FROM ".DBP."tmp_termekxkategoria WHERE kategoria_id = ".$katId." AND termek_id = {$t['id']}" );
				if(!$vanKatXTerm) {
					// nincs még fenn a kategória kapcsolat
					$k = array('termek_id' => $t['id'], 'kategoria_id' => $katId);
					$this->sqlSave($k, 'tmp_termekxkategoria');
				}
			} else {
				$katId = $this->sqlSave(array('slug' => 'importkategoria','nev' => 'Importált termékek','kep' => 'https://i.imgur.com/uSxT5U9.png' ), 'kategoriak');
				$k = array('termek_id' => $t['id'], 'kategoria_id' => $katId);
				$this->sqlSave($k, 'tmp_termekxkategoria');
			}
			//print '**';
			$this->termekJellemzo('Név' ,$t['id'], JELLEMZO_STRING,  (string)$sor->name);
			$this->termekJellemzo('Leírás' ,$t['id'], JELLEMZO_TEXT,  (string)$sor->description);
			if((string)$sor->attribute1!='') {
				$this->termekJellemzo((string)$sor->attribute1 ,$t['id'], JELLEMZO_STRING,  (string)$sor->value1);
			}
			if((string)$sor->attribute2!='') {
				$this->termekJellemzo((string)$sor->attribute2 ,$t['id'], JELLEMZO_STRING,  (string)$sor->value2);
			}
			
			
			if((string)$sor->video!='') {
				$video = (string)$sor->video;
				
				if($video=='0') $video = '';
				print $video.' '; 
				$this->termekJellemzo('Youtube' ,$t['id'], JELLEMZO_STRING,  $video);
			}
			if((string)$sor->width!='') {
				$this->termekJellemzo('Szélesség' ,$t['id'], JELLEMZO_LEBEGO,  (string)$sor->width);
			}
			if((string)$sor->height!='') {
				$this->termekJellemzo('Magasság' ,$t['id'], JELLEMZO_LEBEGO,  (string)$sor->height);
			}
			if((string)$sor->depth!='') {
				$this->termekJellemzo('Mélység' ,$t['id'], JELLEMZO_LEBEGO,  (string)$sor->depth);
			}
			if((string)$sor->weight!='') {
				$this->termekJellemzo('Súly' ,$t['id'], JELLEMZO_LEBEGO,  (string)$sor->weight);
			}
			
			
			
			//print $t['id']." -- ".$this->termekJellemzo('Név' ,$t['id'], JELLEMZO_STRING).' ';
			
			// képek...
			$termekKep = new Termekkep_osztaly();
			
			$dir = $termekKep->mappakeszites($t['id']);
			$fokep = true;
			
			for($i=0; $i<9;$i++) {
				$mezo = 'image'.$i;
				if((string)$sor->$mezo!='') {
					$file_nev = basename($sor->$mezo);
					if(!file_exists(FCPATH.$dir.$file_nev)) {
						if(file_put_contents(FCPATH.$dir.$file_nev, file_get_contents($sor->$mezo))) {
							// mentés vagy update
							$a = array(
								'szerep' => ($fokep?1:0),
								'file' => $dir.$file_nev, 
								'termek_id' => $t['id']);
							
							$this->Sql->sqlSave($a, DBP.'tmp_termek_kepek');
							$fokep = false;
						}
					}
				}
			}
			
		}
		redirect(ADMINURL.'import/index?m=Az importálás elkészült');
		return '<h2>KÉSZ</h2>';
		
	}
	function szinkronizalas() {
		
		
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		

		globalisMemoria('utvonal', array(array('felirat' => 'Tartmék importálás')));

		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Szinkronizálás");
		
		$ALG->adatBeallitas('fejlecGomb', array('url' => ADMINURL.'import/index', 'felirat' => 'Vissza'));
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();

		$doboz->dobozCim( 'Szintronizálás eredmények', 2);
		
		$ujDb = 0;
		$frissitveDb = 0;
		$torlendoDb = 0;
		$imortaltIdArr = array();
		
		$ujTermekek = $this->sqlSorok("SELECT id, cikkszam FROM ".DBP."tmp_termekek ");
		if(!empty($ujTermekek)) {
			// meglét vizsgálata
			foreach($ujTermekek as $ujTermek) {
				$tmpTermek = $this->sqlSor("SELECT * FROM ".DBP."tmp_termekek WHERE id = '{$ujTermek->id}' LIMIT 1");
				
				$van = $this->sqlSor("SELECT id FROM ".DBP."termekek WHERE cikkszam = '{$ujTermek->cikkszam}' LIMIT 1");
				if($van) {
					$frissitveDb++;
					$tid = $van->id;
					
					$a = (array)$tmpTermek;
					$a['id'] = $van->id;
					
					$this->sqlUpdate($a, DBP.'termekek');
					
				} else {
					$a = (array)$tmpTermek;
					unset($a['id']);
					
					$tid = $this->sqlSave($a, DBP.'termekek');
					
					$ujDb++;
				}
				$imortaltIdArr[] = $tid;
				
			}
			
			$torlendoOssz = 0;
			if(!empty($imortaltIdArr)) {	
				$sql = "SELECT COUNT(*) as ossz FROM ".DBP."termekek WHERE id NOT IN (".implode(', ',$imortaltIdArr).")";
				$rs = $this->sqlSor($sql);
				
				$torlendoOssz = $rs->ossz;
			} else {
				$torlendoOssz = 0;
			}
		}
		
		$doboz->HTMLHozzaadas("Frissítve: ".$frissitveDb."<br>");
		$doboz->HTMLHozzaadas("Új termék felvive: ".$ujDb."<br>");
		$doboz->HTMLHozzaadas("Törlésre került termékek: ".$torlendoOssz."<br>");
		
		
		$ALG->urlapVege();
		
		$ALG->tartalomDobozVege();

		return $ALG->kimenet();
	}
	function termekJellemzo($kulcs, $tid, $tipus = null, $ertek = null ) {
		
		
		
		
		$sql = "SELECT id FROM ".DBP."termek_jellemzok WHERE nev = '$kulcs' LIMIT 1";
		$vanKulcs = $this->Sql->sqlSor($sql);
		
		if(!$vanKulcs) {
			$a = array('nev' => $kulcs, 'tipus' => $tipus);
			$kulcsId = $this->sqlSave($a, 'termek_jellemzok' );
		} else {
			$kulcsId = $vanKulcs->id;
		}
		
		$sql = "SELECT id, ertek_{$tipus} as ertek FROM ".DBP."tmp_jellemzok WHERE termek_jellemzo_id = $kulcsId AND termek_id = $tid LIMIT 1";
		$van = $this->Sql->sqlSor($sql);
		
		if($van) {
			
			if($ertek===null) return $van->ertek;
			
			// update
			$a = array('id' => $van->id,'termek_id' => $tid,  'termek_jellemzo_id' => $kulcsId, 'ertek_'.$tipus => $ertek);
			
			
			$this->sqlUpdate($a, 'tmp_jellemzok');
		} else {
			if($ertek===null) return false;
			// update
			$a = array( 'termek_jellemzo_id' => $kulcsId, 'termek_id' => $tid, 'ertek_'.$tipus => $ertek);
			$this->sqlSave($a, 'tmp_jellemzok');
		}
		
		
	}
}

