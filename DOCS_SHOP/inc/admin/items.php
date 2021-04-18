<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
require_once(INC_DIR."/db_extend_mysql.php");

class items{

public $show_form=1;

function delete_item_with_msg($itemid){
global $admin_lib, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$this->delete_item($itemid, true);
return $admin_lib->good_msg("$lang[success_del_product]<br><br><a href=\"javascript:self.close()\">$lang[close]</a><br><br><a href=\"javascript:opener.location.reload();self.close()\">$lang[refresh]</a>", 0);
}

function delete_item($itemid, $update_itemcount = false){
global $db, $ed_category, $lang, $admset;

$itemid=intval($itemid);

$tbl_items=DB_PREFIX.'items';
$tbl_gallery=DB_PREFIX.'gallery';
$tbl_mainitems=DB_PREFIX.'mainitems';
$tbl_item_special=DB_PREFIX.'item_special';
$tbl_item_similar=DB_PREFIX.'item_similar';
$tbl_options_match=DB_PREFIX.'item_options_match';
$tbl_item_categories=DB_PREFIX.'item_categories';
$tbl_item_comments=DB_PREFIX.'item_comments';
$tbl_item_comments_new=DB_PREFIX.'item_comments_new';


 if($admset['pre_delete_img']){

 $res = $db->query("SELECT `small_img`, `big_img` FROM `$db->dbname`.`$tbl_items` WHERE `itemid` = '$itemid'")or die($db->error());
 $row = $db->fetch_array($res);

  if($row['small_img'] && file_exists(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
  @unlink(SCRIPTCHF_DIR."/img/small/$row[small_img]");
  }

  if($row['big_img'] && file_exists(SCRIPTCHF_DIR."/img/big/$row[big_img]")){
  @unlink(SCRIPTCHF_DIR."/img/big/$row[big_img]");
  }

 $res2 = $db->query("SELECT small_img, big_img FROM `$db->dbname`.`$tbl_gallery` WHERE itemid = '$itemid'")or die($db->error());
  while($row2=$db->fetch_array($res2)){

   if($row2['big_img'] && file_exists(SCRIPTCHF_DIR."/img/big/$row2[big_img]")){
    if(! @unlink(SCRIPTCHF_DIR."/img/big/$row2[big_img]")){
    }
   }

   if($row2['small_img'] && file_exists(SCRIPTCHF_DIR."/img/small/$row2[small_img]")){
    if(! @unlink(SCRIPTCHF_DIR."/img/small/$row2[small_img]")){
    }
   }

  }

 }



 if($update_itemcount){
 $all_item_categories = array();
 $res = $db->query("SELECT catid FROM `$db->dbname`.`$tbl_item_categories` WHERE itemid = $itemid") or die($db->error());
  while($ic_row = $db->fetch_array($res)){
  array_push($all_item_categories, $ic_row['catid']);
  }
 }



db_extend::multi_delete("$tbl_items.itemid, $tbl_gallery.itemid, $tbl_mainitems.main_itemid, $tbl_item_special.sp_itemid, $tbl_item_similar.itemid, $tbl_item_comments.itemid, $tbl_item_comments_new.itemid, $tbl_options_match.itemid, $tbl_item_categories.itemid", $itemid);


 if($update_itemcount){
  if(sizeof($all_item_categories)){
   foreach($all_item_categories as $category_id){
   $ed_category->update_itemcount_in_parentline($category_id, -1);
   }
  }
 }


return 1;
}


function get_item($itemid){
global $db;
$itemid=intval($itemid);
$tbl_items=DB_PREFIX.'items';
$tbl_mainitems=DB_PREFIX.'mainitems';
$tbl_item_special=DB_PREFIX.'item_special';
$tbl_item_categories=DB_PREFIX.'item_categories';
$tbl_categories=DB_PREFIX.'categories';
$res = $db->query("SELECT * FROM $tbl_items WHERE itemid = $itemid") or die($db->error());
$row=$db->fetch_array($res);
$row['catid'] = intval($row['catid']);

$res = $db->query("SELECT * FROM $tbl_mainitems WHERE main_itemid = $itemid") or die($db->error());
$row2=$db->fetch_array($res);
$row['main_itemid']=$row2['main_itemid'];
$row['main_sortid']=$row2['main_sortid'];

$res = $db->query("SELECT * FROM $tbl_item_special WHERE sp_itemid = $itemid") or die($db->error());
$row2=$db->fetch_array($res);
$row['sp_itemid']=$row2['sp_itemid'];
$row['sp_sortid']=$row2['sp_sortid'];

$res = $db->query("SELECT sortid FROM $tbl_item_categories WHERE itemid = $itemid AND catid = $row[catid]") or die($db->error());
$row3=$db->fetch_array($res);
$row['sortid']=$row3['sortid'];

$res = $db->query("SELECT `fcatname` FROM `$tbl_categories` WHERE `catid` = $row[catid]") or die($db->error());
$row4=$db->fetch_array($res);
$row['fcatname']=$row4['fcatname'];

return $row;
}


function item_fcatname($catid){
global $db;
$catid=intval($catid);
$tbl_categories=DB_PREFIX.'categories';
$res = $db->query("SELECT `fcatname` FROM `$tbl_categories` WHERE `catid` = $catid") or die($db->error());
$row=$db->fetch_array($res);
return $row['fcatname'];
}


function save_item($itemid){
global $db, $admin_lib, $sett, $admset, $upload, $act, $itemid, $ed_category, $lang, $custom;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$err = $this->check_post($itemid);

if($err){return "<font class=\"red\">$err</font>";}

$errmsg = '';

$itemid=intval($itemid);

 if(! empty($_POST['visible'])){
 $_POST['visible']=1;
 }
 else{
 $_POST['visible']=0;
 }


 if($_POST['smallimg_subfolder']){
 $smallimg_subfolder_slash = '/';
 }
 else{
 $smallimg_subfolder_slash = '';
 }

 if($_POST['bigimg_subfolder']){
 $bigimg_subfolder_slash = '/';
 }
 else{
 $bigimg_subfolder_slash = '';
 }


$tbl_items=DB_PREFIX.'items';
$tbl_mainitems=DB_PREFIX.'mainitems';
$tbl_item_special=DB_PREFIX.'item_special';
$tbl_item_categories=DB_PREFIX.'item_categories';

 if($act === 'editem'){
 $res = $db->query("SELECT COUNT(*) FROM $tbl_items WHERE itemid = $itemid") or die($db->error());
  if($db->result($res,0,0)<1){
  $this->show_form=0;
  return "<center><font class=\"red\">$lang[product_with_id] '$itemid' $lang[not_found]</font></center>";
  }
 }
 elseif($act === 'additem'){
  if( (defined('SV_MODE') && SV_MODE == 1) || TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl_items") or die($db->error());
  $count_items=$db->result($res,0,0);
   if(SV_MODE == 1){
   global $svc_sadpadm;
    if($count_items >= $svc_sadpadm->max_user_products()){
    return $svc_sadpadm->many_products();
    }
   }
   elseif(TDTC == 1){
    if($count_items >= 50){
    return mdmogrn("$lang[130] 50 $lang[143]");
    }
   }
  }
 }

$res = $db->query("SELECT catid as old_catid, small_img, big_img FROM $tbl_items WHERE itemid = $itemid")or die($db->error());
$row=$db->fetch_array($res);





$small_img_deleted = 0;
 if(! empty($_POST['del_smallimg']) && $row['small_img']){
  if(file_exists(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
   if(! @unlink(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
   $errmsg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[small_img]\"<br>";
   }
   else{
   $row['small_img']='';
   $small_img_deleted = 1;
   }
  }
  else{
  $row['small_img']='';
  $small_img_deleted = 1;
  }
 }


$big_img_deleted = 0;
 if(! empty($_POST['del_bigimg']) && $row['big_img']){
  if(file_exists(SCRIPTCHF_DIR."/img/big/$row[big_img]")){
   if(! @unlink(SCRIPTCHF_DIR."/img/big/$row[big_img]")){
   $errmsg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/big/$row[big_img]\"<br>";
   }
   else{
   $row['big_img']='';
   $big_img_deleted = 1;
   }
  }
  else{
  $row['big_img']='';
  $big_img_deleted = 1;
  }
 }

clearstatcache();



 if(isset($_POST['smallimg_efile']) && ! $small_img_deleted){
 $row['small_img'] = $_POST['smallimg_subfolder'] . $smallimg_subfolder_slash . $_POST['smallimg_efile'];
 }

 if(isset($_POST['bigimg_efile']) && ! $big_img_deleted){
 $row['big_img'] = $_POST['bigimg_subfolder'] . $bigimg_subfolder_slash . $_POST['bigimg_efile'];
 }



 if($upload->is_upload_file('bigimg_file')){
  if($admset['pre_delete_img'] && $row['big_img']){
   if(file_exists(SCRIPTCHF_DIR."/img/big/$row[big_img]") && ! @unlink(SCRIPTCHF_DIR."/img/big/$row[big_img]")){
   $errmsg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/big/$row[big_img]\"<br>";
   }
  }
 $row['big_img'] = $_POST['bigimg_subfolder'] . $bigimg_subfolder_slash . $upload->auto_upload_file('bigimg_file', SCRIPTCHF_DIR."/img/big$bigimg_subfolder_slash$_POST[bigimg_subfolder]");

  if($admset['set_img_chmod']){
   if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/big/$row[big_img]")){
   @chmod(SCRIPTCHF_DIR."/img/big/$row[big_img]", octdec($admset['img_chmod']));
   }
  }

 }






function img_type($filename){
$type = strtolower(preg_replace('#.*(\.[a-z0-9]+)$#i', '$1', $filename));
 switch($type){
 case '.gif': return 'gif';
 case '.jpg': return 'jpeg';
 case '.jpeg': return 'jpeg';
 case '.jfif': return 'jpeg';
 case '.png': return 'png';
 }
return '';
}

function watermark($main_file){
global $admset;
$watermark_file = SCRIPTCHF_DIR."/img/watermark.$admset[watermark_format]" ;

$wtype = img_type($watermark_file);
$mtype = img_type($main_file);

$func = 'imagecreatefrom'.$wtype;
$watermark = $func($watermark_file);
$func = 'imagecreatefrom'.$mtype;
$main = $func($main_file);


 if(empty($admset['watermark_position']) || $admset['watermark_position'] == 'center'){
 $left = (imagesx($main) - imagesx($watermark)) / 2;
 $top = (imagesy($main) - imagesy($watermark)) / 2;
 }
 elseif(isset($admset['watermark_position']) && $admset['watermark_position'] == 'down_right'){
 $marge_right = 10;
 $marge_bottom = 10;
 $left = imagesx($main) - imagesx($watermark) - $marge_right;
 $top = imagesy($main) - imagesy($watermark) - $marge_bottom;
 }

imagecopy($main, $watermark, $left, $top, 0, 0, imagesx($watermark), imagesy($watermark));

$func = 'image'.$mtype;
$func($main, $main_file);
imagedestroy($main);
}

 if(! isset($admset['watermark_format']) || ! preg_match('/^(gif|jpg|jpeg|jfif|png)$/i', $admset['watermark_format'])){
 $admset['watermark_format'] = '';
 }

 if($admset['watermark_format'] && (! empty($_FILES['bigimg_file']['tmp_name']) && ! empty($row['big_img'])) ){
  if(file_exists(SCRIPTCHF_DIR."/img/watermark.$admset[watermark_format]")){
  watermark(SCRIPTCHF_DIR."/img/big/$row[big_img]");
  }
 }





 if($upload->is_upload_file('smallimg_file') && empty($_POST['auto_resize'])){
  if($admset['pre_delete_img'] && $row['small_img']){
   if(file_exists(SCRIPTCHF_DIR."/img/small/$row[small_img]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
   $errmsg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[small_img]\"<br>";
   }
  }
 $row['small_img'] = $_POST['smallimg_subfolder'] . $smallimg_subfolder_slash . $upload->auto_upload_file('smallimg_file', SCRIPTCHF_DIR."/img/small$smallimg_subfolder_slash$_POST[smallimg_subfolder]");

  if($admset['set_img_chmod']){
   if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
   @chmod(SCRIPTCHF_DIR."/img/small/$row[small_img]", octdec($admset['img_chmod']));
   }
  }

 }
 elseif(! empty($_POST['auto_resize']) && $row['big_img']){
  if($admset['pre_delete_img'] && $row['small_img']){
   if(file_exists(SCRIPTCHF_DIR."/img/small/$row[small_img]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
   $errmsg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[small_img]\"<br>";
   }
  }
 $row['small_img'] = $_POST['smallimg_subfolder'] . $smallimg_subfolder_slash . $upload->auto_exists_name(SCRIPTCHF_DIR."/img/small$smallimg_subfolder_slash$_POST[smallimg_subfolder]", $this->get_filename_from_fullfilename($row['big_img']));

 $resize_result = $this->resize_image_file($admset['gen_smimg_width'], $admset['gen_smimg_height'], SCRIPTCHF_DIR."/img/big/$row[big_img]", SCRIPTCHF_DIR."/img/small/$row[small_img]");

  if($resize_result){

   if($admset['set_img_chmod']){
    if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
    @chmod(SCRIPTCHF_DIR."/img/small/$row[small_img]", octdec($admset['img_chmod']));
    }
   }

  }
  else{
  $row['small_img']='';
  }

 }

unset($upload);




 if($_POST['quantity'] > 4294967295 || $_POST['quantity'] == 'unlim'){
 $_POST['quantity'] = '4294967295';
 }

$_POST['quantity'] = doubleval($_POST['quantity']);
if($_POST['quantity'] < 0){$_POST['quantity'] = 0;}

$_POST['catid']=intval($_POST['catid']);
$_POST['itemname'] = trim($_POST['itemname']);
$_POST['itemname']=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $_POST['itemname']);
$_POST['mnf_id'] = intval($_POST['mnf_id']);
$_POST['sku']=$custom->replace_quotes(trim($_POST['sku']));
$_POST['title']=$custom->replace_quotes(trim($_POST['title']));
$_POST['description']=$custom->replace_quotes(trim($_POST['description']));
$_POST['keywords']=$custom->replace_quotes(trim($_POST['keywords']));
$_POST['sortid']=intval($_POST['sortid']);

$_POST['itemname']=$db->cutstr($_POST['itemname'], 128);
$_POST['title'] = $db->cutstr($_POST['title'], 255);
$_POST['sku'] = $db->cutstr($_POST['sku'], 255);
$_POST['short_descript'] = $db->cutstr($_POST['short_descript'], 65535, true);
$_POST['long_descript'] = $db->cutstr($_POST['long_descript'], 16777215, true);
$_POST['meta_title'] = $db->cutstr($_POST['meta_title'], 255);
$_POST['description'] = $db->cutstr($_POST['description'], 255);
$_POST['keywords'] = $db->cutstr($_POST['keywords'], 255);
$_POST['metatags'] = $db->cutstr($_POST['metatags'], 65535, true);
$_POST['special'] = $db->cutstr($_POST['special'], 65535, true);


 if($act == 'editem'){
 

 $db->query("UPDATE $tbl_items SET itemname = '$_POST[itemname]', catid=$_POST[catid], mnf_id=$_POST[mnf_id], sku='$_POST[sku]', title='$_POST[title]', price='$_POST[price]', old_price='$_POST[old_price]', quantity=$_POST[quantity], quantity_txt='$_POST[quantity_txt]', short_descript='$_POST[short_descript]', long_descript='$_POST[long_descript]', small_img='$row[small_img]', big_img='$row[big_img]', upd_date='" .time(). "', meta_title = '$_POST[meta_title]', description='$_POST[description]', keywords='$_POST[keywords]', metatags='$_POST[metatags]', special='$_POST[special]', visible=$_POST[visible] WHERE itemid = $itemid") or die($db->error());

  if($_POST['catid'] != $row['old_catid']){
  $db->query("DELETE  FROM $tbl_item_categories WHERE itemid = $itemid AND catid = $row[old_catid]") or die($db->error());
  }

 $db->query("DELETE  FROM $tbl_item_categories WHERE itemid = $itemid AND catid = $_POST[catid]") or die($db->error());

  if(empty($_POST['show_on_main'])){
  $db->query("DELETE FROM $tbl_mainitems WHERE main_itemid = $itemid") or die($db->error());
  }
  
  if(empty($_POST['special_offer'])){
  $db->query("DELETE FROM $tbl_item_special WHERE sp_itemid = $itemid") or die($db->error());
  }
  
 }
 elseif($act==='additem'){

 $db->query("INSERT INTO $tbl_items (itemid, itemname, catid, mnf_id, sku, title, price, old_price, quantity, quantity_txt, short_descript, long_descript, small_img, big_img, add_date, upd_date, meta_title, description, keywords, metatags, special, visible) VALUES(NULL, '$_POST[itemname]', $_POST[catid], $_POST[mnf_id], '$_POST[sku]', '$_POST[title]', '$_POST[price]', '$_POST[old_price]', $_POST[quantity], '$_POST[quantity_txt]', '$_POST[short_descript]', '$_POST[long_descript]', '$row[small_img]', '$row[big_img]', '" .time(). "', '" .time(). "', '$_POST[meta_title]', '$_POST[description]', '$_POST[keywords]', '$_POST[metatags]', '$_POST[special]', $_POST[visible])") or die($db->error());

 $itemid = $db->insert_id();



  if(! $_POST['itemname']){
  $_POST['itemname'] = $itemid;
  $db->query("UPDATE `$tbl_items` SET `itemname` = '$_POST[itemname]' WHERE `itemid` = $itemid") or die($db->error());
  }

 $act='editem';

 }



$db->query("INSERT INTO $tbl_item_categories (catid, itemid, sortid) VALUES ($_POST[catid], $itemid, $_POST[sortid])") or die($db->error());

$res = $db->query("SELECT catid FROM $tbl_item_categories WHERE itemid = $itemid") or die($db->error());

 while($catrow=$db->fetch_array($res)){
 $ed_category->update_totalitemcount($ed_category->get_firstparent($catrow['catid']));
 }


 if(isset($_POST['old_catid']) && $_POST['catid'] != $_POST['old_catid']){
 $ed_category->update_totalitemcount($ed_category->get_firstparent($_POST['old_catid']));
 }




 if(! empty($_POST['show_on_main'])){
 $_POST['main_sortid']=intval($_POST['main_sortid']);
 $res = $db->query("SELECT COUNT(*) FROM $tbl_mainitems WHERE main_itemid = $itemid") or die($db->error());
  if($db->result($res, 0, 0) > 0){
  $query = "UPDATE $tbl_mainitems SET main_sortid = '$_POST[main_sortid]' WHERE main_itemid = $itemid";
  }
  else{
  $query = "INSERT INTO $tbl_mainitems (main_itemid, main_sortid) VALUES($itemid, '$_POST[main_sortid]')";
  }
 $db->query($query) or die($db->error());
 }

 if(! empty($_POST['special_offer'])){
 $_POST['sp_sortid']=intval($_POST['sp_sortid']);
 $res = $db->query("SELECT COUNT(*) FROM $tbl_item_special WHERE sp_itemid = $itemid") or die($db->error());
  if($db->result($res, 0, 0) > 0){
  $query = "UPDATE $tbl_item_special SET sp_sortid = '$_POST[sp_sortid]' WHERE sp_itemid = $itemid";
  }
  else{
  $query = "INSERT INTO $tbl_item_special (sp_itemid, sp_sortid) VALUES($itemid, '$_POST[sp_sortid]')";
  }
 $db->query($query) or die($db->error());
 }

if($errmsg){$errmsg="<font class=\"red\">$errmsg</font>";}
return "<h3>$lang[changes_success]</h3>$errmsg";
}


function check_post($itemid){
global $upload, $lang, $db;
require_once(INC_DIR.'/admin/chpu.php');
$tbl_items = DB_PREFIX.'items';
$itemid = intval($itemid);
$err_msg = '';

$_POST['title']=str_replace('"', '&quot;', $_POST['title']);
$_POST['sku']=str_replace('"', '&quot;', $_POST['sku']);

 if(! $_POST['title']){
 $err_msg.="$lang[enter_product_name]<br>";
 }

 if(empty($_POST['catid']) && empty($_POST['invis'])){
 $err_msg.="$lang[select_category]<br>";
 }

$_POST['itemname'] = trim($_POST['itemname']);
$_POST['itemname'] = chpu::autoName($_POST['itemname'], $_POST['title'], $itemid, false);
 if($_POST['itemname']){
 $ch_itemname = $db->secstr($_POST['itemname']);
 $res = $db->query("SELECT COUNT(*) FROM `$tbl_items` WHERE `itemname` = '$ch_itemname' AND `itemid` <> $itemid") or die($db->error());
  if($db->result($res) > 0){
  $err_msg .= "$lang[link_name] \"$_POST[itemname]\" $lang[used_in_other_product]<br>";
  }
 }

require_once(INC_DIR."/upload.php");
$upload=new upload;

require_once(INC_DIR."/img_types.php");

$fieldname='smallimg_file';
 if($upload->is_upload_file('smallimg_file') && empty($_POST['auto_resize'])){
  if(! $upload->is_allowed_filetype($fieldname, $allow_imgtypes)){
  $err_msg .= "$lang[allow_imgtypes] " .implode(' ', $allow_imgtypes). '<br>';
  $imgtype_err = 1;
  }
  if(! $upload->is_allowed_expansion($fieldname, $allow_imgexpansions)){
  $err_msg .= "$lang[allow_expansions] " .implode(' ', $allow_imgexpansions). '<br>';
  $expansion_err = 1;
  }
 }

$fieldname='bigimg_file';
 if($upload->is_upload_file('bigimg_file')){
  if(! $upload->is_allowed_filetype($fieldname, $allow_imgtypes)){
  if(! $imgtype_err){$err_msg.="$lang[allow_imgtypes] " .implode(' ', $allow_imgtypes). '<br>';}
  }
  if(! $upload->is_allowed_expansion($fieldname, $allow_imgexpansions)){
  if(! $expansion_err){$err_msg.="$lang[allow_expansions] " .implode(' ', $allow_imgexpansions). '<br>';}
  }
 }

$_POST['price']=$this->correct_price($_POST['price']);
$_POST['old_price']=$this->correct_price($_POST['old_price']);

 if(! empty($_POST['auto_br_short_descript'])){
 $_POST['short_descript'] = nl2br($_POST['short_descript'], false);
 }

 if(! empty($_POST['auto_br_long_descript'])){
 $_POST['long_descript'] = nl2br($_POST['long_descript'], false);
 }

 if(! empty($_POST['auto_br_special'])){
 $_POST['special'] = nl2br($_POST['special'], false);
 }

return $err_msg;
}


function correct_price($price){
$price=str_replace(',', '.', $price);
if(! strstr($price, '.') || strlen($price)>16){$price=substr($price, 0, 13);}
if($price < 0){$price = 0.00;}
$price=preg_replace('([^0-9\x2E])', '', $price);
return pricef($price);
}


function update_gallery($itemid){
global $lang, $db, $max_img_quantity, $admin_lib, $admset;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$err_msg = '';

 if($_POST['smallimg_subfolder']){
 $smallimg_subfolder_slash = '/';
 }
 else{
 $smallimg_subfolder_slash = '';
 }

 if($_POST['bigimg_subfolder']){
 $bigimg_subfolder_slash = '/';
 }
 else{
 $bigimg_subfolder_slash = '';
 }


$itemid=intval($itemid);
require_once(INC_DIR."/upload.php");
$upload=new upload;
require_once(INC_DIR."/img_types.php");

$err_msg.=$this->delete_gallery_images();

 for($i=0;$i<$max_img_quantity;$i++){

   if($upload->is_upload_file("bigimg_file$i")){

     if(! $upload->is_allowed_filetype("bigimg_file$i", $allow_imgtypes)){
     if(! $imgtype_err){$err_msg.="$lang[allow_imgtypes] " .implode(' ', $allow_imgtypes). '<br>'; $imgtype_err=1;}
     }

     if(! $upload->is_allowed_expansion("bigimg_file$i", $allow_imgexpansions)){
     if(! $expansion_err){$err_msg.="$lang[allow_expansions] " .implode(' ', $allow_imgexpansions). '<br>'; $expansion_err=1;}
     }

   }

   if($upload->is_upload_file("smallimg_file$i")){

     if(! $upload->is_allowed_filetype("smallimg_file$i", $allow_imgtypes)){
     if(! $imgtype_err){$err_msg.="$lang[allow_imgtypes] " .implode(' ', $allow_imgtypes). '<br>'; $imgtype_err=1;}
     }

     if(! $upload->is_allowed_expansion("smallimg_file$i", $allow_imgexpansions)){
     if(! $expansion_err){$err_msg.="$lang[allow_expansions] " .implode(' ', $allow_imgexpansions). '<br>'; $expansion_err=1;}
     }

   }

 }


if($err_msg){return "<font class=\"red\">$err_msg</font><br>";}

 for($i=0;$i<$max_img_quantity;$i++){

   if($upload->is_upload_file("bigimg_file$i") || $upload->is_upload_file("smallimg_file$i")){

     if($upload->is_upload_file("bigimg_file$i")){
     $big_img = $_POST['bigimg_subfolder'] . $bigimg_subfolder_slash . $upload->auto_upload_file("bigimg_file$i", SCRIPTCHF_DIR."/img/big$bigimg_subfolder_slash$_POST[bigimg_subfolder]");

      if($admset['set_img_chmod']){
       if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/big/$big_img")){
       @chmod(SCRIPTCHF_DIR."/img/big/$big_img", octdec($admset['img_chmod']));
       }
      }

     }
     else{
     $big_img='';
     }

     if($upload->is_upload_file("smallimg_file$i") && ! $_POST['auto_resize']){
     $small_img = $_POST['smallimg_subfolder'] . $smallimg_subfolder_slash . $upload->auto_upload_file("smallimg_file$i", SCRIPTCHF_DIR."/img/small$smallimg_subfolder_slash$_POST[smallimg_subfolder]");

      if($admset['set_img_chmod']){
       if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/small/$small_img")){
       @chmod(SCRIPTCHF_DIR."/img/small/$small_img", octdec($admset['img_chmod']));
       }
      }

     }
     elseif($_POST['auto_resize'] && $big_img){
     $small_img = $_POST['smallimg_subfolder'] . $smallimg_subfolder_slash . $upload->auto_exists_name(SCRIPTCHF_DIR."/img/small$smallimg_subfolder_slash$_POST[smallimg_subfolder]", $this->get_filename_from_fullfilename($big_img));
     $resize_result = $this->resize_image_file($admset['gen_smimg_width_gal'], $admset['gen_smimg_height_gal'], SCRIPTCHF_DIR."/img/big/$big_img", SCRIPTCHF_DIR."/img/small/$small_img");

      if($resize_result){

       if($admset['set_img_chmod']){
        if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/small/$small_img")){
        @chmod(SCRIPTCHF_DIR."/img/small/$small_img", octdec($admset['img_chmod']));
        }
       }

      }
      else{
      $small_img='';
      }

     }
     else{
     $small_img='';
     }


   $alt=str_replace('"', "'", $_POST["alt$i"]);

   $tbl=DB_PREFIX.'gallery';
   $db->query("INSERT INTO $tbl (imgid, itemid, small_img, big_img, alt) VALUES(NULL, '$itemid', '$small_img', '$big_img', '$alt')") or die($db->error());

   }

 }

return "<h3>$lang[changes_success]</h3>";
}


function get_gallery($itemid){
global $db, $lang, $sett;
if($sett['gallery_q_columns']<1){$sett['gallery_q_columns']=2;}
$itemid=intval($itemid);
$tbl=DB_PREFIX.'gallery';
$res = $db->query("SELECT * FROM $tbl WHERE itemid = '$itemid' ORDER BY imgid DESC") or die($db->error());
if($db->num_rows($res)<1){return "$lang[no_gallery_images]<br><br>";}

$ret="<table>";
$column_number=0;

 if($sett['gal_smimg_width']){
 $def_img_width=" width=\"$sett[gal_smimg_width]\" ";
 }
 else{
 $def_img_width='';
 }

 while($row=$db->fetch_array($res)){
 if($column_number==0){$ret.='<tr>';}

 if(! $row['small_img']){$row['small_img']='none.gif';}

  if($row['big_img']){
  $ret.="<td valign=\"top\"><a href=\"javascript:showimg('$sett[relative_url]img/big/$row[big_img]')\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" border=\"0\" alt=\"$row[alt]\" title=\"$row[alt]\"$def_img_width></a>";
  }
  else{
  $ret.="<td valign=\"top\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" border=\"0\" alt=\"$row[alt]\" title=\"$row[alt]\"$def_img_width>";
  }

 $ret.="<br><input type=\"checkbox\" name=\"del_img[$row[imgid]]\">$lang[del_image]<br><br></td>";

 $column_number++;

  if($column_number<$sett['gallery_q_columns']){
  $ret.='<td>&nbsp;&nbsp;&nbsp;</td>';
  }
  else{
  $ret.='</tr>';
  $column_number=0;
  }

 }

 if($column_number>0){
  for($column_number; $column_number<$sett['gallery_q_columns'];){
  $ret.='<td>&nbsp;</td>';
  $column_number++;
   if($column_number<$sett['gallery_q_columns']){
   $ret.='<td>&nbsp;&nbsp;&nbsp;</td>';
   }
  }
 $ret.='</tr>';
 }

$ret.="</table>";

return $ret;
}


function delete_gallery_images(){
global $db, $lang, $sett;
if(! isset($_POST['del_img']) || ! is_array($_POST['del_img'])){return '';}
if(sizeof($_POST['del_img']) < 1){return '';}
$err_msg = '';

 foreach($_POST['del_img'] as $imgid => $value){

 $tbl=DB_PREFIX.'gallery';
 $res = $db->query("SELECT small_img, big_img FROM $tbl WHERE imgid = '$imgid'") or die($db->error());
 $row=$db->fetch_array($res);

  if($row['big_img']){
   if(file_exists(SCRIPTCHF_DIR."/img/big/$row[big_img]") && ! @unlink(SCRIPTCHF_DIR."/img/big/$row[big_img]")){
   $err_msg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/big/$row[big_img]\"<br>";
   }
  }

  if($row['small_img']){
   if(file_exists(SCRIPTCHF_DIR."/img/small/$row[small_img]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$row[small_img]")){
   $err_msg.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[small_img]\"<br>";
   }
  }

 $db->query("DELETE FROM $tbl WHERE imgid = $imgid") or die($db->error());

 }

clearstatcache();

return $err_msg;
}


function resize_image_file($width, $max_height, $fin, $fout){
global $admset;
$width = intval($width);
$max_height = intval($max_height);

 if($width < 1){
 $width = 160;
 }

 if(! $size = GetImageSize($fin)){
 return 0;
 }

 if($size[0] < $width){
 $width = $size[0];
 }

$height = round($size[1] / ($size[0] / $width));

 if($max_height > 0 && $height > $max_height){
 $height = $max_height;
 $width = round($size[0] / ($size[1] / $height));
 }

$typein = $this->getImageType($fin);
$typeout = $this->getImageType($fout);
if(! $typein || ! $typeout){return 0;}

$func = 'ImageCreateFrom'.$typein;
$im_in = $func($fin);

$x1 = 0;
$y1 = 0;

$im_out=ImageCreateTrueColor($width, $height);
$bgcolor=ImageColorAllocate($im_out,0,0,0);





 if($typein === $typeout){
  if($typeout === 'Gif'){
  $transparentcolor = imagecolortransparent($im_in);
   if($transparentcolor != -1){
   imagefill($im_out,0,0,$transparentcolor);
   imagecolortransparent($im_out,$transparentcolor);
   }
  }
  elseif($typeout === 'Png'){
  imageAlphaBlending($im_out, false);
  imageSaveAlpha($im_out, true);
  }
 }




 if($admset['simg_smoothing']){
 imagecopyresampled($im_out,$im_in,$x1,$y1,0,0,$width,$height,$size[0],$size[1]); 
 }
 else{
 ImageCopyResized($im_out,$im_in,$x1,$y1,0,0,$width,$height,$size[0],$size[1]);
 }

$func='Image'.$typeout;
$func($im_out, $fout);

ImageDestroy($im_in);
ImageDestroy($im_out);
return 1;
}


function getImageType($filename){
$upload = new upload;
$expansion = strtolower($upload->get_expansion($filename));
 switch($expansion){
 case '.gif': return 'Gif';
 case '.jpg': return 'Jpeg';
 case '.jpeg': return 'Jpeg';
 case '.jfif': return 'Jpeg';
 case '.png': return 'Png';
 }
return '';
}


function get_manufacturers_list($selected_id){
global $db;
$ret = '';
$tablename = DB_PREFIX.'manufacturers';
$res=$db->query("SELECT mnf_id, title FROM $tablename ORDER BY sortid, title")or die($db->error());
 while($row=$db->fetch_array($res)){
  if($row['mnf_id']){
  if($row['mnf_id']==$selected_id){$sel_value=' selected';}else{$sel_value='';}
  $ret .= "<option value=\"".$row['mnf_id']."\"$sel_value>$row[title]";
  }
 }
return $ret;
}



function get_img_subfolders($folder, $def_filename){
$ret = $this->dir_img_subfolders($folder);
$arr = explode("\x7C", $ret);
$ret = '';

$pos = strrpos($def_filename, '/');
 if($pos > 0){
 $def_subfolder = substr($def_filename, 0, $pos);
 }
 else{
 $def_subfolder = '';
 }

 if(is_array($arr)){
  if(sizeof($arr)){
  sort($arr); 
   foreach($arr as $dirname){
    if($dirname){
     if($dirname === $def_subfolder){
     $selected = ' selected="selected"';
     }
     else{
     $selected = '';
     }
    $ret .=  "<option value=\"$dirname\"$selected>img/$folder/$dirname</option>";
    }
   }
  }
 }
return $ret;
}


function dir_img_subfolders($folder, $new_folder = ''){
$dir_all_tree = 0 ;

 if($new_folder){
 $new_folder_slash = '/';
 }
 else{
 $new_folder_slash = '';
 }

$ret = '';

$dirhandle = opendir(SCRIPTCHF_DIR."/img/$folder$new_folder_slash$new_folder");
 while(($dirname = readdir($dirhandle)) !== false){
 if($dirname != '.' && $dirname != '..'){
  if(is_dir(SCRIPTCHF_DIR."/img/$folder/$new_folder$new_folder_slash$dirname")){
   $ret .=  "$new_folder$new_folder_slash$dirname|";
    if($dir_all_tree){
    $ret .= $this->dir_img_subfolders($folder, "$new_folder$new_folder_slash$dirname");
    }
   }
  }
 }
closedir($dirhandle);
return $ret;
}


function get_filename_from_fullfilename($full_filename){
$pos = strrpos($full_filename, '/');
 if($pos > 0){
 return substr($full_filename, $pos+1);
 }
 else{
 return $full_filename;
 }
}


function update_negative_prices($field_name){
global $db;
$tbl_items=DB_PREFIX.'items';
 if($field_name !== 'price' && $field_name !== 'old_price'){
 die('Invalid name of field!');
 }
$db->query("UPDATE $tbl_items SET price = '0.00' WHERE price < 0") or die($db->error());
$db->query("UPDATE $tbl_items SET old_price = '0.00' WHERE old_price < 0") or die($db->error());
return true;
}



}
?>