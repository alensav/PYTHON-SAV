<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/itemsform');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $itemid=intval($_GET['itemid']);
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $itemid=intval($_POST['itemid']);
 }

?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['addition_categories']; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function q(text){if(! confirm(text+'?')){return false;}else{return true;}}
</script>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#ffffff">
<?php
 if(isset($_POST['save']) && $_POST['save'] == 1){
 echo save_addition_categories($itemid);
 }
?>
<h4 style="margin:3px"><?php echo $lang['addition_categories'] . '</h4>';
$iem_info = get_item_info($itemid);
if($itemid){echo '&quot;' . $iem_info['title'] . '&quot;';} ?>

<?php
 if(! $itemid){
 echo "$lang[addcategories_notfound_product]<br><br>";
 }
 else{
?>
<form name="frm" method="POST" action="?">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="addition_categories">
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="independ" value="1">
<?php  echo get_addition_categories($itemid, $iem_info['catid']); ?>
<table width="100%" class="settbl">
 <tr class="htr">
  <td><?php echo $lang['add_in_category']; ?></td>
 </tr>
 <tr class="str">
  <td><?php 
require_once(INC_DIR."/admin/view_cat.php");
$view_category = new view_category;
?><select name="new_catid"><option value=""><?php echo $lang['not_selected'] . $view_category->get_chapters_list(0); ?></select>
  </td>
 </tr>
 <tr class="ttr">
  <td><?php echo $lang['sort_index']; ?> <input type="text" name="new_sortid" value="0" size="10"></td>
 </tr>
</table>
<br>&nbsp;<input type="submit" value="<?php echo $lang['submit']; ?>" class="button1">
</form>
<?php } ?>
&nbsp;<a href="javascript:self.close()"><?php echo $lang['close_window']; ?></a>
</body>
</html>
<?php

function get_addition_categories($itemid, $def_catid){
global $db, $lang, $admin_lib, $custom;
$tbl_categories=DB_PREFIX.'categories';
$tbl_item_categories=DB_PREFIX.'item_categories';
$itemid = intval($itemid);
$def_catid = intval($def_catid);

$res = $db->query("SELECT $tbl_item_categories.catid, $tbl_item_categories.sortid, $tbl_categories.fcatname, $tbl_categories.fulltitle FROM $tbl_item_categories, $tbl_categories WHERE $tbl_item_categories.itemid = $itemid AND $tbl_item_categories.catid <> $def_catid AND $tbl_categories.catid = $tbl_item_categories.catid ORDER BY $tbl_categories.sortid, $tbl_categories.fulltitle") or die($db->error());

$ret = "<table width=\"100%\" class=\"settbl\"><tr class=\"htr\"><td>$lang[category_name]</td><td align=\"center\">$lang[sort_index]</td><td align=\"center\">$lang[eliminate]</td></tr>";
$count = 0;
 while($row = $db->fetch_array($res)){
 $row['sortid'] = intval($row['sortid']);
 $def_class = $admin_lib->sett_class();
 $ret .= "<tr class=\"$def_class\"><td>" . '<a href="' . @stdi2("cat=$row[catid]", $custom->statlink($row['fcatname'], '', "cat$row[catid]/", 'c')) . "\" target=\"_blank\">$row[fulltitle]</a></td><td align=\"center\">&nbsp;<input type=\"text\" name=\"sortid[$row[catid]]\" value=\"$row[sortid]\" size=\"10\">&nbsp;</td><td align=\"center\"><input type=\"checkbox\" name=\"eliminate[$row[catid]]\"></td></tr>";
 $count++;
 }
if(! $count){$ret .= "<tr class=\"str\"><td colspan=\"2\" align=\"center\">$lang[no_addition_categories]</td></tr>";}
$ret .= '</table><br>';
return $ret;
}


function get_item_info($itemid){
global $db, $lang;
$tbl=DB_PREFIX.'items';
$res = $db->query("SELECT catid, title FROM $tbl WHERE itemid = $itemid") or die($db->error());
$row = $db->fetch_array($res);
return $row;
}


function save_addition_categories($itemid){
global $db, $lang, $admin_lib;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$itemid = intval($itemid);

 if(is_array($_POST['sortid'])){
  if(count($_POST['sortid'])){
   foreach($_POST['sortid'] as $catid => $sortid){
    if(! empty($_POST["eliminate"]["$catid"])){
    eliminate_addition_category($catid, $itemid);
    }
    else{
    update_addition_category($catid, $itemid, $sortid);
    }
   }
  }
 }


$catid = intval($_POST['new_catid']);
$sortid = intval($_POST['new_sortid']);
 if(! $itemid || ! $catid){
 return "<h3>$lang[changes_success]</h3>";
 }
$tbl=DB_PREFIX.'item_categories';
$res = $db->query("SELECT COUNT(*) FROM $tbl WHERE itemid = $itemid AND catid = $catid") or die($db->error());
if($db->result($res,0,0)>0){return '';}

 if(TDTC == 1){
 $res = $db->query("SELECT COUNT(*) FROM $tbl WHERE itemid = $itemid") or die($db->error());
  if($db->result($res,0,0) >= 3){
  return mdmogrn("$lang[416] 2 $lang[429]");
  }
 }

$result = $db->query("INSERT INTO $tbl (catid, itemid, sortid) VALUES ($catid, $itemid, $sortid)") or die($db->error());
 if($result){
 require_once(INC_DIR."/admin/ed_cat.php");
 $ed_category = new ed_category;
 $ed_category->update_itemcount_in_parentline($catid, +1);
 }

return "<h3>$lang[changes_success]</h3>";
}


function update_addition_category($catid, $itemid, $sortid){
global $db, $lang;
$itemid = intval($itemid);
$catid = intval($catid);
$sortid = intval($sortid);
if(! $itemid || ! $catid){return 0;}
$tbl=DB_PREFIX.'item_categories';
$res = $db->query("UPDATE $tbl SET sortid = $sortid WHERE itemid = $itemid AND catid = $catid") or die($db->error());
if($res){return 1;}else{return 0;}
}


function eliminate_addition_category($catid, $itemid){
global $db, $lang;
$itemid = intval($itemid);
$catid = intval($catid);
$tbl=DB_PREFIX.'item_categories';
$result = $db->query("DELETE FROM $tbl WHERE itemid = $itemid AND catid = $catid") or die($db->error());
 if($result){
 require_once(INC_DIR."/admin/ed_cat.php");
 $ed_category = new ed_category;
 $ed_category->update_itemcount_in_parentline($catid, -1);
 return 1;
 }
}

?>