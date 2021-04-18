<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/editor');
?><!DOCTYPE html><html>
<head>
<meta charset="<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="adm/admin2.css" rel="stylesheet" type="text/css">
<title><?php echo $lang['images_mgr']; ?></title>
<style type="text/css">
body{
min-width: 300px;
margin: 0px;
padding: 0px;
font-size: 14px;
background: #ffffff;
}
table td{
font-size: 14px;
}
</style>
<script type="text/javascript">
function ch_preview(){
 if(document.getElementById('imgurl').value !== '' && document.getElementById('imgurl').value !== 'http://'){
 document.getElementById('preview').innerHTML='<img src="'+document.getElementById('imgurl').value+'" alt="" style="max-width:300px;max-height:300px;">';
 }
 else{
 document.getElementById('preview').innerHTML='';
 }
}
</script>
</head>
<body>
<div>
 <iframe name="browse_images" src="?view=editor&act=ed_img_list&independ=1" frameborder="1" style="display:inline-block;width:300px;height:300px;border:2px inset #eeeeee;"></iframe>
 <div id="preview" style="display:inline-block;width:300px;max-height:300px;vertical-align:top;"></div>
</div>
<?php
if(isset($_GET['editor']) && $_GET['editor'] == 1){ ?>
<div style="margin-left:6px;margin-right:6px;">
<input type="text" name="imgurl" id="imgurl" onchange="ch_preview();">
<button onclick="opener.winImgUrlCallback(document.getElementById('imgurl').value);self.close();return false;"><?php echo $lang['insert_image']; ?></button><br><br>
</div>
<?php
 }
 else{
 echo <<<HTMLDATA
<input type="hidden" name="imgurl" id="imgurl">
HTMLDATA;
 }
?>
</body></html>