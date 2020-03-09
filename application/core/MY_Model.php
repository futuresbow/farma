<?php
/*
 * modellek őse alapfunkciókat tartalmaz
 **/
 
class MY_Model extends CI_Model  {
	
	
	function __construct() {
		parent::__construct();
		
	}
	// objektumtömbot ad vissza a lekérdezés eredményeként
	function sqlSorok($sql) { 
		return $this->db->query($sql)->result();
	}
	// objektumot ad vissza a lekérdezés eredményeként
	function sqlSor($sql) { 
		$rs = $this->db->query($sql)->result();
		if(isset($rs[0])) return $rs[0];
		return false;
	}
	// lekérdezést készít adott kereső mező alapján, objektumot ad vissza
	function get($id, $tabla, $fieldName) {
		if(!is_numeric($id)) $id = "'$id'";
		return $this->sqlSor("SELECT * FROM $tabla WHERE $fieldName = $id LIMIT 1 ");
	}
	// egy mező értékét adja vissza
	function getFieldValue($sql, $mezo) {
		$r = $this->sqlSor($sql);
		if(isset($r->{$mezo})) return $r->{$mezo};
		return false;
	}
	// egy mező értékét adja vissza kulcstömbként
	function fieldKeyArray($sql, $mezo, $id) {
		$r = $this->sqlSorok($sql);
		$ret = array() ;
		if(!$r) return false;
		foreach($r as $sor) {
			$ret[$sor->$id] = $sor->$mezo;
		}


		return $ret;
	}
	// lekérdezést készít, objektumtömbként adja vissza a találatokat
	function gets($tabla, $sqlplussz = "", $resultclass = '') {
		$sql = "SELECT * FROM $tabla ".$sqlplussz;
		
		
		if($resultclass!='') 
			$rs = $this->db->query($sql)->result($resultclass);
		else 
			$rs = $this->db->query($sql)->result();
		
		
		if(isset($rs[0])) return $rs;
		return false;
	}
	
	// asszociatív töbmként adja vissza a találatokat, kulcsként a megadott mező szerint
	function getsIdArr($tabla, $kulcs, $sqlplussz = '') {
		$lista = $this->gets($tabla, $sqlplussz);
		if(empty($lista)) return false;
		$ret = array();
		foreach($lista as $l) {
			$ret[$l->$kulcs] = $l;
		}
		return $ret;
	}
	// sql insert-et állít össze tömb ellemeiből
	public function sqlSave($adat, $tabla, $idStr = 'id') {
		if(isset($adat[$idStr])) unset($adat[$idStr]);
		$this->db->insert( $tabla,$adat);
		return $this->db->insert_id();
    }
	// sql uodate-et állít össze tömb elemeiből
    public function sqlUpdate($adat, $tabla, $idStr = 'id') {
		if(!is_numeric($adat[$idStr])) $adat[$idStr] = "'".$adat[$idStr]."'";
		$adat = (array)$adat;
		$id = $adat[$idStr];
		unset($adat[$idStr]);
		$this->db->where($idStr, $id);
		
		$this->db->update($tabla,$adat );
    }
	
	// találatszámot szolgáltat tábla és kiegészítő sql parancs alapján
    public function countRows($table, $sql = '') {
		$r = $this->sqlSor("SELECT COUNT(*) as ossz FROM $table $sql");
		return $r->ossz;
	}
	
	// töröl sort/sorokat adott táblából megadható mezőérték alapján
    public function sqlDelete($id,$tabla,$idmezo = 'id') {
		if(!is_numeric($id)) $id = "'$id'";
		$sql = "DELETE FROM $tabla WHERE $idmezo = '$id' ";
		$this->db->query($sql);
	}
}
