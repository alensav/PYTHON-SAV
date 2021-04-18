<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/manufacturers');

echo "<h3>$lang[manufacturers]</h3>";

 if($act==='delete'){
 echo delete_manufacturer($_GET['mnf_id']);
 }

 switch($act){

 case 'add':
 include(INC_DIR."/admin/pages/manufacturer_form_p.php");
 break;
 
 case 'edit':
 include(INC_DIR."/admin/pages/manufacturer_form_p.php");
 break;

 default:
 echo get_all_manufacturers();
 }


function get_all_manufacturers(){
global $db, $lang, $admin_lib;

$ret = "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=manufacturers&act=add\">$lang[add_manufacturer]</a></p>";

$ret .= '<table width="100%" class="settbl">';
$ret .= "<tr class=\"htr\"><td>$lang[manufacturer_title]</td><td align=\"center\">$lang[delete]</td></tr>";

$tbl=DB_PREFIX.'manufacturers';
$res = $db->query("SELECT mnf_id, title FROM $tbl WHERE mnf_id <> 0 ORDER BY sortid, title");

$num_rows = 0;
 while($row=$db->fetch_array($res)){
 $def_class = $admin_lib->sett_class();
 $ret .= "<tr class=\"$def_class\"><td><a href=\"?view=manufacturers&act=edit&mnf_id=$row[mnf_id]\">$row[title]</a></td><td align=\"center\"><a href=\"?view=manufacturers&act=delete&mnf_id=$row[mnf_id]\" onclick=\"return q('$lang[delete_manufacturer]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
 $num_rows++;
 }

 if(! $num_rows){
 $ret .= "<tr class=\"str\"><td colspan=\"2\" align=\"center\">$lang[no_manufacturers]</td></tr>";
 }

$ret .= '</table>';
return $ret;
}


function get_manufacturer($mnf_id){
global $db, $delete_file_err;
$mnf_id = intval($mnf_id);
if(! $mnf_id){return '';}
$tbl=DB_PREFIX.'manufacturers';
$res = $db->query("SELECT * FROM $tbl WHERE mnf_id = $mnf_id") or die($db->error());
return $db->fetch_array($res);
}


function save_manufacturer($mnf_id, $row){
global $db, $admin_lib, $admset, $custom, $lang, $delete_file_err, $act;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

require_once(INC_DIR.'/admin/chpu.php');

$tbl_manufacturers=DB_PREFIX.'manufacturers';

 if($act==='add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl_manufacturers") or die($db->error());
   if($db->result($res,0,0) >= 8 + 1){
   return mdmogrn("$lang[130] 8 $lang[195]");
   }
  }
 }

$err_msg = '';

$_POST = $custom->trim_array($_POST);

$mnf_id=intval($mnf_id);
$_POST['mnfname'] = trim($_POST['mnfname']);
$_POST['mnfname'] = chpu::autoName($_POST['mnfname'], $_POST['title'], $mnf_id, false);

 if($_POST['mnfname']){
 $ch_mnfname=$db->secstr($_POST['mnfname']);
 $res=$db->query("SELECT COUNT(*) FROM `$tbl_manufacturers` WHERE `mnfname` = '$ch_mnfname' AND `mnf_id` <> $mnf_id") or die($db->error());
  if($db->result($res,0,0)>0){
  $err_msg.="$lang[link_name] \"$_POST[mnfname]\" $lang[used_in_other_mnf]<br>";
  }
 }

$_POST['title'] = $custom->replace_quotes($_POST['title']);
$_POST['title'] = $db->cutstr($_POST['title'], 255);
$_POST['description'] = $db->cutstr($_POST['description'], 16777215, true);
$_POST['url'] = $db->cutstr($_POST['url'], 255);
$_POST['meta_title'] = $db->cutstr($_POST['meta_title'], 255);
$_POST['meta_description'] = $db->cutstr($_POST['meta_description'], 255);
$_POST['meta_keywords'] = $db->cutstr($_POST['meta_keywords'], 255);
$_POST['meta_tags'] = $db->cutstr($_POST['meta_tags'], 65535, true);
$_POST['sortid'] = intval($_POST['sortid']);

if(! $_POST['title']){$err_msg.="$lang[not_manufacturer_title]<br>";}

if($err_msg){return $err_msg;}

$delete_file_err='';

require_once(INC_DIR."/upload.php");
$upload=new upload;

 if(! empty($_POST['delete_image'])){
  if($row['image'] && file_exists(SCRIPTCHF_DIR."/img/small/$row[image]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$row[image]")){
  $delete_file_err.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[image]\". $lang[check_chmod] \"" . SCRIPTCHF_DIR . "/img/small\".<br>";
  }
 $row['image'] = '';
 }

 if($upload->is_upload_file('upload_image')){
  if($row['image'] && file_exists(SCRIPTCHF_DIR."/img/small/$row[image]") && ! @unlink(SCRIPTCHF_DIR."/img/small/$row[image]")){
  $delete_file_err.="$lang[cant_delete_file] \"" . SCRIPTCHF_DIR . "/img/small/$row[image]\". $lang[check_chmod] \"" . SCRIPTCHF_DIR . "/img/small\".<br>";
  }
 $row['image'] = $upload->auto_upload_file('upload_image', SCRIPTCHF_DIR."/img/small");

  if($admset['set_img_chmod']){
   if(is_numeric($admset['img_chmod']) && is_file(SCRIPTCHF_DIR."/img/small/$row[image]")){
   @chmod(SCRIPTCHF_DIR."/img/small/$row[image]", octdec($admset['img_chmod']));
   }
  }

 }


 if($act==='add'){
 $res = $db->query("SELECT MAX(mnf_id) AS mnf_id FROM $tbl_manufacturers") or die($db->error());
 $max_mnf_id = $db->fetch_array($res);
 $mnf_id = $max_mnf_id['mnf_id'] + 1;
  if(! $_POST['mnfname']){
  $_POST['mnfname']="$mnf_id";
  }
  if(! isset($row['image'])){
  $row['image'] = '';
  }
 $res = $db->query("INSERT INTO $tbl_manufacturers(mnf_id, mnfname, title, description, image, url, meta_title, meta_description, meta_keywords, meta_tags, sortid) VALUES($mnf_id, '$_POST[mnfname]', '$_POST[title]', '$_POST[description]', '$row[image]', '$_POST[url]', '$_POST[meta_title]', '$_POST[meta_description]', '$_POST[meta_keywords]', '$_POST[meta_tags]', $_POST[sortid])") or die($db->error());
 }
 elseif($act==='edit'){
 if(! $mnf_id){return 'Invalid mnf_id!';}
  if(! $_POST['mnfname']){
  $_POST['mnfname']="$mnf_id";
  }
 $res = $db->query("UPDATE $tbl_manufacturers SET mnfname = '$_POST[mnfname]', title = '$_POST[title]', description = '$_POST[description]', image = '$row[image]', meta_title = '$_POST[meta_title]', url = '$_POST[url]', meta_description = '$_POST[meta_description]', meta_keywords = '$_POST[meta_keywords]', meta_tags = '$_POST[meta_tags]', sortid = $_POST[sortid] WHERE mnf_id = $mnf_id") or die($db->error());
 }
 else{
 return ' ';
 }

$_POST['mnf_id']=$mnf_id;

if($res){return 1;}else{return "Can't write to database!";}
}


function delete_manufacturer($mnf_id){
global $db, $lang, $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$mnf_id=intval($mnf_id);
$tbl_manufacturers=DB_PREFIX.'manufacturers';
$tbl_items=DB_PREFIX.'items';
$err = '';

$res = $db->query("SELECT mnf_id, image FROM $tbl_manufacturers WHERE mnf_id = $mnf_id") or die($db->error());
$row = $db->fetch_array($res);

if(! $row['mnf_id']){return '';}

 if($row['image']){
  if(is_file(SCRIPTCHF_DIR."/img/small/$row[image]")){
   if(! @unlink(SCRIPTCHF_DIR."/img/small/$row[image]")){
   $err.="$lang[cant_delete_file] &quot;".SCRIPTCHF_DIR."/img/small/$row[image]"."&quot;. $lang[check_chmod] &quot;".SCRIPTCHF_DIR."/img/small"."&quot;<br>";
   }
  }
 }

if($err){$err="<font class=\"red\">$err</font>";}

$res = $db->query("DELETE FROM $tbl_manufacturers WHERE mnf_id = $mnf_id") or die($db->error());

$res = $db->query("UPDATE $tbl_items SET mnf_id = 0 WHERE mnf_id = $mnf_id") or die($db->error());

return <<<HTMLDATA
<h3>$lang[manufacturer_is_deleted]</h3>$err
<script type="text/javascript">
setTimeout("document.location.href='?view=manufacturers';", 2000);
</script>
HTMLDATA;
}

?>