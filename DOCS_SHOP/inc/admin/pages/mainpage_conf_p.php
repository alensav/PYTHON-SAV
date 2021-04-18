<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<form name="frm" method="POST" action="?">
<input type="hidden" name="view" value="mainconf">
<input type="hidden" name="savesemainconf" value="1">
<?php
$custom->get_lang('admin_lang/mainpage_conf');
require_once(INC_DIR."/admin/mainpage_conf.php");
$mainconf=new mainconf;
 if(! empty($_POST['savesemainconf'])){
 echo $mainconf->save_mainconf();
 }
$main_settings=$mainconf->get_mainconf();
?>
<br><table class="settbl">

<tr class="htr"><td><?php echo $lang['mainpage_conf']; ?></td></tr>

<tr class="str"><td><?php echo $lang['main_title']; ?><br><input type="text" name="meta_title" value="<?php echo $main_settings['meta_title']; ?>" size="70"><br><br></td></tr>

<tr class="ttr"><td>
<?php echo $lang['meta_description']; ?><br>
<input type="text" name="meta_description" value="<?php echo $main_settings['meta_description']; ?>" size="70" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="str"><td>
<?php echo $lang['keywords']; ?><br>
<input type="text" name="keywords" value="<?php echo $main_settings['keywords']; ?>" size="70" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="ttr"><td><?php echo $lang['description']; ?><br>
<textarea id="description" name="description" cols="56" rows="30"><?php echo $main_settings['description']; ?></textarea><div id="auto_br_description"><input type="checkbox" name="auto_br_description"><?php echo $lang['auto_br']; ?></div></td></tr>

<tr class="str"><td><p style="margin:20px"><?php echo $lang['main_products_help']; ?></p></td></tr>

<tr class="ttr"><td><?php echo $lang['special']; ?><br>
<textarea id="special" name="special" cols="56" rows="30"><?php echo $main_settings['special']; ?></textarea><div id="auto_br_special"><input type="checkbox" name="auto_br_special"><?php echo $lang['auto_br']; ?></div><br></td></tr>

<tr class="str"><td><?php echo $lang['main_metatags']; ?><br><textarea name="metatags" cols="56" rows="4"><?php echo $main_settings['metatags']; ?></textarea><br><br></td></tr>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>
<?php if($admset['wysiwyg']){echo $editor->init_js(array('description','special'));} ?>