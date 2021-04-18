<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class orders_statistics{

function get_statistics(){
global $db, $lang, $admset, $sett, $admin_lib, $custom;

if($admset['stat_ordersonpage']<1){$admset['stat_ordersonpage']=100;}

$_GET = $custom->trim_array($custom->replace_tags_and_quotes($_GET));

$tbl_orders=DB_PREFIX.'orders';
$tbl_orders_items=DB_PREFIX.'orders_items';

$sort = isset($_GET['sort']) ? preg_replace("([^a-z0-9\_])", '', $_GET['sort']) : '';

 switch($sort){

 case 'total_price':
 $orderby='total_price DESC';
 break;

 case 'total_quantity':
 $orderby='total_quantity DESC';
 break;

 case 'price':
 $orderby="middle_price DESC";
 break;

 case 'title':
 $orderby="$tbl_orders_items.title";
 break;

 case 'sku':
 $orderby="$tbl_orders_items.sku";
 break;

 default:
 $orderby='total_price DESC';

 }


 if(! isset($_GET['begin']) || $_GET['begin'] != 'all'){
 $begin = isset($_GET['begin']) ? intval(str_replace('-', '', $_GET['begin'])) : 0;
 }
 else{
 $begin = 'all';
 $limit = '';
 }

 if(! empty($_GET['date1']) && ! empty($_GET['date2'])){
 $date1 = intval(str_replace('-', '', $_GET['date1']));
 $date2 = intval(str_replace('-', '', $_GET['date2']));
 }
 elseif(empty($_GET['y1']) || empty($_GET['y2'])){
 $date2 = time();
 $date1 = $date2 - 2678400;
 }
 else{

 $_GET['y1']=intval($_GET['y1']);
 if($_GET['y1']<1970){$_GET['y1']=1970;}
 $_GET['m1']=intval($_GET['m1']);
 if($_GET['m1']<1){$_GET['m1']=1;}
 if($_GET['m1']>12){$_GET['m1']=12;}
 if(strlen($_GET['m1'])<2){$_GET['m1']='0'.$_GET['m1'];}
 $_GET['d1']=intval(str_replace('-', '', $_GET['d1']));
 if($_GET['d1']<1){$_GET['d1']=1;}
 if($_GET['d1']>31){$_GET['d1']=31;}
 if(strlen($_GET['d1'])<2){$_GET['d1']='0'.$_GET['d1'];}
 $date1=strtotime("$_GET[y1]-$_GET[m1]-$_GET[d1]");

 $_GET['y2']=intval($_GET['y2']);
 if($_GET['y2']<1970){$_GET['y2']=1970;}
 $_GET['m2']=intval($_GET['m2']);
 if($_GET['m2']<1){$_GET['m2']=1;}
 if($_GET['m2']>12){$_GET['m2']=12;}
 if(strlen($_GET['m2'])<2){$_GET['m2']='0'.$_GET['m2'];}
 $_GET['d2']=intval(str_replace('-', '', $_GET['d2']));
 if($_GET['d2']<1){$_GET['d2']=1;}
 if($_GET['d2']>31){$_GET['d2']=31;}
 if(strlen($_GET['d2'])<2){$_GET['d2']='0'.$_GET['d2'];}
 $date2=strtotime("$_GET[y2]-$_GET[m2]-$_GET[d2]");

 }


$date1 += $sett['time_diff'] * 3600;
$date2 += $sett['time_diff'] * 3600;
$date2_for_srch = $date2 + 86399;

$_GET['y1']=@date("Y", $date1);
$_GET['m1']=@date("m", $date1);
$_GET['d1']=@date("d", $date1);
$_GET['y2']=@date("Y", $date2);
$_GET['m2']=@date("m", $date2);
$_GET['d2']=@date("d", $date2);

 if(isset($_GET['status'])){
 $status = intval($_GET['status']);
 }
 else{
 $status = -1;
 }
$pmid = isset($_GET['pmid']) ? intval($_GET['pmid']) : 0;
$dmid = isset($_GET['dmid']) ? intval($_GET['dmid']) : 0;
$username = isset($_GET['username']) ? $custom->replace_tags_and_quotes($_GET['username']) : '';
$email = isset($_GET['email']) ? $custom->replace_tags_and_quotes($_GET['email']) : '';
$orders_statuses_select=$this->orders_statuses_select($status);
$paymethods_select=$this->paymethods_select($pmid);
$deliverymethods_select=$this->deliverymethods_select($dmid);
$where1 = '';
 if($status>-1){
 $where1 .= "AND `$tbl_orders`.`status` = '$status'";
 }
 if(! empty($_GET['pmid'])){
 $where1 .= "AND `$tbl_orders`.`pmid` = '$pmid'";
 }
 if(! empty($_GET['dmid'])){
 $where1 .= "AND `$tbl_orders`.`dmid` = '$dmid'";
 }
 if($username){
 $where1 .= "AND `$tbl_orders`.`username` = '".$db->secstr($username)."'";
 }
 if($email){
 $where1 .= "AND `$tbl_orders`.`email` = '".$db->secstr($email)."'";
 }

$price_help = custom::contextHelp($lang['middle_price_descr']);

echo <<<HTMLDATA
<form action="?" method="GET">
<input type="hidden" name="view" value="orders_statistics">
<input type="hidden" name="view" value="orders_statistics">
  
<table class="settbl" style="display:inline-block;width:auto;vertical-align:top;">
<tr class="htr"><td>&nbsp;</td><td>$lang[day]</td><td>$lang[month]</td><td>$lang[year]</td></tr>
<tr class="str">
<td>$lang[from_date]</td>
<td><input type="text" name="d1" value="$_GET[d1]" size="3" maxlength="2"></td>
<td><input type="text" name="m1" value="$_GET[m1]" size="3" maxlength="2"></td>
<td><input type="text" name="y1" value="$_GET[y1]" size="6" maxlength="4"></td>
</tr>
<tr class="ttr">
<td>$lang[to_date]</td>
<td><input type="text" name="d2" value="$_GET[d2]" size="3" maxlength="2"></td>
<td><input type="text" name="m2" value="$_GET[m2]" size="3" maxlength="2"></td>
<td><input type="text" name="y2" value="$_GET[y2]" size="6" maxlength="4"></td>
</tr>
</table>

<table style="display:inline-block;vertical-align:top;">
 <tr><td>$lang[status]</td><td>$orders_statuses_select</td></tr>
 <tr><td>$lang[pay_method]</td><td>$paymethods_select</td></tr>
 <tr><td>$lang[delivery_method]</td><td>$deliverymethods_select</td></tr>
 <tr><td>$lang[username]</td><td><input type="text" name="username" value="$username"></td></tr>
 <tr><td>$lang[email]</td><td><input type="text" name="email" value="$email"></td></tr>
</table>

<br><input type="submit" value="$lang[show_statistics]" class="button1">

</form>

<table class="settbl" width="100%">
<tr class="htr"><td colspan="20">$lang[sort_by]</td></tr>
<tr class="htr">
<td><a href="?view=orders_statistics&sort=title&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email">$lang[title]</a></td>
<td><a href="?view=orders_statistics&sort=sku&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email">$lang[sku]</a></td>
<td><a href="?view=orders_statistics&sort=price&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email">$lang[price]</a> $price_help</td>
<td><a href="?view=orders_statistics&sort=total_price&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email">$lang[total_price]</a></td>
<td><a href="?view=orders_statistics&sort=total_quantity&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email">$lang[total_quantity]</a></td>
</tr>
HTMLDATA;

$res = $db->query("SELECT $tbl_orders_items.*, SUM($tbl_orders_items.price * $tbl_orders_items.quantity) AS total_price, SUM($tbl_orders_items.price * $tbl_orders_items.quantity) / SUM($tbl_orders_items.quantity) AS middle_price, SUM($tbl_orders_items.quantity) AS total_quantity FROM $tbl_orders, $tbl_orders_items WHERE $tbl_orders.date >= $date1 AND $tbl_orders.date <= $date2_for_srch $where1 AND $tbl_orders_items.orderid = $tbl_orders.orderid GROUP BY $tbl_orders_items.itemid ORDER BY $orderby")or die($db->error());

$count_records=0;
$print_count=0;
$total_quantity=0;
$total_price=0;

 while($row=$db->fetch_array($res)){
 $def_class=$admin_lib->sett_class();

    if( ($count_records >= $begin && $print_count < $admset['stat_ordersonpage']) || $begin === 'all'){

    $not_round_middle_price = sprintf("%.13f", $row['total_price'] / $row['total_quantity']);
    $row['middle_price'] = pricef($row['middle_price']);

    echo <<<HTMLDATA
<tr class="$def_class">
<td><a href="javascript:editem($row[itemid])">$row[title]</a></td>
<td>$row[sku]</td>
<td><a href="#" title="$not_round_middle_price" onclick="alert('$not_round_middle_price');return false;">$row[middle_price]</a></td>
<td>$row[total_price]</a></td>
<td>$row[total_quantity]</td>
</tr>
HTMLDATA;
    $print_count++;
    }

 $count_records++;
 $total_quantity += $row['total_quantity'];
 $total_price += $row['total_price'];
 }
$total_price = pricef($total_price);

echo '<tr class="ftr"><td colspan="20">&nbsp;</td></tr></table>';


echo '<br>';

$quantity_pages = ceil($count_records / $admset['stat_ordersonpage']);

 echo "$lang[pages]: ";
 $page_number=1;
 $limit=0;
  while($page_number<($quantity_pages+1)){
   if($limit != $begin || $begin === 'all'){
   echo "<a href=\"?view=orders_statistics&sort=$sort&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email&begin=$limit\">$page_number</a> ";
   }
   else{
   echo "$page_number ";
   }
  $limit+=$admset['stat_ordersonpage'];
  $page_number++;
  }

 if($page_number>2 && $begin !== 'all'){
 echo " &nbsp; <a href=\"?view=orders_statistics&sort=$sort&date1=$date1&date2=$date2&status=$status&pmid=$pmid&dmid=$dmid&username=$username&email=$email&begin=all\">$lang[show_all]</a>";
 }

echo "<hr><b>$lang[results]</b> $lang[for_chosen_period] $count_records $lang[products_names] $lang[in_total_quantity] $total_quantity $lang[on_the_sum] $total_price $sett[curr_brief].";

}


function orders_statuses_select($selected_status){
global $lang;
require_once(INC_DIR."/admin/orders.php");
$orders=new orders;
$ret="<select name=\"status\"><option value=\"-1\">$lang[not_selected]</option>";
 foreach($orders->statuses as $status_id => $status_arr){
 if($status_id == $selected_status){$selected=' selected="selected"';}else{$selected='';}
 $ret .= "<option value=\"$status_id\"$selected>$status_arr[name]</option>";
 }
$ret.="</select>";
return $ret;
}


function paymethods_select($selected_id){
global $lang, $db;
$tbl=DB_PREFIX.'paymethods';
$ret="<select name=\"pmid\"><option value=\"0\">$lang[not_selected]</option>";
$res=$db->query("SELECT `pmid`, `pmtitle` FROM `$tbl` ORDER BY `sortid`, `pmtitle`") or die($db->error());
 while($row=$db->fetch_array($res)){
 if($row['pmid']==$selected_id){$selected=' selected="selected"';}else{$selected='';}
 $ret.="<option value=\"$row[pmid]\"$selected>$row[pmtitle]</option>";
 }
$ret.="</select>";
return $ret;
}


function deliverymethods_select($selected_id){
global $lang, $db;
$tbl=DB_PREFIX.'deliverymethods';
$ret="<select name=\"dmid\"><option value=\"0\">$lang[not_selected]</option>";
$res=$db->query("SELECT `dmid`, `dmname` FROM `$tbl` ORDER BY `sortid`, `dmname`") or die($db->error());
 while($row=$db->fetch_array($res)){
 if($row['dmid']==$selected_id){$selected=' selected="selected"';}else{$selected='';}
 $ret.="<option value=\"$row[dmid]\"$selected>$row[dmname]</option>";
 }
$ret.="</select>";
return $ret;
}



}
?>