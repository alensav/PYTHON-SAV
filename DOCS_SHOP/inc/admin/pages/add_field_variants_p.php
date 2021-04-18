<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<!DOCTYPE html><html><head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php
global $field_info;
$field_info = get_field($field_id);
echo "$lang[possible_variants_for_field] &quot;$field_info[title]&quot;"; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#ffffff">
<h4 style="margin:3px"><?php echo $lang['possible_variants_for_field'] . "</h4>&quot;$field_info[title]&quot;"; ?>
<?php

 if(! empty($_POST['update_variants'])){
 echo update_field_variants($field_id);
 }

?>
<center>
<form name="frm" method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="add_fields">
<input type="hidden" name="act" value="variants">
<input type="hidden" name="field_id" value="<?php echo $field_id; ?>">
<input type="hidden" name="update_variants" value="1">
<input type="hidden" name="independ" value="1">

<?php echo get_field_variants($field_id); ?><br>

<table width="100%" class="settbl" border="0">

<tr class="htr">
<td colspan="3"><?php echo $lang['add_variant']; ?></td>
</tr>

<tr class="htr">
 <td align="center"><?php echo $lang['value']; ?></td>
 <td align="center"><?php echo $lang['sort_index']; ?></td>
 <td align="center"><?php echo $lang['default_value']; ?></td>
</tr>

<tr class="str">
 <td align="center"><textarea name="new_field_value" cols="40" rows="3"></textarea></td>
 <td align="center"><input type="text" name="new_sortid" size="10" value="0"></td>
 <td align="center"><input type="checkbox" name="new_def"></td>
</tr>

</table>

<p><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></p>

</form>
</center>
</body>
</html><?php


function get_field_variants($field_id){
global $db, $admin_lib, $lang;
$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';
$field_id=intval($field_id);
$res = $db->query("SELECT * FROM $tbl_add_fields_variants WHERE field_id = $field_id ORDER BY sortid, value") or die($db->error());

 $ret = <<<HTMLDATA
<table width="100%" class="settbl" border="0">
<tr class="htr">
 <td align="center">$lang[value]</td>
 <td align="center">$lang[sort_index]</td>
 <td align="center">$lang[default_value]</td>
 <td align="center">$lang[delete]</td>
</tr>
HTMLDATA;

if(! is_multiple_field_type()){$one_default_value = ' onclick="one_def_val(this.checked);"';}

$variants_all_id = array();

 while($row=$db->fetch_array($res)){
 $def_class=$admin_lib->sett_class();
 if($row['def']){$checked=' checked="checked"';}else{$checked='';}
 $ret .= <<<HTMLDATA
<tr class="$def_class">
 <td align="center"><textarea name="field_value[$row[value_id]]" cols="40" rows="3">$row[value]</textarea></td>
 <td align="center"><input type="text" name="sortid[$row[value_id]]" size="10" value="$row[sortid]"></td>
 <td align="center"><input type="checkbox" name="def[$row[value_id]]"$checked$one_default_value></td>
 <td align="center"><input type="checkbox" name="delete[$row[value_id]]"></td>
</tr>
HTMLDATA;

 array_push($variants_all_id, $row['value_id']);

 }


$ret .= '</table>';

 if(! is_multiple_field_type()){
 $js_variants_id = implode(',', $variants_all_id);
 $ret .= <<<HTMLDATA
<script type="text/javascript">
var variants_id=new Array($js_variants_id);
function one_def_val(is_checked){
var check_count=get_checked_count();
 if(check_count>1){
  for(n=0;n<variants_id.length;n++){
   if(get_checked_count()>1){
   document['frm']['def['+variants_id[n]+']']['checked']=false;
   }
  }
 alert('$lang[possible_one_default_value]');
 }
}
function get_checked_count(){
var check_count=0;
 for(i=0;i<variants_id.length;i++){
  if(document['frm']['def['+variants_id[i]+']']['checked']){
  check_count++;
  }
 }
return check_count;
}
</script>
HTMLDATA;
 }

return $ret;
}


function update_field_variants($field_id){
global $db, $admin_lib, $lang, $custom;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$field_id=intval($field_id);
if(! $field_id){return '';}

$_POST = $custom->trim_array($_POST);

$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';

 if(is_array($_POST['field_value'])){
  if(sizeof($_POST['field_value'])){
   foreach($_POST['field_value'] as $value_id => $value){
    if($_POST["delete"]["$value_id"]){
    $db->query("DELETE FROM $tbl_add_fields_variants WHERE value_id = $value_id") or die($db->error());
    }
    else{
    $_POST["field_value"]["$value_id"] = $db->cutstr($_POST["field_value"]["$value_id"], 65535, true);
    if($_POST["def"]["$value_id"]){$def=1;}else{$def=0;}
    $_POST["sortid"]["$value_id"] = intval($_POST["sortid"]["$value_id"]);
    $db->query("UPDATE $tbl_add_fields_variants SET value = '{$_POST[field_value][$value_id]}', def = $def, sortid = {$_POST[sortid][$value_id]} WHERE value_id = $value_id") or die($db->error());
    }

   }
  }
 }


 if($_POST['new_field_value']){
 $_POST['new_field_value']= $db->cutstr($_POST['new_field_value'], 65535, true);
 if($_POST['new_def']){$_POST['new_def']=1;}else{$_POST['new_def']=0;}
 $_POST['new_sortid']=intval($_POST['new_sortid']);
 $db->query("INSERT INTO $tbl_add_fields_variants (value_id, field_id, value, def, sortid) VALUES (NULL, $field_id, '$_POST[new_field_value]', $_POST[new_def], $_POST[new_sortid])") or die($db->error());
 }

return "<h4>$lang[changes_success]</h4>";
}


function is_multiple_field_type(){
global $field_info;
if($field_info['type'] != 6){return false;}
return true;
}


?>