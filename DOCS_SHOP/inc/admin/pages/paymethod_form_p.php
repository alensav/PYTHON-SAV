<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

$pminfo=array();

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
  if(! isset($_GET['pmid'])){
  $_GET['pmid'] = 0;
  }
  if($_GET['pmid']){
  echo "<h3>$lang[editing_pay_method]</h3>";
  }
  else{
  echo "<h3>$lang[adding_pay_method]</h3>";
  }
 $pminfo = $pay_methods->get_pminfo($_GET['pmid']);
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  if($_POST['save']){
   $save_code=$pay_methods->save_pminfo();
   if($save_code==1){
   echo "<h3>$lang[changes_success]</h3>";
   $pminfo=$pay_methods->get_pminfo($_POST['pmid']);
   }
   else{
   echo "<p class=\"red\">$save_code</p>";
   $pminfo=$custom->stripslashes_array($_POST);
   }
  }
 }

if($pminfo['pmid']){$act='edit';}
?>
<form name="frm" METHOD="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="pay_methods">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="pmid" value="<?php echo $pminfo['pmid']; ?>">
<input type="hidden" name="save" value="<?php if($act=='edit'){echo 'edit';}else{echo 'add';} ?>">
<?php

 if($pminfo['advname'] && $admin_lib->is_valid_pmmod_name($pminfo['advname']) && is_file(PM_MODULES_DIR."/$pminfo[advname]/admin/pm_module.php")){
 echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?pmmod=$pminfo[advname]&act=settings&pmid=$pminfo[pmid]\">$lang[advanced_settings]</a></p>";
 }

echo <<<HTMLDATA
<table class="settbl" border="0">

<tr class="htr">
<td>&nbsp;</td>
</tr>

<tr class="str">
<td>$lang[paymethod_name]<br><input type="text" name="pmtitle" value="$pminfo[pmtitle]"></td>
</tr>

<tr class="ttr">
<td>
$lang[short_descript]<br>
<textarea id="short_descript" name="short_descript" cols="36" rows="5">$pminfo[short_descript]</textarea><div id="auto_br_short_descript"><input type="checkbox" name="auto_br_short_descript">$lang[auto_br]</div><br>
</td>
</tr>

<tr class="str">
<td>
$lang[long_descript]<br>
<textarea id="long_descript" name="long_descript" cols="36" rows="12">$pminfo[long_descript]</textarea><div id="auto_br_long_descript"><input type="checkbox" name="auto_br_long_descript">$lang[auto_br]</div><br>
</td>
</tr>

<tr class="ttr">
<td>
$lang[adv_descript]<br><span style="font-size:11px">($lang[adv_descript_info])</span><br>
<textarea id="adv_descript" name="adv_descript" cols="36" rows="12">$pminfo[adv_descript]</textarea><div id="auto_br_adv_descript"><input type="checkbox" name="auto_br_adv_descript">$lang[auto_br]</div><br>
</td>
</tr>

<tr class="str">
<td>
$lang[adv_descript_mail]<br><span style="font-size:11px">($lang[adv_descript_mail_info])</span><br>
<textarea name="adv_descript_mail" cols="36" rows="12">$pminfo[adv_descript_mail]</textarea>
</td>
</tr>
HTMLDATA;
?>

<tr class="ttr">
<td>
<span style="font-size:11px"><?php echo $lang['paymethod_currencies']; ?></span><br>
<select name="paymethod_currencies[]" size="10" multiple>
<?php echo $pay_methods->get_available_currencies_list($pminfo['pmid']); ?>
</select> <span style="cursor:hand" onclick="for(i=0;i<document['frm']['paymethod_currencies[]'].length;i++){document['frm']['paymethod_currencies[]'][i].selected=true;}"><u><?php echo $lang['select_all']; ?></u></span>
</td>
</tr>

<tr class="str">
<td>
<span style="font-size:11px"><?php echo $lang['paymethod_deliverymethods']; ?></span><br>
<select name="paymethod_deliverymethods[]" size="10" multiple>
<?php echo $pay_methods->get_available_deliverymethods_list($pminfo['pmid']); ?>
</select> <span style="cursor:hand" onclick="for(i=0;i<document['frm']['paymethod_deliverymethods[]'].length;i++){document['frm']['paymethod_deliverymethods[]'][i].selected=true;}"><u><?php echo $lang['select_all']; ?></u></span>
</td>
</tr>

<?php if(isset($_GET['act']) && $_GET['act'] == 'add_paymethod'){$pminfo['enabled'] = 1;} ?>

<td class="ttr"><?php echo $lang['sort_index']; ?><br>
<input type="text" name="sortid" value="<?php echo isset($pminfo['sortid']) ? intval($pminfo['sortid']) : 0; ?>" size="10"></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td>
<?php echo $lang['pm_enabled_in_shop']; ?><br>
<input type="radio" name="enabled" value="1"<?php if($pminfo['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="enabled" value="0"<?php if(! $pminfo['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<?php
 if(! isset($pminfo['advname'])){
 $pminfo['advname'] = '';
 }
$pm_modules_select = pm_modules_select($pminfo['advname']);
 if($pm_modules_select){
 echo '<tr class="'.$admin_lib->sett_class()."\"><td>$lang[use_module]<br>$pm_modules_select</td></tr>";
 }
?>

<?php
echo <<<HTMLDATA
<tr class="ftr"><td><br><input type="submit" value="$lang[submit]" class="button1"></td></tr>
</table><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=pay_methods">$lang[all_pay_methods]</a>
</form>
HTMLDATA;
if($admset['wysiwyg']){echo $editor->init_js(array('short_descript', 'long_descript', 'adv_descript'));}
?>