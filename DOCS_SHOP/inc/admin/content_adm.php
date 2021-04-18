<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class content_adm{

function get_all_pages(){
global $db, $admin_lib, $lang;

$ret = <<<HTMLDATA
<table class="settbl" width="100%">
<tr class="htr"><td>$lang[page]</td><td>$lang[delete]</td></tr>
HTMLDATA;

$tbl=DB_PREFIX.'content';
$res=$db->query("SELECT `pname`, `menutitle` FROM `$tbl` ORDER BY `sortid`")or die($db->error());

 while($row=$db->fetch_array($res)){

 $def_class=$admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class" colspan="2"><td><a href="?view=content&amp;act=edit&amp;pname=$row[pname]">$row[menutitle]</a></td><td><a href="?view=content&amp;act=delete&amp;pname=$row[pname]" onclick="return q('$lang[delete_this_page]')"><img src="adm/img/del.gif" border="0" alt="$lang[delete]"></a></td></tr>
HTMLDATA;

 }

$ret.=<<<HTMLDATA
<tr class="ftr" align="center"><td colspan="2">&nbsp;</td></tr>
</table>
HTMLDATA;

return $ret;
}


function get_page($pagename){
global $db, $page_tags, $sett;
$pagename = preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $pagename);
$pagename = $db->secstr($pagename);
if(! $pagename){return '';}
$tbl=DB_PREFIX.'content';
$res=$db->query("SELECT * FROM $tbl WHERE pname = '$pagename'") or die($db->error());
return $db->fetch_array($res);
}


function save_page(){
global $db, $act, $lang, $admin_lib;

require_once(INC_DIR.'/admin/chpu.php');

$err_msg = '';

$_POST['title']=trim($_POST['title']);
if(! $_POST['title']){$err_msg.="$lang[no_title]<br>";}

$_POST['menutitle']=trim($_POST['menutitle']);
if(! $_POST['menutitle']){$err_msg.="$lang[no_menutitle]<br>";}

$_POST['pname'] = trim($_POST['pname']);
$_POST['pname'] = chpu::autoName($_POST['pname'], $_POST['title'], '', false);
$_POST['pname'] = $db->secstr($_POST['pname']);
$_POST['pname'] = $db->cutstr($_POST['pname'], 255);
$_POST['old_pname']=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $_POST['old_pname']);
$_POST['old_pname'] = $db->secstr($_POST['old_pname']);
$_POST['old_pname'] = $db->cutstr($_POST['old_pname'], 255);
if(! $_POST['pname']){$err_msg.="$lang[no_pagename]<br>";}

if($err_msg){return $err_msg;}

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl=DB_PREFIX.'content';

 if($act == 'add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
   if($db->result($res,0,0) >= 10){
   return mdmogrn("$lang[130] 10 $lang[221]");
   }
  }
 }

$_POST['sortid']=intval($_POST['sortid']);

 if(! empty($_POST['auto_br_text'])){
 $_POST['text'] = nl2br($_POST['text'], false);
 }

 if(! empty($_POST['auto_br_special'])){
 $_POST['special'] = nl2br($_POST['special'], false);
 }


 if($act == 'edit'){
 $res=$db->query("SELECT COUNT(*) FROM $tbl WHERE pname = '$_POST[pname]' AND pname <> '$_POST[old_pname]'") or die($db->error());

  if($db->result($res) > 0){
  return $lang['page_already_exist'];
  }

 $res=$db->query("UPDATE $tbl SET pname = '$_POST[pname]', menutitle = '$_POST[menutitle]', title = '$_POST[title]', description = '$_POST[description]', keywords = '$_POST[keywords]', metatags = '$_POST[metatags]', special = '$_POST[special]', text = '$_POST[text]', sortid = '$_POST[sortid]' WHERE pname = '$_POST[old_pname]'") or die($db->error());
 }
 elseif($act==='add'){
 $res=$db->query("SELECT COUNT(*) FROM $tbl WHERE pname = '$_POST[pname]'") or die($db->error());
 if($db->result($res,0,0)>0){return $lang['page_already_exist'];}

 $res=$db->query("INSERT INTO $tbl (pname, menutitle, title, description, keywords, metatags, special, text, sortid) VALUES('$_POST[pname]', '$_POST[menutitle]', '$_POST[title]', '$_POST[description]', '$_POST[keywords]', '$_POST[metatags]', '$_POST[special]', '$_POST[text]', '$_POST[sortid]')") or die($db->error());
 }

if($res){return 1;}else{return '';}
}


function delete_page($pname){
global $db, $lang, $admin_lib;
$pname=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $pname);
if(! $pname){return '';}

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl=DB_PREFIX.'content';
$db->query("DELETE FROM $tbl WHERE pname = '$pname'") or die($db->error());
return "<h3 align=\"center\">$lang[page_is_deleted]</h3>";
}


}
?>
