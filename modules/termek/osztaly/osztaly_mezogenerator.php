<?php

class Mezogenerator_osztaly extends MY_Model {
    
    public $szerkezet;
    public $tabla;
	
	public $tipusok = array('int(11)', 'float', 'varchar(255)', 'text');
   
    
    
    public function letezik($tablanev) {
        $sql = "show tables like '$tablanev'";
        
        $rs = $this->sqlSor($sql);
        
        if ($rs) return true;
        
        return false;
    }
    
    public function betolt($tablanev) {
        if ( $this->letezik($tablanev)) {
            $sql = "SHOW COLUMNS FROM $tablanev ";
            $rs = $this->sqlSorok($sql);
            
            $szerkezet = array();
            foreach ($rs as $sor) {
				$sor = (array)$sor;
                $szerkezet[$sor['Field']] = array(
                    'kulcs' => $sor['Field'],
                    'tipus' => $sor['Type']
                );
            }
            $this->szerkezet = $szerkezet;
            $this->tabla = $tablanev;
            return true;
        } else {
            return false;
        }
    }
    
    public function termekLeiroLetrehoz($tabla) {
        
        $sql = "
        CREATE TABLE IF NOT EXISTS `$tabla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `termek_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `termek_id` (`termek_id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

        ";
        $this->db->query($sql);
    }
    
    public function szinkronizalas($tabla) {
		$msg = array();
		
        $sql = "SELECT * FROM  termek_jellemzok ORDER BY sorrend ASC";
        $mezok = $this->sqlSorok($sql);
        $this->betolt($tabla);
        $voltak = array();
        foreach ($mezok as $mezo) {
			
			$msg[] = $mezo->nev.' mező vizsgálata';
			
            $voltak[] = $mezo;
            if ($this->mezoLetezik($mezo->slug)) {
                // ALTER
                $msg[] = $this->mezoModositas($mezo->slug, $mezo->tipus);
            } else {
                // ADD
                $msg[] = $this->mezoHozzaad($mezo->slug, $mezo->tipus);
                
            }
        }
        
        // feleslegesek törlése
        $uzenetek = $this->kimaradoTorles($voltak);
        if(!empty($uzenetek)) $msg = array_merge($msg, $uzenetek);
        return $msg;
    }
    public function mezoLetezik($nev) {
        return (isset($this->szerkezet[$nev]));
    }
    public function mezoHozzaad($kulcs, $tipus) {
		
		$tipus = $this->tipusok[(int)$tipus];
		
        $sql = "ALTER TABLE `".$this->tabla."` ADD `$kulcs` $tipus NOT NULL ";
        
        $this->db->query($sql);
        return $sql.'<br />';
        
    }
    public function kimaradoTorles($vannak) {
        $torolni = array();
        $fent = $this->szerkezet;
        
        foreach ($vannak as $kulcs) {
            if (isset($fent[$kulcs->slug])) {
                unset($fent[$kulcs->slug]);
            }
            
            
        }
        foreach ($fent as $kulcs => $sor) {
            
            $this->mezoTorles($kulcs);
        }
    }
    
    public function mezoTorles($kulcs) {
        if ($kulcs == 'id' or $kulcs == 'termek_id') return 0;
        $sql = "ALTER TABLE `".$this->tabla."` DROP `$kulcs`";
        $this->db->query($sql);
        return $sql.'<br />';
        
    }
    public function mezoModositas($kulcs, $tipus) {
        $tipus = $this->tipusok[(int)$tipus];
        $sql = "ALTER TABLE `".$this->tabla."` CHANGE `$kulcs` `$kulcs` $tipus NOT NULL ";
        
        $this->db->query($sql);
        
        return $sql.'<br />';
    }
    
}
