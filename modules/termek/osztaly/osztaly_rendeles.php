<?php
include_once ('osztaly_termek.php');
		
class Rendeles_osztaly extends MY_Model {
	
	var $termekLista = array();
	var $koltsegLista = array();
	
	var $osszNetto = null;
	var $osszAfa = null;
	var $osszBrutto = null;
	
	var $kosarOsszNetto = null;
	var $kosarOsszAfa = null;
	var $kosarOsszBrutto = null;
	
	var $armodositoArNetto = array();
	var $armodositoArBrutto = array();
	
	var $armodositok = null;
	var $vevo = null;
	
	var $ervenyesitettArmodositok = array();
	var $kuponEngedelyezettCikkszamok = array();
	
	var $osszKedvezmenyekNetto = 0;
	var $osszKedvezmenyekBrutto = 0;
	function betoltesMegrendeles($id) {
		$rs = $this->get($id, DBP.'rendelesek', 'id');
		if(!$rs) return false;
		
		foreach($rs as $k => $v) {
			$this->$k = $v;
		}		
		// ármódosítók
		$this->modositoNevek = array('kupon' => 'Kupon','szallitasmod' => 'Szállítási mód', 'fizetesmod' => 'Fizetési mód', 'kedvezmeny' => 'Kedvezmény', 'egyeb' => 'Egyéb költség');

		

		$this->armodositok = $this->gets(DBP."rendeles_armodositok", " WHERE rendeles_id = $id ");

		if($this->armodositok) foreach($this->armodositok as $k => $sor) {
			
			$this->armodositok[$k]->megnevezes = $this->modositoNevek[$sor->tipus]; 
			$this->{$sor->tipus} = $this->armodositok[$k];
		}
		
		if(isset($this->kupon)) {
			$engedelyezettCikkszamok = array();
				
			if(trim($this->kupon->cikkszamok)!='') {
				$cikkszamok = explode(',',$this->kupon->cikkszamok);
				foreach($cikkszamok as $cikkszam) $engedelyezettCikkszamok[trim($cikkszam)] = trim($cikkszam);
			}
			if(!empty($engedelyezettCikkszamok)) $this->kuponEngedelyezettCikkszamok = $engedelyezettCikkszamok;
			
		}

		
		$termekidArr = $this->gets(DBP."rendeles_termekek", " WHERE rendeles_id = $id ");
		if($termekidArr) {
			foreach($termekidArr as $termek) {				
				$t = new Termek_osztaly($termek->id, true);
				
				if(!empty($this->kuponEngedelyezettCikkszamok)) {
					// van cikkszámos kupon
					if(isset($this->kuponEngedelyezettCikkszamok[$t->cikkszam])) {
						$t->kuponKedvezmeny($this->kupon);
					}
				}
				
				
				$this->termekLista[] = $t;
			}
		}
		
		$this->vevo = $this->get($this->rendeles_felhasznalo_id, DBP."rendeles_felhasznalok", 'id');
	}
	
	function megrendelesAdatTablak($file='') {
		
		$this->megrendelesArszamitas();
		if($file == '' )$file = 'rendelesadatok.php';
		$file = FCPATH.TEMAMAPPA.'/rendszerlevelek/'.$file;
		if(!file_exists($file)) return "Hiányzó rendelésadat template file: ".$file;
		ob_start();include($file);$out = ob_get_contents();ob_end_clean();		
		return $out;
	}
	function megrendelesOsszar() {
		if(is_null($this->osszNetto)) $this->megrendelesArszamitas();
		return $this->osszNetto;
	}
	function megrendelesOsszarBrutto() {
		if(is_null($this->osszNetto)) $this->megrendelesArszamitas();
		return $this->osszBrutto;
	}
	function megrendelesOsszarAfa() {
		if(is_null($this->osszNetto)) $this->megrendelesArszamitas();
		return $this->osszAfa;
	}
	function megrendelesArszamitas() {
		
		// termék összárak
		$osszar = 0; 
		$osszarBrutto = 0; 
		
		$osszarBruttoKedvezmeny = 0; 
		
		$osszKedvezmenyNetto = 0;
		$osszKedvezmenyBrutto = 0;
		
		
		foreach($this->termekLista as $t) {
			$osszar += $t->megrendeltOsszAr(); 			
			$osszarBrutto += $t->megrendeltOsszBruttoAr();
			
			$osszKedvezmenyNetto += $t->megrendelesOsszNettoKedvezmenyAr();
			
			
			$osszKedvezmenyBrutto += $t->megrendelesOsszBruttoKedvezmenyAr();
			
			
		}		
		// ha a bruttóár nagyobb mint a limit akkor nincs költség
			$termekOsszar = $osszar;
			
			if($this->armodositok) {				
				foreach($this->armodositok as $k =>  $modosito) {					if(isset($modosito->id)) {
						
						
						
						$amNetto = $this->armodositok[$k]->nettoAr = 0;
						$amBrutto = $this->armodositok[$k]->bruttoAr = 0;
						
						
						
						
						
						
						
							
						if($modosito->ingyeneslimitar!=0) if($modosito->ingyeneslimitar<$termekOsszar) {
							continue;
						}						//print($modosito->nev." ");
					
						if(!isset($modosito->cikkszamok)) $modosito->cikkszamok = '';
						if(trim($modosito->cikkszamok)!='') {
							
							// termékenként számoljuk a kedvezményt, mert nem vonatozik mindegyikre
							
							$this->osszKedvezmenyekNetto += 
								$amNetto =  
									$osszKedvezmenyNetto;
							$this->osszKedvezmenyekBrutto += 
								$amBrutto =  
									$osszKedvezmenyBrutto;
							
							$this->armodositok[$k]->nettoAr =  $osszKedvezmenyNetto;
							$this->armodositok[$k]->bruttoAr = $osszKedvezmenyBrutto;

							
						
							
						} else {
							$amNetto =  $modosito->ar;
							$amBrutto =  $amNetto+($amNetto/100)*$modosito->afa;
								
							if($modosito->mukodesimod==0) {
								// hozzáadódik az ár
								$this->osszKedvezmenyekNetto += $this->armodositok[$k]->nettoAr = $amNetto =  $modosito->ar;
								$this->osszKedvezmenyekBrutto += $this->armodositok[$k]->bruttoAr =$amBrutto =  $amNetto+($amNetto/100)*$modosito->afa;
								
								$osszar += $amNetto;
								$osszarBrutto += $amBrutto;
								
							} else {
								// százalékos működés								
								$this->osszKedvezmenyekNetto += $this->armodositok[$k]->nettoAr = $amNetto =  ($termekOsszar/100)*$modosito->ar;

								$this->osszKedvezmenyekBrutto += $this->armodositok[$k]->bruttoAr =$amBrutto =  $amNetto+($amNetto/100)*$modosito->afa;

								
								
								$osszar = $osszar+$amNetto;
								$osszarBrutto = $osszarBrutto+$amBrutto;
								
							}
						}						
						$this->ervenyesitettArmodositok[] = array(
							'nev' => $modosito->nev,
							'netto' => $amNetto,
							'brutto' => $amBrutto,
							'afaertek' => $amBrutto-$amNetto,
							'afa' => $modosito->afa,
						);
						//print $modosito->nev." ".$osszar.' '.$osszarBrutto.'<br>';
					} else {
						
					}
				}
			}
			
		
		
		$this->osszNetto = $osszar;
		$this->osszBrutto = $osszarBrutto;
		$this->osszAfa = $osszarBrutto-$osszar;
                            
		
	}
	function betoltesMunkamenetbol($kosaradatok) {
		
		if(isset($kosaradatok['termekek']))if(!empty($kosaradatok['termekek'])) {			
			
			if(isset($kosaradatok['kupon'])) {

				$kupon = $this->Sql->get((int)$kosaradatok['kupon'], DBP.'kuponok', 'id');
				$engedelyezettCikkszamok = array();
				
				if(trim($kupon->cikkszamok)!='') {
					$cikkszamok = explode(',',$kupon->cikkszamok);
					foreach($cikkszamok as $cikkszam) $engedelyezettCikkszamok[trim($cikkszam)] = trim($cikkszam);
				}
				if(!empty($engedelyezettCikkszamok)) $this->kuponEngedelyezettCikkszamok = $engedelyezettCikkszamok;
				
				//print_r($this->kuponEngedelyezettCikkszamok);
				
				
				$this->armodositok['kupon'] = $this->Sql->get((int)$kosaradatok['kupon'], DBP.'kuponok', 'id');
				
			}
			
			
			
			foreach($kosaradatok['termekek'] as $kosarElem) {
				if((int)$kosarElem['db']==0) continue;
				$termek = new Termek_osztaly($kosarElem['termek_id']);
				$termek->valtozatBeallitas(isset($kosarElem['valtozat'])?$kosarElem['valtozat']:false);
				$termek->valtozatBeallitas2(isset($kosarElem['valtozat2'])?$kosarElem['valtozat2']:false);
				$termek->kosarId = $kosarElem['kosarId'];
				
				if(!empty($kosarElem['opciok'])) {
					foreach($kosarElem['opciok'] as $opcio) {
						$termek->opcioBeallitas($opcio['termek_armodositok_id']);
					}
				}
				$termek->darabszamBeallitas($kosarElem['db']);				
				if(!empty($this->kuponEngedelyezettCikkszamok)) {
					// nézzük, ez a termék kuponozható-e?
					//print $termek->cikkszam."\n";
					if(isset($this->kuponEngedelyezettCikkszamok[$termek->cikkszam])) {
						// igen
						$termek->kuponKedvezmeny($kupon);
						//print 'Igenigen';
					}
				}
				$this->termekLista[] = $termek;
			}
						if(isset($kosaradatok['szallitasmod'])) {
				$this->armodositok['szallitasmod'] = $this->Sql->get((int)$kosaradatok['szallitasmod'], DBP.'szallitasmodok', 'id');
			}
			
			if(isset($kosaradatok['fizetesmod'])) {
				$this->armodositok['fizetesmod'] = $this->Sql->get((int)$kosaradatok['fizetesmod'], DBP.'fizetesmodok', 'id');
			}
			
		}
		
	}
	function arSzamitas() {
		$netto = 0;
		$afa = 0;
		$brutto = 0;
		if(!empty($this->termekLista)) {
			foreach($this->termekLista as $termek) {
				$netto += $termek->kosarOsszNettoAr();
				$afa += $termek->kosarOsszAfa();
				$brutto += $termek->kosarOsszBruttoAr();
			}
			$this->osszAfa = $afa;
			$this->osszNetto = $netto;
			$this->osszBrutto = $brutto;
		}
		return 0;
	}
	function osszNetto() {
		if(is_null($this->osszNetto)) {
			$this->arSzamitas();
		}
		return $this->osszNetto;
	}
	
	
	function osszAfa() {
		if(is_null($this->osszNetto)) {
			$this->arSzamitas();
		}
		return $this->osszAfa;
	}
	
	function osszBrutto() {
		if(is_null($this->osszNetto)) {
			$this->arSzamitas();
		}
		return $this->osszBrutto;
	}
	
	function kosarOsszNetto() {
		if(is_null($this->kosarOsszNetto)) {
			$this->kosarArSzamitas();
		}
		return $this->kosarOsszNetto;
	}
	
	
	function kosarOsszAfa() {
		if(is_null($this->kosarOsszNetto)) {
			$this->kosarArSzamitas();
		}
		return $this->kosarOsszAfa;
	}
	
	function kosarOsszBrutto() {
		if(is_null($this->kosarOsszNetto)) {
			$this->kosarArSzamitas();
		}
		return $this->kosarOsszBrutto;
	}
	function kosarArSzamitas() {
		
		// termék összárak
		$osszar = 0; 
		$osszarBrutto = 0; 
		
		$osszarBruttoKedvezmeny = 0; 
		
		$osszKedvezmenyNetto = 0;
		$osszKedvezmenyBrutto = 0;
		
		foreach($this->termekLista as $t) {
			$osszar += $t->kosarOsszNettoAr(); 
			$osszarBrutto += $t->kosarOsszBruttoAr();
			
			$osszKedvezmenyNetto += $t->kosarOsszNettoKedvezmenyAr();
			$osszKedvezmenyBrutto += $t->kosarOsszBruttoKedvezmenyAr();
		}
		
		// ha a bruttóár nagyobb mint a limit akkor nincs költség
			$termekOsszar = $osszar;
			if($this->armodositok) {
				foreach($this->armodositok as $k => $modosito) {
					
					
					if(!isset($modosito->id)) continue;
					
					if(isset($modosito->cikkszamok)) if(trim($modosito->cikkszamok)!='') {
						// termékenként számoljuk a kedvezményt, mert nem vonatozik mindegyikre
						
						$this->armodositoArNetto[$k] = $osszKedvezmenyNetto;

						$this->armodositoArBrutto[$k] = $osszKedvezmenyBrutto;

						continue;
					}

					
					if($modosito->ingyeneslimitar>0) if($modosito->ingyeneslimitar<$termekOsszar) {
						$this->armodositoArNetto[$k] = 0;
						$this->armodositoArBrutto[$k] = 0;
						continue;
					}					
					
					$amNetto =  $modosito->ar;
					$amBrutto =  $amNetto+($amNetto/100)*$modosito->afa;
											
					if($modosito->mukodesimod==0) {
						// hozzáadódik az ár
						$amNetto =  $modosito->ar;
						$amBrutto =  $amNetto+($amNetto/100)*$modosito->afa;
						$this->armodositoArNetto[$k] = $amNetto;
						$this->armodositoArBrutto[$k] = $amBrutto;
						
						
						$osszar += $amNetto;
						$osszarBrutto += $amBrutto;
						
					} else {						
						// százalékos működés						$amNetto =  ($termekOsszar/100)*$modosito->ar;

						$amBrutto =  $amNetto+($amNetto/100)*$modosito->afa;
						
						
						$this->armodositoArNetto[$k] = $amNetto;

						$this->armodositoArBrutto[$k] = $amBrutto;

						

						

						$osszar += $amNetto;

						$osszarBrutto += $amBrutto;
						
						
					}
					//print $modosito->nev." ".$osszar.' '.$osszarBrutto.'<br>';
				}
			}
			
		
		
		$this->kosarOsszNetto = $osszar;
		$this->kosarOsszBrutto = $osszarBrutto;
		$this->kosarOsszAfa = $osszarBrutto-$osszar;
                            
		
	}
	function armodositoArNetto( $tipus) {
		if(empty($this->armodositoArNetto)) {
			$this->kosarArSzamitas();
		}
		if(!isset($this->armodositoArNetto[$tipus])) {
			return 0;
		}
		return $this->armodositoArNetto[$tipus];
	}
	
	
	function armodositoArBrutto( $tipus) {
		if(empty($this->armodositoArBrutto)) {
			$this->kosarArSzamitas();
		}
		if(!isset($this->armodositoArBrutto[$tipus])) {
			return 0;
		}
		return $this->armodositoArBrutto[$tipus];
	}
	
	
	
}
