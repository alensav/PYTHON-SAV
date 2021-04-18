<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if(! empty($_POST['save'])){
 $save_res = save_field($field_id);
  if($save_res == 1){
  $act = 'edit';
  echo "<h4>$lang[changes_success]</h4>";
  }
  else{
  $row = $custom->stripslashes_array($_POST);
  echo "<p><font class=\"red\">$save_res</font></p>";
  }
 }

 if($act == 'edit' && (empty($save_res) || $save_res == 1)){;
 $row = get_field($field_id);
 }

 if($act == 'add'){
 echo "<p>$lang[about_field_variants]</p>";
 }
 elseif($act=='edit' && ($row['type']==4 || $row['type']==5 || $row['type']==6)){
 $tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';
 $res = $db->query("SELECT COUNT(*) FROM $tbl_add_fields_variants WHERE field_id = $row[field_id]") or die($db->error());
 $count_variants = $db->result($res,0,0);
 echo "<p><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"javascript:window.open('?view=settings&settype=add_fields&act=variants&field_id=$field_id&independ=1','add_fields_variants$field_id','status,scrollbars,resizable,width=790,height=600');void(0);\">$lang[field_variants] ($count_variants)</a></p>";
 }

?>
<form name="affrm" action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="add_fields">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="field_id" value="<?php echo $field_id; ?>">
<input type="hidden" name="save" value="1">
<table width="100%" class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php if($act==='edit'){echo $lang['edit_field'];}else{echo $lang['add_field'];} ?></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['field_type']; ?></td>
<td><select name="type">
<option value="0"><?php echo $lang['not_selected']; ?></option>
<option value="1"<?php if(isset($row['type']) && $row['type']==1){echo ' selected="selected"';} ?>><?php echo $lang['text']; ?></option>
<option value="2"<?php if(isset($row['type']) && $row['type']==2){echo ' selected="selected"';} ?>><?php echo $lang['textarea']; ?></option>
<option value="3"<?php if(isset($row['type']) && $row['type']==3){echo ' selected="selected"';} ?>><?php echo $lang['checkbox']; ?></option>
<option value="4"<?php if(isset($row['type']) && $row['type']==4){echo ' selected="selected"';} ?>><?php echo $lang['radio']; ?></option>
<option value="5"<?php if(isset($row['type']) && $row['type']==5){echo ' selected="selected"';} ?>><?php echo $lang['select']; ?></option>
<option value="6"<?php if(isset($row['type']) && $row['type']==6){echo ' selected="selected"';} ?>><?php echo $lang['select_multiple']; ?></option>
<option value="7"<?php if(isset($row['type']) && $row['type']==7){echo ' selected="selected"';} ?>><?php echo $lang['password']; ?></option>
<option value="8"<?php if(isset($row['type']) && $row['type']==8){echo ' selected="selected"';} ?>><?php echo $lang['hidden']; ?></option>
</select></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['field_title']; ?></td>
<td><textarea name="title" cols="34" rows="3"><?php echo isset($row['title']) ? $row['title'] : ''; ?></textarea></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td colspan="2"><input type="checkbox" name="required"<?php if(! empty(
$row['required'])){echo 'checked="checked"';} ?>><?php echo $lang['required']; ?></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td colspan="2"><input type="checkbox" name="enabled"<?php if(! empty(
$row['enabled']) || ($act == 'add' && $_SERVER['REQUEST_METHOD'] == 'GET')){echo 'checked="checked"';} ?>><?php echo $lang['enabled']; ?></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td>
<?php echo $lang['use_in']; ?></td><td>
<input type="checkbox" name="use_in_order"<?php if(! empty($row['use_in_order'])){echo 'checked="checked"';} ?>><?php echo $lang['order_form']; ?><br>
<input type="checkbox" name="use_in_feedback"<?php if(! empty($row['use_in_feedback'])){echo 'checked="checked"';} ?>><?php echo $lang['feedback_form']; ?><br>
</td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['width']; ?></td>
<td><input type="text" name="width" size="10" value="<?php if($act==='add' && $_SERVER['REQUEST_METHOD']==='GET'){$row['width']=0;}echo $row['width']; ?>"></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['height']; ?></td>
<td><input type="text" name="height" size="10" value="<?php if($act==='add' && $_SERVER['REQUEST_METHOD']==='GET'){$row['height']=0;}echo $row['height']; ?>"></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['def_text_value'] . ' ' . custom::contextHelp($lang['def_text_value_help']); ?></td>
<td><textarea name="def_value" cols="34" rows="4"><?php echo isset($row['def_value']) ? $row['def_value'] : ''; ?></textarea></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td colspan="2"><input type="checkbox" name="def_from_last_order"<?php if(! empty(
$row['def_from_last_order'])){echo 'checked="checked"';} ?>><?php echo $lang['def_from_last_order'] . ' ' . custom::contextHelp($lang['def_from_last_help']); ?></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['placeholder'] . ' ' . custom::contextHelp($lang['placeholder_help']); ?></td>
<td><textarea name="placeholder" cols="34" rows="4"><?php echo isset($row['placeholder']) ? $row['placeholder'] : ''; ?></textarea></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="contexthelp" cols="34" rows="4"><?php echo isset($row['contexthelp']) ? $row['contexthelp'] : ''; ?></textarea></td>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['additional_attributes']; ?></td>
<td><textarea name="add_attributes" cols="34" rows="4"><?php echo isset($row['add_attributes']) ? $row['add_attributes'] : ''; ?></textarea></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['bind_paymethods']; ?></td>
<td>
<select name="bind_paymethods[]" size="10" multiple>
<?php
$pay_methods_str = isset($row['pay_methods']) ? $row['pay_methods'] : '';
$pm_list = af_available_pm_list($pay_methods_str);
echo $pm_list['options'];
?>
<input type="hidden" name="pm_all_count" value="<?php echo $pm_list['pm_all_count']; ?>">
</select> <span style="cursor:hand" onclick="for(i=0;i<document['affrm']['bind_paymethods[]'].length;i++){document['affrm']['bind_paymethods[]'][i].selected=true;}"><u><?php echo $lang['select_all']; ?></u></span>
</td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="sortid" value="<?php echo isset($row['sortid']) ? intval($row['sortid']) : 0; ?>" size="10"></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo "$lang[field_name]<br><span style=\"font-size:11px;\">($lang[field_name_descript])</span>"; ?></td>
<td><input type="text" name="field_name" value="<?php echo isset($row['field_name']) ? $row['field_name'] : ''; ?>" maxlength="64"></td>
</tr>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=add_fields"><?php echo $lang['all_additional_fields']; ?></a></p>