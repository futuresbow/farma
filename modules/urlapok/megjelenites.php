<?php
class Megjelenites extends MY_Modul{
	
	function index() { 
		$data = array();
		if(($this->ci->input->post('a'))) {
			$a = $this->ci->input->post('a');
			$hiba = false;
			//print_r($a);
			if(strlen($a['nev'])<3) {
				$hiba = true;
				$data['h']['nev'] = __f("Kérem, add meg a nevedet.");
			}
			if(strlen($a['telefon'])<3) {
				$hiba = true;
				$data['h']['telefon'] = __f("Kérem, add meg a telefonszámodat.");
			}
			
			if(strlen($a['text'])<3) {
				$hiba = true;
				$data['h']['text'] = __f("Kérjük, írjon üzenetet.");
			}
			
			if(!filter_var($a['email'], FILTER_VALIDATE_EMAIL) ) {
				$hiba = true;
				$data['h']['email'] = __f("Nem megfelelő E-mail cím.");
			}
			
			if(!$hiba) {
				
				naplozo('Kosár oldal megjelenítése');
				
				
				$targy = "Weboldal kapcsolat űrlap kitöltés ".$a['nev'];

				$uzenet = "<h1>{$a['nev']} üzenetet küldött:</h1>
				<p><b>".nl2br($a['text'])."</b></p><p>E-mail címe: <a href=\"mailto:".$a['email']."\">".$a['email']."</a></p>
				<p></p>
				<p>
				<i>Kapcsolati űrlap</i>
				</p>
				";


		

		

				include(ROOTPATH.'modules/hirlevel/autoload.php');

				$level = new Levelkuldo_osztaly;

				$level->rendszerlevelKeszites($uzenet);

				

				if($level->levelKuldes(beallitasOlvasas('admin_ertesites_email_cim'), $targy))
					return $this->load->view(ws_temahtml().'kapcsolat_sikereskuldes.php', $data, true);
				
			}
			
			
			
		}
		// nézet által meghajtott kontact form
		return $this->load->view(ws_temahtml().'kapcsolat.php', $data, true);

	}
}
