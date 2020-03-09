<?php

class MY_Modul extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->ci = getCI();
		if(!defined('FRONTENDTEMA')) define('FRONTENDTEMA', beallitasOlvasas('FRONTENDTEMA').'/');
		if(!defined('FRONTENDURL')) define('FRONTENDURL', base_url().'templates/'. beallitasOlvasas('FRONTENDURL').'/');
	}

}
