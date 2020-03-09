<?php

class Termekkep_osztaly extends MY_Model {
	
	public $termekKepekDir = 'assets/termekkepek/';
	
	public function mappakeszites($tid) {
		$dir = $this->termekKepekDir;
		if($tid==0) {
			@mkdir(FCPATH.$dir.'0/');
			return $dir.'0/';
		
		}
		$tid = sprintf("%04d", $tid);
		
		for($i = 0; $i < strlen($tid); $i++) {
			$dir .= $tid[$i].'/';
			@mkdir(FCPATH.$dir);
		}
		return $dir;
		
	}
	public function teljesKeplista($tid) {
		return $this->gets(DBP.'termek_kepek', " WHERE termek_id = ".$tid." ORDER BY sorrend ASC");
	}
	public function kepTorles($id) {
		$sor = $this->get($id, DBP."termek_kepek", 'id');
		if(!isset($sor->id)) return 0;
		ws_delimagevariants($sor->file);
		@unlink(FCPATH.$sor->file);
		$this->db->query("DELETE FROM ".DBP."termek_kepek WHERE id = $id LIMIT 1");
		return 1;
	}
	public function kepathelyezes($tid) {
		$lista = $this->teljesKeplista(0);
		
		if(!empty($lista)) {
			$cel = $this->mappakeszites($tid);
			
			foreach($lista as $sor) {
				$file = basename($sor->file);
				rename(FCPATH.$sor->file,FCPATH.$cel.$file);
				$a = array('id' => $sor->id, 'file' => $cel.$file, 'termek_id' => $tid);
				$this->sqlUpdate($a, DBP.'termek_kepek');
			}
		}
	}
	public function osszesKepTorlese($tid) {
		$lista = $this->teljesKeplista($tid);
		if($lista) foreach($lista as $sor) $this->kepTorles($sor->id);
	}
}
