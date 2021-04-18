<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class orders{

public $statuses = array();


function __construct($get_statuses=1){
if(! $get_statuses){return true;}
require_once(INC_DIR."/profile.php");
$profile = new profile;
$this->statuses = $profile->get_order_statuses();
return true;
}


function get_orders(){
global $db, $lang, $admin_lib, $sett, $admset;

if(! $admset['orders_recordsonpage']){$admset['orders_recordsonpage']=20;}

$pg = isset($_GET['pg']) ? intval(str_replace('-', '', $_GET['pg'])) : 0;
if(! $pg){$pg=1;}

$sort = isset($_GET['sort']) ? preg_replace('/[^a-z\_]/', '', $_GET['sort']) : '';

 switch($sort){
 case 'orderid':
 $orderby='orderid DESC';
 break;

 case 'status':
 $orderby='status';
 break;

 case 'total_with_discount':
 $orderby='total_with_discount DESC';
 break;

 case 'currency':
 $orderby='currency';
 break;

 case 'pay_method':
 $orderby='paymethod';
 break;

 case 'username':
 $orderby='username';
 break;

 case 'first_name':
 $orderby='first_name';
 break;

 case 'last_name':
 $orderby='last_name';
 break;

 case 'email':
 $orderby='email';
 break;

 default:
 $orderby='orderid DESC';
 $sort='orderid';
 }

$record = $pg * $admset['orders_recordsonpage'] - $admset['orders_recordsonpage'];

$sum_help = custom::contextHelp($lang['total_prompt']);

$ret = <<<HTMLDATA
<table class="settbl">
<tr class="htr">
<td colspan="10">$lang[sort_by]</td>
</tr>
 <tr class="htr">
  <td><a href="?view=orders&sort=orderid">$lang[order_number]</a></td>
  <td><a href="?view=orders&sort=status">$lang[status]</a></td>
  <td><a href="?view=orders&sort=total_with_discount">$lang[sum]</a> $sum_help</td>
  <td><a href="?view=orders&sort=currency">$lang[currency]</a></td>
  <td><a href="?view=orders&sort=pay_method">$lang[pay_method]</a></td>
  <td><a href="?view=orders&sort=username">$lang[username]</a></td>
  <td><a href="?view=orders&sort=first_name">$lang[first_name]</a></td>
  <td><a href="?view=orders&sort=last_name">$lang[last_name]</a></td>
  <td><a href="?view=orders&sort=email">$lang[email]</a></td>
  <td>$lang[delete]</td>
 </tr>
HTMLDATA;

$tbl=DB_PREFIX.'orders';

$res=$db->query("SELECT COUNT(*) FROM $tbl") or die($db->error());
$quantity_orders=$db->result($res,0,0);

$res=$db->query("SELECT orderid, date, status, paymethod, currency_brief, def_currency_brief, total_with_discount, userid, username, first_name, last_name, email FROM $tbl ORDER BY $orderby LIMIT $record, $admset[orders_recordsonpage]") or die($db->error());

 while($row=$db->fetch_array($res)){
 $def_class=$admin_lib->sett_class();

 if($row['date']){
 $row['date']=date("d.m.Y H:i:s", $row['date'] + $sett['time_diff'] * 3600);
 }
 else{
 $row['date']='';
 }

 if($row['username']){
 $row['username'] = "<a href=\"?view=users&act=edit&userid=$row[userid]\">$row[username]</a>";
 }
 else{
 $row['username']=$lang['not_authorized'];
 }

 $status_name = $this->statuses["$row[status]"]['name'];
 $ret .= <<<HTMLDATA
 <tr class="$def_class">
  <td><a href="?view=orders&act=detail&orderid=$row[orderid]">&#8470; $row[orderid]<br>$row[date]</a></td>
  <td>$status_name</td>
  <td>$row[total_with_discount] $row[def_currency_brief]</td>
  <td>$row[currency_brief]</td>
  <td>$row[paymethod]</td>
  <td>$row[username]</td>
  <td>$row[first_name]</td>
  <td>$row[last_name]</td>
  <td>$row[email]</td>
  <td align="center"><a href="?view=orders&act=del&orderid=$row[orderid]" onclick="return q('$lang[delete_this_order]')"><img src="adm/img/del.gif" border="0" alt="$lang[delete]"></a></td>
 </tr>
HTMLDATA;

 }

$ret.="<tr class=\"ftr\"><td colspan=\"10\">&nbsp;</td></table>";


 $quantity_pages = ceil($quantity_orders / $admset['orders_recordsonpage']);

 if($quantity_pages > 1){
 $ret.="<p align=\"left\">$lang[pages] ";
 $pagenumber=1;
  while($pagenumber<=$quantity_pages){
   if($pagenumber != $pg){
   $ret.="<a href=\"?view=orders&pg=$pagenumber&sort=$sort\">$pagenumber</a> &nbsp;";
   }
   else{
   $ret.="$pagenumber &nbsp;";
   }
  $pagenumber++;
  }
 $ret.="</p>";
 }


return $ret;
}


function get_order_info($orderid){
global $db;
$orderid=intval($orderid);
if(! $orderid){return '';}
$tbl=DB_PREFIX.'orders';
$res=$db->query("SELECT * FROM $tbl WHERE orderid = $orderid") or die($db->error());
return $db->fetch_array($res);
}


function get_additional_fields($orderid){
global $db;
$orderid=intval($orderid);
$ret=array();
if(! $orderid){return $ret;}
$tbl=DB_PREFIX.'orders_add_fields_values';
$res=$db->query("SELECT * FROM `$tbl` WHERE `orderid` = $orderid") or die($db->error());
 while($row=$db->fetch_array($res)){
 $row2=array();
  foreach($row as $name => $value){
   if(! is_numeric($name)){
   $row2["$name"]=$value;
   }
  }
 array_push($ret, $row2);
 }
return $ret;
}


function get_order_items($orderid){
global $db;
$orderid=intval($orderid);
if(! $orderid){return '';}
$tbl=DB_PREFIX.'orders_items';
$res=$db->query("SELECT * FROM $tbl WHERE orderid = $orderid") or die($db->error());
$order_items=array();
 while($row=$db->fetch_array($res)){
 array_push($order_items, $row); 
 }
return $order_items;
}


function update_order_info(){
global $db, $admin_lib, $sett, $admset, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$_POST['orderid']=intval($_POST['orderid']);
if(! $_POST['orderid']){return 0;}
$_POST['status']=intval($_POST['status']);
$tbl=DB_PREFIX.'orders';
$db->query("UPDATE $tbl SET status = '$_POST[status]', adm_pub_comment = '$_POST[admin_public_comment]', admin_comment = '$_POST[admin_comment]' WHERE orderid = $_POST[orderid]") or die($db->error());

 if($_POST['change_products_count']){
 require_once(INC_DIR."/shop_order.php");
 $shop_order=new shop_order;
  if($_POST['change_products_count']==='-'){
  $shop_order->order_products_reduction($_POST['orderid']);
  }
  elseif($_POST['change_products_count']==='+'){
  $shop_order->order_products_reduction($_POST['orderid'], 1);
  }
 }


 if($_POST['status'] != $_POST['old_status']){
 $tbl_orders=DB_PREFIX.'orders';
 $tbl_users=DB_PREFIX.'users';
 $res = $db->query("SELECT userid, email, first_name FROM $tbl_orders WHERE orderid = $_POST[orderid]") or die($db->error());
 $row = $db->fetch_array($res);
 require_once(INC_DIR."/mailer.php");
 $mailer=new mailer;

  if($admset['notify_ch_status'] && $row['email']){
   if($mailer->valid_email($row['email']) && $mailer->valid_email($sett['email'])){
   $mailtext = $mailer->get_tplfile('change_order_status');
   $mailtext = str_replace('{first_name}', $row['first_name'], $mailtext);
   $mailtext = str_replace('{order_number}', $_POST['orderid'], $mailtext);
   $mailtext = str_replace('{order_status}', $this->statuses["$_POST[status]"]["name"], $mailtext);
   $mailtext = str_replace('{admin_public_comment}', $_POST['admin_public_comment'], $mailtext);
   $mailer->sendemail($sett['shop_name'], $sett['email'], $row['first_name'], $row['email'],  "$lang[changing_status]$_POST[orderid]", $mailtext);
   }
  }


  if($row['userid'] > 0){
  $res2 = $db->query("SELECT groupid FROM $tbl_users WHERE userid = $row[userid]") or die($db->error());
  $row2 = $db->fetch_array($res2);
  $this->auto_change_user_group($row['userid']);
  }

 }


return 1;
}



function delete_order($orderid){
global $db, $admin_lib;
$orderid=intval($orderid);
if(! $orderid){return 0;}
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(empty($db->handler) || empty($db->dbname)){
 die('Invalid db handler or db name (5)!'); 
 }

$tbl=DB_PREFIX.'orders';
$db->query("DELETE FROM `$db->dbname`.$tbl WHERE orderid = $orderid") or die($db->error());

$tbl=DB_PREFIX.'orders_items';
$db->query("DELETE FROM `$db->dbname`.$tbl WHERE orderid = $orderid") or die($db->error());

$tbl=DB_PREFIX.'wm_merchant';
$db->query("DELETE FROM `$db->dbname`.$tbl WHERE orderid = $orderid") or die($db->error());

$tbl=DB_PREFIX.'orders_add_fields_values';
$db->query("DELETE FROM `$db->dbname`.$tbl WHERE orderid = $orderid") or die($db->error());

return 1;
}



function auto_change_user_group($userid){
global $db, $sett, $lang;
$userid = intval($userid);
 if(! $userid){
 return false;
 }
$tbl_users=DB_PREFIX.'users';
$res = $db->query("SELECT groupid, email, first_name FROM $tbl_users WHERE userid = $userid") or die($db->error());
$row=$db->fetch_array($res);
$groupid = $row['groupid'];
$email = $row['email'];
$first_name = $row['first_name'];

$achgr_ordstatuses = '';

 if(sizeof($this->statuses)){
  foreach($this->statuses as $status_id => $status_arr){
   if($status_arr['auto_change_group']){
   $achgr_ordstatuses.="$status_id,";
   }
  }
 }

 if(substr($achgr_ordstatuses, strlen($achgr_ordstatuses)-1)===','){
 $achgr_ordstatuses=substr($achgr_ordstatuses, 0, strlen($achgr_ordstatuses)-1);
 }

 if(strlen($achgr_ordstatuses) < 1){
 return false;
 }

$total_sum = 0.00;
$tbl=DB_PREFIX.'orders';
$res = $db->query("SELECT total_with_discount FROM $tbl WHERE userid = $userid AND status IN ($achgr_ordstatuses)")or die($db->error());
 while($row = $db->fetch_array($res)){
 $total_sum += $row['total_with_discount'];
 }

$tbl=DB_PREFIX.'users_groups';

$res = $db->query("SELECT groupid, groupname, descript, autochgroup_sum FROM $tbl WHERE autochgroup = 1 AND groupid <> 1")or die($db->error());

$optimal_group = array('autochgroup_sum' => 0);

 while($row = $db->fetch_array($res)){


  if($total_sum > $row['autochgroup_sum']){
   if($optimal_group['autochgroup_sum'] == 0 || $row['autochgroup_sum'] > $optimal_group['autochgroup_sum']){
   $optimal_group = $row;
   }
  }
 }



 if(! $optimal_group['groupid'] || $optimal_group['groupid'] == $groupid){
 return false;
 }

$tbl=DB_PREFIX.'users';

$db->query("UPDATE $tbl SET groupid = $optimal_group[groupid] WHERE userid = $userid")or die($db->error());

 if($_SESSION['arwshop_mk']['user']['groupid']){
 $_SESSION['arwshop_mk']['user']['groupid'] = $optimal_group['groupid'];
 }


  if($email){
  require_once(INC_DIR."/mailer.php");
  $mailer = new mailer;

  $tbl=DB_PREFIX.'users_groups';
  $res = $db->query("SELECT groupname, descript FROM $tbl WHERE groupid = $optimal_group[groupid]") or die($db->error());
  $row = $db->fetch_array($res);
  $mailtext = $mailer->get_tplfile('admin_change_user_group');
  $mailtext = str_replace('{first_name}', $first_name, $mailtext);
  $mailtext = str_replace('{user_group}', $row['groupname'], $mailtext);

  $mailtext = str_replace('{discount}%.', '', $mailtext);
  $mailtext = str_replace('{discount}', '', $mailtext);
  $mailtext = str_replace('%', '', $mailtext);

  $mailtext = str_replace('{group_description}', strip_tags($row['descript']), $mailtext);
  $mailer->sendemail($sett['shop_name'], $sett['email'], $first_name, $email, $lang['user_group_changed'], $mailtext);
  }


return true;
}


function adm_calc_price($price, $course){
$new_price = pricef($price / $course);
 if($price > 0 && $new_price < 0.01){
 $new_price = '0.01';
 }
 elseif($price < 0 && $new_price > -0.01){
 $new_price = '-0.01';
 }
return $new_price;
}



}
?>