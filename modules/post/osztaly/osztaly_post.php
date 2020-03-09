<?php


class Post_osztaly extends MY_Model {	var  $postKategoria = array();	var  $szerzo = array();	
	function load($id) {		$id = (int)$id;				$sql = "SELECT * FROM ".DBP."post WHERE id = $id LIMIT 1";		$rs = $this->sqlSor($sql);		if($rs) {			foreach($rs as $k => $v) {				$this->$k = $v;			}					// cimkék			$sql = "SELECT * FROM  ".DBP."postxkategoria x, ".DBP."post_kategoriak k WHERE k.id = x.kategoria_id AND x.post_id = $id";			$kategoriak = $this->sqlSorok($sql);			foreach($kategoriak as $sor) {				$this->postKategoria[$sor->id] = $sor;			}						// tag			$sql = "SELECT * FROM  ".DBP."felhasznalok  WHERE id = ".$this->felhasznalo_id;			$this->szerzo = $this->sqlSor($sql);								}				return $this;			}	function megtekintesek($hozzaadas = false) {				$valami = 1;		$megtek = (int)$this->megtekintve;				if($hozzaadas) 		{			$megtek = $megtek+1;			$sql = "UPDATE ".DBP."post SET megtekintve = $megtek WHERE id = ".$this->id;						$this->db->query($sql);					}				return $megtek;	}	function foCimke() {		if(empty($this->postKategoria)) {			return false;		}		return current($this->postKategoria);	}	function kereses($keresoSzo, $limit = 30) {				// letiltott post kategóriák, alapból 1-es, a rendszer kategória.		$tiltottKategoriak = "1";				$postok = $this->sqlSorok("SELECT DISTINCT(p.id), p.* FROM ".DBP."post p , ".DBP."postxkategoria x WHERE x.post_id = p.id AND x.kategoria_id NOT IN ($tiltottKategoriak) AND 									p.cim LIKE '%$keresoSzo%' OR  									p.bevezeto LIKE '%$keresoSzo%' OR 									p.szoveg LIKE '%$keresoSzo%' ORDER BY cim ASC  ");			$out = array();		if($postok) foreach($postok as $post) {			$out[] = array(				'cim' => $post->cim,				'leiras' => $post->bevezeto,				'kep' => $post->fokep,				'link' => base_url().beallitasOlvasas('post.oldal.url').'/'.$post->id.'/'.strToUrl($post->cim),			);		}				return $out;	}	function listaKategoriaNevSzerint($kategoriaNev, $limit = 3) {
		
		$kategoria = $this->sqlSor("SELECT * FROM ".DBP."post_kategoriak WHERE kategorianev LIKE '$kategoriaNev' LIMIT 1");
		if(!$kategoria) return false;
		$kategoria_id = $kategoria->id;
		$sql = "SELECT p.* FROM ".DBP."post p, ".DBP."postxkategoria x WHERE x.kategoria_id = $kategoria_id AND x.post_id = p.id ORDER BY datum LIMIT $limit";
		$lista = $this->sqlSorok($sql);
		foreach($lista as $k => $post) {
			$lista[$k]->link= base_url().beallitasOlvasas('post.oldal.url').'/'.$post->id.'/'.strToUrl($post->cim);
		}
		return $lista;
	}	function listaKategoriaSlugSzerint($slug, $limit = 3, $order = "") {
		if($order != "") $order = " ORDER BY ". $order;
		$kategoria = $this->sqlSor("SELECT * FROM ".DBP."post_kategoriak WHERE kategorianev LIKE '$slug' LIMIT 1");
		if(!$kategoria) return false;
		$kategoria_id = $kategoria->id;
		$sql = "SELECT p.* FROM ".DBP."post p, ".DBP."postxkategoria x WHERE x.kategoria_id = $kategoria_id AND x.post_id = p.id $order LIMIT $limit";
		$lista = $this->sqlSorok($sql);
		foreach($lista as $k => $post) {
			$lista[$k]->link= base_url().beallitasOlvasas('post.oldal.url').'/'.$post->id.'/'.strToUrl($post->cim);
		}
		return $lista;
	}
}
