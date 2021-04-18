<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $custom, $lang;
$custom->get_lang('admin_lang/login'); ?>
<!DOCTYPE html><html><head>
<meta charset="<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['adm_title']; ?></title>
<link href="adm/admin2.css" rel="stylesheet" type="text/css">
</head><body>
<div class="header">
 <div class="heaBl">
  <div class="hdrLeft"><img src="adm/img/logo.gif" alt=""></div>
  <div class="hdrRight">
   <div class="hrightText"><b style="font-size:18px;"><?php echo $lang['admin_panel']; ?></b></div>
   </div>
 </div>
</div>

<form method="POST" action="?" style="margin-top:30px;margin-left:30px;">
<input type="hidden" name="enter" value="1">
<?php
$next_loc = '';
$pos = strpos($_SERVER['REQUEST_URI'], '?');
 if($pos !== false){
 $next_loc = substr($_SERVER['REQUEST_URI'], $pos + 1);
 }
 if($next_loc && strpos($next_loc, 'view=logout') === false){
 echo  '<input type="hidden" name="next_loc" value="' . urlencode($next_loc) . '">';
 }

$demo_login = '';
$demo_password = '';
 if(! empty($_GET['auto_demo_login'])){
 $demo_login = 'demo';
 $demo_password = 'demo';
 }

?>
<p class="red"><?php if($err_msg){echo $lang['err_msg'];} ?></p>
 <table>
  <tr><td><?php echo $lang['name']; ?> </td><td> &nbsp;<input type="text" name="admin_name" value="<?php echo $demo_login; ?>" style="width:140px;"></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  <tr><td><?php echo $lang['pass']; ?> </td><td> &nbsp;<input type="password" name="admin_password" value="<?php echo $demo_password; ?>" style="width:140px;"></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td><td style="text-align:center;"><input type="submit" value=" <?php echo $lang['enter']; ?> "></td></tr>
 </table>
</form>

<div class="footer">
 <div class="fooBl">
<?php if(file_exists(SCRIPT_DIR."/admin_copyright.php")){include(SCRIPT_DIR."/admin_copyright.php");} ?>
 </div>
</div>
</body></html>