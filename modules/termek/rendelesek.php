<?php

class Rendelesek extends MY_Modul {
	/*	 * kosarajax	 * 	 * korár adatok frissítése és szolgáltatása	 * 	 */
	function kosarajax() {
		// session törlés
		//$this->ci->session->set_userdata('kosaradatok', false);
		
		$uri = $this->ci->uri->segment(1);
		if($uri=='kosarajax') {
			define('beepulofuttatas_utan_leall', 1);
			// kosárhoz termék hozzáadása
			if(isset($_POST['kosarajax'])) {
				$adatok = $_POST['kosarajax'];
				$adatok['kosarId'] = md5('KOSARID'.rand(1,100).date('Y-m-d H:i'));
				$kosaradatok = $this->ci->session->userdata('kosaradatok');
				$kosaradatok['termekek'][] = $adatok;
				$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);
				
			}
			// elem törlése a kosárból
			if(isset($_POST['termektorles'])) {
				$kosaradatok = $this->ci->session->userdata('kosaradatok');
				foreach($kosaradatok['termekek'] as $k => $sor) {
					if($sor['kosarId']==$_POST['termektorles']) unset($kosaradatok[$k]);
				}
				$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);
			}
			
		}
		if($uri=='kosardarabmod') {
			
			define('beepulofuttatas_utan_leall', 1);
			$kosaradatok = $this->ci->session->userdata('kosaradatok');
			
			if($kosaradatok) foreach($kosaradatok['termekek'] as $k => $sor) {
				if($sor['kosarId']==$_POST['id']) {
					$db = $sor['db']+ $_POST['mod'];
					if($db <= 0) {
						unset($kosaradatok['termekek'][$k]);
					} else {
						$kosaradatok['termekek'][$k]['db'] = $db;
					}
					
				}
				$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);
			}
			return 1;
		}
		if($uri=='kosarwidget') {
			define('beepulofuttatas_utan_leall', 1);
			ws_autoload('termek');
			$kosaradatok = $this->ci->session->userdata('kosaradatok');
			if($kosaradatok) {
				$rendeles = new Rendeles_osztaly;
				$rendeles->betoltesMunkamenetbol($kosaradatok);
				print ws_frontendView('html/kosarwidget', array('rendeles' => $rendeles), true);
			}
		}
		if($uri=='nagykosarfrissites') {
			define('beepulofuttatas_utan_leall', 1);
			ws_autoload('termek');
			$kosaradatok = $this->ci->session->userdata('kosaradatok');
			if($kosaradatok) {
				$rendeles = new Rendeles_osztaly;
				$rendeles->betoltesMunkamenetbol($kosaradatok);
				print ws_frontendView('html/kosaroldal_termeklista', array('rendeles' => $rendeles), true);
			}
		}
		if($uri=='nagykosarosszar') {
			define('beepulofuttatas_utan_leall', 1);
			ws_autoload('termek');
			$kosaradatok = $this->ci->session->userdata('kosaradatok');
			if($kosaradatok) {
				$rendeles = new Rendeles_osztaly;
				$rendeles->betoltesMunkamenetbol($kosaradatok);
				print ws_frontendView('html/kosaroldal_vegosszeg', array('rendeles' => $rendeles), true);
			}
		}
		if($uri=='armodositoar') {
			define('beepulofuttatas_utan_leall', 1);
			ws_autoload('termek');
			$kosaradatok = $this->ci->session->userdata('kosaradatok');
			if($kosaradatok) {
				$rendeles = new Rendeles_osztaly;
				$rendeles->betoltesMunkamenetbol($kosaradatok);				if($_POST['mod']!='kuponkod') {
					print ws_frontendView('html/kosaroldal_armodositoar', array('mod' => $_POST['mod'], 'rendeles' => $rendeles), true);
				} else {										print ws_frontendView('html/kosaroldal_kuponarmodositoar', array('mod' => $_POST['mod'], 'rendeles' => $rendeles), true);				}			}
		}
		if($uri=='kuponkod') {			// szállítás  fizetés mód változás (később kupon, vagy más költség)			define('beepulofuttatas_utan_leall', 1);			ws_autoload('termek');			$kosaradatok = $this->ci->session->userdata('kosaradatok');			if($kosaradatok) {												$kod = $_REQUEST['kuponkod'];				$this->db->where(array('kod' => $kod) );				$this->db->where(('indulas <= "'.date('Y-m-d H:i',time())).'"' );				$this->db->where(('lejarat > "'.date('Y-m-d H:i',time())).'"' );				$this->db->where(('statusz = 1 ') );				$sql = $this->db->get_compiled_select(DBP.'kuponok');				$rs = $this->Sql->sqlSorok($sql);												if(!$rs) {					unset($kosaradatok['kupon']);					$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);					$json = json_encode(array('result' => 0, 'hiba' => 'Nem megfelelő vagy lejárt jód' ));					print $json;					unset($kosaradatok['kupon']);					$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);					exit;				}				$rs = $rs[0];								//termékhez kötött?								if($rs->cikkszamok !='') {					$engedelyezettCikkszamok = explode(',',$rs->cikkszamok);					$vanIyenTermek = false;										$cikkszamok = array();					foreach($kosaradatok['termekek'] as $termAdat) {						//print_r($termAdat);						$trem = $this->Sql->get($termAdat['termek_id'], DBP.'termekek', 'id');						if($trem) $cikkszamok[$trem->cikkszam] = $trem->id;					}					if(!empty($cikkszamok)) {						foreach($engedelyezettCikkszamok as $eCikkszam) {							if(isset($cikkszamok[$eCikkszam])) {								$vanIyenTermek = true;							}						}					}					if(!$vanIyenTermek) {						$json = json_encode(array('result' => 0, 'hiba' => 'Nincs a kosárban olyan termék, amire vonatkozik a kedvezmény' ));						print $json;												unset($kosaradatok['kupon']);						$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);												exit;					}																			}								if($rs->tipus==1) {					// darabszám is számít					if($rs->darabszam <= 0) {						// elfogyott..						unset($kosaradatok['kupon']);						$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);												$json = json_encode(array('result' => 0, 'hiba' => 'A kuponok elfogytak, nem érvényes már.' ));						print $json;						exit;					}				}												$kosaradatok['kupon'] = $rs->id;								$rendeles = new Rendeles_osztaly;				$rendeles->betoltesMunkamenetbol($kosaradatok);				$rendeles->megrendelesArszamitas();				//print ws_frontendView('html/kosaroldal_vegosszeg', array('rendeles' => $rendeles), true);				$json = json_encode(array('result' => 'ok', 'hiba' => '' ));				print $json;								$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);			}		}				if($uri=='kosarosszarfrissites') {
			// szállítás  fizetés mód változás (később kupon, vagy más költség)
			define('beepulofuttatas_utan_leall', 1);
			ws_autoload('termek');
			$kosaradatok = $this->ci->session->userdata('kosaradatok');
			if($kosaradatok) {
				
				$kosaradatok['szallitasmod'] = (int)$_REQUEST['szmod'];
				$kosaradatok['fizetesmod'] = (int)$_REQUEST['fmod'];
				
				$rendeles = new Rendeles_osztaly;
				$rendeles->betoltesMunkamenetbol($kosaradatok);
				$rendeles->megrendelesArszamitas();
				print ws_frontendView('html/kosaroldal_vegosszeg', array('rendeles' => $rendeles), true);
				
				$this->ci->session->set_userdata('kosaradatok',  $kosaradatok);
			}
		}
		
	}	/*	 * kosar	 * 	 * megrendelés oldali kosár megjelenítése	 */ 
	function kosar() {
		$data = array();
		include_once('osztaly/osztaly_rendeles.php');
		$u = $this->ci->input->post('f');
		$data['p'] = isset($_POST)?$_POST:false;	
		if(!$data['p']) {
			// alapértelmezett checkbox-ok
			$data['p']['szalszamlcb'] = 1;
			$data['p']['jelszocb'] = 1;
			$data['p']['hirlevelfeliratkozascb'] = 1;
		
		}				// kosártörlés		if($this->ci->input->get('kosarurites')=='1') {			$this->ci->session->set_userdata('kosaradatok',  false);			redirect(base_url().'kosar');			return;		}				
		$tag = belepettTag();
		if(@$u['regtipus']!='') {
			// soc gombos belépés/reg; ha nincs a user, egyből reggeljük is.
			
			$hiba = array() ;
			if(strlen(trim($u['keresztnev']))<2) {
				$hiba[] = __f('A keresztnév túl rövid!');				naplozo('Kosár oldal hiba', 0, '', 'A keresztnév túl rövid!');
			}
			if(strlen(trim($u['vezeteknev']))<2) {
				$hiba[] = __f('A vezetéknév túl rövid!');				naplozo('Kosár oldal hiba', 0, '', 'A vezetéknév túl rövid!');
			}
			if (!filter_var($u['email'], FILTER_VALIDATE_EMAIL)) {
				$hiba[] = __f('Nem megfelelő E-mail cím!');				naplozo('Kosár oldal hiba', 0, '', 'Nem megfelelő E-mail cím!');
			}
			$u['email'] = strtolower(trim($u['email']));
			$rs = $this->Sql->sqlSor("SELECT id FROM ".DBP."felhasznalok WHERE email = '{$u['email']}' LIMIT 1");
			if ($rs) {
				// beléptetés
				ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $rs->id));
				redirect(base_url().'kosar#szemelyesadatok', 'refresh');
				return;
			}
			
			
			if($u['regtipus']=='') {
				if(isset($_POST['jelszocb'])) {
					$pwd1 = trim($_POST['jelszo']);
					if(strlen($pwd1)<6) $hiba[] = __f('A jelszó túl rövid.');
				} else {
					// oké
					$u['jelszo'] = md5(PASSWORD_SALT.$_POST['jelszo']);
				}
			} else {
				$u['jelszo'] = md5(rand(100,999)."_".rand(100,999));
			}
			
			if(!empty($hiba)) {
				$data = $_POST;
				$data['hiba'] = implode("<br>", $hiba);
			} else {
				$fid = $this->Sql->sqlSave($u, DBP.'felhasznalok', 'id');
				
				ws_hookFuttatas('felhasznalo.regisztracio', array('felhasznalo_id' => $fid ));
				ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $fid ));
				if(isset($_POST['hirlevel'])) {
					ws_hookFuttatas('felhasznalo.hirlevelfeliratkozas', array('felhasznalo_id' => $fid ));
				}
				naplozo('Kosár oldal felhasználó regisztrácoió', $fid, 'felhasznalok');
				redirect(base_url().'kosar#szemelyesadatok', 'refresh');
				return;
			}
			
			
		}
		
		if(isset($_POST['f'])) {
			$hiba = array();
			// ellenörzések
			if(!$tag) {
				if(isset($_POST['jelszocb'])) {
					$pwd1 = trim($_POST['jelszo']);
					if(strlen($pwd1)<6) {						$hiba['jelszo'] = __f('A jelszó túl rövid.');						naplozo('Kosár oldal hiba', 0, '', 'Jelszó rövid');					}
				} else {
					// nem regisztrálós felhasználó
					$u['jelszo'] = md5(rand(100,999)."_".rand(100,999));
				}
			} 
			// mindenmás ellenőrzése...
			
			if(empty($hiba)) {
				// minden oké, mentsünk.
				
				// 1.) felhasználó ha kell				$fid =0;
				if(!$tag) {
					if(isset($_POST['jelszocb'])) {
						$fid = $this->Sql->sqlSave($u, DBP.'felhasznalok', 'id');
				
						ws_hookFuttatas('felhasznalo.regisztracio', array('felhasznalo_id' => $fid ));
						ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $fid ));
						if(isset($_POST['hirlevel'])) {
							ws_hookFuttatas('felhasznalo.hirlevelfeliratkozas', array('felhasznalo_id' => $fid ));
						}						naplozo('Kosár oldal felhasználó regisztrácoió', $fid, 'felhasznalok');
						$tag = new Tag_osztaly($fid);
					} else {
						
					}
				}
				
				// 2.) vásárló mentése
				
				$felhasznalo = $_POST['f'];
				$vasarlo = $_POST['v'];				
				if($vasarlo['szall_telepules']=='') $vasarlo['szall_telepules'] = $vasarlo['szaml_telepules'];
				if($vasarlo['szall_utca']=='') $vasarlo['szall_utca'] = $vasarlo['szaml_utca'];
				if($vasarlo['szall_irszam']=='') $vasarlo['szall_irszam'] = $vasarlo['szaml_irszam'];
				if($vasarlo['szall_nev']=='') $vasarlo['szall_nev'] = $vasarlo['szaml_nev'];
				$vasarlo['vezeteknev'] = $felhasznalo['vezeteknev'];				$vasarlo['keresztnev'] = $felhasznalo['keresztnev'];				$vasarlo['email'] = $felhasznalo['email'];				
				if($tag) {
					
					$u = array(
						'id' => $tag->id,
						'vezeteknev' => $felhasznalo['vezeteknev'],
						'keresztnev' => $felhasznalo['keresztnev'],
						'adoszam' => $felhasznalo['adoszam'],
					);
					$this->ci->Sql->sqlUpdate($u, DBP.'felhasznalok');
					$vasarlo['felhasznalo_id'] = $tag->id;
					naplozo('Kosár oldal vásárló mentés', $tag->id, DBP.'felhasznalok');
				}
				
				$vasarlo_id = $this->ci->Sql->sqlSave($vasarlo, DBP.'rendeles_felhasznalok');
				
				// rendelés törzs felvitele:
				$kosaradatok = $this->ci->session->userdata('kosaradatok');
				if($kosaradatok) {
					$rendeles = new Rendeles_osztaly;
					$rendeles->betoltesMunkamenetbol($kosaradatok);
					$alapStatusz = $this->ci-> Sql->get(1, DBP.'rendeles_statusz', 'alapertelmezett');
					
					$a = array(
						'rendeles_felhasznalo_id' => $vasarlo_id,
						'statusz' => (isset($alapStatusz->id)?$alapStatusz->id:0),
						'osszar' => $rendeles->kosarOsszNetto(),
						'osszafa' => $rendeles->kosarOsszAfa(),
						'osszbrutto' => $rendeles->kosarOsszBrutto(),
						
					);
					$rendeles_id = $this->ci->Sql->sqlSave($a, DBP.'rendelesek');
					naplozo('Rendelés mentése', $rendeles_id, DBP.'rendelesek');		
					if($rendeles->termekLista) foreach($rendeles->termekLista as $termek) {
						$a = array(
							'rendeles_id' => $rendeles_id,
							'termek_id' => $termek->id,
							'cikkszam' => $termek->cikkszam,
							'nev' => $termek->jellemzo('Név'),
							'ar' => $termek->ar,
							'aktiv' => $termek->aktiv,
							'afa' => $termek->afa,
							'darab' => $termek->kosarDarabszam()
						);
						$termek_id = $this->ci->Sql->sqlSave($a, DBP.'rendeles_termekek');
						
						if($termek->vannakKosarOpciok()) {
							foreach($termek->kivalasztottOpciok as $opcio) {
								$a = array(
									'rendeles_termek_id' => $termek_id,
									'termek_armodositok_id' => $opcio->id,
									'tipus' => $opcio->tipus,
									'nev' => $opcio->nev,
									'nyelv' => $opcio->nyelv,
									'ar' => $opcio->ar,
									'sorrend' => $opcio->sorrend,
									'afa' => $opcio->afa,
								);
								$this->ci->Sql->sqlSave($a, DBP.'rendeles_termek_armodositok');
							}
						}
						
						if(!empty($termek->kivalasztottValtozat)) {
							$opcio = $termek->kivalasztottValtozat;
							$a = array(
									'rendeles_termek_id' => $termek_id,
									'termek_armodositok_id' => $opcio->id,
									'tipus' => $opcio->tipus,
									'nev' => $opcio->nev,
									'nyelv' => $opcio->nyelv,
									'ar' => $opcio->ar,
									'sorrend' => $opcio->sorrend,
									'afa' => $opcio->afa,
								);
								$this->ci->Sql->sqlSave($a, DBP.'rendeles_termek_armodositok');
						}
						if(!empty($termek->kivalasztottValtozat2)) {
							$opcio = $termek->kivalasztottValtozat2;
							$a = array(
									'rendeles_termek_id' => $termek_id,
									'termek_armodositok_id' => $opcio->id,
									'tipus' => $opcio->tipus,
									'nev' => $opcio->nev,
									'nyelv' => $opcio->nyelv,
									'ar' => $opcio->ar,
									'sorrend' => $opcio->sorrend,
									'afa' => $opcio->afa,
								);
							$this->ci->Sql->sqlSave($a, DBP.'rendeles_termek_armodositok');
						}
						
						
					}
					// fizetlsi - szállítási módok
						
					$armodosito = $rendeles->armodositok['fizetesmod'];
					$a = array(
								'rendeles_id' => $rendeles_id,
								'tipus' => 'fizetesmod',
								'nev' => $armodosito->nev,
								'kod' => $armodosito->kod,
								'statusz' => $armodosito->statusz,
								'mukodesimod' => $armodosito->mukodesimod,
								'ar' => $armodosito->ar,
								'sorrend' => $armodosito->sorrend,
								'afa' => $armodosito->afa,
								'penznem' => $armodosito->penznem,
								'ingyeneslimitar' => $armodosito->ingyeneslimitar,
								'extrakalkulacio' => $armodosito->extrakalkulacio,
								
							);
					$this->ci->Sql->sqlSave($a, DBP.'rendeles_armodositok');
					$armodosito = $rendeles->armodositok['szallitasmod'];
					$a = array(
								'rendeles_id' => $rendeles_id,
								'tipus' => 'szallitasmod',
								'nev' => $armodosito->nev,
								'kod' => $armodosito->kod,
								'statusz' => $armodosito->statusz,
								'mukodesimod' => $armodosito->mukodesimod,
								'ar' => $armodosito->ar,
								'sorrend' => $armodosito->sorrend,
								'afa' => $armodosito->afa,
								'penznem' => $armodosito->penznem,
								'ingyeneslimitar' => $armodosito->ingyeneslimitar,
								'extrakalkulacio' => $armodosito->extrakalkulacio,
								
							);
					$this->ci->Sql->sqlSave($a, DBP.'rendeles_armodositok');					if(isset($rendeles->armodositok['kupon'])){						$armodosito = $rendeles->armodositok['kupon'];						if($armodosito->tipus==1) {							// csökkentjük a darabszámot							$sql = "UPDATE kuponok SET darabszam = darabszam-1 WHERE id = ".$armodosito->id;							$this->db->query($sql);						}
						$a = array(
									'rendeles_id' => $rendeles_id,
									'tipus' => 'kupon',																		'cikkszamok' => $armodosito->cikkszamok,
									'nev' => $armodosito->nev,
									'kod' => $armodosito->kod,
									'statusz' => $armodosito->statusz,
									'mukodesimod' => $armodosito->mukodesimod,
									'ar' => $armodosito->ar,
									'sorrend' => $armodosito->sorrend,
									'afa' => $armodosito->afa,
									'penznem' => $armodosito->penznem,
									'ingyeneslimitar' => $armodosito->ingyeneslimitar,
									'extrakalkulacio' => $armodosito->extrakalkulacio,
									
								);
						$this->ci->Sql->sqlSave($a, DBP.'rendeles_armodositok');						
					}
					// kész, visszatöltés
					$this->ci->session->unset_userdata('kosaradatok');
					
					$rendeles = new Rendeles_osztaly();
					$rendeles->betoltesMegrendeles($rendeles_id );
					ws_hookFuttatas('rendeles.statuszvaltozas', array('rendeles_id' => $rendeles->id ));
					redirect(base_url().'rendelesbefejezes');
				}
			}
			
		}
		
		
		$kosaradatok = $this->ci->session->userdata('kosaradatok');
		if($kosaradatok) {						naplozo('Kosár oldal megjelenítése');								
			$data['rendeles'] = new Rendeles_osztaly;
			$data['rendeles']->betoltesMunkamenetbol($kosaradatok);
			if($this->ci->input->get('termeklista')==1) {
				return ws_frontendView('html/kosaroldal_termeklista', array($data), true);
			}
			// fizetési - szállítási módok
			$data['fizetesmodok'] = $this->ci->Sql->gets(DBP."fizetesmodok", " WHERE statusz = 1 ORDER BY sorrend ASC");
			$data['szallitasmodok'] = $this->ci->Sql->gets(DBP."szallitasmodok", "WHERE statusz = 1 ORDER BY sorrend ASC");
			$tag = belepettTag();
			if($tag) {
				// tag adatai
				$data['f'] = $tag;
				// váárló adatai
				$data['v'] = $tag->vasarloAdatok();
				
				
			} else {
				$data['f'] = $data['v'] = false;
				
			}
			if(isset($_POST['v'])) {
				$data['v'] = (object)$_POST['v'];
				$data['f'] = (object)$_POST['f'];
			} else {
				if($tag) {
					$data['f'] = $tag;
					$data['v'] = $this->ci->Sql->sqlSor("SELECT * FROM ".DBP."rendeles_felhasznalok WHERE felhasznalo_id = ".$tag->id." ORDER BY ido DESC ");
					
				}
			}			if(!empty($data['rendeles']->termekLista))
				return ws_frontendView('html/kosaroldal', $data, true);			return ws_frontendView('html/kosaroldal_ureskosar', null, true);
		} else {
			if($this->ci->input->get('termeklista')==1) {
				return ws_frontendView('html/kosaroldal_termeklista', $data, true);
			}
			return ws_frontendView('html/kosaroldal_ureskosar', null, true);
		
		}
	}
	
}
