<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class visitlog{

function show_visitlog(){
global $admset, $db, $custom, $lang, $sett, $admin_lib;

echo <<<HTMLDATA
<script type="text/javascript">
function appendHead(tag, attributes){
var el = document.createElement(tag);
 for(var attrName in attributes){
 el.setAttribute(attrName, attributes[attrName]);
 }
document.getElementsByTagName('head')[0].appendChild(el);
}
appendHead('meta', {'name': ['referrer'], 'content': ['never']});
</script>
HTMLDATA;

$tablename=DB_PREFIX.'visitlog';
$query=$db->query("SELECT COUNT(*) from $tablename")or die($db->error());
$count_records=$db->result($query,0,0);
if($admset['visitlog_recordsonpage']<1){$admset['visitlog_recordsonpage']=300;}
$quantity_pages = ceil($count_records / $admset['visitlog_recordsonpage']);

 if(isset($_GET['act']) && $_GET['act'] == 'clear'){
 echo $this->clear_visitlog();
 return '';
 }

$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

 switch($sort){

 case 'date':
 $sort='date';
 break;

 case 'ip':
 $sort='ip';
 break;

 case 'forwarded':
 $sort='forwarded';
 break;

 case 'request':
 $sort='request';
 break;

 case 'referer':
 $sort='referer';
 break;

 case 'useragent':
 $sort='useragent';
 break;

 default:
 $sort='date';

 }

$orderby=$sort;
if($orderby=='date'){$orderby.=' DESC';}

 $l1 = isset($_GET['l1']) ? $_GET['l1'] : '';
 if($l1 !== 'all'){
 $l1=intval(str_replace('-', '', $l1));
 $limit="LIMIT $l1, $admset[visitlog_recordsonpage]";
 }

echo "<span class=\"sm2\">$lang[sort_by] <a href=\"?view=visitlog&sort=date&l1=$l1\">$lang[date]</a> &nbsp; <a href=\"?view=visitlog&sort=ip&l1=$l1\">IP</a> " . custom::contextHelp($lang['ip_help']) . " &nbsp; <a href=\"?view=visitlog&sort=forwarded&l1=$l1\">X_FORWARDED_FOR</a> " . custom::contextHelp($lang['forwarded_help']) . " &nbsp; <a href=\"?view=visitlog&sort=request&l1=$l1\">Request</a> " . custom::contextHelp($lang['request_help']) . " &nbsp; <a href=\"?view=visitlog&sort=referer&l1=$l1\">Referer</a> " . custom::contextHelp($lang['referer_help']) . " &nbsp; <a href=\"?view=visitlog&sort=useragent&l1=$l1\">User Agent</a> " . custom::contextHelp($lang['useragent_help']) . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </nobr><a href=\"?view=visitlog&act=clear\" onclick=\"if(! q('$lang[clear_log]')){return false;}\">$lang[clear]</a></span>";

$query = $db->query("SELECT * FROM $tablename ORDER BY $orderby $limit")or die($db->error());

$prev_day = '';

 while($row = $db->fetch_assoc($query)){

 $row = $custom->replace_tags_and_quotes_array($row);

  foreach($row as $name => $value){
  $row["$name"] = $admin_lib->replace_amp($value);
  }

 $day=date("d.m.Y, l", $row['date'] + $sett['time_diff'] * 3600);
 if($prev_day !== $day){echo "<hr><h2><u>" . date("d.m.Y, l", $row['date'] +  $sett['time_diff'] * 3600) . "</u></h2>";}
 $prev_day = $day;

 if($row['forwarded']){$row['forwarded']="XFF: $row[forwarded]<br>";}
 if($row['useragent']){$row['useragent']="UA: $row[useragent]<br>";}

  if($row['referer']){
  $row['referer'] = "Ref: <a href=\"$row[referer]\" target=\"_blank\">$row[referer]</a><br>";
  }

 echo date("H:i:s, d.m.Y", $row['date'] + $sett['time_diff'] * 3600) . "<br>IP: $row[ip]<br>$row[forwarded]Req: <a href=\"http://$row[request]\" target=\"_blank\">$row[request]</a><br>$row[referer]$row[useragent]<br>";
 }




echo '<br>';
 echo "$lang[pages]: ";
 $page_number=1;
 $limit=0;
  while($page_number<($quantity_pages+1)){
   if($limit != $l1 || $l1 === 'all'){
   echo "<a href=\"?view=visitlog&sort=$sort&l1=$limit\">$page_number</a> ";
   }
   else{
   echo "$page_number ";
   }
  $limit+=$admset['visitlog_recordsonpage'];
  $page_number++;
  }

 if($page_number>2 && $l1 !== 'all'){
 echo " &nbsp; <a href=\"?view=visitlog&sort=$sort&l1=all\">$lang[show_all]</a>";
 }

}


function clear_visitlog(){
global $db, $admin_lib, $admin, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$tablename=DB_PREFIX.'visitlog';
$db->query("DELETE FROM $tablename")or die($db->error());
return $admin_lib->good_msg($lang['log_cleared'], 1);
}

}
?>
