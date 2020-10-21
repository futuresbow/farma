<?php


class Levelkuldo_osztaly extends MY_Model  {

	

	public $data = array();

	public $level = '';
	public $mail = '';

	

	function __construct() {

		$this->data['Oldal URL'] = base_url();
                
                $ci = getCI();
                $ci->load->library('email');

                $mail = $ci->email;
                
                $config['charset'] = 'utf-8';
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = beallitasOlvasas('SMTP_host');
                $config['smtp_user'] = beallitasOlvasas('SMTP_user');
                $config['smtp_pass'] = beallitasOlvasas('SMTP_password');
                $config['smtp_port'] = beallitasOlvasas('SMTP_port');
                $config['smtp_crypto'] = beallitasOlvasas('SMTP_secure');
                $config['mailtype'] = "html";
                
                $mail->initialize($config);
                
                $this->mail = $mail;
                
		/*
                 * PHPMAILER
                 require_once(APPPATH."third_party/PHPMailer-master/src/PHPMailer.php");
                 

		require_once(APPPATH."third_party/PHPMailer-master/src/SMTP.php");

		require_once(APPPATH."third_party/PHPMailer-master/src/Exception.php");

  

		$mail = new PHPMailer\PHPMailer\PHPMailer();

		$mail->IsSMTP(); // enable SMTP

	

		$mail->SMTPDebug = beallitasOlvasas('smptp_debug')=='1'?1:0; // debugging: 1 = errors and messages, 2 = messages only

		$mail->SMTPAuth = true; // authentication enabled

		$mail->SMTPSecure = beallitasOlvasas('SMTP_secure'); //'ssl'  // secure transfer enabled REQUIRED for Gmail

		$mail->Host = beallitasOlvasas('SMTP_host');

		$mail->Port = beallitasOlvasas('SMTP_port'); // or 587

		$mail->IsHTML(true);

		

		$mail->Username = beallitasOlvasas('SMTP_user');

		$mail->Password = beallitasOlvasas('SMTP_password');

		$mail->SetFrom( beallitasOlvasas('Mail_sender_email'));
		$this->mail = $mail;
                 * 
                 */
	}

	function helyorzo($kulcs , $ertek) {

		$this->data[$kulcs] = $ertek;

	} 

	

	function helyorzok($data) {

		foreach($data as $kulcs => $ertek) {

			$this->data[$kulcs] = $ertek;

		}

	} 

	public function rendszerlevelKeszites($uzenet) {

		$level = file_get_contents(FCPATH.'assets/email/index.html');

		

		$this->helyorzo('Levél tartalom',  $this->helyorzoCsere($uzenet));

		$level = $this->helyorzoCsere($level);

		

		preg_match_all('/<img[^>]+>/i', $level, $images);

		foreach ($images[0] as $image) {

			preg_match('/src="([^"]+)"/i', $level, $srcs);

			if(strpos($srcs[1], 'http')===false) {

				$level = str_replace ($srcs[0], 'src="'.base_url().'assets/email/'.$srcs[1].'"', $level);

			}

		}

		

		file_put_contents(FCPATH.'assets/email/preview.html', $level);

		$this->level = $level;

		return $level;

	}

	public function hirleveleloKeszites($id) {

		include_once(ROOTPATH.'modules/termek/autoload.php');

		

		$this->hirlevelSor = $sor = $this->get($id, 'hirlevelek', 'id');

		$level = file_get_contents(FCPATH.'assets/email/index.html');

		

		if($sor->termeklista!='') {

			$tlista = explode(',', trim($sor->termeklista,','));

			$idLista = array();

			foreach($tlista as  $id)  {

				if(trim($id)!='') $idLista[] = (int)$id;

			}

			$termekek = '';

			ob_start();

			include(FCPATH.'assets/email/termekek.php');

			$termekek = ob_get_contents();

			ob_end_clean();

			$this->helyorzo('Terméklista',$termekek);

			

		}


		$this->helyorzo('Levél tartalom', $this->helyorzoCsere($sor->tartalom));

		$level = $this->helyorzoCsere($level);

		

		

		

		preg_match_all('/<img[^>]+>/i', $level, $images);

		foreach ($images[0] as $image) {

			preg_match('/src="([^"]+)"/i', $level, $srcs);

			if(strpos($srcs[1], 'http')===false) {

				$level = str_replace ($srcs[0], 'src="'.base_url().'assets/email/'.$srcs[1].'"', $level);

			}

		}

		

		file_put_contents(FCPATH.'assets/email/preview.html', $level);

		$this->level = $level;

		return $level;

	}

	function helyorzoCsere($str) {

		

		preg_match_all("#\{\{(.*?)\}\}#", $str, $helyorzok);

		
		$feltetelek = array();

		if(!empty($helyorzok)) {

			foreach($helyorzok[1] as $k => $elem) {

				

				if(strpos($elem, 'IF#')!==false) {

					$feltetelek[] = $elem;

					$feltetelekMit[] = $helyorzok[0][$k];

					continue;

				}

				

				$csere = trim($elem);

				$mit = trim($helyorzok[0][$k]);
				//print $mit .' -> '.@$this->data[$csere].' '.$csere.'<br>';
				$str = str_replace($mit, @$this->data[$csere], $str);

			}

		}

		//exit;

		if(!empty($feltetelek)) {

			foreach($feltetelek as $k => $sor) {

				if(strpos($sor, 'ENDIF#')===false) {

					$csere = str_replace('IF#', '', $sor);

					if(isset($this->data[trim($csere)])) {

						// létező változó, benn marad a blokk

						$str = str_replace($feltetelekMit[$k], '', $str);

					} else {

						$csere = $feltetelekMit[$k];

						$csere = str_replace('IF#', 'ENDIF#', $csere );

						

						$marad = '';

						$marad = substr($str,0, strpos($str, $feltetelekMit[$k]));

						$marad .= substr($str, strpos($str, $csere) + strlen($csere)  );

						

					}

					

			

				} else {

					// blokkvég, csak töröljük

					$str = str_replace($feltetelekMit[$k], '', $str);

				}

			}

			

		}

		

		return $str;

		

	} 

	function hirlevelKuldes($cimek) {

		$sor = $this->hirlevelSor;

		$level = $this->level;

		$mail = $this->mail;

		$mail->subject = $this->helyorzoCsere($sor->targy); 

		

		// képek beillesztése

		/* $mail->AddEmbeddedImage('img/2u_cs_mini.jpg', 'logo_2u'); and on the <img> tag put src='cid:logo_2u'

		

		

		preg_match_all('/<img[^>]+>/i', $level, $images);

		

		foreach ($images[0] as $ix => $image) {

			preg_match('/src="([^"]+)"/i', $level, $srcs);

			if(strpos($srcs[1], 'http')!==false) {

				$mail->AddEmbeddedImage(file_get_contents($srcs[1]), 'cidindex_'.$ix);

				$level = str_replace ($srcs[1], 'cid:cidindex_'.$ix, $level);

			}

		}

		print $level;

		exit;

		*/

		$mail->message = $level;

		$cimek = explode(',',$cimek);

		

		foreach($cimek as $cim) {

			$cim = trim($cim) ;

			if($cim) {

				$mail->to($cim);

			}

		}

		

		 if(!$mail->send()) {

			echo "Mailer Error: " . $mail->ErrorInfo;

		 } else {

			//echo "Message has been sent";

		 }

	}

	

	

	function levelKuldes($cimekStr, $targy) {

		

		$level = $this->level;

		

		$mail = $this->mail;

		$mail->subject = $this->helyorzoCsere($targy); 

		

		// képek beillesztése

		/* $mail->AddEmbeddedImage('img/2u_cs_mini.jpg', 'logo_2u'); and on the <img> tag put src='cid:logo_2u'

		

		

		preg_match_all('/<img[^>]+>/i', $level, $images);

		

		foreach ($images[0] as $ix => $image) {

			preg_match('/src="([^"]+)"/i', $level, $srcs);

			if(strpos($srcs[1], 'http')!==false) {

				$mail->AddEmbeddedImage(file_get_contents($srcs[1]), 'cidindex_'.$ix);

				$level = str_replace ($srcs[1], 'cid:cidindex_'.$ix, $level);

			}

		}

		print $level;

		exit;

		*/
                $mail->clear(true);
                $mail->from("send@alkotlak.hu");
		$mail->message = $level;
		
		
		$cimek = explode(',',$cimekStr);

		
		foreach($cimek as $cim) {

			$cim = trim($cim) ;

			if($cim) {

				$mail->cc($cim);

			}

		}
		$ci = getCI();
                
                $mappa = 'data/levelek/'.date('Y-m');
                if(!is_dir(ROOTPATH.$mappa)) mkdir (ROOTPATH.$mappa,0777);
                
                $levelNev = $mappa.'/rendelesStatus_'.date('YmdHi').'_'.rand(100,999).'.html';
                
                file_put_contents(ROOTPATH.$levelNev, $level);
                chmod(ROOTPATH.$levelNev,0777);
                
                $a = array('level' => $levelNev, 'cimek' => $cimekStr, 'targy' => $targy);

		 if(!$mail->send()) {
			 $a['sikeres'] = 0;
			$a['hiba'] =  ( "Mailer Error! ".$mail->print_debugger());

			$ci->Sql->sqlSave($a, DBP.'levelezes','id');
			return false;
			
		 } else {
			$a['sikeres'] = 1;
			$a['hiba'] =  ( "Sikeres levél ".$mail->print_debugger());

                        $ci->Sql->sqlSave($a, DBP.'levelezes','id');
			
			//echo "Message has been sent";
			return true;
		 }

	}

}

