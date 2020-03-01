<?php
session_start();
if ( !session_is_registered("player")) {exit();}
$img1_path = "pic/game/captcha/".$_SESSION['captcha_1'].".png";
$img2_path = "pic/game/captcha/".$_SESSION['captcha_2'].".png";
$img3_path = "pic/game/captcha/".$_SESSION['captcha_3'].".png";
$img4_path = "pic/game/captcha/texto.png";

list($img1_width, $img1_height) = getimagesize($img1_path);
list($img2_width, $img2_height) = getimagesize($img2_path);
list($img3_width, $img3_height) = getimagesize($img3_path);
list($img4_width, $img4_height) = getimagesize($img4_path);

$merged_width  = $img1_width + $img2_width + $img3_width;
//get highest
$merged_height = $img1_height > $img2_height ? $img1_height : $img2_height;

$merged_image = imagecreatetruecolor($merged_width, $merged_height);

imagealphablending($merged_image, false);
imagesavealpha($merged_image, true);

$img1 = imagecreatefrompng($img1_path);
$img2 = imagecreatefrompng($img2_path);
$img3 = imagecreatefrompng($img3_path);
$img4 = imagecreatefrompng($img4_path);

imagecopy($merged_image, $img1, 0, 0, 0, 0, $img1_width, $img1_height);
//place at right side of $img1
imagecopy($merged_image, $img2, $img1_width, 0, 0, 0, $img2_width, $img2_height);
imagecopy($merged_image, $img3, ($img1_width+$img2_width), 0, 0, 0, $img3_width, $img3_height);
imagefilter($merged_image, IMG_FILTER_GRAYSCALE);
imagealphablending($merged_image,true);

imagecopy($merged_image, $img4,0, 0, 0, 0, $img4_width, $img4_height);

header('Content-Type: image/png');
imagepng($merged_image);


//release memory
imagedestroy($merged_image);

?>