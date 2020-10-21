<?php

/*
 * Termek_osztaly
 * 
 * egy terméket reprezentáló osztáy
 * 
 */

class Termek_osztaly extends MY_Model {

	

	var $jellemzok;

	var $darab = 1;

	var $darabAr = null;

	var $valtozatok;

	var $kivalasztottValtozat;

	var $kivalasztottValtozat2;

	var $opciok;
	
	var $kupon;
	
	var $darabArKedvezmeny = 0;
	
	var $eredetiDarabAr;

	var $kepek;
	
	var $bruttoAr;
	
	var $ketagoriaTagsag;
	
	var $cimkek;
	
	var $cimkeTagsag;
	
	var $eredetiBruttoAr;

	var $rendeles = false; // ha rendelést töltünk be, akkor a megrendelés terméktáblákból dolgozunk

	var $kivalasztottOpciok;

	var $termekTabla = 'termekek';

	var $megrendeltTermekTabla = 'rendeles_termekek';
	
	var $termekcsoport;

	var $termekValtozatok = null;
	
	var $jellemzoFeliratok = null;

	public function __construct($id = false, $rendeles = false) {

		$this->rendeles = $rendeles;

		if($id == false) {

			$this->id = 0;

			return false;

		}

		// törzsadatok

		if($rendeles) {

			$termekTabla = $this->megrendeltTermekTabla;

		} else {

			$termekTabla = $this->termekTabla;

			

		}

		$sql = "SELECT * FROM  ".DBP."$termekTabla WHERE id = $id LIMIT 1";

		

		$rs = $this->sqlSor($sql);

		if($rs) {

			foreach($rs as $k => $v) $this->$k = $v;
	
			if($this->afa==0) {
				$this->bruttoAr = $this->ar;
				if(isset( $this->eredeti_ar )) $this->eredetiBruttoAr = $this->eredeti_ar;
			} else {
				$this->bruttoAr = $this->ar + $this->afa*($this->ar/100);
				if(isset( $this->eredeti_ar )) $this->eredetiBruttoAr = $this->eredeti_ar + $this->afa*($this->eredeti_ar/100);
			}

			
			
			

		} else {

			return false;

		}
		// termékcsoport 
		
		$this->termekcsoport = $this->sqlSor("SELECT id,nev FROM ".DBP."termek_csoportok WHERE id =  $this->termek_csoport_id ");
		// kategória

		if($rendeles) {
			$termekId = $this->termek_id;
		} else {
			$termekId = $this->id;
		}
		$kategoriaLista = $this->sqlSorok("SELECT * FROM ".DBP."termekxkategoria WHERE termek_id = $termekId");
		if($kategoriaLista) {
			foreach($kategoriaLista as $sor) {
				$this->ketagoriaTagsag[$sor->kategoria_id] = $sor->kategoria_id;
			}
		}
		
		// cimketagság
		$this->cimkek = $this->getsIdArr(DBP."termek_cimkek", 'id', ' ');
		
		
		$cimkeListas = $this->sqlSorok("SELECT * FROM ".DBP."termekxcimke x  WHERE termek_id = $termekId");
		if($cimkeListas) {
			foreach($cimkeListas as $sor) {
				$this->cimkeTagsag[$sor->cimke_id] = $sor;
			}
		}
		
		
	}
	public function cikkszamMeghatarozas($termek_armodosito_id=0,$rendeles = false ) {
        if($termek_armodosito_id==0) return $this->cikkszam;
        $tabla = DBP.'termek_armodositok';
        if($rendeles) $tabla = DBP.'rendeles_termek_armodositok';
        $amSor = $this->Sql->get($termek_armodosito_id, $tabla, 'id');
        //print ("#".$termek_armodosito_id."#");
        if($amSor->cikkszam!="") return $amSor->cikkszam;
        return $this->cikkszam;
	}
	
	public function elerhetoKeszlet($termek_armodosito_id=0) {
            // először a készlet táblában keresünk
            $termek_armodosito_id = (int)$termek_armodosito_id;
            $keszlet = 0;
            $sql = "SELECT keszlet FROM ".DBP."termek_keszletek WHERE 
                    termek_id = ".$this->id." AND
                    termek_armodosito_id = $termek_armodosito_id
                    ";

            $rs = $this->Sql->sqlSor($sql);
            if(isset($rs->keszlet)) {
                $keszlet = $rs->keszlet;
            } elseif($termek_armodosito_id ==0) {
                // kompatibilitás visszafele, TODO: kivenni
                //$keszlet = $this->keszlet;
            } 
            $ci = getCI();
            $sql = "SELECT SUM(darabszam) as darab FROM ".DBP."termek_kosar_darabszam WHERE session_id != '".$ci->session->userdata('kosarSessId')."' AND termek_id = ".$this->id."";
            $darabszam = $this->Sql->sqlSor($sql);
            $keszlet -= $darabszam->darab;
            return $keszlet;
	}
	/*
	 * vannakTermekValtozatok
	 * 
	 * megvizsgálja és betölti az al és főtermékeket
	 */
	 
	public function vannakTermekValtozatok() {
		if($this->termekValtozatok == Null) {
			$this->loadTermekValtozatok();
		}
		if(!empty($this->termekValtozatok)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function termekvaltozatok() {
		if($this->termekValtozatok == Null) {
			$this->loadTermekValtozatok();
		}
		return $this->termekValtozatok;
	}
	public function loadTermekValtozatok() {
		if($this->termekValtozatok == Null) {
			// ez egy főtermék?
			if($this->termekszulo_id==0) {
				// igen
				
				$this->termekValtozatok[0] = new stdClass();
				$this->termekValtozatok[0]->id = $this->id;
				
                                $sql = "SELECT id FROM ".DBP."termekek t WHERE termekszulo_id = ".$this->id." AND"
                                        . " ( t.keszlet > 0 OR EXISTS( SELECT id FROM ".DBP."termek_keszletek WHERE termek_id = t.id AND  keszlet > 0 LIMIT 1 ) )"
                                        . " ORDER BY altermek_sorrend ASC";
                                
				$lista = $this->Sql->sqlSorok($sql);
				if(!empty($lista)) {
					$this->termekValtozatok = array_merge($this->termekValtozatok,$lista);
				} else {
					$this->termekValtozatok = array();
				}
			} else {
				// ez egy altermek
				$this->termekValtozatok = $this->Sql->sqlSorok("SELECT id FROM ".DBP."termekek WHERE id = ".$this->termekszulo_id." LIMIT 1");
				
                                $sql = "SELECT id FROM ".DBP."termekek t WHERE termekszulo_id = ".$this->termekszulo_id." AND "
                                        . " ( t.keszlet > 0 OR EXISTS( SELECT id FROM ".DBP."termek_keszletek WHERE termek_id = t.id AND  keszlet > 0 LIMIT 1 ) )"
                                        . " ORDER BY altermek_sorrend ASC ";
                                
				$altermekek = $this->Sql->sqlSorok($sql);
				if(!empty($altermekek)) $this->termekValtozatok = array_merge($this->termekValtozatok,$altermekek);
				
			}
			
		}
	}
	/*
	 * megfelelő ár visszaadása
	 */
	function alapAr($armod='Nettó', $termek_armodosito_id = 0) {
		if($termek_armodosito_id!=0){
            if(isset($this->valtozatok[$termek_armodosito_id])){
                $valtozat = $this->valtozatok[$termek_armodosito_id];
                
                if($valtozat->ar > 0) {
                    if(mb_strtolower($armod, 'UTF-8')=='nettó') {
                        return $valtozat->ar;
                    } else {
                        return $valtozat->ar+$valtozat->ar*($valtozat->afa/100);
                    }
                }
            }
        }
		if(mb_strtolower($armod, 'UTF-8')=='nettó') return $this->ar;
		return $this->bruttoAr;
	}
	/*
	 * megfelelő eredeti ár visszaadása
	 */
	function eredetiAr($armod='Netto') {
		if(mb_strtolower($armod, 'UTF-8')=='nettó') return $this->eredeti_ar;
		return $this->eredetiBruttoAr;
	}
	
	
	/*
	 * kuponKedvezmeny
	 * 
	 * aktuális érvényben lévő kupon elmentése
	 */

	public function kuponKedvezmeny($kupon) { 
		// erre a termékre érvényes kupon
		$this->kupon = $kupon;
	}
	
	/*
	 * kategoriaTag
	 * 
	 * ez a termék benn van-e az adott kategóriában?
	 */
	
	public function kategoriaTag($kategoria_id) {
		return isset($this->ketagoriaTagsag[$kategoria_id]);
	}
	
	/*
	 * cimkeTag
	 * 
	 * ez a tartmék adott cimkéhez van-e rendelve
	 */
	
	public function cimkeTag($cimke_id) {
		return isset($this->cimkeTagsag[$cimke_id])?$this->cimkeTagsag[$cimke_id]:false;
	}
	
	/*
	 * valtozatBeallitas
	 * 
	 * ennek a terméknek az elsődleges változata
	 * 
	 */
	
	public function valtozatBeallitas($termek_armodositok_id) {

		$tabla = DBP.'termek_armodositok';

		if($this->rendeles) $tabla = DBP.'rendeles_termek_armodositok';

		

		$valtozat = $this->get($termek_armodositok_id, $tabla, 'id');

		$this->kivalasztottValtozat =  $valtozat;

	}
	/*
	 * valtozatBeallitas2
	 * 
	 * ennek a terméknek az másodlagos változata 
	 * két változat is beállítható egy termékhez
	 * 
	 */
	
	public function valtozatBeallitas2($termek_armodositok_id) {

		$tabla = DBP.'termek_armodositok';

		if($this->rendeles) $tabla = DBP.'rendeles_termek_armodositok';

		

		$valtozat = $this->get($termek_armodositok_id, $tabla, 'id');

		$this->kivalasztottValtozat2 =  $valtozat;

	}
	/*
	 * darabszamBeallitas
	 * 
	 * ennek a terméknek a darabszáma (az összárszámításhoz)
	 */
	 
	public function darabszamBeallitas($darab) {

		$this->darab = $darab;

	}
	
	/*
	 * kosarOsszNettoKedvezmenyAr
	 * 
	 * kosárban lévő termék összes kedvezménye termékre vonatkozó kuon esetén
	 */
	 
	public function kosarOsszNettoKedvezmenyAr() {

		if(is_null($this->darabAr)) $this->kosarDarabAr();
		//print $this->darabArKedvezmeny*$this->darab;
		return $this->darabArKedvezmeny*$this->darab;

	}
	
	/*
	 * kosarOsszBruttoKedvezmenyAr
	 * 
	 * összes bruttó kedvezmény (szorozva van a darabbal)
	 */

	
	public function kosarOsszBruttoKedvezmenyAr() {
		if($this->id==0) return 0 ;
		if(is_null($this->darabAr)) $this->kosarDarabAr();
		$osszNetto = $this->kosarOsszNettoKedvezmenyAr();
		$ossz = round($osszNetto + ($osszNetto/100)*$this->afa,2);
		return $ossz;

	}
	
	/*
	 * kosarOsszNettoAr
	 * 
	 * nettó egységár * darabszám
	 */
	 
	
	public function kosarOsszNettoAr() {

		if(is_null($this->darabAr)) $this->kosarDarabAr();

		return $this->darabAr*$this->darab;

	}
	
	/*
	 * vannakKosarOpciok
	 * 
	 * igaz, ha választottak a termékhez opciót
	 */
	
	function vannakKosarOpciok() {

		if(!empty($this->kivalasztottOpciok)) return true;

		return false;

	}
	/*
	 * kosarOsszAfa
	 * 
	 * termékek áfatartalmának összesítése
	 * 
	 */
	 
	public function kosarOsszAfa() {
		if(!isset($this->id)) return 0 ;
		if($this->id==0) return 0 ;
		
		if(is_null($this->darabAr)) $this->kosarDarabAr();

		$osszNetto = $this->darabAr*$this->darab;

		$osszAfa = round(($osszNetto/100)*$this->afa, 0);

		

		return $osszAfa;

	}
	/*
	 * kosarOsszBruttoAr
	 * 
	 * összes bruttó át (db bruttó ár * db)
	 */
	 
	public function kosarOsszBruttoAr() {
		if(!isset($this->id)) return 0 ;
		if($this->id==0) return 0 ;
		
		if(is_null($this->darabAr)) $this->kosarDarabAr();

		$osszNetto = $this->darabAr*$this->darab;

		$osszAfa = round(($osszNetto/100)*$this->afa, 0);

		

		return $osszNetto+$osszAfa;

	}
	
	/*
	 * kosarDarabAr
	 * 
	 * abban az esetben, ha a kupon a termékhez van rendelve, akkor a kedvezményt 
	 * is lesvesszük
	 */
	
	public function kosarDarabAr() {
		
		if(!isset($this->ar))  return 0 ;
		
		$ar = $this->ar;

		

		if(!empty($this->kivalasztottValtozat)) {

			if($this->kivalasztottValtozat->ar > 0)

				$ar = $this->kivalasztottValtozat->ar;

		}

		if(!empty($this->kivalasztottOpciok)) {

			foreach($this->kivalasztottOpciok as $opcio) {

				

				$ar += $opcio->ar;

			}

		}
		
		// egyedi kedvezmény?
		$this->eredetiDarabAr = $ar;
		if(!empty($this->kupon)) {
			
			$modosito = $this->kupon;
			
			if(isset($modosito->id)) {
				
				if($modosito->mukodesimod==0) {

						// hozzáadódik az ár
						$this->darabArKedvezmeny = $modosito->ar;
						$ar +=  $this->darabArKedvezmeny;
						
						

					} else {
						
						// százalékos működés
						$this->darabArKedvezmeny = ($ar/100)*$modosito->ar;
						$ar +=  $this->darabArKedvezmeny;


					}

				
				
				
			
			}
			//print $this->eredetiDarabAr.' '.$ar.' ';
			
		}
		
		
		$this->darabAr = $ar;

		return $ar;

	}

	/*
	 * kosarDarabszam
	 * 
	 * visszaadja, adott termék darabszámát
	 */

	public function kosarDarabszam() {

		return $this->darab;

	}
	
	/*
	 * opcioBeallitas
	 * 
	 * opció beállítás, normál megjelenítés és rendelés esetén
	 */

	public function opcioBeallitas($termek_armodositok_id, $tabla = 'termek_armodositok') {

		$opcio = $this->get(DBP.$termek_armodositok_id, $tabla, 'id');

		$this->kivalasztottOpciok[] = $opcio;

	}

	/*
	 * kosarTermekNev
	 * 
	 * termék megnevezésének generálása a változat figyelembevételével
	 */

	public function kosarTermekNev() {

		$nevKiegeszites = '';

		if(!empty($this->kivalasztottValtozat)) {

			$nevKiegeszites = " - ".$this->kivalasztottValtozat->nev;

		}

		if(!empty($this->kivalasztottValtozat2)) {

			$nevKiegeszites .= " - ".$this->kivalasztottValtozat2->nev;

		}

		if($this->rendeles) {

			return $this->nev.$nevKiegeszites;

		}

		return $this->jellemzo('Név').$nevKiegeszites;

	}
	
	/*
	 * vannakOpciok
	 * 
	 * igaz, ha a termékhez van opció hozzárendelve
	 */
	
	public function vannakOpciok() {

		if(empty($this->opciok)) {

			$this->opciokBetoltes();

		}

		

		if(empty($this->opciok)) {

			return false;

		}

		return true;

	}

	/*
	 * opciok
	 * 
	 * visszaadja a beállított opciókat
	 */

	public function opciok() {

		if(empty($this->opciok)) {

			$this->opciokBetoltes();

		}

		

		if(empty($this->opciok)) {

			return false;

		}

		return $this->opciok;

	}

	/*
	 * opciokBetoltes
	 * 
	 * a termékhez rendelhető lehetséges opciók betöltése
	 */ 
	
	public function opciokBetoltes() {

		$id = $this->id;

		if($this->rendeles) $id = $this->termek_id;

		

		$sql = "SELECT * FROM ".DBP."termek_armodositok WHERE tipus = 1 AND termek_id = {$id} ORDER BY sorrend ASC ";

		$this->opciok = $this->sqlSorok($sql);

	}

	/*
	 * vannakValtozatok
	 * 
	 * van-e változat lehetőség
	 */
	public function vannakValtozatok() {

		if(empty($this->valtozatok)) {

			$this->valtozatokBetoltes();

		}

		

		if(empty($this->valtozatok)) {

			return false;

		}

		return true;

	}
	public function elsoValtozatId() {

		if(empty($this->valtozatok)) {

			$this->valtozatokBetoltes();

		}

		

		if(empty($this->valtozatok)) {

			return false;

		}

		return current($this->valtozatok)->id;

	}
    
	
	
	public function vannakValtozatok2() {

		if(empty($this->valtozatok2)) {

			$this->valtozatokBetoltes2();

		}

		

		if(empty($this->valtozatok2)) {

			return false;

		}

		return true;

	}

	public function vanBelsoValtozat () {
		return ( $this->vannakValtozatok() or $this->vannakValtozatok2() );
		
	}

	public function valtozatok() {

		if(empty($this->valtozatok)) {

			$this->valtozatokBetoltes();

		}

		

		if(empty($this->valtozatok)) {

			return false;

		}

		return $this->valtozatok;

	}

	public function valtozatok2() {

		if(empty($this->valtozatok2)) {

			$this->valtozatokBetoltes2();

		}

		

		if(empty($this->valtozatok2)) {

			return false;

		}

		return $this->valtozatok2;

	}

	public function megrendeltValtozat() {

		

		// csak rendelés esetén lehetséges

		if($this->rendeles===false) return false;

		// ha van mentett változat, visszaadjuk:

		$sql = "SELECT * FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = {$this->id} AND tipus = 0 ";

		

		return $this->Sql->sqlSor($sql);

		

	}

	public function megrendeltValtozat2() {

		

		// csak rendelés esetén lehetséges

		if($this->rendeles===false) return false;

		// ha van mentett változat, visszaadjuk:

		$sql = "SELECT * FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = {$this->id} AND tipus = 2 ";

		

		return $this->Sql->sqlSor($sql);

		

	}

	

	public function megrendeltOpciok() {

		

		// csak rendelés esetén lehetséges

		if($this->rendeles===false) return false;

		// ha van mentett változat, visszaadjuk:

		$sql = "SELECT * FROM ".DBP."rendeles_termek_armodositok WHERE rendeles_termek_id = {$this->id} AND tipus = 1 ";

		

		return $this->Sql->sqlSorok($sql);

		

	}

	

	public function megrendeltOsszAr() {

		if($this->rendeles===false) return 0;

		return $this->megrendeltEgysegAr()*$this->darab;

	}
	
	public function megrendeltOsszBruttoAr() {

		if($this->rendeles===false) return 0;
		$ar = $this->megrendeltOsszAr();
		$afa = $afa = $this->afa;
		$brutto = $ar + ($ar/100)*$afa;
		return round($brutto, 2);

	}

	public function megrendeltEgysegAr() {

		if($this->rendeles===false) return 0;

		

		// a nettó alapár a termékár vagy ha van kiválasztva változat, akkor annak az ára

		$ar = $this->ar;

		$valtozat = $this->megrendeltValtozat();

		if(isset($valtozat->ar)) if($valtozat->ar!=0) $ar = $valtozat->ar;

		

		// majd hozzáadjuk az opciókat

		$opciok = $this->megrendeltOpciok();

		if($opciok) foreach($opciok as $sor) {

			$ar += $sor->ar;

		}

		// TODO: mi van ha az opció más ÁFAkörbe tartozik??
		
		// egyedi kedvezmény?
		$this->eredetiDarabAr = $ar;
		if(!empty($this->kupon)) {
			
			$modosito = $this->kupon;
			
			if(isset($modosito->id)) {
				
				if($modosito->mukodesimod==0) {

					// hozzáadódik az ár
					$this->darabArKedvezmeny = $modosito->ar;
					$ar +=  $this->darabArKedvezmeny;
					

				} else {
					
					// százalékos működés
					$this->darabArKedvezmeny = ($ar/100)*$modosito->ar;
					$ar +=  $this->darabArKedvezmeny;
				
				}
			
			}
			//print $this->darabArKedvezmeny.' '.$ar.' ';
			
		}
		
		
		
		return $ar;

		

	}
	public function megrendelesOsszNettoKedvezmenyAr() {

		
		//print $this->darabArKedvezmeny*$this->darab;
		return $this->darabArKedvezmeny*$this->darab;

	}
	public function megrendelesOsszBruttoKedvezmenyAr() {

		
		$osszNetto = $this->megrendelesOsszNettoKedvezmenyAr();
		$ossz = round($osszNetto + ($osszNetto/100)*$this->afa,2);
		return $ossz;

	}
	
	public function megrendeltBruttoEgysegAr() {
		/*********************
		 * 
		 * KIKÖTVE
		 * 
		 * akkor kerülhet használatba, ha az opciók és változatok áfája eltérhet a termék áfájától
		 * 
		 */
		
		
		if($this->rendeles===false) return 0;

		

		// a nettó alapár a termékár vagy ha van kiválasztva változat, akkor annak az ára

		$ar = $this->ar;

		$afa = $this->afa;

		

		$valtozat = $this->megrendeltValtozat();

		if(isset($valtozat->ar)) {

			if($valtozat->ar>0) {

				$ar = $valtozat->ar;

				$afa = $valtozat->afa;

			}

		}

		

		$valtozat = $this->megrendeltValtozat2();

		if(isset($valtozat->ar)) {

			if($valtozat->ar>0) {

				$ar = $valtozat->ar;

				$afa = $valtozat->afa;

			}

		}

		$ar = $ar+($ar/100)*$afa;

		// majd hozzáadjuk az opciókat

		$opciok = $this->megrendeltOpciok();

		if($opciok) foreach($opciok as $sor) {

			$ar += $sor->ar+($sor->ar/100)*$sor->afa;

		}

		// TODO: mi van ha az opció más ÁFAkörbe tartozik??

		return $ar;

		

	}

	public function valtozatokBetoltes() {

		$tabla = DBP.'termek_armodositok';

		$id = $this->id;

		if($this->rendeles) $id = $this->termek_id;

		

		//if($this->rendeles) $tabla = DBP.'rendeles_termek_armodositok';

		$sql = "SELECT * FROM $tabla WHERE tipus = 0 AND termek_id = {$id} ORDER BY sorrend ASC ";

		$valtozatok = $this->sqlSorok($sql);
		
		$this->valtozatok = array();
		
		foreach($valtozatok as $sor) {
			// készletek
			$this->valtozatok[$sor->id] = $sor;
		}
		

	}

	public function valtozatokBetoltes2() {

		$tabla = DBP.'termek_armodositok';

		$id = $this->id;

		if($this->rendeles) $id = $this->termek_id;

		

		//if($this->rendeles) $tabla = 'rendeles_termek_armodositok';

		$sql = "SELECT * FROM $tabla WHERE tipus = 2 AND termek_id = {$id} ORDER BY sorrend ASC ";

		$valtozatok2 = $this->sqlSorok($sql);
		
		$this->valtozatok2 = array();
		
		foreach($valtozatok2 as $sor) {
			// készletek
			$this->valtozatok2[$sor->id] = $sor;
		}

	}

	

	public function jellemzo($nev, $nyelv = 'hu') {

		if(empty($this->jellemzok)) {

			$this->jellemzoBetoltes();

		}
		
		if(isset($this->jellemzok[$nev])) {

			
			// szöveges tartalom

			if(isset($this->jellemzok[$nev]->adat[$nyelv])) return $this->jellemzok[$nev]->adat[$nyelv];

			// egyéb tartalom

			if(isset($this->jellemzok[$nev]->adat)) return $this->jellemzok[$nev]->adat;

			

			

		}

		

		return false;

	}

	public function jellemzoFeliratTermelap($nev, $nyelv = 'hu') {

		if(empty($this->jellemzok)) {

			$this->jellemzoBetoltes();

		}
		
		if(isset($this->jellemzoFeliratok[$this->jellemzok[$nev]->slug][$nyelv])) 
			if($this->jellemzoFeliratok[$this->jellemzok[$nev]->slug][$nyelv]!=='')
				return $this->jellemzoFeliratok[$this->jellemzok[$nev]->slug][$nyelv];
		
		if(isset($this->jellemzoFeliratok[$this->jellemzok[$nev]->slug])) 
			if(!is_array($this->jellemzoFeliratok[$this->jellemzok[$nev]->slug]))
				if($this->jellemzoFeliratok[$this->jellemzok[$nev]->slug]!=='')
					return $this->jellemzoFeliratok[$this->jellemzok[$nev]->slug];
		return $nev;
		
		
	}

	

	public function jellemzoSor($nev, $nyelv = 'hu') {

		if(empty($this->jellemzok)) {

			$this->jellemzoBetoltes();

		}

		if(isset($this->jellemzok[$nev])) {

			$mezo = 'ertek_'.$this->jellemzok[$nev]->tipus;

			// szöveges tartalom

			if(isset($this->jellemzok[$nev]->adat[$nyelv]->$mezo)) return $this->jellemzok[$nev]->adat[$nyelv];

			// egyéb tartalom

			if(isset($this->jellemzok[$nev]->adat->$mezo)) return $this->jellemzok[$nev]->adat;

			

			

		}

		

		return false;

	}

	

	public function jellemzoBetoltes($termek_csoport_id = false) {

		

		if(!isset($this->id)) $this->id=0 ;

		if(!$termek_csoport_id) $termek_csoport_id = (int)@$this->termek_csoport_id;
		if($termek_csoport_id==0) {
			$elsotermekcsoport = $this->sqlSor("SELECT id FROM ".DBP."termek_csoportok LIMIT 1");
			
			$termek_csoport_id = $elsotermekcsoport->id;
			
		}
		
		$this->termekcsoport = $this->sqlSor("SELECT id,nev FROM ".DBP."termek_csoportok WHERE id =  $termek_csoport_id ");
		
		$jellemzok = $this->sqlSorok("SELECT tj.* FROM ".DBP."termek_jellemzok tj, ".DBP."termek_csoportxjellemzo x 
			WHERE x.termek_csoport_id = $termek_csoport_id AND
			tj.id = x.termek_jellemzo_id ORDER BY sorrend ASC
		");
		$this->jellemzok = array();
		if($jellemzok) foreach ($jellemzok as $jellemzo)  {
			$this->jellemzok[$jellemzo->nev] = $jellemzo;
		}
		
		$nyelvek = explode(',', beallitasOlvasas('nyelvek'));

		foreach($nyelvek as $nyelv) {
			
			$adatok = $this->get($this->id, DBP.'termek_mezok_'.$nyelv, 'termek_id');
			
			if(isset($adatok->label_feliratok)) if($adatok->label_feliratok!="") {
				$feliratok = @unserialize(base64_decode($adatok->label_feliratok));
				if(is_array($feliratok)) {
					$this->jellemzoFeliratok = $feliratok;
				}
			}
			
			foreach($this->jellemzok as $k => $v) {
				
				
				
				if($v->tipus == 2 or $v->tipus == 3 or $v->tipus == 4 or $v->tipus == 5) {

					// nyelvfüggő jellemzők
					if(isset($adatok->{$v->slug})) {
						$this->jellemzok[$k]->adat[$nyelv] = $adatok->{$v->slug};
					} else {
						$this->jellemzok[$k]->adat[$nyelv] = '';	
					}
					

				} else {

					if(isset($adatok->{$v->slug})) {

						$this->jellemzok[$k]->adat = $adatok->{$v->slug};
					} else {
						$this->jellemzok[$k]->adat = '';
					}
				}
				
			}

		}
		
	}
	
	public function jellemzoFelirat($slug, $nyelv = false) {
		if(isset($this->jellemzoFeliratok[$slug])) {
			if($nyelv) {
				if(@$this->jellemzoFeliratok[$slug][$nyelv]!='') {
					return $this->jellemzoFeliratok[$slug][$nyelv];
				}
			} else {
				if ($this->jellemzoFeliratok[$slug]!="") {
					return $this->jellemzoFeliratok[$slug];
				}
			}
		}
		return '';
	}
	
	public function link() {
		if(!isset($this->id)) return '' ;
		
		
		$id =  $this->id;

		if($this->rendeles) $id = $this->termek_id;

		return base_url().'reszletes/'.strToUrl($id.'-'.$this->jellemzo('Név'));

	}

	public function fokep() {

		if(!$this->kepek) {

			$this->kepBetoltes();

		}

		if($this->kepek) return $this->kepek[0]->file;

		return false;

	}

	public function kepBetoltes() {

		if($this->kepek) return $this->kepek[0]->file;

		if(!isset($this->id)) return false;

		$id = $this->id;

		if($this->rendeles) $id = $this->termek_id;

		$sql = "WHERE termek_id = {$id} ORDER BY sorrend ASC ";

		$this->kepek = $this->Sql->gets(DBP."termek_kepek", $sql);
		if(empty($this->kepek)) $this->kepek = array(0 => (object)array('termek_id' => $id, 'szerep' => 1, 'file' => 'img/noimage.jpg'));
		return $this->kepek;

	}

}

