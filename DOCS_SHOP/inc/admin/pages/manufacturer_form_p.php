<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $delete_file_err;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $mnf_id = isset($_GET['mnf_id']) ? intval($_GET['mnf_id']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $mnf_id = intval($_POST['mnf_id']);
 }

$row = array();
 if($mnf_id){
 $row = get_manufacturer($mnf_id);
 }

 if(! empty($_POST['save'])){
 $save_result = save_manufacturer($mnf_id, $row);
  if($save_result==1){
  $row = get_manufacturer($_POST['mnf_id']);
  $act = 'edit';
  echo "<h3>$lang[changes_success]</h3>";
  }
  else{
  $_POST['image'] = isset($row['image']) ? $row['image'] : '';
  $row = $custom->stripslashes_array($_POST);
  echo "<font class=\"red\">$save_result</font>";
  }
 }

 if($delete_file_err){
 echo "<p><font class=\"red\">$delete_file_err</font></p>";
 }

?>
<form name="frm" action="?" method="POST" enctype="multipart/form-data">
<input type="hidden" name="view" value="manufacturers">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="mnf_id" value="<?php echo isset($row['mnf_id']) ? $row['mnf_id'] : 0; ?>">
<input type="hidden" name="save" value="1">
<table width="100%" class="settbl">
<tr class="htr"><td>
<?php
 if($act=='add'){
 echo "$lang[add_manufacturer]";
 }
 elseif($act=='edit'){
 echo "$lang[edit_manufacturer] &quot;<a href=\"" . @stdi2("view=manufacturers&amp;mnf=$row[mnf_id]", "manufacturers/$row[mnfname]/") . "\" target=\"_blank\">$row[title]</a>&quot;";
 }
?>
</td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['manufacturer_title']; ?><br><input type="text" name="title" size="46" maxlength="255" value="<?php echo isset($row['title']) ? $row['title'] : ''; ?>"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['mnfname']; ?><br><input type="text" name="mnfname" size="32" maxlength="255" value="<?php echo isset($row['mnfname']) ? $row['mnfname'] : ''; ?>"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['sort_index']; ?><br><input type="text" name="sortid" size="10" value="<?php if(! isset($row['sortid']) || ! is_numeric($row['sortid'])){$row['sortid']=0;} echo $row['sortid']; ?>"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['description']; ?><br>
<textarea id="description" name="description" cols="36" rows="12"><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea><div id="auto_br_description"><input type="checkbox" name="auto_br_description"><?php echo $lang['auto_br']; ?></div>
<br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<table cellspacing="0" cellpadding="0"><tr><td valign="bottom"><?php echo $lang['upload_image']; ?></td><td>&nbsp;</td><td><?php if(! empty($row['image'])){echo "<img src=\"$sett[relative_url]img/small/$row[image]\"><br><input type=\"checkbox\" name=\"delete_image\">$lang[delete_image]";} ?>&nbsp;</td></table>
<input type="file" name="upload_image" class="InputFile"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['manufacturer_url']; ?><br>
<input type="text" name="url" value="<?php echo isset($row['url']) ? $row['url'] : ''; ?>" size="46" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_title']; ?><br>
<input type="text" name="meta_title" value="<?php echo isset($row['meta_title']) ? $row['meta_title'] : ''; ?>" size="46" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_description']; ?><br>
<input type="text" name="meta_description" value="<?php echo isset($row['meta_description']) ? $row['meta_description'] : ''; ?>" size="46" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_keywords']; ?><br>
<input type="text" name="meta_keywords" value="<?php echo isset($row['meta_keywords']) ? $row['meta_keywords'] : ''; ?>" size="46" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_tags']; ?><br>
<textarea name="meta_tags" cols="36" rows="4"><?php echo isset($row['meta_tags']) ? $row['meta_tags'] : ''; ?></textarea><br><br>
</td></tr>

</table>
<br>

<input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"> &nbsp; <input type="reset" value="<?php echo $lang['reset']; ?>" class="button1">
</form>

<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=manufacturers"><?php echo $lang['all_manufacturers']; ?></a></p>

<?php
if($admset['wysiwyg']){echo $editor->init_js(array('description'));}
?>