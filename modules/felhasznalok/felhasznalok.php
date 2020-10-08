<?phpclass Felhasznalok extends MY_Modul {	    public function __construct() {        parent::__construct();                if(isset($_GET['back'])) $this->ci->session->set_userdata("user_back_url", $_GET['back']);            }	// felhasználó beléptetés hook (több helyről hívható, regiszráció, rendelés, belépő oldal)	function beleptetes_hook($data) {		ws_autoload('felhasznalok');		$tag = new Tag_osztaly($data['felhasznalo_id']);				if(isset($tag->id)) {			$log = $tag->vezeteknev.' '.$tag->keresztnev." belépett az oldalra";			ws_log('felhasznalo', $log);			naplozo('Belépés az oldalra', $tag->id, 'felhasznalok');			$this->session->set_userdata('__belepett_felhasznalo', $tag->id);		}	} 	function kilepes() {				if($this->ci->input->get('logout')!==null) {			ws_autoload('felhasznalok');			$tag = new Tag_osztaly($this->ci->session->userdata('__belepett_felhasznalo'));			$log = $tag->vezeteknev.' '.$tag->keresztnev." kilépett.";			ws_log('felhasznalo', $log);			naplozo('Kilépés az oldalról', $tag->id, 'felhasznalok');						$this->ci->session->unset_userdata('__belepett_felhasznalo');			$this->ci->session->unset_userdata('tag');			redirect(base_url());		}	} 	// fiókbeállítások	function fiokom() {		naplozo('Fiókom oldal megtekintése');		$data = array();		$tag = ws_belepesEllenorzes();		if(!$tag) redirect(base_url());				// hirlevélre feliratkozott?		$hirlevelFeliratkozas = $this->Sql->sqlSor("SELECT id FROM ".DBP."hirlevel_feliratkozok WHERE email = '{$tag->email}' LIMIT 1");		$data['hirlevelFeliratkozas'] = isset($hirlevelFeliratkozas->id)?true:false;		naplozo('Fiókom oldal adatmódosítás');		if(isset($_POST['u'])) {			$u = $_POST['u'];			if(!isset($_POST['hirlevel'])) {				if($data['hirlevelFeliratkozas']) {					// le kell iratkoztatni					ws_hookFuttatas('felhasznalo.hirlevelleiratkozas', array('email' => $tag->email));														}			} else {				if(!$data['hirlevelFeliratkozas']) {					// le kell iratkoztatni					ws_hookFuttatas('felhasznalo.hirlevelemailfeliratkozas', array('email' => $tag->email, 'nev' => $tag->vezeteknev.' '.$tag->keresztnev));							 		}							}			$u['id'] = $tag->id;			$this->Sql->sqlUpdate($u, DBP.'felhasznalok', 'id');		}		$hirlevelFeliratkozas = $this->Sql->sqlSor("SELECT id FROM ".DBP."hirlevel_feliratkozok WHERE email = '{$tag->email}' LIMIT 1");		$data['hirlevelFeliratkozas'] = isset($hirlevelFeliratkozas->id)?true:false;		$tag = ws_belepesEllenorzes();		$data['tag'] = $tag;				return ws_frontendView('html/fiokom', $data, true);			}			function hirlevelfeliratkozas() {		$data = array() ;		globalisMemoria('utvonal', array(array('felirat' => 'Regisztráció')));		naplozo('Hírlevél feliratkozás');		if(isset($_POST["hu"])) {			$a = $_POST["hu"];			$hiba = array();			if(!isset($_POST['hladatk'])) {				$hiba['aszf'] = 1;			}			if(strlen($a['nev'])<3) {				$hiba['nev'] = 1;			}			if (!filter_var($a['email'], FILTER_VALIDATE_EMAIL)) {				$hiba['email'] = 1;			} else {				$rs = $this->sqlSor("SELECT id FROM ".DBP."hirlevel_feliratkozok WHERE email = '".$a['email']."' LIMIT 1");				if(isset($rs->id)) {					$hiba['feliratkozott'] = 1;				}			}			if(empty($hiba)) {				$id = $this->Sql->sqlSave($a, DBP.'hirlevel_feliratkozok');				naplozo('Sikeres hírlevél feliratkozás', $id, 'hirlevel_feliratkozok');				return $this->load->view(beallitasOlvasas("FRONTENDTEMA").'/html/hirlevelfeliratkozas_sikeres.php', $data, true);			}						$data['hiba'] = $hiba;					}		return $this->load->view(beallitasOlvasas("FRONTENDTEMA").'/html/hirlevelfeliratkozas.php', $data, true);			}		// normál vagy közösségi regisztráció	function regisztracio() {		                if($this->ci->uri->segment(2) == 'aktivalas_szukseges') {                                        return ws_frontendView('html/aktivalas_szukseges',null, true);                }		$tag = ws_belepesEllenorzes();		if($tag) redirect(base_url().'fiokom');				$data = array() ;		globalisMemoria('utvonal', array(array('felirat' => 'Regisztráció')));				if(isset($_POST['u'])) {			$u = $_POST['u'];			$hiba = array() ;			if(strlen(trim($u['keresztnev']))<2) {				$hiba[] = __f('A keresztnév túl rövid!');			}			if(strlen(trim($u['vezeteknev']))<2) {				$hiba[] = __f('A vezetéknév túl rövid!');			}			if (!filter_var(trim($u['email']), FILTER_VALIDATE_EMAIL)) {								$hiba[] = __f('Nem megfelelő E-mail cím!');			}			$u['email'] = strtolower(trim($u['email']));			$rs = $this->Sql->sqlSor("SELECT id FROM ".DBP."felhasznalok WHERE email = '{$u['email']}' LIMIT 1");			if ($rs) {				$hiba[] = __f('Ezzel az E-mail címmel már regisztrált!');			}									if($u['regtipus']=='') {				$pwd1 = trim($_POST['pwd']);				if(strlen($pwd1)<6) $hiba[] = __f('A jelszó túl rövid.');				if($_POST['pwd']!=$_POST['pwd2'])$hiba[] = __f('A két jelszó nem egyezik');			} else {				$u['jelszo'] = md5(rand(100,999)."_".rand(100,999));			}						if(!empty($hiba)) {				$data = $_POST;				$data['hiba'] = implode("<br>", $hiba);			} else {				$u['jelszo'] = md5(PASSWORD_SALT.$_POST['pwd']);                                $visszalink = $u['ellenorzokulcs'] = uniqid(date('YmdHi'),true);				$fid = $this->Sql->sqlSave($u, DBP.'felhasznalok', 'id');                                				// aktivációs levél elküldése                                                                $targy = rendszerUzenetTargy("regisztracio_aktivalas");				$uzenet = rendszerUzenet("regisztracio_aktivalas");								naplozo('Regisztráció aktiválás üzenet küldés', $fid, 'felhasznalok');								ws_autoload('hirlevel');								$level = new Levelkuldo_osztaly;				$level->helyorzo('Név', $u['vezeteknev'].' '.$u['keresztnev']);				$level->helyorzo('Email', $u['email']);				$level->helyorzo('Link', base_url().'belepes/aktivalas/'.$visszalink);                                				$level->rendszerlevelKeszites($uzenet);                                $level->levelKuldes($u['email'], $targy);				                                				naplozo('SikeresRegisztráció', $fid, 'felhasznalok');								ws_hookFuttatas('felhasznalo.regisztracio', array('felhasznalo_id' => $fid ));				// kétlépcsós beléptetés miatt ez nincs                                 //ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $fid ));                                				if(isset($_POST['hirlevel'])) {					ws_hookFuttatas('felhasznalo.hirlevelfeliratkozas', array('felhasznalo_id' => $fid ));				}				                                if($this->ci->session->userdata("user_back_url")) {                                    if($this->ci->session->userdata("user_back_url")=='kosar'){                                        redirect(base_url().'kosar?msg=1');                                        $this->ci->session->unset_userdata("user_back_url");                                        return;                                    }                                }				redirect(base_url().'regisztracio/aktivalas_szukseges');			}		}				if($this->ci->session->userdata('felhasznalo_id')!='') {			redirect(base_url());		}		naplozo('Regisztrációs oldal');						return ws_frontendView('html/regisztracio', $data,true);	}		function jelszovisszaallitas() {		$data = array('jelszohiba' => false, 'kizaroUzenet'=>false);		$unic = $this->uri->segment(3);		if(!$unic) {			redirect(base_url());		}		$hiba = false;		$time =  hexdec(substr($unic,0,8));		if (strtotime("-3 days") > $time) {			$hiba = __f("A jelszó visszaállító link lejárt.");		} else {			$tag = $this->Sql->get($unic, DBP.'felhasznalok', 'ellenorzokulcs');			if(!isset($tag->id)) {				$hiba = __f("A jelszó visszaállító link lejárt.");			}		}		$data['kizaroUzenet'] = $hiba;				if($this->ci->input->post('pwd1')) {			$pwd1 = $this->ci->input->post('pwd1');			$pwd2 = $this->ci->input->post('pwd2');						if($pwd1!=$pwd2) {				$data['jelszohiba'] = __f("A két jelszó eltér");			}			if(strlen($pwd1)<6) {				$data['jelszohiba'] = __f("A két jelszó eltér");			}			if(!$data['jelszohiba']) {								$a = array( 					'jelszo' => md5(PASSWORD_SALT.$pwd1),					'ellenorzokulcs'=> '',					'id' => $tag->id,				);				$this->Sql->sqlUpdate($a, DBP.'felhasznalok');								$data['kizaroUzenet'] = __f('Jelszó beállítása sikeres, most már beléphetsz az oldalra.');				$data['sikeresModositas'] = true;								naplozo('Sikeres jelszó visszaállítás', $tag->id, 'felhasznalok');							}		}		naplozo('Jelszóvisszaállítás oldal');						return ws_frontendView('html/jelszovisszaallitas', $data,true);	}	function elfelejtettjelszo() {				$data = array();		$hiba = false;		if(isset($_POST['elfelejtett_email'])) {			$email = $_POST['elfelejtett_email'];						if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {				$hiba = true;							} 			if(!$hiba) {				$letezik = $this->Sql->get($_POST['elfelejtett_email'], 'felhasznalok', 'email');				if(!isset($letezik->id)) {					$hiba = true;				}			}			if(!$hiba) {				$visszalink = uniqid();				$this->ci->db->query("UPDATE ".DBP."felhasznalok SET ellenorzokulcs = '$visszalink' WHERE id = ".$letezik->id);								$targy = rendszerUzenetTargy("elfelejtett_jelszo_visszaallitas");				$uzenet = rendszerUzenet("elfelejtett_jelszo_visszaallitas");								naplozo('Elfelejtettjelszó visszaállító üzenet küldés', $letezik->id, 'felhasznalok');								ws_autoload('hirlevel');								$level = new Levelkuldo_osztaly;				$level->helyorzo('Email', $letezik->email);				$level->helyorzo('Link', base_url().'belepes/jelszovisszaallitas/'.$visszalink);								$level->rendszerlevelKeszites($uzenet);								$level->levelKuldes($letezik->email, $targy);																				return ws_frontendView('html/elfelejtettjelszo_visszaallias', $data,true);			}					}		$data['hiba'] = $hiba;		naplozo('Elfelejtettjelszó oldal');		return ws_frontendView('html/elfelejtettjelszo', $data,true);	}	// normál vagy közösségi regisztráció	function belepes() {                		if($this->ci->uri->segment(2) == 'aktivalas') {                    $kulcs = $this->ci->uri->segment(3);                    $this->db->where('ellenorzokulcs',  $kulcs);                    $query = $this->db->get(DBP.'felhasznalok');                                        $rows = $query->result();                    if(isset($rows[0])) {                        $a = ['id' => $rows[0]->id, 'statusz' => 1, 'ellenorzokulcs' => ''];                        $this->sqlUpdate($a, DBP.'felhasznalok');                        //ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $rows[0]->id));                                                // aktivációs levél elküldése                        $targy = rendszerUzenetTargy("regisztracio_sikeresaktivalas");                        $uzenet = rendszerUzenet("regisztracio_sikeresaktivalas");                        naplozo('Regisztráció aktiválás üzenet küldés', $fid, 'felhasznalok');                        ws_autoload('hirlevel');                        $level = new Levelkuldo_osztaly;                        $u = (array)$rows[0];                        $level->helyorzo('Név', $u['vezeteknev'].' '.$u['keresztnev']);                        $level->helyorzo('Email', $u['email']);                        $level->helyorzo('Link', base_url().'kapcsolat');                        $level->rendszerlevelKeszites($uzenet);                        $level->levelKuldes($u['email'], $targy);                                                $data = ['cim' => 'Szuper, sikeresen regisztráltál!', 'text' => '<p>Köszönjük, hogy megerősítetted a regisztrációdat! Most már <a href="'. base_url().'belepes">beléphetsz</a> a saját fiókodba!</p>'];                    } else {                        $data = ['cim' => 'Jaj...', 'text' => '<p>Ez az aktiváló link már sajnos lejárt. Ha még nem vagy oldalunkon tag, regisztrálj újra, ha viszont már aktiváltad magad, lépj be.</p>'];                    }                    return ws_frontendView('html/uzenet_oldal',$data, true);                }                		$tag = ws_belepesEllenorzes();                		//if($tag) redirect(base_url().'fiokom');		if($this->ci->uri->segment(2)=='elfelejtett-jelszo') {			return $this->elfelejtettjelszo();		}		if($this->ci->uri->segment(2)=='jelszovisszaallitas') {			return $this->jelszovisszaallitas();		}		$data = array() ;		$data['email'] = '';                $data['social'] = false;                		globalisMemoria('utvonal', array(array('felirat' => 'Regisztráció')));		$hiba = false;		if(isset($_POST['u'])) {			$u = $_POST['u'];			if($u['regtipus']=="") {								$email = $u['email'];				$pwd = md5(PASSWORD_SALT.$_POST['pwd']);				if (filter_var($u['email'], FILTER_VALIDATE_EMAIL)) {										$sql = "SELECT * FROM ".DBP."felhasznalok WHERE email LIKE '$email' AND jelszo = '$pwd' LIMIT 1";					$rs = $this->Sql->sqlSor($sql);					if(isset($rs->id)) {                                                                                                if($rs->statusz==0) {                                                                                                        if($this->ci->session->userdata('aktivalas_kikuldve')) {                                                        $utolsoAktivalasEmail = $this->ci->session->userdata('aktivalas_kikuldve');                                                                                                                if($utolsoAktivalasEmail > time()-60*5) {                                                            $data = ['cim' => 'Kis türelem...', 'text' => '<p>5 percen belül csak egy aktivációs E-mail küldhető. Ellenőrizd kérlek a spam mappát is!</p>'];                                                            return ws_frontendView('html/uzenet_oldal',$data, true);                                                        } else {                                                            $this->ci->session->set_userdata('aktivalas_kikuldve', time());                                                        }                                                    } else {                                                        $this->ci->session->set_userdata('aktivalas_kikuldve', time());                                                                                                            }                                                                                                        $visszalink = $u['ellenorzokulcs'] = uniqid(date('YmdHi'),true);                                                                                                        if($rs->ellenorzokulcs != '') {                                                        $visszalink = $rs->ellenorzokulcs;                                                    } else {                                                        $a = ['id' => $rs->id, 'ellenorzokulcs' => $visszalink];                                                        $this->Sql->sqlUpdate($a, 'felhasznalok');                                                    }                                                                                                                                                            // aktivációs levél elküldése                                                    $targy = rendszerUzenetTargy("regisztracio_aktivalas");                                                    $uzenet = rendszerUzenet("regisztracio_aktivalas");                                                    naplozo('Regisztráció aktiválás üzenet küldés', $fid, 'felhasznalok');                                                    ws_autoload('hirlevel');                                                    $level = new Levelkuldo_osztaly;                                                    $u = (array)$rs;                                                    $level->helyorzo('Név', $u['vezeteknev'].' '.$u['keresztnev']);                                                    $level->helyorzo('Email', $u['email']);                                                    $level->helyorzo('Link', base_url().'belepes/aktivalas/'.$visszalink);                                                    $level->rendszerlevelKeszites($uzenet);                                                    $level->levelKuldes($u['email'], $targy);                                                                                                        $data = ['cim' => 'Még nem aktív a fiókod', 'text' => '<p>Kérjük, aktiváld fiókodat. Ennek érdekében újraküldtük az aktivációs levelet. Kattints a linkre a levélben!</p>'];                                                    return ws_frontendView('html/uzenet_oldal',$data, true);                                                }                                                						ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $rs->id));						if($this->ci->session->userdata("user_back_url")) {                                                    if($this->ci->session->userdata("user_back_url")=='kosar'){                                                        redirect(base_url().'kosar?msg=1');                                                        $this->ci->session->unset_userdata("user_back_url");                                                        return;                                                    }                                                }						if($rs->adminjogok>0){							redirect(base_url().beallitasOlvasas("ADMINURL"));						} else {							redirect(base_url().'fiokom');						}																	naplozo('Belépés oldal sikeres belépés', $rs->id, 'felhasznalok');						return;					}					$hiba = true;					$data['email'] = $email;									} else {					$hiba = true;					$data['email'] = $email;									}							} else {				$u = $_POST['u'];								$email = $u['email'];				$smedia_id = $u['smedia_id'];				$regtipus = $u['regtipus'];												$sql = "SELECT * FROM ".DBP."felhasznalok WHERE email LIKE '$email' AND smedia_id = '$smedia_id' AND  regtipus = '$regtipus' LIMIT 1";								$rs = $this->Sql->sqlSor($sql);				if(isset($rs->id)) {					ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $rs->id));																			naplozo('Belépés oldal sikeres belépés', $rs->id, 'felhasznalok');													redirect(base_url().'fiokom');					return;				}			}								}		$data['hiba'] = $hiba;				if($this->ci->session->userdata('felhasznalo_id')!='') {			redirect(base_url());		}		naplozo('Belépés oldal');		return ws_frontendView('html/belepes', $data,true);	}	// frontend lezárásos admin belépés (settings-ben a FRONTENDURL login-ra rakva.)	function adminlogin() {		globalisMemoria('template_feluliras', 'login');				$tag = ws_belepesEllenorzes();		if($tag) redirect(base_url().'webshopadmin');				$data = array() ;		$data['email'] = '';		globalisMemoria('utvonal', array(array('felirat' => 'Regisztráció')));		$hiba = false;		if(isset($_POST['u'])) {			$u = $_POST['u'];			if($u['regtipus']=="") {								$email = $u['email'];				$pwd = md5(PASSWORD_SALT.$_POST['pwd']);				if (filter_var($u['email'], FILTER_VALIDATE_EMAIL)) {										$sql = "SELECT * FROM ".DBP."felhasznalok WHERE email LIKE '$email' AND jelszo = '$pwd' LIMIT 1";					$rs = $this->Sql->sqlSor($sql);					if(isset($rs->id)) {						ws_hookFuttatas('felhasznalo.beleptetes', array('felhasznalo_id' => $rs->id));						redirect(base_url().'webshopadmin');												naplozo('Admin belépés oldal sikeres belépés', $rs->id, 'felhasznalok');						return;					}					$hiba = true;					$data['email'] = $email;									} else {					$hiba = true;					$data['email'] = $email;									}				globalisMemoria('belepesUzenet',  "Hibás e-mail cím vagy jelszó!");			} 					}		$data['hiba'] = $hiba;				if($this->ci->session->userdata('felhasznalo_id')!='') {			redirect(base_url());		}		return '';	}}