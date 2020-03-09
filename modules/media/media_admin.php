<?php
class Media_admin extends MY_Modul {
	function mediabongeszo() {
		$bDir = FCPATH.'assets/';
		$data = array();
		
		$utvonal = trim($this->ci->input->get('dir'),'/');
		$data['utvonal'] = $utvonal;
		
		if(isset($_FILES['file'])) {
			if(move_uploaded_file($_FILES['file']['tmp_name'], $bDir.$utvonal.'/'.$_FILES['file']['name'])) {
				globalisMemoria('adminUzenet', 'File mentése sikeres.');
			}
		}
		
		
		$data['bDir'] = $bDir;
		$data['files'] = scandir($bDir.$utvonal);
		return $this->ci->load->view(ADMINTEMA."html/mediabongeszo.php", $data, true);
	}
	function mediainfo() {
		$bDir = FCPATH.'assets/';
		$data = array();
		
		$utvonal = trim($this->ci->input->get('file'),'/');
		
		$filenev = basename($utvonal);
		$arr = explode('.', $filenev);
		$ext = strtolower(end($arr));
		
		$data['kep'] = true;
		
		if($ext=='jpg' OR $ext=='jpeg' OR $ext=='png' OR $ext=='gif') {
			$data['kep'] = true;
			
		}
		
		$data['utvonal'] = $utvonal;
		
		$data['bDir'] = $bDir;
		
		print $this->ci->load->view(ADMINTEMA."html/mediainfo.php", $data, true);
		exit;
	}
	function kepvago() {
		$kepadat = $_GET['file'];
		$bDir = FCPATH.'assets/';
		$kepDir = dirname('assets/'.$kepadat).'/';
		$data = array();
		$data['visszaUrl'] = ADMINURL.'media/mediabongeszo?dir=/'.dirname($kepadat);
		
		
		if(isset($_POST['kepeleres'])) {
			
				$kep = FCPATH.'assets/'.$kepadat;
				$kepMeret = getimagesize ($kep);
				$eredetiX = $kepMeret[0];
				$eredetiY = $kepMeret[1];
				
				$screenMeret = $_POST['owidth'];
				$szorzo = $eredetiX/$screenMeret;
				
				// vágás kezdőpontja
				
				$startX = $_POST['cropx'];
				$boxW = $_POST['cwidth'];
				$startY = $_POST['cropy'];
				$boxH = $_POST['cheight'];
				
				
				if($startX>$eredetiX) return;
				if($startY>$eredetiY) return;
				
				//Print ("szorzo ".$szorzo." startX ".$startX." startY ". $startY." boxW ".$boxW." boxH ".$boxH."<br>");
				
				if($startX < 0) {
					$boxW = $boxW+$startX;
					$startX = 0;
				}
				
				
				if($startY < 0) {
					
					$boxH = $boxH+$startY;
					$startY = 0;
				}
				if($boxW<0) return;
				if($boxH<0) return;
				
				//Print ("szorzo ".$szorzo." startX ".$startX." startY ". $startY." boxW ".$boxW." boxH ".$boxH."<br>");
				
				
				if($startX < 0)$startX = 0;
				$startX *= $szorzo;
				
				
				if($startY < 0) $startY = 0;
				$startY *= $szorzo;
				
				
				// doboz mérete
				$boxW = $_POST['cwidth'];
				$boxW *= $szorzo;
				if($startX+$boxW > $eredetiX ) $boxW = $eredetiX-$startX;
				
				
				$boxH *= $szorzo;
				if($startY+$boxH > $eredetiY ) $boxH = $eredetiY-$startY;
				
				
				
				
				$im = imagecreatefromstring(file_get_contents($kep));
				$cropPos = array('x' => $startX, 'y' => $startY, 'width' => $boxW, 'height' => $boxH);
				//print_r($cropPos);
				$im2 = imagecrop($im, $cropPos);
				if ($im2 !== false) {
					$newName = current(explode('.', basename($kep)));
					$newName .= 'vagott_x'.(int)$startX.'y'.(int)$startY.'w'.(int)$boxW.'h'.(int)$boxH.'.jpg';
					
					$path = $kepDir."/".$newName;
					
					
					
					if(imagejpeg($im2,FCPATH.$path )) {
						
						
						
					}
					
					
					
					imagedestroy($im2);
				}
				imagedestroy($im);
				
				
				
				
				
				redirect($data['visszaUrl']);
				exit;
		}
		
		
		
		
		if(!file_exists($bDir.$kepadat)) {
			redirect($data['visszaUrl']);
		}
		$data['kepeleres'] = base_url().'assets/'.$kepadat;
		
		print $this->ci->load->view(ADMINTEMA."html/media_kepvago.php", $data, true);
		exit;
	}
	
	function getMimeType($filename)
	{
		$mimetype = false;
		if(function_exists('finfo_open')) {
			// open with FileInfo
		} elseif(function_exists('getimagesize')) {
			// open with GD
		} elseif(function_exists('exif_imagetype')) {
		   // open with EXIF
		} elseif(function_exists('mime_content_type')) {
		   $mimetype = mime_content_type($filename);
		}
		return $mimetype;
	}	
} 
