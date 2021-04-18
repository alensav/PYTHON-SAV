<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class pmblanks{


function get_all_blanks(){
global $lang, $db, $admin_lib;
$ret=<<<HTMLDATA
<h3>$lang[payment_blanks]</h3>
$lang[payment_blanks_info]<br>
<a href="#" onclick="window.open('?view=help&hpage=payment_blanks_add_poss&independ=1','','status,scrollbars,resizable,width=600,height=400');return false;">$lang[tech_descript]</a><br><br>

<table width="100%" class="settbl">
 <tr class="htr">
  <td>$lang[blank_title]</td>
  <td>$lang[for_paymethod]</td>
  <td align="center">$lang[delete]</td>
 </tr>
HTMLDATA;

$all_pamethods_arr = $this->get_paymethods_arr();

$tbl=DB_PREFIX.'payment_blanks';
$res=$db->query("SELECT `blank_id`, `paymethod_id`, `blank_title` FROM `$tbl` ORDER BY `sortid`, `blank_title`") or die($db->error());

 while($row=$db->fetch_array($res)){
 $paymethod = isset($all_pamethods_arr[$row['paymethod_id']]) ? $all_pamethods_arr[$row['paymethod_id']] : '';
 $def_class = $admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class">
 <td><a href="?view=settings&settype=payment_blanks&act=payblank_edit&blank_id=$row[blank_id]">$row[blank_title]</a></td>
 <td>$paymethod</td>
 <td align="center"><a href="?view=settings&settype=payment_blanks&act=payblank_delete&blank_id=$row[blank_id]" onclick="return q('$lang[delete_this_blank]')"><img src="adm/img/del.gif" border="0" alt="$lang[delete]"></a></td>
</tr>
HTMLDATA;
 }

$ret.=<<<HTMLDATA
</table>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=payment_blanks&act=payblank_add">$lang[add_blank]</a></p>
HTMLDATA;

return $ret;
}


function payblank_form(){
global $act, $lang, $blank_id;
$blank_id = intval($blank_id);

 if(! empty($_POST['save'])){
 echo $this->save_blank($blank_id);
 }

$blank_data = $this->get_blank_data($blank_id);

 if(! isset($blank_data['paymethod_id'])){
 $blank_data['paymethod_id'] = 0;
 }

 if(! isset($blank_data['blank_title'])){
 $blank_data['blank_title'] = '';
 }

 if(! isset($blank_data['blank_text'])){
 $blank_data['blank_text'] = '';
 }

 if(! isset($blank_data['sortid'])){
 $blank_data['sortid'] = 0;
 }

 if($act == 'payblank_edit'){
 $title = "$lang[edit_blank] <a href=\"?view=settings&settype=payment_blanks&act=payblank_preview&blank_id=$blank_data[blank_id]&independ=1\" target=\"_blank\">($lang[payblank_preview])</a>";
 }
 else{
 $title = $lang['add_blank'];
 }

$blank_data['sortid'] = intval($blank_data['sortid']);

$pamethods_select = $this->get_pamethods_select($blank_data['paymethod_id']);

$ret=<<<HTMLDATA
<br>
<form method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="payment_blanks">
<input type="hidden" name="act" value="$act">
<input type="hidden" name="blank_id" value="$blank_id">
<input type="hidden" name="save" value="1">
<table class="settbl">
 <tr class="htr">
 <td colspan="2">$title</td>
 </tr>
 <tr class="str">
  <td>$lang[blank_title]</td>
  <td><input type="text" name="blank_title" value="$blank_data[blank_title]" maxlength="255"></td>
 </tr>
 <tr class="ttr">
  <td colspan="2">
  $lang[blank_code]<br>
  <textarea name="blank_text" cols="55" rows="18">$blank_data[blank_text]</textarea><br><br></td>
 </tr>
 <tr class="str">
  <td>$lang[for_payment_method]</td>
  <td>$pamethods_select</td>
 </tr>
 <tr class="ttr">
  <td>$lang[sort_index]<br>
  <td><input type="text" name="sortid" value="$blank_data[sortid]" size="6"></td>
 </tr>
</table><br>
<br><input type="submit" value="$lang[submit]" class="button1" class="button1">
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=payment_blanks">$lang[all_blanks]</a></p>
HTMLDATA;
return $ret;
}


function payblank_preview($blank_id){
global $db;
$blank_id = intval($blank_id);
 if(! $blank_id){
 return '';
 }
$tbl=DB_PREFIX.'payment_blanks';
$res=$db->query("SELECT blank_text FROM $tbl WHERE blank_id = $blank_id")or die($db->error());
$row=$db->fetch_array($res);
return $row['blank_text'];
}


function get_blank_data($blank_id){
global $db;
$blank_id = intval($blank_id);
$tbl=DB_PREFIX.'payment_blanks';
$res=$db->query("SELECT * FROM `$tbl` WHERE `blank_id` = $blank_id") or die($db->error());
return $db->fetch_array($res);
}



function save_blank(){
global $admin_lib, $db, $act, $lang, $blank_id;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$blank_id = intval($blank_id);
$tbl=DB_PREFIX.'payment_blanks';

$_POST['paymethod_id'] = intval($_POST['paymethod_id']);
$_POST['blank_title'] = trim($_POST['blank_title']);
 if(! $_POST['blank_title']){
 $_POST['blank_title']='Blank';
  if($act==='payblank_edit'){
  $_POST['blank_title'].=" $blank_id";
  }
 }
$_POST['blank_title']=$db->secstr($_POST['blank_title']);
$_POST['blank_text']=$db->secstr($_POST['blank_text']);
$_POST['sortid']=intval($_POST['sortid']);

 if($act==='payblank_edit'){
 $db->query("UPDATE `$tbl` SET `paymethod_id` = $_POST[paymethod_id], `blank_title` = '$_POST[blank_title]',  `blank_text` = '$_POST[blank_text]', `sortid` = $_POST[sortid] WHERE `blank_id` = $blank_id") or die($db->error());
 }
 elseif($act==='payblank_add'){
   if(TDTC == 1){
   $res = $db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
    if($db->result($res,0,0) >= 2){
    return mdmogrn("$lang[130] 2 $lang[299]");
    }
   }
 $db->query("INSERT INTO `$tbl` (`blank_id`, `paymethod_id`, `blank_title`,  `blank_text`, `sortid`) VALUES (NULL, $_POST[paymethod_id], '$_POST[blank_title]', '$_POST[blank_text]', $_POST[sortid])") or die($db->error());
 $blank_id = $db->insert_id();
 $act='payblank_edit';
 }
 else{
 return '';
 }

return "<h3>$lang[changes_success]</h3>";
}



function delete_blank($blank_id){
global $admin_lib, $db, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$blank_id = intval($blank_id);
$tbl=DB_PREFIX.'payment_blanks';
$db->query("DELETE FROM `$tbl` WHERE `blank_id` = $blank_id") or die($db->error());
return "<h3>$lang[blank_deleted]</h3>";
}


function get_paymethods_arr(){
global $db;
$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT `pmid`, `pmtitle` FROM `$tbl` ORDER BY `sortid`, `pmtitle`") or die($db->error());
$all_pamethods_arr=array();
 while($row=$db->fetch_array($res)){
 $all_pamethods_arr["$row[pmid]"]=$row['pmtitle'];
 }
return $all_pamethods_arr;
}


function get_pamethods_select($selected_id){
global $lang;
$all_pamethods_arr = $this->get_paymethods_arr();
$ret="<select name=\"paymethod_id\"><option value=\"0\">$lang[not_selected]</option>";
 if(sizeof($all_pamethods_arr)){
  foreach($all_pamethods_arr as $pmid => $pmtitle){
  if($pmid==$selected_id){$selected=' selected';}else{$selected='';}
  $ret.="<option value=\"$pmid\"$selected>$pmtitle</option>";
  }
 }
$ret.="</select>";
return $ret;
}


}
?>