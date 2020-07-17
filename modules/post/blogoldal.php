<?php

class Blogoldal extends MY_Modul{
	public function index($param) {
		ws_autoload('post');
		$elem = $this->ci->Sql->get( $param['kategoria_id'], DBP."post_kategoriak", " id ");
		
		$ci = getCI();
		$post = false;
		$w = '';
		if($ci->uri->segment(2)!='') {
            $id = (int)$ci->uri->segment(2);
            $fohir = $this->ci->Sql->sqlSor("SELECT p.* FROM ".DBP."postxkategoria x, post p WHERE x.kategoria_id = ".(int)$param['kategoria_id']." AND x.post_id = p.id AND p.id = $id ORDER BY datum DESC LIMIT 1");
            
            if(isset($fohir->id)) {
                $post = $fohir;
                $w = ' AND p.id != '.$fohir->id;
                
                $seoTartalom = globalisMemoria('seoTartalom');

				
				//$seoTartalom = new stdClass();
				$cim = $post->cim;
				if($post->seo_title!='') $cim = $post->seo_title;
				$leiras = $post->bevezeto;
				if($post->seo_description!='') $leiras = $post->seo_description;
				
				$seoTartalom->cim = $cim.' - '.beallitasOlvasas('aruhaznev');
				$seoTartalom->leiras = $leiras;
				
				globalisMemoria('seoTartalom', $seoTartalom);
            }
        
		}
		
		
		$postLista = $this->ci->Sql->sqlSorok("SELECT p.id FROM ".DBP."postxkategoria x, post p WHERE x.kategoria_id = ".(int)$param['kategoria_id']." AND x.post_id = p.id $w ORDER BY p.datum DESC LIMIT 20");
		
		if(isset($postLista[0])) if(!$post) $post = $postLista[0];
		
		
		naplozo('Blogoldal megtekintés', $param['kategoria_id'], 'post_kategoriak');
		return ws_frontendView('html/blogoldal', array('post' => $post, 'lista' => $postLista), true);
		
	}
}
