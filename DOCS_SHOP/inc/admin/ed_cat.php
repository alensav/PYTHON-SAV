<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class ed_category{

function mk_newcategory(){
global $admin_lib, $db, $admin, $lang, $save_result, $cat;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

require_once(INC_DIR.'/admin/chpu.php');

$tbl=DB_PREFIX.'categories';

$_POST['parent']=intval($_POST['parent']);
$_POST['title']=$admin_lib->replace_quotes(trim($_POST['title']));

if(! $_POST['title']){return "<font class=\"red\">$lang[enter_cattitle]</font>";}

 if(empty($_POST['duble_chtitle'])){
 $res=$db->query("SELECT catid FROM $tbl WHERE title = '".$db->secstr($_POST['title'])."'") or die($db->error());
 $row=$db->fetch_array($res);
  if($row['catid']){
  return "<font class=\"red\">$lang[category] \"" . stripslashes($_POST['title']) . "\" $lang[already_exist]</font>";
  }
 }

 if($_POST['parent'] != 0){
 $res=$db->query("SELECT catid from $tbl WHERE catid = $_POST[parent]") or 	die($db->error());
 if($db->num_rows($res)<1){return "<font class=\"red\">$lang[category] '$_POST[parent]' $lang[not_found]</font>";}
 }



 if(TDTC == 1){
 $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
  if($db->result($res,0,0) >= 30 + 1){
  return mdmogrn("$lang[156] 30 $lang[169]");
  }
 }

$_POST['meta_description']=str_replace('"', '&quot;', trim($_POST['meta_description']));
$_POST['keywords']=str_replace('"', '&quot;', trim($_POST['keywords']));

$chapter_id=0;
$query=$db->query("SELECT catid from $tbl ORDER BY catid")or die($db->error());
 while($row=$db->fetch_array($query)){
 if($row['catid'] > ($chapter_id +1)){break;}
 $chapter_id = $row['catid'];
 }
$chapter_id++;

$_POST['fcatname'] = trim($_POST['fcatname']);
$_POST['fcatname'] = chpu::autoName($_POST['fcatname'], $_POST['title'], $chapter_id, false);
$_POST['fcatname'] = $db->secstr($_POST['fcatname']);
$_POST['fcatname'] = $db->cutstr($_POST['fcatname'], 128);
 if($_POST['fcatname']){
 $res = $db->query("SELECT `fcatname` FROM `$tbl`") or die($db->error());
  while($row=$db->fetch_array($res)){
  $row['fcatname']=$this->catname_from_fullcatname($row['fcatname']);
   if(mb_strtolower($_POST['fcatname'])===mb_strtolower($row['fcatname'])){
   return "<font class=\"red\">$lang[link_name] \"$_POST[fcatname]\" $lang[used_in_parent]!</font>";
   }
  }
 }

 if(! $_POST['fcatname']){
 $_POST['fcatname']="$chapter_id";
 }

$chapter_path=$this->get_chapter_path($_POST['parent']);
if($chapter_path['fulltitle']){$chapter_path['fulltitle'].=' / ';}
$chapter_path['fulltitle'].=$_POST['title'];
if($chapter_path['fullcatname']){$chapter_path['fullcatname'].='/'.$_POST['fcatname'];}else{$chapter_path['fullcatname']=$_POST['fcatname'];}

$_POST['sortid']=intval($_POST['sortid']);

 if(! empty($_POST['auto_br_special'])){
 $_POST['special'] = nl2br($_POST['special'], false);
 }

$_POST['title'] = $db->cutstr($_POST['title'], 255);
$_POST['description'] = $db->cutstr($_POST['description'], 16777215, true);

 if(! empty($_POST['auto_br_description'])){
 $_POST['description'] = nl2br($_POST['description'], false);
 }

$_POST['meta_title'] = $db->cutstr($_POST['meta_title'], 255);
$_POST['keywords'] = $db->cutstr($_POST['keywords'], 255);
$_POST['metatags'] = $db->cutstr($_POST['metatags'], 65535, true);
$_POST['special'] = $db->cutstr($_POST['special'], 16777215, true);

$upload_image_res = $this->upload_category_image('image', array(), 0);
$upload_menu_img_res = $this->upload_category_image('menu_img', array(), 0);
$upload_main_img_res = $this->upload_category_image('main_img', array(), 0);

$result=$db->query("INSERT INTO $tbl(catid, fcatname, parent, title, description, image, menu_img, main_img, count, meta_title, meta_description, keywords, metatags, special, fulltitle, sortid) VALUES ($chapter_id, '$chapter_path[fullcatname]', $_POST[parent], '$_POST[title]', '$_POST[description]', '$upload_image_res[image]', '$upload_menu_img_res[menu_img]', '$upload_main_img_res[main_img]', 0, '$_POST[meta_title]', '$_POST[meta_description]', '$_POST[keywords]', '$_POST[metatags]', '$_POST[special]', '$chapter_path[fulltitle]', '$_POST[sortid]')") or die($db->error());

$cat=$chapter_id;

$save_result=1;

return "<h4>$lang[success_created_cat]: &quot;" . stripslashes($chapter_path['fulltitle']) . "&quot;</h4>";
}


function get_chapter_path($def_cat, $delimiter=' / '){
global $db;
$def_cat=intval($def_cat);
$tbl=DB_PREFIX.'categories';
$row=Array();
$row['parent']=$def_cat;
$slash = '';
$slash2 = '';
$ch_title = '';
$fullcatname = '';
 while($row['parent'] != 0){
 $query=$db->query("SELECT fcatname, parent, title from $tbl WHERE catid = $row[parent]") or die($db->error());
 $row=$db->fetch_array($query);
 $ch_title=$row['title'].$slash.$ch_title;
 $fullcatname = $this->catname_from_fullcatname($row['fcatname']).$slash2.$fullcatname;
 $slash=$delimiter;
 $slash2='/';
 }
$ret=array();
$ret['fulltitle']=trim($ch_title);
$ret['fullcatname']=$fullcatname;
$ret['ch_title']=$ch_title;


return $ret;
}


function move_category(){
global $admin_lib, $cat, $db, $lang, $save_result;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

require_once(INC_DIR.'/admin/chpu.php');

$cat=intval($cat);

$_POST['parent']=intval($_POST['parent']);
$_POST['title']=$admin_lib->replace_quotes(trim($_POST['title']));

if(! $cat){return "<font class=\"red\">$lang[invalid_catid]</font>";}

$tbl=DB_PREFIX.'categories';

$_POST['fcatname']=trim($_POST['fcatname']);
$_POST['fcatname'] = chpu::autoName($_POST['fcatname'], $_POST['title'], $cat, false);
$_POST['fcatname'] = $db->secstr($_POST['fcatname']);
$_POST['fcatname'] = $db->cutstr($_POST['fcatname'], 128);
 if($_POST['fcatname']){
 $res = $db->query("SELECT fcatname FROM $tbl WHERE catid <> $cat") or die($db->error());
  while($row=$db->fetch_array($res)){
  $row['fcatname']=$this->catname_from_fullcatname($row['fcatname']);
   if(mb_strtolower($_POST['fcatname'])===mb_strtolower($row['fcatname'])){
   return "<font class=\"red\">$lang[link_name] \"$_POST[fcatname]\" $lang[used_in_parent]!</font>";
   }
  }
 }
 else{
 $_POST['fcatname']="$cat";
 }

$_POST['title']=trim($_POST['title']);
if(! $_POST['title']){return "<font class=\"red\">$lang[enter_cattitle]</font>";}
if($cat==$_POST['parent']){return "<font class=\"red\">$lang[itself_parent]</font>";}

if($this->is_child($cat, $_POST['parent'])){return "<font class=\"red\">$lang[moving_cat_daughter]</font>";}

 if(empty($_POST['duble_chtitle'])){
 $query=$db->query("SELECT COUNT(*) FROM $tbl WHERE title = '".$db->secstr($_POST['title'])."' AND catid <> $cat")or die($db->error());
  if($db->result($query,0,0)>0){
  return "<font class=\"red\">$lang[category] '$_POST[title]' $lang[already_exist]</font>";
  }
 }

$_POST['meta_description']=str_replace('"', '&quot;', trim($_POST['meta_description']));
$_POST['keywords']=str_replace('"', '&quot;', trim($_POST['keywords']));

$chapter_path=$this->get_chapter_path($_POST['parent']);
if($chapter_path['fulltitle']){$chapter_path['fulltitle'].=' / ';}
$chapter_path['fulltitle'].=$_POST['title'];
if($chapter_path['fullcatname']){$chapter_path['fullcatname'].='/'.$_POST['fcatname'];}else{$chapter_path['fullcatname']=$_POST['fcatname'];}
$old_first_parent=$this->get_firstparent($cat);

$_POST['sortid']=intval($_POST['sortid']);

 if(! empty($_POST['auto_br_special'])){
 $_POST['special'] = nl2br($_POST['special'], false);
 }

$_POST['title'] = $db->cutstr($_POST['title'], 255);
$_POST['description'] = $db->cutstr($_POST['description'], 16777215, true);

 if(! empty($_POST['auto_br_description'])){
 $_POST['description'] = nl2br($_POST['description'], false);
 }

$_POST['meta_title'] = $db->cutstr($_POST['meta_title'], 255);
$_POST['keywords'] = $db->cutstr($_POST['keywords'], 255);
$_POST['metatags'] = $db->cutstr($_POST['metatags'], 65535, true);
$_POST['special'] = $db->cutstr($_POST['special'], 16777215, true);

$res = $db->query("SELECT catid, image, menu_img, main_img FROM $tbl WHERE catid = $cat") or die($db->error());
$row_images = $db->fetch_array($res);
 if(! isset($_POST['delete_image'])){
 $_POST['delete_image'] = 0;
 }
$upload_image_res = $this->upload_category_image('image', $row_images, $_POST['delete_image']);
 if(! isset($_POST['delete_menu_img'])){
 $_POST['delete_menu_img'] = 0;
 }
$upload_menu_img_res = $this->upload_category_image('menu_img', $row_images, $_POST['delete_menu_img']);
 if(! isset($_POST['delete_main_img'])){
 $_POST['delete_main_img'] = 0;
 }
$upload_main_img_res = $this->upload_category_image('main_img', $row_images, $_POST['delete_main_img']);

$query=$db->query("UPDATE $tbl SET fcatname = '$chapter_path[fullcatname]', parent = '$_POST[parent]', title = '$_POST[title]', description = '$_POST[description]', image = '$upload_image_res[image]', menu_img = '$upload_menu_img_res[menu_img]', main_img = '$upload_main_img_res[main_img]', meta_title = '$_POST[meta_title]', meta_description = '$_POST[meta_description]', keywords = '$_POST[keywords]', metatags = '$_POST[metatags]', special = '$_POST[special]', fulltitle = '$chapter_path[fulltitle]', sortid = '$_POST[sortid]' WHERE catid = '$cat'") or die($db->error());
$this->rename_subchapters_fulltitle($cat);

$new_first_parent=$this->get_firstparent($cat);
$this->update_totalitemcount($old_first_parent);
if($new_first_parent != $old_first_parent){$this->update_totalitemcount($new_first_parent);}

$save_result=1;

return "<h3>$lang[changes_success]</h3>$upload_image_res[error]";
}


function is_child($check_parent, $check_child){
global $db;
$tbl=DB_PREFIX.'categories';
$query=$db->query("SELECT COUNT(*) FROM $tbl WHERE catid = '$check_child'")or die($db->error());
if($db->result($query,0,0)<1){return 0;}

$cat_parent=$check_child;
$i = 0;
while($cat_parent != '0'){
$query=$db->query("SELECT parent FROM $tbl WHERE catid = '$cat_parent'")or die($db->error());
$cat_parent=$db->result($query,0,'parent');
if($cat_parent==$check_parent){return 1;}
$i++;
if($i > 1000){return 0;}
 }
return 0;
}


function rename_subchapters_fulltitle($parent){
global $db;
$tbl=DB_PREFIX.'categories';
$res=$db->query("SELECT catid, fcatname, title, parent FROM $tbl WHERE parent = $parent ORDER BY title")or die($db->error());
 while($row = $db->fetch_array($res)){
 $chapter_path = $this->get_chapter_path($row['catid'],' / ');
 $db->query("UPDATE $tbl SET fcatname = '$chapter_path[fullcatname]', fulltitle = '$chapter_path[fulltitle]' WHERE catid = $row[catid]") or die($db->error());
 $parent = $row['catid'];
 $this->rename_subchapters_fulltitle($parent);
 }
}


function delete_category(){
global $cat, $admin_lib, $db, $admin_lib, $lang, $items;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$cat=intval($cat);
if(! $cat){return $admin_lib->err_msg("$lang[not_chosen_cat]", 1);}
$tbl_categories=DB_PREFIX.'categories';
$tbl_items=DB_PREFIX.'items';
$query = $db->query("SELECT COUNT(*) from $tbl_categories WHERE catid = '$cat'")or die($db->error());
if($db->result($query,0,0)<1){return $admin_lib->err_msg("$lang[cat_with_id] '$cat' $lang[not_found]", 0);}
$chapter_path=$this->get_chapter_path($cat);

$first_parent=$this->get_firstparent($cat);

require_once(INC_DIR."/admin/items.php");
$items=new items;

$errmsg=$this->delete_allchild_chapters($cat, '');
$errmsg.=$this->unlink_category($cat);
$this->update_totalitemcount($first_parent);

return "<br><b>$lang[category] \"".rtrim($chapter_path['ch_title'])."\" $lang[success_del_cat]</b><br><div class=\"red\">$errmsg</div><br><a href=\"?view=cts\">$lang[to_catlist]</a>";
}


function delete_allchild_chapters($cat, $errmsg){
global $db;
$tbl_categories=DB_PREFIX.'categories';
$res=$db->query("SELECT catid FROM $tbl_categories WHERE parent = '$cat'")or die($db->error());

 while($row=$db->fetch_array($res)){
 $cat=$row['catid'];
 $this->delete_allchild_chapters($cat, $errmsg);
 $errmsg.=$this->unlink_category($cat);
 }

return $errmsg;
}


function unlink_category($cat){
global $db, $lang, $items;
$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$tbl_item_categories=DB_PREFIX.'item_categories';
$errmsg = '';
$res=$db->query("SELECT itemid FROM $tbl_items WHERE catid = '$cat'")or die($db->error());

 while($row=$db->fetch_array($res)){
 $items->delete_item($row['itemid']);
 }

  $res=$db->query("SELECT image, menu_img, main_img FROM $tbl_categories WHERE catid = $cat") or die($db->error());
  $row = $db->fetch_array($res);
  
   if($row['image']){
   if(! @unlink(SCRIPTCHF_DIR."/img/small/$row[image]")){$errmsg.="$lang[cant_del_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[image]\"<br>";}
   }

   if($row['menu_img']){
   if(! @unlink(SCRIPTCHF_DIR."/img/small/$row[menu_img]")){$errmsg.="$lang[cant_del_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[menu_img]\"<br>";}
   }

   if($row['main_img']){
   if(! @unlink(SCRIPTCHF_DIR."/img/small/$row[main_img]")){$errmsg.="$lang[cant_del_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[main_img]\"<br>";}
   }

$db->query("DELETE FROM `$tbl_categories` WHERE catid = '$cat'") or die($db->error());
$db->query("DELETE FROM `$tbl_item_categories` WHERE catid = '$cat'") or die($db->error());

return $errmsg;
}



function update_totalitemcount($cat){
global $db;

 if(empty($db->handler) || empty($db->dbname)){
 die('Invalid db handler or db name (2)!'); 
 }

$tbl_categories=DB_PREFIX.'categories';
$tbl_items=DB_PREFIX.'items';
$tbl_item_categories=DB_PREFIX.'item_categories';
$cat=intval($cat);
$cnt=0;

$res = $db->query("SELECT COUNT(*) FROM `$db->dbname`.$tbl_item_categories, `$db->dbname`.$tbl_items WHERE `$db->dbname`.$tbl_item_categories.catid = $cat AND `$db->dbname`.$tbl_items.itemid = `$db->dbname`.$tbl_item_categories.itemid AND `$db->dbname`.$tbl_items.visible = 1") or die($db->error());

$cnt+=$db->result($res,0,0);
if($cnt < 0){$cnt = 0;}
$res = $db->query("SELECT catid FROM `$db->dbname`.$tbl_categories WHERE parent = $cat") or die($db->error());

 while($row=$db->fetch_array($res)){
  if($row['catid']>0){
  $cnt += $this->update_totalitemcount($row['catid']);
  }
 }

if($cat>0){$db->query("UPDATE `$db->dbname`.$tbl_categories SET count = $cnt WHERE catid = $cat") or die($db->error());}


return $cnt;
}


function get_firstparent($cat){
global $db;
$cat=intval($cat);
if(! $cat){return 0;}
$tbl=DB_PREFIX.'categories';
$def_parent=0;
$row=array();
$row['parent']=1;
$res=$db->query("SELECT parent FROM $tbl WHERE catid = $cat") or die($db->error());

 while($row['parent']>0){
 $row=$db->fetch_array($res);

  if($row['parent']>0){
  if($row['parent']>0){$def_parent=$row['parent'];}
  $row['parent']=$this->get_firstparent($row['parent']);
  }

 if($row['parent']>0){$def_parent=$row['parent'];}

 }

if($def_parent>0){return $def_parent;}else{return $cat;}
}



function moveallitems_fromcategory(){
global $ed_category, $admin_lib, $db, $lang;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$_POST['oldcat']=intval($_POST['oldcat']);
$_POST['newcat']=intval($_POST['newcat']);

if(! $_POST['newcat']){return $admin_lib->err_msg("$lang[invalid_catid]", 1);}

$tbl_categories=DB_PREFIX.'categories';
$tbl_items=DB_PREFIX.'items';
$tbl_item_categories=DB_PREFIX.'item_categories';

$query=$db->query("SELECT COUNT(*) FROM $tbl_categories WHERE catid = $_POST[newcat]") or die($db->error());
if($db->result($query,0,0)<1){echo $admin_lib->err_msg("$lang[cat_with_id] '$_POST[newcat]' $lang[not_found]", 1); return;}

$query=$db->query("SELECT itemid FROM $tbl_items WHERE catid = $_POST[oldcat]") or die($db->error());


 while($row=$db->fetch_array($query)){
 $db->query("UPDATE $tbl_items SET catid = $_POST[newcat] WHERE itemid = $row[itemid]") or die($db->error());
 $db->query("UPDATE $tbl_item_categories SET catid = $_POST[newcat] WHERE itemid = $row[itemid] AND catid = $_POST[oldcat]") or die($db->error());
 }


$old_first_parent=$this->get_firstparent($_POST['oldcat']);
$new_first_parent=$this->get_firstparent($_POST['newcat']);
$this->update_totalitemcount($old_first_parent);
if($new_first_parent != $old_first_parent){$this->update_totalitemcount($new_first_parent);}

require_once(INC_DIR."/admin/view_cat.php");
$view_category=new view_category;
$chain_chapter_title=$view_category->adm_chain_chapter_title($_POST['newcat'], ' / ');

return "<h3>$lang[products_success_moved] $chain_chapter_title[ch_title_link]</h3>";
}



function update_itemcount_in_parentline($cat, $offset){
global $db;
$tbl_categories=DB_PREFIX.'categories';
$cat=intval($cat);
$cnt=0;

$res = $db->query("SELECT count FROM $tbl_categories WHERE catid = $cat") or die($db->error());
$cnt+=$db->result($res,0,0)+$offset;
if($cnt < 0){$cnt = 0;}

$db->query("UPDATE $tbl_categories SET count = $cnt WHERE catid = $cat") or die($db->error());

$res=$db->query("SELECT parent FROM $tbl_categories WHERE catid = $cat") or die($db->error());

$row=array();
$row['parent']=1;

 while($row['parent']>0){
 $row=$db->fetch_array($res);
  if($row['parent']>0){
  $cnt+=$this->update_itemcount_in_parentline($row['parent'], $offset);
  }
 }

return $cnt;
}



function delete_all_categories_and_items(){
global $db, $admset;

 if(empty($db->handler) || empty($db->dbname)){
 die('Invalid db handler or db name (3)!'); 
 }

$tbl_categories=DB_PREFIX.'categories';
$tbl_item_categories=DB_PREFIX.'item_categories';
$tbl_items=DB_PREFIX.'items';

 if($admset['pre_delete_img']){
 $res = $db->query("SELECT catid, image FROM `$db->dbname`.$tbl_categories") or die($db->error());
  while($row = $db->fetch_assoc($res)){
   if(! empty($row['image'])){
   @unlink(SCRIPTCHF_DIR."/img/small/$row[image]");
   }
  }
 }



require_once(INC_DIR."/admin/items.php");
$items = new items;
$res = $db->query("SELECT `itemid` FROM `$db->dbname`.`$tbl_items`") or die($db->error());
 while($itemid = $db->result($res)){
 $items->delete_item($itemid);
 }

$db->query("DELETE FROM `$db->dbname`.`$tbl_categories` WHERE catid <> 0") or die($db->error());
$db->query("DELETE FROM `$db->dbname`.`$tbl_item_categories` WHERE catid <> 0") or die($db->error());

return true;
}



function upload_category_image($rowname, $row, $delete=0){
global $db, $admset, $lang;
$error = '';
$ret = array('error' => '');

 if(! empty($row['catid'])){
 $ret["$rowname"] = $row["$rowname"];
 }
 else{
 $ret["$rowname"] = '';
 }

$upload=new upload;

 if($delete && $ret["$rowname"]){
  if($upload->is_valid_filename($ret["$rowname"]) && file_exists(SCRIPTCHF_DIR."/img/small/$ret[$rowname]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$ret[$rowname]")){
  $error.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$ret[$rowname]\"<br>";
  $ret['error'] = "<font class=\"red\">$error</font><br>";
  }
 $ret["$rowname"] = '';
 }

 if(! $upload->is_upload_file("$rowname")){
 return $ret;
 }

 if($ret["$rowname"]){
  if($upload->is_valid_filename($ret["$rowname"]) && file_exists(SCRIPTCHF_DIR."/img/small/$ret[$rowname]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$ret[$rowname]")){
  $error.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$ret[$rowname]\"<br>";
  }
 } 

$ret["$rowname"] = $upload->auto_upload_file("$rowname", SCRIPTCHF_DIR."/img/small");

 if($admset['set_img_chmod']){
  if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/small/$ret[$rowname]")){
  @chmod(SCRIPTCHF_DIR."/img/small/$ret[$rowname]", octdec($admset['img_chmod']));
  }
 }

if($error){$error = "<font class=\"red\">$error</font><br>";}
$ret['error'] = $error;

return $ret;
}


function catname_from_fullcatname($fullcatname){
$pos=strrpos($fullcatname, '/');
if($pos){return substr($fullcatname, $pos+1);}else{return $fullcatname;}
}


}
?>