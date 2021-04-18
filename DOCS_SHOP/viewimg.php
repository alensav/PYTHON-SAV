<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
error_reporting(E_ALL & ~E_NOTICE);
$img = '';
 if(isset($_GET['img'])){
 $img = preg_replace('/[^a-zA-Z0-9\/\:\.\~\_\-]/', '', $_GET['img']);
 }
$img = preg_replace('/http(s){0,1}\:\/\/[a-z0-9\.\-]+\//i', 'http$1://'.$_SERVER['HTTP_HOST'].'/', $img);
$test_img = preg_replace('/http(s){0,1}\:\/\/[a-z0-9\.\-]+\//', '/', $img);
$test_img = substr($test_img, 1);
 if(! is_file($test_img)){
 header('HTTP/1.1 404 Not Found');
 echo '404 Not Found';
 exit;
 }
?><!DOCTYPE html>
<html><head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Image</title>
<script type="text/javascript">
var resizeCount=0;
function w_resize(){
 if(resizeCount>=3){
 return;
 }
 try{
 var widthplus=37;
 var heightplus=98;
 var imgwidth=document.getElementById('image').width;
 var imgheight=document.getElementById('image').height;
  if(imgwidth<300 && imgheight<300){
  imgwidth=300;
  imgheight=300;
  }
  else{
   if(imgwidth>screen.width){
   imgwidth=screen.width-widthplus;
   }
   if(imgheight>screen.height){
   imgheight=screen.height-heightplus;
   }
  }
 window.resizeTo(imgwidth+widthplus,imgheight+heightplus);
 window.moveTo(screen.width/2-document.body.clientWidth/2,screen.height/2-document.body.clientHeight/2);
 setTimeout('w_resize();',100);
 resizeCount++;
 }
 catch(e){}
}
window.onkeyup=function(){if(window.event.keyCode==27){self.close();}};
</script>
</head>
<body style="margin:0px;padding:0px;" onload="w_resize();">
<img name="image" id="image" alt="Image" src="<?php echo $img; ?>" onload="w_resize();">
</body>
</html>