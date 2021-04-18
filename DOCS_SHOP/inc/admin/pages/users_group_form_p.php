<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
  if(! empty($_GET['grid'])){
  echo "<h3>$lang[editing_users_group]</h3>";
  }
  else{
  echo "<h3>$lang[adding_users_group]</h3>";
  }
 $grinfo = isset($_GET['grid']) ? $users_groups->get_group_info($_GET['grid']) : array();
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  if($_POST['save']){
   $save_code=$users_groups->save_group();
   if($save_code==1){
   echo "<h3>$lang[changes_success]</h3>";
    if($_POST['grid'] > 0){
    $grinfo=$users_groups->get_group_info($_POST['grid']);
    }
   }
   else{
   echo "<font class=\"red\">$save_code</font><br>";
   $grinfo=$custom->stripslashes_array($_POST);
   }
  }
 }

 if(! empty($grinfo['groupid'])){
 $act = 'edit';
 }
?>
<form name="grform" METHOD="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="users_groups">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="grid" value="<?php echo $grinfo['groupid']; ?>">
<input type="hidden" name="save" value="<?php if($act=='edit'){echo 'edit';}else{echo 'add';} ?>">
<?php

 if(empty($grinfo['min_order_sum'])){
 $grinfo['min_order_sum'] = '0.00';
 }

 if(empty($grinfo['autochgroup_sum'])){
 $grinfo['autochgroup_sum'] = '9999999999999.99';
 }

 if(! empty($grinfo['autochgroup'])){
 $checked = ' checked';
 $disabled = '';
 }
 else{
 $checked = '';
 $disabled = ' disabled';
 }

 if(isset($grinfo['groupid']) && $grinfo['groupid'] == 1){
 $default_group_info = $lang['this_is_default_group'];
 }
 else{
 $default_group_info = '';
 }
 
 if(! isset($grinfo['groupname'])){
 $grinfo['groupname'] = '';
 }

 if(! isset($grinfo['descript'])){
 $grinfo['descript'] = '';
 }

 if(! isset($grinfo['groupid'])){
 $grinfo['groupid'] = 0;
 }

echo <<<HTMLDATA
<table class="settbl" width="100%" border="0">

<tr class="htr">
<td colspan="2">&nbsp;$default_group_info</td>
</tr>

<tr class="str">
<td>$lang[group_name]</td>
<td><input type="text" name="groupname" value="$grinfo[groupname]"></td>
</tr>

<tr class="ttr">
<td>$lang[min_order_sum]<br><font style="font-size:11px">($lang[min_sum_descript])</font></td>
<td><input type="text" name="min_order_sum" size="13" value="$grinfo[min_order_sum]" maxlength="13"> $sett[curr_brief]</td>
</tr>

<tr class="str">
<td>$lang[descript]</td>
<td><textarea name="descript" cols="30" rows="5">$grinfo[descript]</textarea></td>
</tr>
HTMLDATA;

 if($grinfo['groupid'] != 1){
 echo <<<HTMLDATA
<tr class="ttr">
<td><input type="checkbox" name="autochgroup"$checked onclick="if(this.checked){document.grform.autochgroup_sum.disabled=false;}else{document.grform.autochgroup_sum.disabled=true;}">$lang[auto_change_group_sum]<br><font style="font-size:11px">($lang[without_delivery_cost])</font></td>
<td><input type="text" name="autochgroup_sum" size="20" value="$grinfo[autochgroup_sum]" maxlength="16"> $sett[curr_brief]</td>
</tr>
HTMLDATA;
 }
 
$grinfo['sortid'] = isset($grinfo['sortid']) ? intval($grinfo['sortid']) : 0;

echo <<<HTMLDATA
<tr class="str">
<td>$lang[sort_index]</td>
<td><input type="text" name="sortid" value="$grinfo[sortid]" size="10"></td>
</tr>
HTMLDATA;

echo '</table><br>';

echo $users_groups->get_groupdiscounts_form($grinfo['groupid']);

echo <<<HTMLDATA
<br><input type="submit" value="$lang[submit]" class="button1">
</form>
HTMLDATA;

 if($grinfo['groupid'] != 1){
echo <<<HTMLDATA
<p>$lang[set_orders_statuses] <a href="?view=settings&settype=order_statuses">$lang[in_order_statuses]</a>.</p>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=users_groups">$lang[all_users_groups]</a></p>
HTMLDATA;
 }

 if($disabled && $grinfo['groupid'] != 1){
echo <<<HTMLDATA
<script type="text/javascript">
document.grform.autochgroup_sum.disabled=true;
</script>
</form>
HTMLDATA;
 }

?>
