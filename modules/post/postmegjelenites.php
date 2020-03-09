<?php

class Postmegjelenites extends MY_Modul{
	public function kereses($keresoSzo) {
		ws_autoload('post');
		$bejegyzesek = new Post_osztaly;
		
		return $bejegyzesek->kereses($keresoSzo);
	
	}
	public function index($param = false) {
		if(isset($param['post_id'])) {
			$post = $this->sqlSor("SELECT * FROM ".DBP."post WHERE id = ".$param['post_id']);			naplozo('Bejegyzés megtekintése', $param['post_id'], 'post');
			return $this->ci->load->view(FRONTENDTEMA.'html/post_index', $post, true);
		}
		ws_autoload('post');
		
		$id = $this->ci->uri->segment(2);
		if($id) {
			$id = (int)$id;
			$post = $this->sqlSor("SELECT * FROM ".DBP."post WHERE id = ".$id);			
			$bejegyzesek = new Post_osztaly;
			if(!$post) show_404();			naplozo('Bejegyzés megtekintése', $id, 'post', $post->cim);
			return $this->ci->load->view(FRONTENDTEMA.'html/bejegyzesoldal', array('post' => $post, 'hirlista' => $bejegyzesek->listaKategoriaNevSzerint('Hírek', 10)), true);
		}
		// hírek oldal
		$bejegyzesek = new Post_osztaly;
		return $this->ci->load->view(FRONTENDTEMA.'html/hirekoldal', array('hirlista' => $bejegyzesek->listaKategoriaNevSzerint('Hírek', 10)), true);
		
		
	}
	public function foldali_kategoria_ujdonsagok($param = false) {
		$lista = array();
		ws_autoload('termek');
		ws_autoload('post');
		$kategoria = new Kategoriak_osztaly;
		$postok = new Post_osztaly();
		return $this->ci->load->view(FRONTENDTEMA.'html/katergoria_es_ujpostok', array('lista' => $lista,'postok' => $postok, 'kategoria' => $kategoria), true);
	}
}
