<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/static_urls');
 if(! empty($_POST['savesettings'])){
 $_POST['new_sett']['vcatname'] = trim($_POST['new_sett']['vcatname']);
 $_POST['new_sett']['vcatname']=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\/\_\-])", '', $_POST['new_sett']['vcatname']);
 $_POST['new_sett']['vcatname']=mb_substr($_POST['new_sett']['vcatname'], 0, 64);
  if($_POST['new_sett']['vcatname'] && substr($_POST['new_sett']['vcatname'], strlen($_POST['new_sett']['vcatname'])-1)!=='/'){
  $_POST['new_sett']['vcatname'].='/';
  }
 echo $admin_lib->save_settings(2, $_POST['new_sett']);
 $sett=$custom->get_settings(2);
 }
?>
<!DOCTYPE html><html><head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['static_urls_settings']; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function chVcatDivs(){
 if(document.sufrm['new_sett[vcatname]'].value=='/'){
 document.sufrm['new_sett[vcatname]'].value='';
 }
 if(document.sufrm['new_sett[vcatname]'].value){
  if(document.sufrm['new_sett[vcatname]'].value.substring(document.sufrm['new_sett[vcatname]'].value.length-1)!='/'){
  document.sufrm['new_sett[vcatname]'].value+='/';
  }
 }
var vcn=document.sufrm['new_sett[vcatname]'].value;
vcn1.innerHTML=vcn;
vcn2.innerHTML=vcn;
vpn1.innerHTML=vcn;
vpn2.innerHTML=vcn;
vpn3.innerHTML=vcn;
}
</script>
</head><body>
<?php
$err='';
 if(! $sett['static_urls']){
 $err=$lang['static_disabled'];
 }
 elseif($sett['old_static']){
 $err=$lang['old_static_enabled'];
 }
 if($err){
 echo "<h5>$err</h5></body></html>";
 exit;
 }
?>
<form name="sufrm" method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="static_urls">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="savesettings" value="1">
<table width="100%" class="settbl">

<tr class="htr"><td colspan="2"><?php echo $lang['static_urls_settings']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['vcatname']; ?></td><td><?php echo $sett['url']; ?><input type="text" name="new_sett[vcatname]" value="<?php echo $sett['vcatname']; ?>" size="20" maxlength="64" onchange="chVcatDivs();" onkeydown="if(window.event.keyCode==13){chVcatDivs();}"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['lctype']; ?></td><td>
<input type="radio" name="new_sett[lctype]" value="0"<?php if(! $sett['lctype']){echo ' checked';} ?>> <?php echo $sett['relative_url']; ?><span id="vcn1"><?php echo $sett['vcatname']; ?></span><?php echo $lang['category_name']; ?>/<?php echo $lang['subcategory_name']; ?>/<br>
<input type="radio" name="new_sett[lctype]" value="1"<?php if($sett['lctype']==1){echo ' checked';} ?>>
<?php echo $sett['relative_url']; ?><span id="vcn2"><?php echo $sett['vcatname']; ?></span><?php echo $lang['subcategory_name']; ?>/
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['lptype']; ?></td><td>
<input type="radio" name="new_sett[lptype]" value="0"<?php if(! $sett['lptype']){echo ' checked';} ?>> <?php echo $sett['relative_url']; ?><span id="vpn1"><?php echo $sett['vcatname']; ?></span><?php echo $lang['category_name']; ?>/<?php echo $lang['subcategory_name']; ?>/<?php echo $lang['product_name']; ?>.html<br>
<input type="radio" name="new_sett[lptype]" value="1"<?php if($sett['lptype']==1){echo ' checked';} ?>>
<?php echo $sett['relative_url']; ?><span id="vpn2"><?php echo $sett['vcatname']; ?></span><?php echo $lang['subcategory_name']; ?>/<?php echo $lang['product_name']; ?>.html<br>
<input type="radio" name="new_sett[lptype]" value="2"<?php if($sett['lptype']==2){echo ' checked';} ?>>
<?php echo $sett['relative_url']; ?><span id="vpn3"><?php echo $sett['vcatname']; ?></span><?php echo $lang['product_name']; ?>.html
</td></tr>

</table>
<br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1">
</form>
</body></html>