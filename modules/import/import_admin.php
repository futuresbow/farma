<?php


class Import_admin extends MY_Modul {

	var $data = array();

	

	public function index() {
		globalisMemoria("Nyitott menüpont",'Tartalomkezelés');
		$limit = 100;

		globalisMemoria('utvonal', array(array('felirat' => 'Tartmék importálás')));

		$ALG = new Adminlapgenerator;
		$ALG->adatBeallitas('lapCim', "Importálás");
		
		$ALG->urlapStart(array('attr'=> ' action="" enctype="multipart/form-data" method="post" '));
		
		$ALG->tartalomDobozStart();
		$doboz = $ALG->ujDoboz();

		$doboz->HTMLHozzaadas("<b>Importáló modul előkészítés (üzemen kívül)</b>");
		
		
		$ALG->tartalomDobozVege();

		/*
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
        */
        
		$ALG->urlapVege();
		
		$ALG->tartalomDobozVege();

		return $ALG->kimenet();
		
		
	}
	

}



