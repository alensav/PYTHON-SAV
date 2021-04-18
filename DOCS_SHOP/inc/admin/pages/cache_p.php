<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<form name="frm" method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="cache">
<input type="hidden" name="save" value="1">
<?php
$custom->get_lang('admin_lang/cache');
 if(! empty($_POST['save'])){
 $_POST['new_sett']['period'] = str_replace(',', '.', $_POST['new_sett']['period']);
 $_POST['new_sett']['period'] = preg_replace('([^0-9\.])', '', $_POST['new_sett']['period']);
 $_POST['new_sett']['nocacheModules']=preg_replace('([^a-zA-Z0-9\,\_\-])', '', $_POST['new_sett']['nocacheModules']);
 echo $admin_lib->save_settings(7, $_POST['new_sett']);
 $cchset=$custom->get_settings(7);
 $admin_lib->save_settings(2, $_POST['new_sett_global']);
 $sett=$custom->get_settings(2);
  if(! empty($_POST['clear_cache'])){
  require_once(INC_DIR."/admin/cache_adm.php");
  $cache_adm=new cache_adm;
  $cache_adm->clear_cache();
  }
 }
 else{
 $cchset=$custom->get_settings(7);
 }
?>
<h3><?php echo $lang['cache']; ?></h3>

<p><?php echo $lang['cache_descript']; ?></p>

<table width="100%" class="settbl">
<tr class="htr"><td><?php echo $lang['description']; ?></td><td><?php echo $lang['value']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['cache_on']; ?></td><td><input type="radio" name="new_sett_global[cache]" value="1"<?php if($sett['cache']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett_global[cache]" value="0"<?php if(! $sett['cache']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['period']; ?></td><td><input type="text" name="new_sett[period]" value="<?php echo $cchset['period']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['nocacheAdmin']; ?></td><td><input type="radio" name="new_sett[nocacheAdmin]" value="1"<?php if($cchset['nocacheAdmin']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[nocacheAdmin]" value="0"<?php if(! $cchset['nocacheAdmin']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['nocacheModules']; ?></td><td><input type="text" name="new_sett[nocacheModules]" value="<?php echo $cchset['nocacheModules']; ?>" maxlength="255"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><input type="checkbox" name="clear_cache"><?php echo $lang['clear_cache']; ?></td><td></td></tr>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>