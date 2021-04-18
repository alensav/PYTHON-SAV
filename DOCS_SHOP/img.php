<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
error_reporting(E_ALL & ~E_NOTICE);

 if(! extension_loaded('gd')){
 die('Unfortunately, on this server the "GD" library is not supported, which used for work with the images.<br>For the decision this problem, please, contact with support of Your hosting provider.<hr>');
 }





$fontfile = dirname(__FILE__) . '/futural.ttf';
@putenv('GDFONTPATH=' . realpath('.'));
$imgwidth = 150;
$imgheight = 45;
$im = imagecreate($imgwidth, $imgheight);
mt_srand((double) microtime() * 1000000);
$background_color = imagecolorallocate($im, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));

 for($i=0;$i<100;$i++){
 $color = imagecolorallocate($im, mt_rand(150,255), mt_rand(150,255), mt_rand(150,255));
 imagefilledellipse($im, mt_rand(1,$imgwidth-2), mt_rand(1,$imgheight-2), 2, 3, $color);
 }

$color = imagecolorallocate($im, 100, 100, 100);
imagerectangle($im, 0, 0, $imgwidth-1, $imgheight-1, $color);

$left = 8;

 if(function_exists('imagettftext') && file_exists($fontfile)){
 $gettftext_enabled = true;
 }
 else{
 $gettftext_enabled = false;
 }

$full_rndcode = '';

 for($i=0;$i<6;$i++){
 $fontsize = mt_rand(16,24);
 $slopping = mt_rand(-20,20);
 $top = mt_rand(26,38);
 $color = imagecolorallocate($im, mt_rand(0,160), mt_rand(0,160), mt_rand(0,160));

 $rndcode = 7;
  while($rndcode == 7){
  $rndcode = mt_rand(0,9);
  }

  if($gettftext_enabled){
  imagettftext($im, $fontsize, $slopping, $left, $top, $color, $fontfile, $rndcode);
  }
  else{
  imagestring($im, 5, $left, $top-14, $rndcode, $color);
  }

 $full_rndcode .= $rndcode;
 $left += $fontsize;
 }

@session_start();
if(! session_id()){@session_destroy(); exit;}
$_SESSION['arwshop_mk']['rnd_botcode']=$full_rndcode;

 if(function_exists('imagepng')){
 header("Content-type: image/x-png");
 imagepng($im);
 }
 elseif(function_exists('imagegif')){
 header("Content-type: image/gif");
 imagegif($im);
 }
 elseif(function_exists('imagejpeg')){
 header("Content-type: image/jpeg");
 imagejpeg($im);
 }
 else{
 echo 'The GD functions are absents: imagepng(); imagegif(); imagejpeg()<br>For the decision this problem, please, contact with support of Your hosting provider.<hr>';
 }

imagedestroy($im);


function domain_from_url($url){
$domain = ' '.strtolower(trim($url));
$domain = str_replace("\\", '/', $domain);
$pos = strpos($domain,'://');
if($pos>0){$domain = ' '.substr($domain,$pos+3);}
$pos = strpos($domain,'/');
if($pos>0){$domain = substr($domain,0,$pos);}
 if(substr($domain, 1, 4) == 'www.'){
  if(substr_count($domain, '.')>1){
  $domain = ' '.substr($domain, 5);
  }
 }
return substr($domain,1);
}
?>