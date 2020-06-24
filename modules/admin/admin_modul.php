<?php



class Admin_modul extends MY_Modul {

	

	var $adminTemplate = 'vezerlo/';

	var $data = array();

	

	function __construct(){

		parent::__construct();

		$tag = ws_belepesEllenorzes();

		if(!$tag) redirect(base_url());
		if($tag->adminjogok==0) redirect(base_url());

		$this->adminTemplate = beallitasOlvasas('ADMINTEMA').'/';

		define('ADMINTEMPLATE' , $this->adminTemplate);
		// alias
		define('ADMINTEMA' , $this->adminTemplate);

		define('ADMINURL' , base_url().'webshopadmin/');

		$this->data['stilusUrl'] = base_url().TEMAMAPPA.'/'.$this->adminTemplate;

		$this->data['utvonal'] = false;

		$this->ci->load->library('Adminlapgenerator');
        
	}

	public function adatBeallitas($kulcs, $ertek) {

		$this->data[$kulcs] = $ertek;

	}

	public function index() {

		$this->data['modulKimenet'] = '... modul nem elérhető ...';
		globalisMemoria("Nyitott menüpont",'admin/fooldal');

		$ci = getCI();

		if($ci->uri->segment(2)!='') {

			$modul = $ci->uri->segment(2);

			$metodus = $ci->uri->segment(3);

			

			// jogosultság ellenőrzés, menüpont

			$menusor = $this->Sql->sqlSor("SELECT * FROM adminmenu WHERE modul_eleres = '$modul/$metodus' LIMIT 1");

			// ha nincs, keresülk az első almenüt adott modullal

			$sql = "SELECT * FROM adminmenu WHERE szulo_id != 0 AND  modul_eleres LIKE '$modul/%' LIMIT 1" ;

			if(!$menusor) $menusor = $this->Sql->sqlSor( $sql);

			

			if(isset($menusor->id)) {

				if($menusor->szulo_id != 0 ) {

					globalisMemoria("Nyitott menüpont",$modul.'/'.$metodus);

				}

			}

			
			
			

			$class = $modul.'_admin';

			if( is_file(ROOTPATH.'modules/'.$modul.'/'.$class.'.php')) {


				include_once(ROOTPATH.'modules/'.$modul.'/'.$class.'.php');

				$obj = new $class;

				

				if(method_exists($obj, $metodus) ){
					
					$jogkorRs = $this->Sql->sqlSor("SELECT * FROM hozzaferesek WHERE eleres = '".$modul.'/'.$class.'/'.$metodus."' LIMIT 1");
					$jogkor = 0;
					$ujJokkor = false;
					if(!$jogkorRs) {
						// nincs még ilyen hozzáférési opció, ezért felvisszük szuperadmin johkörrel, hogy adminisztrálható legyen
						$a = array('eleres' => $modul.'/'.$class.'/'.$metodus, 'jogkor' => 56);// JOG_SUPERADMIN && JOG_ADMIN && JOG_BOSS
						$ujJokkor = true;
						$this->Sql->sqlSave($a, 'hozzaferesek', 'id');
						$jogkor = 0;
					} else {
						$jogkor = $jogkorRs->jogkor;
					}
					
					
					$tag = belepettTag();
					if(  !$tag->is( $jogkor ) )  {
						if($ujJokkor){
							$this->data['modulKimenet'] = '<b>A hozzáférési pontot az adatbázishoz kapcsoltam, kérlek frissítsd az oldalt</b>';
							
							
						} else {
							$this->data['modulKimenet'] = '<b>Nincs megfelelő jogosultságod, ha szükséged van a felületre, kérlek jelezd az adminnak.</b>';
							naplozo('Admin jogosultság hiba',0,'', $modul."/".$metodus."/".$ci->uri->segment(4));
						}
						
					} else {
						$this->data['modulKimenet'] = $obj->$metodus();
						naplozo('Admin tevékenység',0,'', $modul."/".$metodus."/".$ci->uri->segment(4));
					}
				}

			}

		} else {

			include_once(ROOTPATH.'modules/admin/admin_admin.php');

			$obj = new Admin_admin;

				

			$this->data['modulKimenet'] = $obj->index();
			naplozo('Admin tevékenység',0,'','Admin főoldal');
            

		}

		$this->data['adminAdatok']  = ws_moduladminadatok();

		

		

		if(!is_null($this->ci->input->get('ajax'))) {

			print $this->data['modulKimenet'];

		} else {

			$this->ci->load->view($this->adminTemplate.'keret_view', $this->data);

	

		}

	}

}



