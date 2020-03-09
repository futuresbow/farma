<?php

class adattablaSzerkeszto {
    
    public $szerkezet;
    public $tabla;
    public function adatMezok() {
        $ret = $this->szerkezet;
        unset($ret['id']);
        unset($ret['termek_id']);
        foreach ($ret as $k => $sor) $ret[$k] = getCol('nev', 'bos_termekmezok'," kulcs = '$k'");
        return $ret;
        
    }
    
    
    public function letezik($tablanev) {
        $sql = "show tables like '$tablanev'";
        
        $rs = mysql_num_rows(sqluniv($sql));
        
        if ($rs > 0) return true;
        
        return false;
    }
    
    public function betolt($tablanev) {
        if ( $this->letezik($tablanev)) {
            $sql = "SHOW COLUMNS FROM $tablanev ";
            $rs = sqluniv4($sql);
            $szerkezet = array();
            foreach ($rs as $sor) {
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
        sqluniv($sql);
    }
    
    public function szinkronizalas($tabla) {
        $sql = "SELECT * FROM bos_termekmezok ORDER BY sorrend ASC";
        $mezok = sqluniv4($sql);
        $this->betolt($tabla);
        $voltak = array();
        foreach ($mezok as $mezo) {
            $voltak[] = $mezo;
            if ($this->mezoLetezik($mezo['kulcs'])) {
                // ALTER
                $this->mezoModositas($mezo['kulcs'], $mezo['tipus']);
            } else {
                // ADD
                $this->mezoHozzaad($mezo['kulcs'], $mezo['tipus']);
            }
        }
        
        // feleslegesek törlése
        $this->kimaradoTorles($voltak);
        
    }
    public function mezoLetezik($nev) {
        return (isset($this->szerkezet[$nev]));
    }
    public function mezoHozzaad($kulcs, $tipus) {
        $sql = "ALTER TABLE `".$this->tabla."` ADD `$kulcs` $tipus NOT NULL ";
        print $sql.'<br />';
        sqluniv($sql);
        
    }
    public function kimaradoTorles($vannak) {
        $torolni = array();
        $fent = $this->szerkezet;
        
        foreach ($vannak as $kulcs) {
            if (isset($fent[$kulcs['kulcs']])) {
                unset($fent[$kulcs['kulcs']]);
            }
            
            
        }
        foreach ($fent as $kulcs => $sor) {
            
            $this->mezoTorles($kulcs);
        }
    }
    
    public function mezoTorles($kulcs) {
        if ($kulcs == 'id' or $kulcs == 'termek_id') return 0;
        $sql = "ALTER TABLE `".$this->tabla."` DROP `$kulcs`";
        print $sql.'<br />';
        sqluniv($sql);
    }
    public function mezoModositas($kulcs, $tipus) {
        
        $sql = "ALTER TABLE `".$this->tabla."` CHANGE `$kulcs` `$kulcs` $tipus NOT NULL ";
        print $sql.'<br />';
        sqluniv($sql);
    }
    
}