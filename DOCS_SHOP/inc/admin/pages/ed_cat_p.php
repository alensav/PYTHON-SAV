<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/ed_cat');

$cat=intval($cat);

require_once(INC_DIR."/upload.php");
require_once(INC_DIR."/admin/ed_cat.php");
$ed_category=new ed_category;
$save_result=0;

 if(! empty($_POST['save'])){
  if($view==='makecat'){
  echo $ed_category->mk_newcategory();
   if($save_result==1){
   $view='movecat';
   }
  else{
  $row = $custom->stripslashes_array($_POST);
  }
  
  }
  elseif($view==='movecat'){
  echo $ed_category->move_category();
  }
 }
?>
<form name="frm" action="?" method="POST" enctype="multipart/form-data">
<?php echo "<input type=\"hidden\" name=\"view\" value=\"$view\">"; ?>
<input type="hidden" name="save" value="1">
<br><table width="100%" class="settbl">
<tr class="htr"><td>

<table width="100%"><tr class="htr"><td>
<?php
 if($view==='makecat'){
 echo "$lang[mk_category]";
 }
 elseif($view==='movecat'){
 require_once(INC_DIR."/admin/view_cat.php");
 $view_category=new view_category;
 $chain_chapter_title=$view_category->adm_chain_chapter_title($cat, ' / ');

  if(empty($_POST['save']) || $save_result==1){
  $tbl=DB_PREFIX.'categories';
  $res=$db->query("SELECT * FROM $tbl WHERE catid = '$cat'")or die($db->error());
  $row = $db->fetch_array($res);
  }
  else{
  $row=$custom->stripslashes_array($_POST);
  }

 echo "<input type=\"hidden\" name=\"cat\" value=\"$cat\">";
 echo "$lang[edit_cat] $chain_chapter_title[ch_title_link]<br>";
 echo "<a href=\"" . @stdi2("cat=$row[catid]", $custom->statlink($row['fcatname'], '', "cat$row[catid]/", 'c')) . "\" target=\"_blank\">($lang[view_in_public])</a>";
 }
?>
</td></tr></table>
</td></tr>
<tr class="str"><td>
<?php echo $lang['parent']; ?><br><select name="parent"><option value="0"><?php echo $lang['root_cat'];
require_once(INC_DIR."/admin/view_cat.php");
$view_category=new view_category;
$row['parent'] = isset($row['parent']) ? $row['parent'] : 0;
echo $view_category->get_chapters_list($row['parent']);
?>
</select>
<br><br></td></tr>

<tr class="ttr"><td>
<?php echo $lang['cat_title']; ?><br><input type="text" name="title" size="50" maxlength="255" value="<?php echo isset($row['title']) ? $row['title'] : ''; ?>"><br>
<input type="checkbox" name="duble_chtitle"<?php if(! empty($_POST['duble_chtitle'])){echo ' checked="checked"';} ?>> <?php echo $lang['allow_dupl_name']; ?><br><br>
</td></tr>

<tr class="str"><td>
<?php echo $lang['catname']; ?><br><input type="text" name="fcatname" size="50" maxlength="128" value="<?php $row['fcatname'] = isset($row['fcatname']) ? $row['fcatname'] : ''; echo $ed_category->catname_from_fullcatname($row['fcatname']); ?>"><br><br>
</td></tr>

<tr class="ttr"><td>
<?php echo $lang['sort_index']; ?><br><input type="text" name="sortid" size="10" value="<?php if(! isset($row['sortid']) || ! is_numeric($row['sortid'])){$row['sortid']=0;} echo $row['sortid']; ?>"><br>
</td></tr>

</table>
<br>
<table width="100%" class="settbl">
<tr class="htr"><td>
<?php echo $lang['optional_fields']; ?>
</td></tr>

<tr class="str"><td>
<?php echo $lang['category_description']; ?><br>
<textarea id="description" name="description" cols="39" rows="12"><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea><div id="auto_br_description"><input type="checkbox" name="auto_br_description"><?php echo $lang['auto_br']; ?></div><br>
</td></tr>

<tr class="ttr"><td>
<?php
 if(! empty($row['image'])){
 echo "<img src=\"$sett[relative_url]img/small/$row[image]\"><br><input type=\"checkbox\" name=\"delete_image\">$lang[delete_image]<br>";
 }
echo $lang['category_image'];
?>
&nbsp;<input type="file" name="image" class="InputFile"><br><br>
</td></tr>

<tr class="str"><td>
<?php
 if(! empty($row['menu_img'])){
 echo "<img src=\"$sett[relative_url]img/small/$row[menu_img]\"><br><input type=\"checkbox\" name=\"delete_menu_img\">$lang[delete_image]<br>";
 }
echo $lang['menu_img'];
?>
&nbsp;<input type="file" name="menu_img" class="InputFile"><br><br>
</td></tr>

<tr class="ttr"><td>
<?php
 if(! empty($row['main_img'])){
 echo "<img src=\"$sett[relative_url]img/small/$row[main_img]\"><br><input type=\"checkbox\" name=\"delete_main_img\">$lang[delete_image]<br>";
 }
echo $lang['main_img'];
?>
&nbsp;<input type="file" name="main_img" class="InputFile"><br><br>
</td></tr>

<tr class="str"><td>
<?php echo $lang['meta_title']; ?><br>
<input type="text" name="meta_title" value="<?php echo isset($row['meta_title']) ? $row['meta_title'] : ''; ?>" size="50" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="ttr"><td>
<?php echo $lang['meta_description']; ?><br>
<input type="text" name="meta_description" value="<?php echo isset($row['meta_description']) ? $row['meta_description'] : ''; ?>" size="50" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="str"><td>
<?php echo $lang['meta_keywords']; ?><br>
<input type="text" name="keywords" value="<?php echo isset($row['keywords']) ? $row['keywords'] : ''; ?>" size="50" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="ttr"><td>
<?php echo $lang['meta_tags']; ?><br>
<textarea name="metatags" cols="39" rows="4"><?php echo isset($row['metatags']) ? $row['metatags'] : ''; ?></textarea><br><br>
</td></tr>

<tr class="str"><td>
<?php echo $lang['banner_code']; ?><br>
<textarea name="special" cols="39" rows="8"><?php echo isset($row['special']) ? $row['special'] : ''; ?></textarea><br><input type="checkbox" name="auto_br_special"><?php echo $lang['auto_br']; ?><br><br>
</td></tr>
</table>
<br>

<input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"> &nbsp; <input type="reset" value="<?php echo $lang['reset']; ?>" class="button1">
</form>
<?php
if($admset['wysiwyg']){echo $editor->init_js(array('description'));}
?>