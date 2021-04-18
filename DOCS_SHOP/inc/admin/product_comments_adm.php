<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class prcomm_adm{

function __construct(){
global $db, $pcomset, $custom;
$pcomset = $custom->get_settings(6);
$custom->get_lang('admin_lang/product_comments');
}

function get_comments($itemid){
global $db, $sett, $pcomset, $custom, $pg, $lang;
$itemid = intval($itemid);
 if(! $itemid){
 return '';
 }
$pg=intval($pg);
if($pg < 1){$pg=1;}

$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$res = $db->query("SELECT `$tbl_items`.`itemid`, `$tbl_items`.`itemname`, `$tbl_items`.`catid`, `$tbl_items`.`title`, `$tbl_items`.`visible`, `$tbl_categories`.`fcatname` FROM `$tbl_items`, `$tbl_categories` WHERE `$tbl_items`.`itemid` = $itemid AND `$tbl_categories`.`catid` = `$tbl_items`.`catid`") or die($db->error());
$row = $db->fetch_array($res);
 if(! $row['itemid']){
 return $lang['product_not_found'];
 }
$item_title = $row['title'];
 if($row['visible']){
 $product_link='<a href="'.@stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'))."\" target=\"_blank\">$item_title</a>";
 }
 else{
 $product_link=$item_title;
 }

$tbl_item_comments=DB_PREFIX.'item_comments';

 if($pcomset['reverse_sort']){
 $desc = ' DESC';
 }
 else{
 $desc = '';
 }

$res = $db->query("SELECT COUNT(*) FROM $tbl_item_comments WHERE itemid = $itemid AND visible = 1") or die($db->error());

$q_comments = $db->result($res, 0, 0);

$ret=$this->js_functions();

$ret.="<b>$lang[product_comments_to] &quot;$product_link&quot;</b><br><br>";

 if(! $q_comments){
 $ret.="<p>$lang[no_comments]</p>";
 return $ret.$this->footer();
 }

$pcomset['qpcomm'] = intval($pcomset['qpcomm']);
if($pcomset['qpcomm'] < 1){$pcomset['qpcomm'] = 40;}
$tstfirst_line=$pg * $pcomset['qpcomm'] - $pcomset['qpcomm'];
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){return '';}
if($first_line < 0 ){return '';}

$limit='';
 if(empty($_GET['show_all'])){
 $limit=" LIMIT $first_line, $pcomset[qpcomm]";
 }

 if($q_comments){
 $res = $db->query("SELECT * FROM $tbl_item_comments WHERE itemid = $itemid AND `visible` = 1 ORDER BY `sortid`, `cpdate`$desc$limit") or die($db->error());
 }

$ret.='<table cellspacing="0" cellpadding="0" width="100%" border="0" class="settbl">';

$def_class='ttr';
 while($row = $db->fetch_array($res)){
 $row['cpdate']=date("d.m.Y H:i:s", $row['cpdate'] + $sett['time_diff'] * 3600);
 $row['ardate']=date("d.m.Y H:i:s", $row['ardate'] + $sett['time_diff'] * 3600);
 
  if(! $row['sender_name']){
  $row['sender_name'] = $pcomset['name_empty'];
  }
  
  if($row['sender_email']){
  $row['sender_name']="<a href=\"mailto:$row[sender_email]\">$row[sender_name]</a>";
  }
 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
 $ret.=<<<HTMLDATA
<tr class="pComHdr">
 <td>$row[sender_name]</td>
 <td align="right">$row[cpdate]</td>
</tr>
<tr>
 <td colspan="2">$row[scomment]
HTMLDATA;

  if($row['admin_reply']){
  $ret.=<<<HTMLDATA
<br><br><table cellspacing="0" cellpadding="0" width="100%" border="0">
<tr>
 <td width="50">&nbsp;</td>
 <td class="pComHdr">$pcomset[admin_name]</td>
 <td align="right" class="pComHdr">$row[ardate]</td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td colspan="2">$row[admin_reply]</td>
</tr>
</table>
HTMLDATA;
  }

 $ret.=<<<HTMLDATA
 </td>
</tr>
<tr>
 <td colspan="2"><br>&nbsp;<a href="javascript:replycomment($row[comid])">$lang[reply]</a> | <a href="javascript:editcomment($row[comid])">$lang[edit]</a> | <a href="javascript:delcomment($row[comid])">$lang[delete]</a></td>
</tr>
<tr>
 <td colspan="2"><br><img src="adm/img/hr.gif" width="100%" height="1" style="margin-bottom:2px"></td>
</tr>
HTMLDATA;
 }

$ret.='</table>';

$kolvopagesconst=ceil($q_comments / $pcomset['qpcomm']);

 if($pg>1 && $pg>$kolvopagesconst){
 return '';
 }

$full_pagebar = '';
$pagebar = '';

 if($kolvopagesconst>1 && empty($_GET['show_all'])){

 $kolvopages = $kolvopagesconst;
 $pagenumber = 1;

  while($kolvopages>0){
   if($pagenumber == $pg){
   $pagebar .= "<span class=\"PgOpen\">$pagenumber</span> &nbsp;";
   }
   else{
   $pagebar.="<a href=\"?view=product&act=comments&pcsub=list&itemid=$itemid&pg=$pagenumber\" class=\"PglA\">$pagenumber</a> &nbsp;";
   }
 $kolvopages--;
 $pagenumber++;
  }

 if($pg>=$kolvopagesconst){$nextpage='';}else{$nextpage=$lang['next'];}
 if($pg<=1){$prevpage='';}else{$prevpage=$lang['previous'];}

 $nextpagenumber=$pg+1;
 $prevpagenumber=$pg-1;

  if($prevpagenumber==1 && $prevpage){
 $full_pagebar.="<a href=\"?view=product&act=comments&pcsub=list&itemid=$itemid&pg=$prevpagenumber\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }
  elseif($prevpage){
  $full_pagebar.="<a href=\"?view=product&act=comments&pcsub=list&itemid=$itemid&pg=$prevpagenumber\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

 $full_pagebar.=$pagebar;

 if($nextpage){$full_pagebar.="<a href=\"?view=product&act=comments&pcsub=list&itemid=$itemid&pg=$nextpagenumber\" rel=\"next\" class=\"PglNext\">$nextpage</a>";}

 }

 if($full_pagebar){
 $full_pagebar='<p class="PgLinks">'.$full_pagebar.'</p>';
 }


return $ret.$full_pagebar.$this->footer();
}



function comment_form($comid, $pcsub){
global $db, $pcomset, $lang, $custom, $sett, $admset;
$comid=intval($comid);
$tbl_item_comments=DB_PREFIX.'item_comments';
$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$tbl_users=DB_PREFIX.'users';

 if(! empty($_POST['auto_br_admin_reply'])){
 $_POST['admin_reply'] = nl2br($_POST['admin_reply'], false);
 }

$res = $db->query("SELECT * FROM `$tbl_item_comments` WHERE `comid` = $comid") or die($db->error());
$row_com=$db->fetch_array($res);
 if(! $row_com['comid']){
 return 'Comment not found';
 }

$row_com['itemid']=intval($row_com['itemid']);
$res = $db->query("SELECT `$tbl_items`.`title`, `$tbl_items`.`itemname`, `$tbl_items`.`visible`, `$tbl_categories`.`fcatname` FROM `$tbl_items`, `$tbl_categories` WHERE `$tbl_items`.`itemid` = '$row_com[itemid]' AND `$tbl_categories`.`catid` = `$tbl_items`.`catid`") or die($db->error());
$row_item=$db->fetch_array($res);

$row_com['userid'] = intval($row_com['userid']);
$row_user = array();
 if($row_com['userid']){
 $res = $db->query("SELECT `username` FROM `$tbl_users` WHERE `userid` = '$row_com[userid]'") or die($db->error());
 $row_user=$db->fetch_array($res);
 }

$ret='';

 if(! empty($_POST['save'])){
 $row_com = array_merge($row_com, $custom->stripslashes_array($_POST));
 $cpdate = $row_com['cpdate'];
 $ardate = $row_com['ardate'];
 $row_com['visible'] = isset($_POST['visible']) ? $_POST['visible'] : '';
 $ret.=$this->update_comment($comid, $pcsub, $row_com, $row_item, $row_user);
 }
 else{
 $cpdate = $this->date_to_array($row_com['cpdate']);
  if(! $row_com['ardate']){
  $row_com['ardate'] = time();
  }
 $ardate = $this->date_to_array($row_com['ardate']);
 }


 if($row_item['visible']){
 $product_link='<a href="'.@stdi2("product=$row_com[itemid]", $custom->statlink($row_item['fcatname'], "$row_item[itemname].html", "product$row_com[itemid].html", 'p'))."\" target=\"_blank\">$row_item[title]</a>";
 }
 else{
 $product_link=$row_item['title'];
 }

 if(empty($row_user['username'])){
 $row_user['username']  = $lang['not_auth'];
 }

 if($row_com['visible']){
 $row_com['visible'] = ' checked="checked"';
 }

 if(! empty($_POST['notifi_user'])){
 $_POST['notifi_user'] = ' checked="checked"';
 }
 else{
 $_POST['notifi_user'] = '';
 }

 if($admset['wysiwyg']){
 require_once(INC_DIR."/editor.php");
 $editor=new editor;
 $editor_link=$editor->script_link();
 }

$ret.=<<<HTMLDATA
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=$sett[charset]">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>$lang[comment_to] &quot;$row_item[title]&quot;</title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">$editor_link
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#FFFFFF">
<form name="pcomfrm" action="?" method="POST">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="comments">
<input type="hidden" name="pcsub" value="$pcsub">
<input type="hidden" name="comid" value="$comid">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="save" value="1">
<table cellspacing="0" cellpadding="0" class="settbl" width="100%">
<tr class="htr">
 <td colspan="2">$lang[comment_to] &quot;$product_link&quot;</td>
</tr>
HTMLDATA;

 if($pcsub==='edit'){
 $ret.=<<<HTMLDATA
<tr class="str">
 <td>$lang[username]</td>
 <td>$row_user[username]</td>
</tr>
<tr class="ttr">
 <td>$lang[sender_email]</td>
 <td><input type="text" name="sender_email" value="$row_com[sender_email]" size="34"></td>
</tr>
<tr class="str">
 <td>$lang[sender_name]</td>
 <td><input type="text" name="sender_name" value="$row_com[sender_name]" size="34"></td>
</tr>
<tr class="ttr">
 <td>$lang[cpdate]<br>($lang[date_format])</td>
 <td><input type="text" name="cpdate[day]" value="$cpdate[day]" size="2" maxlength="2">.<input type="text" name="cpdate[month]" value="$cpdate[month]" size="2" maxlength="2">.<input type="text" name="cpdate[year]" value="$cpdate[year]" size="4" maxlength="4"> &nbsp; <input type="text" name="cpdate[hour]" value="$cpdate[hour]" size="2" maxlength="2">:<input type="text" name="cpdate[minutes]" value="$cpdate[minutes]" size="2" maxlength="2">:<input type="text" name="cpdate[seconds]" value="$cpdate[seconds]" size="2" maxlength="2"></td>
</tr>
<tr class="str">
 <td>$lang[scomment]</td>
 <td><textarea id="scomment" name="scomment" cols="60" rows="12">$row_com[scomment]</textarea></td>
</tr>
<tr class="ttr">
 <td><input type="checkbox" name="visible"$row_com[visible]>$lang[visible]</td>
 <td>&nbsp;</td>
</tr>
<tr class="str">
 <td>$lang[sort_index]</td>
 <td><input type="text" name="sortid" value="$row_com[sortid]" size="10"></td>
</tr>
HTMLDATA;
 }
 elseif($pcsub==='reply'){
  if(! $row_com['sender_name']){
  $row_com['sender_name'] = $pcomset['name_empty'];
  }
  if($row_com['sender_email']){
  $sender_name="<a href=\"mailto:$row_com[sender_email]\">$row_com[sender_name]</a>";
  }
  else{
  $sender_name=$row_com['sender_name'];
  }
 $comment_date=date("d.m.Y H:i:s", $row_com['cpdate'] + $sett['time_diff'] * 3600);
 $ret.=<<<HTMLDATA
<tr class="str">
 <td>$sender_name</td><td align="right">$comment_date</td>
</tr>
<tr class="ttr">
 <td colspan="2">$row_com[scomment]</td>
</tr>
<tr class="str">
 <td>$lang[ardate]<br>($lang[date_format])</td>
 <td><input type="text" name="ardate[day]" value="$ardate[day]" size="2" maxlength="2">.<input type="text" name="ardate[month]" value="$ardate[month]" size="2" maxlength="2">.<input type="text" name="ardate[year]" value="$ardate[year]" size="4" maxlength="4"> &nbsp; <input type="text" name="ardate[hour]" value="$ardate[hour]" size="2" maxlength="2">:<input type="text" name="ardate[minutes]" value="$ardate[minutes]" size="2" maxlength="2">:<input type="text" name="ardate[seconds]" value="$ardate[seconds]" size="2" maxlength="2"></td>
</tr>
<tr class="ttr">
 <td colspan="2">$lang[admin_reply]<br><textarea id="admin_reply" name="admin_reply" cols="60" rows="12">$row_com[admin_reply]</textarea><div id="auto_br_admin_reply"><input type="checkbox" name="auto_br_admin_reply">$lang[auto_br]</div><br></td>
</tr>
HTMLDATA;
  if($row_com['sender_email']){
  $ret.=<<<HTMLDATA
<tr class="str">
 <td colspan="2"><input type="checkbox" name="notifi_user"$_POST[notifi_user]>$lang[notifi_user]</td>
</tr>
HTMLDATA;
  }
 }

$ret.=<<<HTMLDATA
<tr class="ftr"><td colspan="2"><br>&nbsp; <input type="submit" value="$lang[submit]" class="button1"><br></td></tr>
</table>
</form>
HTMLDATA;
 if($admset['wysiwyg']){
  if($pcsub==='reply'){
  $ret.=$editor->init_js(array('admin_reply'));
  }
 }
$ret.='</body></html>';


return $ret;
}



function update_comment($comid, $pcsub, $row_com, $row_item, $row_user){
global $admin_lib, $lang, $db, $sett, $custom;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$comid=intval($comid);
$cpdate = isset($_POST['cpdate']) ? $this->array_to_date($_POST['cpdate']) : 0;
$ardate = isset($_POST['ardate']) ? $this->array_to_date($_POST['ardate']) : 0;

$tbl=DB_PREFIX.'item_comments';
$data = $db->secstr_array($_POST);
 if(! empty($data['visible'])){
 $data['visible'] = 1;
 }
 else{
 $data['visible'] = 0;
 }
$data['sortid'] = isset($data['sortid']) ? intval($data['sortid']) : 0;

 if($pcsub==='edit'){
 $query = "UPDATE `$tbl` SET `sender_email` = '$data[sender_email]', `sender_name` = '$data[sender_name]', `cpdate` = '$cpdate', `scomment` = '$data[scomment]', `visible` = '$data[visible]', `sortid` = '$data[sortid]' WHERE comid = $comid";
 }
 elseif($pcsub==='reply'){
 $query = "UPDATE `$tbl` SET `ardate` = '$ardate', `admin_reply` = '$data[admin_reply]' WHERE comid = $comid";
 }
 else{
 return 'Invalid parametrs.';
 }

$db->query($query) or die($db->error());

 if(! empty($_POST['notifi_user']) && $row_com['sender_email']){
 require_once(INC_DIR."/mailer.php");
 $mailer = new mailer;
 $mailtext = $mailer->get_tplfile('product_comment_reply_notifi_user');
 $mailtext = str_replace('{product_title}', $row_item['title'], $mailtext);
 $mailtext = str_replace('{product_url}', $sett['url'] . substr(@stdi2("product=$row_com[itemid]", $custom->statlink($row_item['fcatname'], "$row_item[itemname].html", "product$row_com[itemid].html", 'p')), 1), $mailtext);
 $mailtext = str_replace('{scomment}', $this->strip_mailbody($row_com['scomment']), $mailtext);
 $mailtext = str_replace('{admin_reply}', $this->strip_mailbody($row_com['admin_reply']), $mailtext);
 $mailtext = str_replace('{username}', $row_user['username'], $mailtext);
 $mailtext = str_replace('{sender_name}', $row_com['sender_name'], $mailtext);
 $mailtext = str_replace('{sender_email}', $row_com['sender_email'], $mailtext);
 $mailer->sendemail($sett['shop_name'], $sett['email'], $row_com['sender_name'], $row_com['sender_email'], $lang['subject'], $mailtext);
 }

return "<h3>$lang[changes_success]</h3>";
}



function date_to_array($intdate){
global $sett;
$intdate = intval($intdate) + intval($sett['time_diff']) * 3600;
$ret=array();
$ret['year']=date('Y', $intdate);
$ret['month']=date('m', $intdate);
$ret['day']=date('d', $intdate);
$ret['hour']=date('H', $intdate);
$ret['minutes']=date('i', $intdate);
$ret['seconds']=date('s', $intdate);
return $ret;
}


function array_to_date($strdate){
global $sett;
 if(! is_array($strdate)){
 return 0;
 }
 if(sizeof($strdate)){
  foreach($strdate as $name => $value){
  $strdate["$name"] = $value;
  }
 }
return intval(strtotime("$strdate[year]-$strdate[month]-$strdate[day] $strdate[hour]:$strdate[minutes]:$strdate[seconds]")) - intval($sett['time_diff']) * 3600;
}


function strip_mailbody($body){
$body = strip_tags(str_replace('>', '> ', $body));
$body = custom::rn_to_n($body);
$body = str_replace("\n", ' ', $body);
return $this->delete_double_spaces($body);
}


function delete_double_spaces($str){
return preg_replace("/[\x09\x20]+/", ' ', $str);
}


function delete_comment($comid){
global $admin_lib, $db, $lang, $sett;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$comid=intval($comid);
$tbl_item_comments=DB_PREFIX.'item_comments';
$tbl_item_comments_new=DB_PREFIX.'item_comments_new';
$db->query("DELETE FROM `$tbl_item_comments` WHERE `comid` = $comid") or die($db->error());
$db->query("DELETE FROM `$tbl_item_comments_new` WHERE `comid` = $comid") or die($db->error());
$ret=<<<HTMLDATA
<!DOCTYPE html><html><head>
<meta http-equiv="Content-type" content="text/html; charset=$sett[charset]">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>$lang[delete_comment]</title>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#FFFFFF">
HTMLDATA;
$ret .= $admin_lib->good_msg("$lang[comment_deleted]<br><br><a href=\"javascript:self.close()\">$lang[close]</a><br><br><a href=\"javascript:opener.location.reload();self.close()\">$lang[refresh]</a>", 0);
$ret.='</body></html>';
return $ret;
}


function new_comments(){
global $db, $pcomset, $admset, $lang, $custom, $sett;
$admset['qpnewpcom'] = isset($admset['qpnewpcom']) ? intval($admset['qpnewpcom']) : 0;
 if($admset['qpnewpcom'] < 1){
 $admset['qpnewpcom'] = 10 ;
 }
$qpnewpcom_src=$admset['qpnewpcom'];

 if(! empty($_POST['save'])){
 echo $this->update_new_comments();
 }

$show_all = 0;
 if(! empty($_GET['show_all']) || ! empty($_POST['show_all'])){
 $show_all = 1;
 $limit='';
 }
 else{
 $limit=" LIMIT $admset[qpnewpcom]";
 }

$custom->get_lang('admin_lang/product_comments_new');

$tbl_item_comments=DB_PREFIX.'item_comments';
$tbl_item_comments_new=DB_PREFIX.'item_comments_new';

$res = $db->query("SELECT COUNT(*) FROM $tbl_item_comments_new") or die($db->error());
$q_comments = $db->result($res, 0, 0);

$ret="<h4>$lang[new_comments]</h4>";

 if(! $q_comments){
 $ret.="<p>$lang[no_new_comments]</p>";
 return $ret;
 }


 if($q_comments < $admset['qpnewpcom']){
 $admset['qpnewpcom'] = $q_comments;
 }

$res = $db->query("SELECT * FROM $tbl_item_comments_new, $tbl_item_comments WHERE $tbl_item_comments.comid = $tbl_item_comments_new.comid ORDER BY `cpdate`$limit") or die($db->error());

$ret.=$this->js_functions();
$ret.=<<<HTMLDATA
<form name="newcomfrm" action="?" method="POST">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="comments">
<input type="hidden" name="pcsub" value="new">
<input type="hidden" name="show_all" value="$show_all">
<input type="hidden" name="save" value="1">
HTMLDATA;
 if(! $show_all){
 $ret.="<p>$lang[shows_first] $admset[qpnewpcom] $lang[of] $q_comments $lang[of_new_comments]. <a href=\"?view=product&act=comments&pcsub=new&show_all=1\">$lang[show_all]</a>.</p>";
 }
 
$ret.='<table cellspacing="0" cellpadding="0" width="100%" border="0" class="settbl">';

$def_class='ttr';
 while($row = $db->fetch_array($res)){
 $item_attr=$this->get_item_attr($row['itemid']);
 
 $row['cpdate']=date("d.m.Y H:i:s", $row['cpdate'] + $sett['time_diff'] * 3600);
 $row['ardate']=date("d.m.Y H:i:s", $row['ardate'] + $sett['time_diff'] * 3600);
 
  if(! $row['sender_name']){
  $row['sender_name'] = $pcomset['name_empty'];
  }
  
  if($row['sender_email']){
  $row['sender_name']="<a href=\"mailto:$row[sender_email]\">$row[sender_name]</a>";
  }
 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
 $ret.=<<<HTMLDATA
<tr class="pComHdr">
 <td colspan="2">$lang[comment_to] &quot;$item_attr[link]&quot;</td>
</tr>
<tr class="pComHdr">
 <td>$row[sender_name]</td>
 <td align="right">$row[cpdate]</td>
</tr>
<tr>
 <td colspan="2">$row[scomment]
HTMLDATA;

  if($row['admin_reply']){
  $ret.=<<<HTMLDATA
<br><br><table cellspacing="0" cellpadding="0" width="100%" border="0">
<tr>
 <td width="50">&nbsp;</td>
 <td class="pComHdr">$pcomset[admin_name]</td>
 <td align="right" class="pComHdr">$row[ardate]</td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td colspan="2">$row[admin_reply]</td>
</tr>
</table>
HTMLDATA;
  }

 $ret.=<<<HTMLDATA
 </td>
</tr>
<tr>
 <td colspan="2"><br>&nbsp;<a href="javascript:replycomment($row[comid])">$lang[reply]</a> | <a href="javascript:editcomment($row[comid])">$lang[edit]</a> | <input type="radio" name="new_com_approve[$row[comid]]" value="1" checked="checked">$lang[approve] <input type="radio" name="new_com_approve[$row[comid]]" value="0">$lang[delete]
 </td>
</tr>
<tr>
 <td colspan="2"><br><img src="adm/img/hr.gif" width="100%" height="1" style="margin-bottom:2px"></td>
</tr>
HTMLDATA;
 }

$ret.="</table><p>$lang[save_descript]";

 if(! $show_all){
 $ret.="<br>$lang[next_step] $qpnewpcom_src $lang[to_next_comments].";
 }

$ret.=<<<HTMLDATA
</p><input type="submit" value="$lang[submit]" class="button1">
</form>
HTMLDATA;

return $ret;
}


function js_functions(){
global $lang;
return <<<HTMLDATA
<script type="text/javascript"> 
function replycomment(id){window.open('?view=product&act=comments&pcsub=reply&comid='+id+'&independ=1','','status,scrollbars,resizable,width=724,height=520');}
function editcomment(id){window.open('?view=product&act=comments&pcsub=edit&comid='+id+'&independ=1','','status,scrollbars,resizable,width=724,height=450');}
function delcomment(id){if(q('$lang[del_this_comment]')){window.open('?view=product&act=comments&pcsub=delete&comid='+id+'&independ=1','','width=300,height=160');}}
</script>
HTMLDATA;
}


function footer(){
global $lang;
return <<<HTMLDATA
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=product&act=comments&pcsub=new">$lang[new_comments]</a><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=product_comments">$lang[comments_settings]</a></p>
HTMLDATA;
}

function get_item_attr($itemid){
global $db, $custom;
$itemid=intval($itemid);
$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$res = $db->query("SELECT `$tbl_items`.`itemid`, `$tbl_items`.`itemname`, `$tbl_items`.`catid`, `$tbl_items`.`title`, `$tbl_items`.`visible`, `$tbl_categories`.`fcatname` FROM `$tbl_items`, `$tbl_categories` WHERE `$tbl_items`.`itemid` = $itemid AND `$tbl_categories`.`catid` = `$tbl_items`.`catid`") or die($db->error());
$row = $db->fetch_array($res);
 if(! $row['itemid']){
 return array();
 }
 if($row['visible']){
 $product_link='<a href="'.@stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'))."\" target=\"_blank\">$row[title]</a>";
 }
 else{
 $product_link=$row['title'];
 }
return array('title' => $row['title'], 'link' => $product_link);
}



function update_new_comments(){
global $db, $admin_lib, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$tbl_item_comments=DB_PREFIX.'item_comments';
$tbl_item_comments_new=DB_PREFIX.'item_comments_new';
 if(is_array($_POST['new_com_approve'])){
  if(sizeof($_POST['new_com_approve'])){
   foreach($_POST['new_com_approve'] as $comid => $approve){
   $comid=intval($comid);
    if($approve){
    $db->query("UPDATE `$tbl_item_comments` SET `visible` = 1 WHERE `comid` = $comid") or die($db->error());
    }
    else{
    $db->query("DELETE FROM `$tbl_item_comments` WHERE `comid` = $comid") or die($db->error());
    }
   $db->query("DELETE FROM `$tbl_item_comments_new` WHERE `comid` = $comid") or die($db->error());
   }
  }
 }
return "<h4>$lang[changes_success]</h4>";
}



}

?>