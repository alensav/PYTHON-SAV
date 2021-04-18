<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/editor');
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
require_once(INC_DIR."/admin/ed_images.php");
$ed_images = new ed_images;
require_once(INC_DIR."/upload.php");
$upload = new upload;
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $dir = isset($_GET['dir']) ? preg_replace("([^a-zA-Z0-9\/\~\_\-])", '', $_GET['dir']) : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $dir = preg_replace("([^a-zA-Z0-9\/\~\_\-])", '', $_POST['dir']);
 }
$dirname = $dir;
if(! $dirname){$dirname='img';}

 if($dir){
 $imgbase = "$sett[relative_url]img/$dir/";
 }
 else{
 $imgbase = "$sett[relative_url]img/";
 }
?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" CONTENT="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['browse_images']; ?></title>
<style type="text/css">
body{margin: 0px; background: #ffffff;}
.htr{background-color: #c8d8e6; color:#133f66; font-size:12px; font-weight:bold;}
.str{background-color: #ffffff;}
.ttr{background-color: #f4f4f7;}
.InputFileSm{
border-right: #c8d8e6 1px solid; border-top: #c8d8e6 1px solid; font-size: 10px; border-left: #c8d8e6 1px solid; border-bottom: #c8d8e6 1px solid; font-family: Verdana, Geneva, Arial;
}
</style>
<script type="text/javascript">
var imgbase='<?php echo $imgbase; ?>';
function sel_file(fname){
parent.document.getElementById('imgurl').value=imgbase+fname;
parent.ch_preview();
return false;
}
</script>
</head>
<body>
<form action="?" method="POST" enctype="multipart/form-data">
<input type="hidden" name="view" value="editor">
<input type="hidden" name="act" value="ed_img_list">
<input type="hidden" name="dir" value="<?php echo $dir; ?>">
<input type="hidden" name="upload_img" value="1">
<input type="hidden" name="independ" value="1">
&nbsp;<?php echo $lang['upload_new_img']; ?><br><input type="file" name="new_img" class="InputFileSm"><br><input type="submit" value="<?php echo $lang['upload']; ?>" class="InputFileSm"><hr>
<?php
require(INC_DIR."/img_types.php");
$dirname = $ed_images->filter_dirname($dirname);

 if(! empty($_POST['upload_img'])){
 echo $ed_images->upload_image($dirname);
 }

echo $ed_images->images_list($dirname);
?>
</form>
</body>
</html>