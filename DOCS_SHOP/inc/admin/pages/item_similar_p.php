<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/item_similar');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $itemid=intval($_GET['itemid']);
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $itemid=intval($_POST['itemid']);
 }

 if(isset($_POST['operation']) && $_POST['operation'] == 'add'){
 echo add_similar_items();
 }
 elseif(isset($_POST['operation']) && $_POST['operation'] == 'update'){
 echo update_similar_items();
 }
 
echo item_similar_form($itemid);


function item_similar_form($itemid){
global $lang, $db, $admin_lib, $custom;
$itemid = intval($itemid);
$tbl_items=DB_PREFIX.'items';
$tbl_item_similar=DB_PREFIX.'item_similar';
$tbl_categories=DB_PREFIX.'categories';

$item_data = get_item_data($itemid);
 if(! $item_data['itemid']){
 return html_page("<p>$lang[similar_notfound_product]<br><br><a href=\"javascript:self.close()\">$lang[close_window]</a></p>");
 }
 

 if($item_data['visible']){
 $ret = $lang['for_product'].' &quot;<a href="' . @stdi2("product=$itemid", $custom->statlink($item_data['fcatname'], "$item_data[itemname].html", "product$item_data[itemid].html", 'p')) . '" target="_blank">' . $item_data['title'] . '</a>&quot;<br>';
 }
 else{
 $ret = $lang['for_product'].' &quot;' . $item_data['title'] . '&quot;<br>';
 }

$res = $db->query("SELECT $tbl_item_similar.*, $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_item_similar, $tbl_items, $tbl_categories WHERE $tbl_item_similar.itemid = $itemid AND $tbl_items.itemid = $tbl_item_similar.similar_itemid AND $tbl_categories.catid = $tbl_items.catid ORDER BY $tbl_item_similar.sortid") or die($db->error());

$ret.=<<<HTMLDATA
<br>
<form name="updfrm" action="?" method="POST">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="item_similar">
<input type="hidden" name="itemid" value="$itemid">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="operation" value="update">
<table width="100%" class="settbl">
<tr class="htr"><td>$lang[product_title]</td><td>$lang[product_sku]</td><td align="center">$lang[sort_index]</td><td align="center">$lang[eliminate]</td></tr>
HTMLDATA;

$qw_similar_items = 0;

 while($row=$db->fetch_array($res)){
 $qw_similar_items++;
 
  if($row['visible']){
  $link = '<a href="' . @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p')) . '" target="_blank">' . $row['title'] . '</a>';
  }
  else{
  $link = $row['title'];
  }

  if(! isset($row['eliminate'])){
  $row['eliminate'] = '';
  }

 $ret .= '<tr class="' . $admin_lib->sett_class() . "\"><td class=\"prtd\">$link<br>".item_similar_link($row['itemid']).'</td><td>'. $row['sku']. '</td><td align="center"><input type="text" name="sortid[' . $row['itemid'] . ']" size="10" value="' . $row['sortid'] . '"></td><td align="center"><input type="checkbox" name="eliminate['.$row['itemid'].']">' . $row['eliminate'] . '</td></tr>';
 }

$ret.='</table><br>';

 if($qw_similar_items){
 $ret.="<p><input type=\"checkbox\" name=\"from_similar_eliminate_similar\">$lang[eliminate] &quot;$item_data[title]&quot; $lang[from_similar_eliminate_similar]</p><input type=\"submit\" value=\"$lang[submit]\" class=\"button1\">";
 }
 else{
 $ret.=$lang['not_similar_products'].'<br>';
 }

 if(isset($_POST['operation']) && $_POST['operation'] == 'search'){
 $srch_res = search_results($itemid, $item_data['title']);
 }
 else{
 $srch_res = '';
 }

$ret.=<<<HTMLDATA
</form>
<h4>$lang[search_add_product]</h4>
<form name="updfrm" action="?" method="POST">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="item_similar">
<input type="hidden" name="itemid" value="$itemid">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="operation" value="search">
<select name="search_for">
HTMLDATA;
$ret.='<option value="title"';
 if(isset($_POST['search_for']) && $_POST['search_for'] == 'title'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['for_title'].'</option>';
$ret.='<option value="sku"';
 if(isset($_POST['search_for']) && $_POST['search_for'] == 'sku'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['for_sku'].'</option>';
$ret.='<option value="itemid"';
 if(isset($_POST['search_for']) && $_POST['search_for'] == 'itemid'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['for_id'].'</option>';

$product_srch = isset($_POST['product_srch']) ? $_POST['product_srch'] : '';

$ret.=<<<HTMLDATA
</select>
<input type="text" name="product_srch" value="$product_srch" size="48" maxlength="255">
<input type="submit" value="$lang[search]" class="button1">
</form>
HTMLDATA;

 if($srch_res){
 $ret.= $srch_res;
 }

return html_page($ret);
}


function search_results($itemid, $product_title){
global $db, $custom, $lang, $admin_lib;
 if($_POST['search_for'] === 'itemid'){
 $srch = intval(trim($_POST['product_srch']));
 }
 else{
 $srch = stripslashes($_POST['product_srch']);
 $srch = $custom->replace_tags_and_quotes($srch);
 $srch = trim(mb_substr($srch, 0, 255));
 $srch = preg_replace("([^\x09\x20\!\#\$\%\&\(\)\*\+\,\.\/0-9\:\;\=\?\@A-Z\[\]\^\_a-z\{\}\x7E-\xFF\-])", ' ', $srch);
 }
$_POST['product_srch'] = $srch;
$srch = $db->secstr($srch);

$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$query='';
$limit = 100 ;

 switch($_POST['search_for']){

 case 'title':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.title LIKE '%".$db->secstr($srch)."%' AND $tbl_categories.catid = $tbl_items.catid ORDER BY $tbl_items.title LIMIT $limit";
 $lng_srch_for = $lang['for_title'];
 $lng_srch_results = "$lang[shows_first] $limit $lang[search_results] $lang[for_title]:";
 break;

 case 'sku':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.sku LIKE '%".$db->secstr($srch)."%' AND $tbl_categories.catid = $tbl_items.catid ORDER BY $tbl_items.sku LIMIT $limit";
 $lng_srch_for = $lang['for_sku'];
 $lng_srch_results = "$lang[shows_first] $limit $lang[search_results] $lang[for_sku]:";
 break;

 case 'itemid':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.title, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.itemid = '".intval($srch)."' AND $tbl_categories.catid = $tbl_items.catid";
 $lng_srch_for = $lang['for_id'];
 break;

 default: $query=''; 
 }

$err='';

 if(! $query){
 $err .= "$lang[not_search_for]!<br>";
 }

 if(! $srch){
 $err .= "$lang[not_search_value]!<br>";
 }

 if($err){
 return "<p class=\"red\">$err</p>";
 }

$ret='';
$res = $db->query($query) or die($db->error());
 while($row=$db->fetch_array($res)){

  if($row['visible']){
  $link = '<a href="' . @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p')) . '" target="_blank">' . $row['title'] . '</a><br>';
  }
  else{
  $link = $row['title'];
  }

 $def_class = $admin_lib->sett_class();
 $ret.="<tr class=\"$def_class\"><td>$link</td><td>$row[sku]</td><td align=\"center\"><input type=\"text\" name=\"sortid[$row[itemid]]\" size=\"6\" value=\"0\"></td><td align=\"center\"><input type=\"checkbox\" name=\"add_similar[$row[itemid]]\"></td></tr>";
 }

 if(! $ret){
 return "<p>$lang[product] $lng_srch_for \"$srch\" $lang[not_found].</p>";
 }

$ret=<<<HTMLDATA
<br>
<form name="addfrm" action="?" method="POST" style="margin:0px;">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="item_similar">
<input type="hidden" name="itemid" value="$itemid">
<input type="hidden" name="independ" value="1">
<input type="hidden" name="operation" value="add">
$lng_srch_results
<table width="100%" class="settbl">
<tr class="htr"><td>$lang[product_title]</td><td>$lang[product_sku]</td><td align="center">$lang[sort_index]</td><td align="center">$lang[add]</td></tr>
$ret
</table>
<p><input type="checkbox" name="in_similar_added_similar">$lang[add] &quot;$product_title&quot; $lang[in_similar_added_similar]</p>
<input type="submit" value="$lang[add_selected]" class="button1">
</form>
HTMLDATA;

return $ret;
}


function html_page($body){
global $sett, $lang;
$similar_disabled = '';
 if(! $sett['similar']){
 $similar_disabled = "<p class=\"warn\">$lang[similar_disabled].</p>";
 }
return <<<HTMLDATA
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=$sett[charset]">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>$lang[item_similar]</title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<style type="text/css"> 
.prtd{padding-bottom:7px;}
</style>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#ffffff">
<table width="100%" bgcolor="#ffffff"><tr><td>
$similar_disabled
<h1 style="margin:3px">$lang[item_similar]</h1>
$body
</td></tr></table><br>
</body>
</html>
HTMLDATA;
}


function get_item_data($itemid){
global $db;
$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$itemid = intval($itemid);
$res = $db->query("SELECT `$tbl_items`.`itemid`, `$tbl_items`.`itemname`, `$tbl_items`.`catid`, `$tbl_items`.`sku`, `$tbl_items`.`title`, `$tbl_items`.`visible`, `$tbl_categories`.`fcatname` FROM `$tbl_items`, `$tbl_categories` WHERE `$tbl_items`.`itemid` = '$itemid' AND `$tbl_categories`.`catid` = `$tbl_items`.`catid`") or die($db->error());
return $db->fetch_assoc($res);
}


function add_similar_items(){
global $admin_lib, $db, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$itemid = intval($_POST['itemid']);
 if(! $itemid){
 return "Invalid itemid!";
 }

$tbl_item_similar=DB_PREFIX.'item_similar';

 if(isset($_POST['add_similar']) && is_array($_POST['add_similar'])){
  if(sizeof($_POST['add_similar'])){
   foreach($_POST['add_similar'] as $similar_itemid => $value){
   

   $res = $db->query("SELECT COUNT(*) FROM $tbl_item_similar WHERE itemid = $itemid AND similar_itemid = $similar_itemid") or die($db->error());
    if($db->result($res, 0, 0) < 1){
    $sortid=intval($_POST['sortid']["$similar_itemid"]);
     if($similar_itemid != $itemid){
     $db->query("INSERT INTO $tbl_item_similar (itemid, similar_itemid, sortid) VALUES ($itemid, $similar_itemid, $sortid)") or die($db->error());
     }
    }


    if(! empty($_POST['in_similar_added_similar'])){
    $res = $db->query("SELECT COUNT(*) FROM $tbl_item_similar WHERE itemid = $similar_itemid AND similar_itemid = $itemid") or die($db->error());
     if($db->result($res, 0, 0) < 1){
      if($similar_itemid != $itemid){
      $db->query("INSERT INTO $tbl_item_similar (itemid, similar_itemid, sortid) VALUES ($similar_itemid, $itemid, 0)") or die($db->error());
      }
     }
    }

  
  
   }
  }
 }

return "<h3>$lang[changes_success]</h3>";
}



function update_similar_items(){
global $admin_lib, $db, $lang;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$itemid = intval($_POST['itemid']);
 if(! $itemid){
 return "Invalid itemid!";
 }

$tbl_item_similar=DB_PREFIX.'item_similar';

 if(is_array($_POST['sortid'])){
  if(sizeof($_POST['sortid'])){
   foreach($_POST['sortid'] as $similar_itemid => $sortid){

    if(! empty($_POST['eliminate']["$similar_itemid"])){
    $db->query("DELETE FROM $tbl_item_similar WHERE itemid = $itemid AND similar_itemid  = $similar_itemid ") or die($db->error());
     if($_POST['from_similar_eliminate_similar']){
     $db->query("DELETE FROM $tbl_item_similar WHERE itemid = $similar_itemid  AND similar_itemid  = $itemid ") or die($db->error());
     }
    }
    else{
    $sortid=intval($_POST['sortid']["$similar_itemid"]);
    $db->query("UPDATE $tbl_item_similar SET sortid = $sortid WHERE itemid = $itemid AND similar_itemid  = $similar_itemid ") or die($db->error());
    }

   }
  }
 }
return "<h3>$lang[changes_success]</h3>";
}

function item_similar_link($itemid){
global $lang;
return "<a href=\"javascript:window.open('?view=product&act=item_similar&itemid=$itemid&independ=1','item_similar$itemid','status,scrollbars,resizable,width=640,height=500');void(0);\">($lang[edit_item_similar])</a>";
}

?>