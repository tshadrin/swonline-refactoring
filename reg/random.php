<?php
	session_start();
	image();
	exit();
	
	function image()
	{
	
		header("Content-type: image/png");
		//0 et o enlevees (possibilite de confusion) (seulement le minuscules)
		$key = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "u", "v",  "w",  "x",  "y", "z");
		$mot = "";
		for ($i=0; $i<5; $i++)
		{
		   $select = rand(1, 36);
		   $mot =  $mot."".$key[$select];
		}
		
		$_SESSION['kg_key'] = $mot;
		$size = 16;
		$marge = 15;
		$font = 'm.ttf';
		
		$matrix_blur = array(
			array(1,1,1),
			array(1,1,1),
			array(1,1,1));
			
		$box = imagettfbbox($size, 0, $font, $mot);
		//$largeur = $box[2] - $box[0];
		//$hauteur = $box[1] - $box[7];
		$largeur = 100;
		$hauteur = 15;
		$largeur_lettre = round($largeur/strlen($mot));
		
		$img = imagecreate($largeur+$marge, $hauteur+$marge);
		$blanc = imagecolorallocate($img, 255, 255, 255);
		$grey = imagecolorallocate($img, 128, 128, 128); 
		$noir = imagecolorallocate($img, 0, 0, 0);
		$blue = imagecolorallocate($img, 0, 0, 102);
		$bblue = imagecolorallocate($img, 0, 153, 204);
		$rand_bg = array($blanc, $grey, $noir, $blue, $bblue);
		
		imagefilledrectangle($img, 0, 0, $largeur+$marge, $hauteur+$marge, $rand_bg[rand(1, 5)]);
		$couleur = array(
			imagecolorallocate($img, 0x99, 0x00, 0x66),
			imagecolorallocate($img, 0xCC, 0x00, 0x00),
			imagecolorallocate($img, 0x00, 0x00, 0xCC),
			imagecolorallocate($img, 0x00, 0x00, 0xCC),
			imagecolorallocate($img, 0xBB, 0x88, 0x77));
	
		for($i = 0; $i < strlen($mot);++$i)
		{
			$l = $mot[$i];
			$angle = mt_rand(-35,35);
			imagettftext($img,mt_rand($size-7,$size),$angle,($i*$largeur_lettre)+$marge, $hauteur+mt_rand(0,$marge/2),$couleur[array_rand($couleur)], $font, $l);	
		}
		
		//imageline($img, 2,mt_rand(2,$hauteur), $largeur+$marge, mt_rand(2,$hauteur), $blanc);
		//imageline($img, 2,mt_rand(2,$hauteur), $largeur+$marge, mt_rand(2,$hauteur), $blanc);
		//imageconvolution($img, $matrix_blur,9,0);
		
		imagepng($img);
		imagedestroy($img);
	}
?>
