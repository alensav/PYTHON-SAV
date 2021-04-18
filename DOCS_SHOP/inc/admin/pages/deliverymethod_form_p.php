<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
  if(! isset($_GET['dmid'])){
  $_GET['dmid'] = 0;
  }
  if($_GET['dmid']){
  echo "<h3>$lang[editing_delivery_method]</h3>";
  }
  else{
  echo "<h3>$lang[adding_delivery_method]</h3>";
  }
 $dminfo = $delivery_methods->get_dminfo($_GET['dmid']);
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  if($_POST['save']){
  $save_code=$delivery_methods->save_dminfo();
   if($save_code === '1'){
   echo "<h3>$lang[changes_success]</h3>";
    if($_POST['dmid'] > 0){
    $dminfo=$delivery_methods->get_dminfo($_POST['dmid']);
    }
   }
   else{
   echo "<p class=\"red\">$save_code</p>";
   $dminfo=$custom->stripslashes_array($_POST);
   }
  }
 }

if($dminfo['dmid']){$act='edit';}
?>
<form name="frm" METHOD="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="delivery_methods">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="dmid" value="<?php echo $dminfo['dmid']; ?>">
<input type="hidden" name="save" value="<?php if($act=='edit'){echo 'edit';}else{echo 'add';} ?>">
<?php
echo <<<HTMLDATA
<table class="settbl" border="0">

<tr class="htr">
<td>&nbsp;</td>
</tr>

<tr class="str">
<td>
$lang[deliverymethod_name]<br>
<input type="text" name="dmname" value="$dminfo[dmname]"></td>
</tr>

<tr class="ttr">
<td>
$lang[short_descript]<br>
<textarea id="short_descript" name="short_descript" cols="36" rows="6">$dminfo[short_descript]</textarea>
<div id="auto_br_short_descript"><input type="checkbox" name="auto_br_short_descript">$lang[auto_br]</div>
<br>
</td>
</tr>

<tr class="str">
<td>
$lang[long_descript]<br>
<textarea id="long_descript" name="long_descript" cols="36" rows="12">$dminfo[long_descript]</textarea>
<div id="auto_br_long_descript"><input type="checkbox" name="auto_br_long_descript">$lang[auto_br]</div>
<br>
</td>
</tr>
HTMLDATA;

if(isset($_GET['act']) && $_GET['act'] == 'add_deliverymethod'){$dminfo['enabled']=1;}
?>

<tr class="ttr">
<td>
<?php echo $lang['delivery_cost'].' '.$lang['delivery_cost_explanation']; ?><br>
<input type="text" name="delivery_cost" value="<?php printf('%.2f', isset($dminfo['delivery_cost']) ? $dminfo['delivery_cost'] : '0'); ?>" maxlength="16"> <?php echo $sett['curr_brief']; ?></td>
</tr>

<tr class="str">
<td>
<?php echo $lang['free_delivery_sum'] . ' ' . custom::contextHelp($lang['free_delivery_sum_help']); ?><br>
<input type="text" name="free_delivery_sum" value="<?php printf('%.2f', isset($dminfo['free_delivery_sum']) ? $dminfo['free_delivery_sum'] : '0'); ?>" maxlength="16"> <?php echo $sett['curr_brief']; ?></td>
</tr>

<tr class="ttr">
<td>
<?php echo $lang['sort_index']; ?><br>
<input type="text" name="sortid" value="<?php echo isset($dminfo['sortid']) ? intval($dminfo['sortid']) : 0; ?>" size="10"></td>
</tr>

<tr class="str">
<td><?php echo $lang['dm_enabled_in_shop']; ?><br>
<input type="radio" name="enabled" value="1"<?php if($dminfo['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="enabled" value="0"<?php if(! $dminfo['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<?php
echo <<<HTMLDATA
<tr class="ftr"><td><br><input type="submit" value="$lang[submit]" class="button1"></td></tr>
</table><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=delivery_methods">$lang[all_delivery_methods]</a>
</form>
HTMLDATA;
if($admset['wysiwyg']){echo $editor->init_js(array('short_descript', 'long_descript'));}
?>