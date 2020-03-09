<?php

class Blogoldal extends MY_Modul{
	public function index($param) {
		
		$elem = $this->ci->Sql->get( $param['kategoria_id'], DBP."post_kategoriak", " id ");
		
		$postLista = $this->ci->Sql->sqlSorok("SELECT p.id FROM ".DBP."postxkategoria x, post p WHERE x.kategoria_id = ".(int)$param['kategoria_id']." AND x.post_id = p.id ORDER BY p.datum DESC");
		
		naplozo('Blogoldal megtekintés', $param['kategoria_id'], 'post_kategoriak');
		return ws_frontendView('html/blogoldal', array('lista' => $postLista), true);
		
	}
}
