<?php

class Feliratkozas extends MY_Modul {
	function leiratkozas_hook($data) {
		$email = $data['email'];
		$a = array('kod' => md5($email));
		$this->ci->Sql->sqlSave($a, 'leiratkozasok');
		$sql = "DELETE FROM hirlevel_feliratkozok WHERE email LIKE '$email' LIMIT 1";
		$this->ci->db->query($sql);
	}
	// új hírlevél feliratkozás hook
	function ujfeliratkozas_hook($adat) {
		$sql = "SELECT * FROM felhasznalok WHERE id = {$adat['felhasznalo_id']} LIMIT 1";
		$rs = $this->Sql->sqlSor($sql);
		
		if ($rs) {
			$sql = "SELECT id FROM hirlevel_feliratkozok WHERE email = '{$rs->email}' LIMIT 1";
			$feliratkozok_rs = $this->Sql->sqlSor($sql);
			if(!isset($feliratkozok_rs->id)){
				$this->emailfeliratkozas_hook(array('email' => $rs->email, 'nev' => $rs->vezeteknev.' '.$rs->keresztnev));
				return true;
			}
		} return false;
	} 
	function emailfeliratkozas_hook($adat){
		$email = $adat['email'];
		$nev = $adat['nev'];
		$a = array(
					'nev' => $nev,
					'email' => $email,
					'ellenorzokulcs' => md5(rand(100000,999999))
		);
		$this->Sql->sqlSave($a, 'hirlevel_feliratkozok', 'id');
		ws_autoload('hirlevel');
		$targy = rendszerUzenetTargy("regisztracios_megerosito");
		$uzenet = rendszerUzenet("regisztracios_megerosito");

		$level = new Levelkuldo_osztaly;
		$level->helyorzo('Teljes név', $a['nev']);
		$level->helyorzo('Email', $a['email']);
		$level->helyorzo('Aktivációs link', base_url().'aktivalas/'.$a['ellenorzokulcs']);
		$level->rendszerlevelKeszites($uzenet);
		
		$level->levelKuldes($a['email'], $targy);
	}
}
