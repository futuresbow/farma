<?php
include_once('osztaly_termek.php');

class Termeklista_osztaly extends MY_Model {
	
	public $order = 'id ASC';
	public $where = '';
	public $talalatszam = 0;
	public function jellemzoFajtak($nev, $tipus = 2) {
		$sql = "SELECT ertek_".$tipus." as ertek, tj.id FROM ".DBP."jellemzok j , ".DBP."termek_jellemzok tj WHERE 
			j.termek_jellemzo_id = tj.id AND tj.nev = '$nev' GROUP BY ertek ORDER BY nev ASC 
		";
		
		return $this->Sql->sqlSorok($sql);
	}
	public function szukites($sql) {
		
		$szukites = $this->sqlSorok($sql);
		$idArr = array();
		foreach($szukites as $sor) $idArr[] = $sor->tid;
		
		if(!empty($idArr)) $this->where .= " AND t.id IN (".implode(",", $idArr).") ";
		
		
		
	}
	public function rendezesBeallitas($rendezes) {
		$rendezesiModok = array('nev' => ' nev ASC','ar' => ' ar ASC ', 'nepszeruseg' => ' vasarlasszam ASC ' );
		
		$this->order = $rendezesiModok[$rendezes];
		
	}
	public function termekAjanlo($termek_id, $darab=3) {
		$lista = $this->sqlSorok("SELECT t.id FROM ".DBP."termekek t WHERE statusz = 0 ORDER BY RAND() LIMIT ".$darab );
		$termekek = $this->termekOszalyLista($lista);
		return $termekek;
	}
	public function kiemeltTermekek($tipus, $darab=3) {
		$lista = $this->sqlSorok("SELECT t.id, j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." GROUP BY t.id ORDER BY RAND() LIMIT ".$darab );
		$termekek = $this->termekOszalyLista($lista);
		return $termekek;
	}
	
	public function kereses($keresoSzo, $darab=30) {

		$lista = $this->sqlSorok("SELECT t.id, j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." AND ( j.ertek_2 LIKE '%$keresoSzo%' OR t.cikkszam LIKE '%$keresoSzo%') GROUP BY t.id ORDER BY nev LIMIT ".$darab );

		$termekek = $this->termekOszalyLista($lista);
		$out = array();
		
		if($termekek) foreach($termekek as $t) {
			$out[] = array(
				'cim' => $t->jellemzo('Név'),
				'leiras' => $t->cikkszam,
				'kep' => $t->fokep(),
				'link' => $t->link(),
			);
		}
		
		return $out;

	}
	public function kategoriaTermekek($szegmens, $limit, $start) {
		$szegmens = ($szegmens);
		$kategoria = $this->sqlSor("SELECT * FROM ".DBP."kategoriak WHERE slug = '$szegmens' LIMIT 1");
		if($kategoria) {
			$termekek = $katTermekek = $this->kategoriaTermekekByKategoriaId($kategoria->id, array(), $limit, $start);
			
			if(!empty($termekek)) return $termekek;
			return false;
			
		} else {
			return false;
		}
	}
	public function uniqTermekek($termekek) {
		$ret = array();
		foreach($ret as $termek) {
			$ret[$termek->id] = $termek;
		}
		return $ret;
	}
	public function kategoriaTermekekByKategoriaId($id, $termekek = array(), $limit = 12, $start = 0 ) {
		$id = (int)($id);
		$alKategoriak = $this->sqlSorok("SELECT * FROM ".DBP."kategoriak WHERE szulo_id = $id");
		if($alKategoriak) foreach($alKategoriak as $alKategoria) {
			$termekek = $this->kategoriaTermekekByKategoriaId($alKategoria->id, $termekek);
		}
		
		
		$sql = "SELECT t.id, j.ertek_2 as nev FROM ".DBP."termekek t,".DBP."jellemzok j, ".DBP."termekxkategoria x WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." AND  t.aktiv = 1 AND t.id = x.termek_id AND x.kategoria_id = {$id} {$this->where} GROUP BY t.id ORDER BY ".$this->order;
		$lista = $this->sqlSorok($sql );
		
		if($lista) {
			foreach($lista as $sor) {
				$termekek[$sor->id] = new Termek_osztaly($sor->id);
			}
			
			
		}
		
		$this->talalatszam = count($termekek);
		$lista = array();
		$i = 0;
		
		foreach($termekek as $sor) {
			if($i>=$start and $i < ($start+$limit) ) {
				$lista[] = $sor;
			}
			$i++;
		}
		return $lista;
		
	}
	
	public function termekek($limit = 9, $start = 0 ) {		$sql = "SELECT COUNT(DISTINCT(t.id))as ossz FROM `".DBP."jellemzok` j, ".DBP."termekek t  WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." ".$this->where;
		//print $sql;
		$talalatszam = $this->sqlSor($sql );		$this->talalatszam = $talalatszam->ossz;
		//print '<br>'.$this->talalatszam.'<br>';
		$sql = "SELECT t.id, j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." ".$this->where." GROUP BY t.id ORDER BY ".$this->order." LIMIT $start,$limit ";
		$lista = $this->sqlSorok($sql );		
		$termekek = $this->termekOszalyLista($lista);
		return $termekek;
	
	}
	public function termekekCimkeszerint($cimke_id, $limit = 9) {
		
		
		
		$idLista = $this->sqlSorok("SELECT DISTINCT(t.id) FROM  ".DBP."termekek t, ".DBP."termekxcimke x WHERE x.termek_id = t.id AND x.cimke_id = ".$cimke_id);
		$idArr = array();
		if(!empty($idLista)) foreach($idLista as $idSor) $idArr[] = $idSor->id;
		$w = ' AND 1 = 2 ';
		if(!empty($idLista)) {
			$w = " AND t.id IN (".implode(',', $idArr).") ";
		}		
		$sql = "SELECT COUNT(t.id) as ossz FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." $w ";
		//print $sql;
		$talalatszam = $this->sqlSor($sql );
		$this->talalatszam = $talalatszam->ossz;
		
		
		$lista = $this->sqlSorok("SELECT t.id, j.ertek_2 as nev, t.* FROM `".DBP."jellemzok` j, ".DBP."termekek t WHERE j.termek_id = t.id AND j.termek_jellemzo_id = ".beallitasOlvasas("termeknev.termekjellemzo_id")." $w GROUP BY t.id ORDER BY ".$this->order." LIMIT $limit " );
		$termekek = $this->termekOszalyLista($lista);
		return $termekek;
	
	}
	
	public function termekOszalyLista($lista) {
		$termekek = array();
		if($lista) {
			
			foreach($lista as $sor) {
				
				$t = new Termek_osztaly($sor->id);
				$termekek[] = $t;
			}
		}
		return $termekek;
	}
}
