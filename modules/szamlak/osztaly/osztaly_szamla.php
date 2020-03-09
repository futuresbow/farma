<?php

class Szamla_osztaly extends MY_Model {

	var $afa = 27;
	var $szamlaNev = 'szamla_';
	var $utolsoFile = 27;
	var $mindenkeppenSzamla = false;
	var $jutalekszamladijbekero = false;
	var $mindenSzallasnakDijbekeroStr = 'true';
	protected $CI;



	var $cegesBankszamlaszam;
	function __construct() {
		parent::__construct();
		$this->basePath = FCPATH;
		$this->CI =& get_instance();

		$this->cegesBankszamlaszam = beallitasOlvasas('ceg_szamlaszam');
		$this->user = beallitasOlvasas('szamlazz_user');
		$this->jelszo = beallitasOlvasas('szamlazz_jelszo');

	}
	function szamlazz($rendeles) {
		
		// készült már számla?
		$vanSzamla = $this->sqlSor("SELECT * FROM ".DBP."szamlazas WHERE rendeles_id = ".$rendeles->id." AND sztorno = 0 ");
		if($vanSzamla) return false;
		
		// XML elkészítése
		
		$this->szamlaNev = 'szaml_'.ws_ordernumber($rendeles->id);
		
		$this->xml_keszito($rendeles);
		$ret = $this->szamla_keszito($rendeles);
		
		if($ret===true) {
			$sz = array(
				'rendeles_id' => $rendeles->id,
				'rendeles_felhasznalo_id' => $rendeles->rendeles_felhasznalo_id,
				'szamlanev' => $this->szamlaNev,
			);
			$this->sqlSave($sz , DBP. 'szamlazas', 'id');
		} else {
			$sz = array(
				'rendeles_id' => $rendeles->id,
				'rendeles_felhasznalo_id' => $rendeles->rendeles_felhasznalo_id,
				'szamlanev' => $this->szamlaNev,
				'hiba' => serialize($ret),
			);
			$this->sqlSave($sz , DBP.'szamlazas', 'id');
		}
		return $ret;
	}
	
	
	function xml_keszito($rendeles) {
		
		$szamlaAdatok = array(
			'szamlaKelte'	=> date('Y-m-d'),
			'teljesitesDatuma'	=> date('Y-m-d'),
			'fizetesiHatarido'	=> Date('Y-m-d', strtotime("+8 days")),
			'megjegyzes'	=> 'Internetes vásárlás - '.beallitasOlvasas('aruhaznev'),
		);
		$szamlaAdatok['fizetesiMod'] = $rendeles->fizetesmod->nev;
		
		
		

		$doc = new \DOMDocument('1.0', 'utf-8');
		$doc->formatOutput = true;

		$xmlszamla = $doc->createElementNS('http://www.szamlazz.hu/xmlszamla', 'xmlszamla');
		$doc->appendChild($xmlszamla);
		$xmlszamla->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$xmlszamla->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'schemaLocation', 'http://www.szamlazz.hu/xmlszamla xmlszamla.xsd ');

		$beallitasok = $doc->createElement('beallitasok');
		$xmlszamla->appendChild($beallitasok);

		//$beallitasok->appendChild($doc->createElement('felhasznalo', 'hkteszt'));
		$beallitasok->appendChild($doc->createElement('felhasznalo', $this->user));
		//$beallitasok->appendChild($doc->createElement('felhasznalo', 'hotelkupon'));
		$beallitasok->appendChild($doc->createElement('jelszo', $this->jelszo));
		//tanúsítvány után áttenni true-ra!!!
		$beallitasok->appendChild($doc->createElement('eszamla', 'false'));
		$beallitasok->appendChild($doc->createElement('szamlaLetoltes', 'true'));
		$beallitasok->appendChild($doc->createElement('szamlaLetoltesPld', '1'));
		$beallitasok->appendChild($doc->createElement('valaszVerzio', '1'));

		$fejlec = $doc->createElement('fejlec');
		$xmlszamla->appendChild($fejlec);
		$fejlec->appendChild($doc->createElement('keltDatum', $szamlaAdatok['szamlaKelte']));
		$fejlec->appendChild($doc->createElement('teljesitesDatum', $szamlaAdatok['teljesitesDatuma']));
		$fejlec->appendChild($doc->createElement('fizetesiHataridoDatum', $szamlaAdatok['fizetesiHatarido']));
		$fejlec->appendChild($doc->createElement('fizmod', $szamlaAdatok['fizetesiMod']));
		$fejlec->appendChild($doc->createElement('penznem', 'Ft'));
		$fejlec->appendChild($doc->createElement('szamlaNyelve', 'hu'));
		$fejlec->appendChild($doc->createElement('megjegyzes', $szamlaAdatok['megjegyzes']));
		$fejlec->appendChild($doc->createElement('arfolyamBank', 'MNB'));
		$fejlec->appendChild($doc->createElement('arfolyam', '0.0'));
		$fejlec->appendChild($doc->createElement('rendelesSzam', ''));
		$fejlec->appendChild($doc->createElement('elolegszamla', 'false'));
		$fejlec->appendChild($doc->createElement('vegszamla', 'false'));



		$fejlec->appendChild($doc->createElement('dijbekero', 'true'));

		$fejlec->appendChild($doc->createElement('szamlaszamElotag', ''));

		$elado = $doc->createElement('elado');
		$xmlszamla->appendChild($elado);
		$elado->appendChild($doc->createElement('bank', 'Unicredit Bank'));
		$elado->appendChild($doc->createElement('bankszamlaszam', $this->cegesBankszamlaszam));
		$elado->appendChild($doc->createElement('emailReplyto', ''));
		$elado->appendChild($doc->createElement('emailTargy', ''));
		$elado->appendChild($doc->createElement('emailSzoveg', ''));
		//$elado->appendChild($doc->createElement('alairoNeve', ''));

		$vevo = $doc->createElement('vevo');
		$xmlszamla->appendChild($vevo);
		$nev = $doc->createElement('nev');
		$vevo->appendChild($nev);
		
		$user = $rendeles->vevo; 
		
		$nev->appendChild($doc->createCDATASection( $user->szaml_nev ) );
		$vevo->appendChild($doc->createElement('irsz', $user->szaml_irszam));
		$vevo->appendChild($doc->createElement('telepules', $user->szaml_telepules));
		$vevo->appendChild($doc->createElement('cim', $user->szaml_utca));
		$vevo->appendChild($doc->createElement('adoszam', ''));

		$postazasiNev = $doc->createElement('postazasiNev');
		$vevo->appendChild($postazasiNev);
		$postazasiNev->appendChild($doc->createCDATASection( $user->szall_nev ) );
		$vevo->appendChild($doc->createElement('postazasiIrsz', $user->szall_irszam));
		$vevo->appendChild($doc->createElement('postazasiTelepules', $user->szall_telepules));
		$vevo->appendChild($doc->createElement('postazasiCim', $user->szall_utca));
		
		
		
		
		
		//$vevo->appendChild($doc->createElement('alairoNeve', ''));
		//$vevo->appendChild($doc->createElement('telefonszam', ''));
		$vevo->appendChild($doc->createElement('megjegyzes', '' ));

		$tetelek = $doc->createElement('tetelek');
		$xmlszamla->appendChild($tetelek);
		
		// termékek listája
		$osszar = 0;
		$osszarBrutto = 0;
		$rendeles->megrendelesArszamitas();
		
		
		foreach($rendeles->termekLista as $t) {
			
			
			$tetel = $doc->createElement('tetel');
			$tetelek->appendChild($tetel);

			$tetel->appendChild($doc->createElement('megnevezes',$t->nev." ({$t->cikkszam})"));
			$tetel->appendChild($doc->createElement('mennyiseg', $t->darab));
			$tetel->appendChild($doc->createElement('mennyisegiEgyseg', 'db'));
	//		$tetel->appendChild($doc->createElement('nettoEgysegar', $this->bruttobolNetto($osszeloleg)));
	//		$tetel->appendChild($doc->createElement('afakulcs', $this->afa));
	//		$tetel->appendChild($doc->createElement('nettoErtek', $this->bruttobolNetto($osszeloleg)));
	//		$tetel->appendChild($doc->createElement('afaErtek', $this->afaErtek($osszeloleg)));

			//print $tr->get('vouchertipus');
			$tetel->appendChild($doc->createElement('nettoEgysegar', $t->megrendeltEgysegAr() ));
			$tetel->appendChild($doc->createElement('afakulcs', $t->afa));
			$tetel->appendChild($doc->createElement('nettoErtek', $t->megrendeltOsszAr()));
			$tetel->appendChild($doc->createElement('afaErtek', $t->megrendeltOsszBruttoAr()-$t->megrendeltOsszAr()));
			$tetel->appendChild($doc->createElement('bruttoErtek', $t->megrendeltOsszBruttoAr()));



			$tetel->appendChild($doc->createElement('megjegyzes', ''));
			
			
			$osszar += $t->megrendeltOsszAr(); 
			$osszarBrutto += $t->megrendeltOsszBruttoAr();

		}
		
		// ármódosítók
		if($rendeles->ervenyesitettArmodositok) {
			foreach($rendeles->ervenyesitettArmodositok as $am) {
				$tetel = $doc->createElement('tetel');
				$tetelek->appendChild($tetel);

				$tetel->appendChild($doc->createElement('megnevezes',$am['nev']));
				$tetel->appendChild($doc->createElement('mennyiseg', 1));
				$tetel->appendChild($doc->createElement('mennyisegiEgyseg', 'db'));
		//		$tetel->appendChild($doc->createElement('nettoEgysegar', $this->bruttobolNetto($osszeloleg)));
		//		$tetel->appendChild($doc->createElement('afakulcs', $this->afa));
		//		$tetel->appendChild($doc->createElement('nettoErtek', $this->bruttobolNetto($osszeloleg)));
		//		$tetel->appendChild($doc->createElement('afaErtek', $this->afaErtek($osszeloleg)));

				//print $tr->get('vouchertipus');
				$tetel->appendChild($doc->createElement('nettoEgysegar', $am['netto'] ));
				$tetel->appendChild($doc->createElement('afakulcs', $am['afa']));
				$tetel->appendChild($doc->createElement('nettoErtek', $am['netto']));
				$tetel->appendChild($doc->createElement('afaErtek', $am['afaertek']));
				$tetel->appendChild($doc->createElement('bruttoErtek', $am['brutto']));

			}
		
		}
		
		
		
		 
		$s = $doc->save($this->basePath.'data/xml/'.$this->szamlaNev.'.xml');
		
		
		return $doc->save($this->basePath.'data/xml/'.$this->szamlaNev.'.xml');


	}
	
	//Honlapon történ vásárlás jóváhagyásakor a díjbekérő kiküldése

	public function szamla_keszito($rendeles){
		
		$cookie_file 	= FCPATH.'data/szamlazz_cookie_teszt.txt';
		$pdf_file 	= $this->basePath.'data/pdf/'.$this->szamlaNev.'.pdf';
		$xmlfile 		= $this->basePath.'data/xml/'.$this->szamlaNev.'.xml';

		$agent_url 	= 'https://www.szamlazz.hu/szamla/';
		$szamlaletoltes = true;

		if (!file_exists($cookie_file)) {
			file_put_contents($cookie_file, '');
		}
		//print $xmlfile.'<br>';
		//print htmlspecialchars(file_get_contents($xmlfile));



		$ch = curl_init($agent_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$cfile = curl_file_create($xmlfile,'text/xml','action-xmlagentxmlfile');
		$arr = array('action-xmlagentxmlfile'=>$cfile);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);

		//$arr = array('action-xmlagentxmlfile'=>'@' . $xmlfile);
		//print_r($arr);
		//die();
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);


		if (file_exists($cookie_file) && filesize($cookie_file) > 0) {
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		}

		$agent_response 	= curl_exec($ch);
		$http_error 		= curl_error($ch);
		//var_dump(curl_getinfo($ch));
		$agent_http_code 	= curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$header_size 		= curl_getinfo($ch,CURLINFO_HEADER_SIZE);
		$agent_header 		= substr($agent_response, 0, $header_size);
		$agent_body 		= substr( $agent_response, $header_size );
		curl_close($ch);
		//print  $agent_header;
		$header_array 		= explode("\n", $agent_header);
		$volt_hiba 		= false;
		
		
		
		
		foreach ($header_array as $val) {
			if (substr($val, 0, strlen('szlahu')) === 'szlahu') {
				//echo urldecode($val).'<br>';
				if (substr($val, 0, strlen('szlahu_error:')) === 'szlahu_error:') {
					$volt_hiba 	= true;
					$agent_error 	= substr($val, strlen('szlahu_error:'));
				}
				if (substr($val, 0, strlen('szlahu_error_code:')) === 'szlahu_error_code:') {
					$volt_hiba 	= true;
					$agent_error_code = substr($val, strlen('szlahu_error_code:'));
				}
			}
		}
		//exit;
		//curl kapcsolódási hiba
		if($http_error){
			$hiba 	= array('rendszer' => 'curl', 'hibauzenet' => $http_error);

			return $hiba;
		}

		//számlázz.hu hiba
		if($volt_hiba){
			$hiba 	= array('rendszer' => 'szamlazz.hu', 'hibakod' => $agent_error_code, 'hibauzenet' => urldecode($agent_error));

			return $hiba;
		}
		else{
			$this->utolsoFile = $pdf_file;
			file_put_contents($pdf_file, $agent_body);
			return true;
		}
	}
	
	
	

}
