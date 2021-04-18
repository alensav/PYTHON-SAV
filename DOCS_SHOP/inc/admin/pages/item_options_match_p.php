<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/itemsform');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $itemid = intval($_GET['itemid']);
 $option_id = isset($_GET['option_id']) ? intval($_GET['option_id']) : 0;
 $edit = isset($_GET['edit']) ? $_GET['edit'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $itemid = intval($_POST['itemid']);
 $option_id = intval($_POST['option_id']);
 $edit = $_POST['edit'];
 }


 if($edit==1){ ?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['used_option_values'] . ' &quot;' . get_item_option_name($option_id) . '&quot;'; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function chk_dis(option_value_id){
is_checked=document.frm['use_option['+option_value_id+']'].checked;
 if(is_checked){
 document.frm['price_difference['+option_value_id+']'].disabled=false;
  for(i=0;i<document.frm.def.length;i++){
   if(document.frm.def[i].value==option_value_id){
   document.frm.def[i].disabled=false;
   break;
   }
  }
 }
 else{
 document['frm']['price_difference['+option_value_id+']'].disabled=true;
  for(i=0;i<document.frm.def.length;i++){
   if(document.frm.def[i].value==option_value_id){
   document.frm.def[i].disabled=true;
   break;
   }
  }
 }
}
function select_all(){
var is_checked=0;
 for(i=0;i<document.frm.def.length;i++){
  if(document['frm']['use_option['+document.frm.def[i].value+']']['checked']){
  is_checked=1;
  break;
  }
 }
 for(i=0;i<document.frm.def.length;i++){
  if(is_checked){
  document['frm']['use_option['+document.frm.def[i].value+']']['checked']=false;
  chk_dis(document.frm.def[i].value);
  }
  else{
  document['frm']['use_option['+document.frm.def[i].value+']']['checked']=true;
  chk_dis(document.frm.def[i].value);
  }
 }
return false;
}
</script>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#ffffff">
<table bgcolor="#ffffff"><tr><td>
<?php if(isset($_POST['update']) && $_POST['update'] == 1){echo update_item_option_values($itemid, $option_id);} ?>
<h4 style="margin:3px"><?php echo $lang['used_option_values'] . '</h4>&quot;' . get_item_option_name($option_id) . "&quot; $lang[for_product] &quot;" . get_item_title($itemid) . '&quot;'; ?>
<form name="frm" method="POST" action="?">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="item_options">
<input type="hidden" name="edit" value="1">
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
<input type="hidden" name="update" value="1">
<input type="hidden" name="option_id" value="<?php echo $option_id; ?>">
<input type="hidden" name="independ" value="1">
<?php echo get_item_option_values($itemid, $option_id); ?>
</form>
<p style="margin-left:10px;"><a href="?view=product&act=item_options&itemid=<?php echo $itemid; ?>&independ=1"><?php echo $lang['all_product_options']; ?></a></p>
</td></tr></table>
</body>
</html><?php
 
 }
 else{

?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['product_options']; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#ffffff">
<table bgcolor="#ffffff"><tr><td>
<h4 style="margin:3px"><?php echo $lang['product_options']; ?></h4>
<?php
 if(! $itemid){
 echo "$lang[options_notfound_product]<br><br><a href=\"javascript:self.close()\">$lang[close_window]</a>";
 }
 else{
 echo ' &quot;' . get_item_title($itemid) . '&quot;';
 echo get_all_items_options($itemid);
 }
?>
</td></tr></table>
<?php if($itemid){ ?><p style="margin-left:10px;"><a href="?view=settings&settype=items_options" target="_blank"><?php echo $lang['change_options']; ?></a></p><?php } ?>
</body>
</html>
<?php

 }

function get_all_items_options($itemid){
global $db, $lang;
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_values=DB_PREFIX.'item_options_values';
$tbl_options_match=DB_PREFIX.'item_options_match';
$res = $db->query("SELECT option_id, option_name FROM $tbl_options ORDER BY sortid, option_name") or die($db->error());

$ret="<table class=\"settbl\" border=\"0\" width=\"100%\"><tr class=\"htr\"><td>&nbsp;$lang[option_name]&nbsp;</td><td align=\"center\">&nbsp;$lang[used_values]&nbsp;</td></tr>";

$def_class = 'ttr';

 while($row=$db->fetch_array($res)){
 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

 $res2 = $db->query("SELECT COUNT(*) FROM $tbl_options_values WHERE option_id = $row[option_id]") or die($db->error());
 $count_all = $db->result($res2,0,0);

 $res3 = $db->query("SELECT COUNT(*) FROM $tbl_options_match WHERE itemid = $itemid AND option_id = $row[option_id]") or die($db->error());
 $count_used = $db->result($res3,0,0);

 if($count_all>0){$row['option_name']="<a href=\"?view=product&act=item_options&edit=1&itemid=$itemid&option_id=$row[option_id]&independ=1\">$row[option_name]</a>";}

 $ret.="<tr class=\"$def_class\"><td>$row[option_name]</td><td align=\"center\">$count_used $lang[from] $count_all</td></tr>";
 }

$ret.="<tr class=\"ftr\"><td colspan=\"3\">&nbsp;</td></tr></table>";

return $ret;
}


function get_item_option_name($option_id){
global $db, $lang;
$tbl=DB_PREFIX.'item_options';
$res = $db->query("SELECT option_name FROM $tbl WHERE option_id = $option_id") or die($db->error());
$row = $db->fetch_array($res);
return $row['option_name'];
}

function get_item_title($itemid){
global $db, $lang;
$tbl=DB_PREFIX.'items';
$res = $db->query("SELECT title FROM $tbl WHERE itemid = $itemid") or die($db->error());
$row = $db->fetch_array($res);
return $row['title'];
}

function get_item_option_values($itemid, $option_id){
global $db, $lang;
$ret = '';
$tbl_options_values=DB_PREFIX.'item_options_values';
$tbl_options_match=DB_PREFIX.'item_options_match';

$res = $db->query("SELECT * FROM $tbl_options_values WHERE option_id = $option_id ORDER BY sortid, option_value") or die($db->error());

 $ret .= <<<HTMLDATA
<table width="100%" class="settbl" border="0">
<tr class="htr">
 <td>$lang[value]</td>
 <td><a href="#" onclick="return select_all()">$lang[use_option]</a></td>
 <td>$lang[price_difference]</td>
 <td>$lang[default_value]</td>
</tr>
HTMLDATA;

$def_class='ttr';

 while($row=$db->fetch_array($res)){

 $res2 = $db->query("SELECT itemid, price_difference, def FROM $tbl_options_match WHERE itemid = $itemid AND option_id = $option_id AND option_value_id = $row[option_value_id]") or die($db->error());
 $row2=$db->fetch_array($res2);

 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

  if($row2['itemid']){
  $use_option_checked=' checked';
  $disabled='';
  }
  else{
  $use_option_checked='';
  $disabled=' disabled';
  }

  if($row2['def']){
  $def_checked=' checked';
  }
  else{
  $def_checked='';
  }

 $row2['price_difference'] = correct_price_difference($row2['price_difference']);

 $ret .= <<<HTMLDATA
<tr class="$def_class">
 <td>$row[option_value]</td>
 <td align="center"><input type="checkbox" name="use_option[$row[option_value_id]]" onclick="chk_dis($row[option_value_id])"$use_option_checked></td>
 <td><input type="text" name="price_difference[$row[option_value_id]]" value="$row2[price_difference]"$disabled></td>
 <td align="center"><input type="radio" name="def" value="$row[option_value_id]"$def_checked$disabled></td>
</tr>
HTMLDATA;

 }

 $ret .= <<<HTMLDATA
<tr class="ftr"><td colspan="4" align="center"><br><input type="submit" value="$lang[submit]" class="button1"></td></tr>
</table>
HTMLDATA;

return $ret;
}


function update_item_option_values($itemid, $option_id){
global $db, $lang, $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl=DB_PREFIX.'item_options_match';

$db->query("DELETE FROM $tbl WHERE itemid = $itemid AND option_id = $option_id") or die($db->error());

 if(isset($_POST['use_option']) && is_array($_POST['use_option'])){
  if(count($_POST['use_option'])){
  $cnt = 0;
   foreach($_POST['use_option'] as $option_value_id => $value){
    $option_value_id = intval($option_value_id);
    $_POST["price_difference"]["$option_value_id"] = correct_price_difference($_POST["price_difference"]["$option_value_id"]);
     if(isset($_POST["def"]) && $option_value_id == $_POST["def"]){
     $def = 1;
     }
     else{
     $def = 0;
     }
    if($value){

     if(TDTC == 1){
      if($cnt >= 6){
      return mdmogrn("$lang[130] 6 $lang[442]");
      }
     }

    $db->query("INSERT INTO $tbl (itemid, option_id, option_value_id, price_difference, def) VALUES ($itemid, $option_id, $option_value_id, '" . $_POST['price_difference']["$option_value_id"] . "', $def)") or die($db->error());
    $cnt++;
    }
   }
  }
 }

return "<h3>$lang[changes_success]</h3>";
}


function correct_price_difference($price){
$price=str_replace(',', '.', $price);
if(! strstr($price, '.') || strlen($price)>16){$price=substr($price, 0, 13);}
$price=preg_replace('([^0-9\x2E\-])', '', $price);
return pricef($price);
}


?>