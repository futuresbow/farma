<?php

class Temak_admin extends MY_Modul {
	
	public function beallitasok() {
		$ci = getCI();
		globalisMemoria("Nyitott menüpont",'Témabeállítások');
		$tema = $ci->uri->segment(4);
		$kimenet = '';
		include (FCPATH.TEMAMAPPA.'/'.$tema.'/tema_admin.php');
		return $kimenet;
		//$this->load->view(ADMINTEMPLATE.'html/tartalomepito', $data, true);
	}
	public function temavalaszto() {
		$ci = getCI();
		
		$lista = ws_temaadatok();
		$tema = beallitasOlvasas("FRONTENDTEMA");
		
		if(isset($_GET['bekapcsol'])) {
			$sql = "UPDATE ".DBP."settings SET  ertek = '".$lista[(int)$ci->input->get('bekapcsol')]['dir']."' WHERE kulcs = 'FRONTENDTEMA' LIMIT 1";
			
			$ci->db->query($sql);
			$lista = ws_temaadatok();
			redirect(ADMINURL."temak/temavalaszto?m=".urlencode("Téma kiválasztása megtörtént"));
		}
		
		$ALG = new Adminlapgenerator;

		

		$ALG->adatBeallitas('lapCim', "Témaválasztás");

		$ALG->adatBeallitas('szelessegOsztaly', "full-width");

		$ALG->tartalomDobozStart();

		

		// táblázat adatok összeállítása

		$adatlista = array();

		$start = 0;

		$w = '';

		
		$tablasorok = array();
		foreach($lista as $i => $sor) {

			$tablasorok[] = (object)array(
				'id' => $i+1,
				'nev' => $sor['nev'],
				'beallitasok' => '<a href="'.ADMINURL.'temak/beallitasok/'.$sor['dir'].'">Beállítás</a>',
				'kep' => '<img src="'.$sor['kep'].'" height="150" >',
				'kapcsolo' => ($tema==$sor['dir'])
				?'':'<a href="?bekapcsol='.$i.'">Bekapcsolás</a>',
				'statusz' => ($tema==$sor['dir'])?'<b style="color:green">BEKAPCSOLVA</b>':'',
			);
			
			
			

			

		}

		// táblázat beállítás

		$tablazat = $ALG->ujTablazat();

		

		

		$keresoMezok = false;

		$tablazat->adatBeallitas('keresoMezok', $keresoMezok);

		$tablazat->adatBeallitas('megjelenitettMezok', array('nev' => 'Név', 'kep' => 'Kép','statusz' => 'Státusz' ,  'kapcsolo' => '', "beallitasok" => "Beállítások" ));

		$tablazat->adatBeallitas('lista', $tablasorok);

		

		

		$ALG->tartalomDobozVege();

		return $ALG->kimenet();


	}
	
	
}
