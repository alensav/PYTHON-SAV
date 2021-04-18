<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/global_settings');
?>
<script type="text/javascript">
var sdeMsg='<?php echo $lang['changes_not_saved']; ?>';
</script>
<script type="text/javascript" src="adm/sel-design-exit.js"></script>
<form method="POST" action="?" onsubmit="window.onbeforeunload=null;">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="global">
<input type="hidden" name="savesettings" value="1">
<?php
 if(! empty($_POST['savesettings'])){
 gs_check_settings($_POST['new_sett']);
 echo $admin_lib->save_settings(2, $_POST['new_sett']);
  if(isset($_POST['html_sett'])){
  $admin_lib->save_settings(2, $_POST['html_sett'], true, false);
  $sett = $custom->get_settings(2);
  }
 }

require_once(INC_DIR.'/admin/after_login.php');
echo after_login::check();



function gs_check_settings(&$new_sett){

 if(isset($new_sett['mail_delay'])){
 $new_sett['mail_delay'] = str_replace(',', '.', $new_sett['mail_delay']);
 $new_sett['mail_delay'] = floatval($new_sett['mail_delay']);
  if($new_sett['mail_delay'] < 0){
  $new_sett['mail_delay'] = 0;
  }
  if($new_sett['mail_delay'] > 25){
  $new_sett['mail_delay'] = 25;
  }
 }

gs_check_pr_lst_no($new_sett);

$new_sett['quantity_columns'] = intval($new_sett['quantity_columns']);
 if($new_sett['quantity_columns'] < 1){
 $new_sett['quantity_columns'] = 1;
 }

}


function gs_check_pr_lst_no(&$new_sett){
$checks = array('prLstNoMain', 'prLstNoCat', 'prLstNoMnf', 'prLstNoSrch');
 foreach($checks as $name){
 $newval = '';
  if(isset($new_sett["$name"]) && is_array($new_sett["$name"]) && count($new_sett["$name"]) > 0){
   foreach($new_sett["$name"] as $value){
    if($value){
    $newval .= $value . ',';
    }
   }
  }
  if(substr($newval, strlen($newval)-1) === ','){
  $newval = substr($newval, 0, strlen($newval)-1);
  }
 $new_sett["$name"] = $newval;
 }
}


?>
<h1><?php echo $lang['basic_config']; ?></h1>
<table width="100%" class="settbl">

<tr class="htr"><td><?php echo $lang['description']; ?></td><td><?php echo $lang['value']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['url'] . ' ' . custom::contextHelp($lang['url_help']); ?></td><td><input type="text" name="new_sett[url]" value="<?php
 if($sett['url']){
 echo $sett['url'];
 }else{
 echo $admin_lib->dirurl('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
 } ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>Site language &nbsp; &nbsp; &nbsp; <?php echo $lang['lang']; ?></td><td><select name="new_sett[lang]"><?php
if(is_dir(SCRIPT_DIR."/lang")){
$dirhandle=opendir(SCRIPT_DIR."/lang");
 while(($dirname = readdir($dirhandle)) !== false){
  if($dirname != '.' && $dirname != '..' && $dirname != 'index.htm' && $dirname != 'index.html' && $dirname != '.htaccess'){
   if(is_dir(SCRIPT_DIR."/lang/$dirname")){
    if(is_file(SCRIPT_DIR."/lang/$dirname/info.txt")){
    $fh=fopen(SCRIPT_DIR."/lang/$dirname/info.txt", "r") or die("Can't open file lang/$dirname/info.txt");
    $lang_title=chop(fgets($fh, 100));
    fclose($fh);
    if($dirname==$sett['lang']){$selected=' selected';}else{$selected='';}
    echo "<option value=\"$dirname\"$selected>$lang_title";
    }
   }
  }
 }
closedir($dirhandle);
}
?></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['charset']; ?></td><td><?php echo $sett['charset']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['time_diff']; ?></td><td><input type="text" name="new_sett[time_diff]" value="<?php echo $sett['time_diff']; ?>" maxlength="3"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['email']; ?></td><td><input type="email" name="new_sett[email]" value="<?php echo $sett['email']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['email2']; ?></td><td><input type="email" name="new_sett[email2]" value="<?php echo $sett['email2']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['shop_sender_only'] . ' ' . custom::contextHelp($lang['shop_sender_only_help']); ?></td><td><input type="radio" name="new_sett[shop_sender_only]" value="1"<?php if(! empty($sett['shop_sender_only'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[shop_sender_only]" value="0"<?php if(empty($sett['shop_sender_only'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['nonames_mailheaders'] . ' ' . custom::contextHelp($lang['nonames_mailheaders_help']); ?></td><td><input type="radio" name="new_sett[nonames_mailheaders]" value="1"<?php if(! empty($sett['nonames_mailheaders'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[nonames_mailheaders]" value="0"<?php if(empty($sett['nonames_mailheaders'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['mail_delay']; ?></td><td><input type="text" name="new_sett[mail_delay]" value="<?php echo $sett['mail_delay']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['counter']; ?></td><td><input type="radio" name="new_sett[counter]" value="1"<?php if($sett['counter']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[counter]" value="0"<?php if(! $sett['counter']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['visitlog']; ?></td><td><input type="radio" name="new_sett[visitlog]" value="1"<?php if($sett['visitlog']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[visitlog]" value="0"<?php if(! $sett['visitlog']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['static_urls'] . ' ' . custom::contextHelp($lang['static_urls_help']) . "<br>(<a href=\"#\" onclick=\"window.open('?view=settings&settype=static_urls&independ=1','','status,scrollbars,resizable,width=800,height=260');return false;\">$lang[static_urls_settings]</a>)"; ?></td><td><input type="radio" name="new_sett[static_urls]" value="1"<?php if($sett['static_urls']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[static_urls]" value="0"<?php if(! $sett['static_urls']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<?php
if(isset($sett['old_static'])){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['old_static']; ?></td><td><input type="radio" name="new_sett[old_static]" value="1"<?php if($sett['old_static']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[old_static]" value="0"<?php if(! $sett['old_static']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>
<?php } ?>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
 <td><?php echo $lang['index_file'] . ' ' . custom::contextHelp($lang['index_file_help']); ?></td>
 <td>
<select name="new_sett[index_file]">
<option value=""<?php if(! $sett['index_file']){echo ' selected';} ?>><?php echo $lang['Without_index_file']; ?></option>
<option value="index.php"<?php if($sett['index_file']=='index.php'){echo ' selected';} ?>>index.php</option></select>
</td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['shop_name']; ?></td><td><input type="text" name="new_sett[shop_name]" value="<?php echo $sett['shop_name']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pages_title']; ?></td><td><input type="text" name="new_sett[pages_title]" value="<?php echo $sett['pages_title']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['item_title_cat']; ?></td><td><input type="radio" name="new_sett[item_title_cat]" value="1"<?php if($sett['item_title_cat']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[item_title_cat]" value="0"<?php if(! $sett['item_title_cat']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['products_onpage']; ?></td><td><input type="text" name="new_sett[products_onpage]" value="<?php echo $sett['products_onpage']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['show_all_lnk']; ?></td><td><input type="radio" name="new_sett[show_all_lnk]" value="1"<?php if(! empty($sett['show_all_lnk'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[show_all_lnk]" value="0"<?php if(empty($sett['show_all_lnk'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['sbcpr']; ?></td><td><input type="radio" name="new_sett[sbcpr]" value="1"<?php if(! empty($sett['sbcpr'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[sbcpr]" value="0"<?php if(empty($sett['sbcpr'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['show_quantity']; ?></td><td><input type="radio" name="new_sett[show_quantity]" value="1"<?php if($sett['show_quantity']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[show_quantity]" value="0"<?php if(! $sett['show_quantity']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['show_quantity_main']; ?></td><td><input type="radio" name="new_sett[show_quantity_main]" value="1"<?php if(! empty($sett['show_quantity_main'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[show_quantity_main]" value="0"<?php if(empty($sett['show_quantity_main'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['sort_products']; ?></td><td>
<select name="new_sett[sort_products]">
<option value="id"<?php if($sett['sort_products']==='id' || ! $sett['sort_products']){echo ' selected';} ?>><?php echo $lang['by_id']; ?></option>
<option value="udate"<?php if($sett['sort_products']==='udate'){echo ' selected';} ?>><?php echo $lang['by_udate']; ?></option>
<option value="price"<?php if($sett['sort_products']==='price'){echo ' selected';} ?>><?php echo $lang['by_price']; ?></option>
<option value="title"<?php if($sett['sort_products']==='title'){echo ' selected';} ?>><?php echo $lang['by_title']; ?></option>
<option value="sku"<?php if($sett['sort_products']==='sku'){echo ' selected';} ?>><?php echo $lang['by_sku']; ?></option>
<option value="mnf"<?php if($sett['sort_products']==='mnf'){echo ' selected';} ?>><?php echo $lang['by_manufacturer']; ?></option>
</select><br>
<select name="new_sett[sortpr_desc]">
<option value="1"<?php if($sett['sortpr_desc']==1){echo ' selected';} ?>><?php echo $lang['inverse_order']; ?></option>
<option value="0"<?php if(! $sett['sortpr_desc']){echo ' selected';} ?>><?php echo $lang['direct_order']; ?></option>
</select>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['sort_onlycatmnf']; ?></td><td><input type="radio" name="new_sett[sort_onlycatmnf]" value="1"<?php if(! empty($sett['sort_onlycatmnf'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[sort_onlycatmnf]" value="0"<?php if(empty($sett['sort_onlycatmnf'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['manufacturers_sort_products']; ?></td><td>
<select name="new_sett[mnf_sort_products]">
<option value="id"<?php if($sett['mnf_sort_products']==='id' || ! $sett['mnf_sort_products']){echo ' selected';} ?>><?php echo $lang['by_id']; ?></option>
<option value="udate"<?php if($sett['mnf_sort_products']==='udate'){echo ' selected';} ?>><?php echo $lang['by_udate']; ?></option>
<option value="price"<?php if($sett['mnf_sort_products']==='price'){echo ' selected';} ?>><?php echo $lang['by_price']; ?></option>
<option value="title"<?php if($sett['mnf_sort_products']==='title'){echo ' selected';} ?>><?php echo $lang['by_title']; ?></option>
<option value="sku"<?php if($sett['mnf_sort_products']==='sku'){echo ' selected';} ?>><?php echo $lang['by_sku']; ?></option>
<option value="cat"<?php if($sett['mnf_sort_products']==='cat'){echo ' selected';} ?>><?php echo $lang['by_category']; ?></option>
</select><br>
<select name="new_sett[mnf_sortpr_desc]">
<option value="1"<?php if($sett['mnf_sortpr_desc']==1){echo ' selected';} ?>><?php echo $lang['inverse_order']; ?></option>
<option value="0"<?php if(! $sett['mnf_sortpr_desc']){echo ' selected';} ?>><?php echo $lang['direct_order']; ?></option>
</select>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['sort_nostock_last'] . ' ' . custom::contextHelp($lang['sort_nostock_last_help']); ?></td><td><input type="radio" name="new_sett[sort_nostock_last]" value="1"<?php if(! empty($sett['sort_nostock_last'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[sort_nostock_last]" value="0"<?php if(empty($sett['sort_nostock_last'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['maincat_qcolumns'] . ' ' . custom::contextHelp($lang['maincat_qcolumns_help']); ?></td><td><input type="text" name="new_sett[maincat_qcolumns]" value="<?php echo $sett['maincat_qcolumns']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['main_maxsubcats']; ?></td><td><input type="text" name="new_sett[main_maxsubcats]" value="<?php echo $sett['main_maxsubcats']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['quantity_columns'] . ' ' . custom::contextHelp($lang['quantity_columns_help']); ?></td><td><input type="text" name="new_sett[quantity_columns]" value="<?php echo $sett['quantity_columns']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['gallery_q_columns'] . ' ' . custom::contextHelp($lang['gallery_q_columns_help']); ?></td><td><input type="text" name="new_sett[gallery_q_columns]" value="<?php echo $sett['gallery_q_columns']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['smallimg_width'] . ' ' . custom::contextHelp($lang['smallimg_width_help']); ?></td><td><input type="text" name="new_sett[smallimg_width]" value="<?php echo $sett['smallimg_width']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['gal_smimg_width'] . ' ' . custom::contextHelp($lang['gal_smimg_width_help']); ?></td><td><input type="text" name="new_sett[gal_smimg_width]" value="<?php echo $sett['gal_smimg_width']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['bigimg_width'] . ' ' . custom::contextHelp($lang['bigimg_width_help']); ?></td><td><input type="text" name="new_sett[bigimg_width]" value="<?php echo $sett['bigimg_width']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['poduct_detail_big_img']; ?></td><td>
<input type="radio" name="new_sett[pd_big_img]" value="1"<?php if($sett['pd_big_img']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pd_big_img]" value="0"<?php if(! $sett['pd_big_img']){echo ' checked';} ?>> <?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['show_similar_products']; ?></td><td>
<input type="radio" name="new_sett[similar]" value="1"<?php if(! empty($sett['similar'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[similar]" value="0"<?php if(empty($sett['similar'])){echo ' checked';} ?>> <?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['search_type'] . ' ' . custom::contextHelp($lang['search_type_help']); ?></td><td>
<select name="new_sett[search_type]">
<option value="0"<?php if(! $sett['search_type']){echo ' selected';} ?>><?php echo $lang['usual']; ?></option>
<option value="1"<?php if($sett['search_type']==1){echo ' selected';} ?>><?php echo $lang['relevance']; ?></option>
<option value="2"<?php if($sett['search_type']==2){echo ' selected';} ?>><?php echo $lang['any_coincidences']; ?></option>
?>
</select>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['design']; ?></td>
 <td>
 <select name="new_sett[design]" id="design" onchange="checkTunableDesign(this.value);formChanged();"><?php
$designs = array();
$design_titles = array();
$tunable_designs = array();
if(is_dir(DESIGN_DIR)){
$dirhandle=opendir(DESIGN_DIR);
 while(($dirname = readdir($dirhandle)) !== false){
  if($dirname != '.' && $dirname != '..' && $dirname != 'index.htm' && $dirname != 'index.html' && $dirname != '.htaccess'){
   if(is_dir(DESIGN_DIR."/$dirname")){
    if(is_file(DESIGN_DIR."/$dirname/info.txt")){
    $fh = fopen(DESIGN_DIR."/$dirname/info.txt", "r") or die("Can't open file $dirname/info.txt");;
    $design_title = chop(fgets($fh, 100));
    fclose($fh);
    array_push($designs, $dirname);
    array_push($design_titles, $design_title);
     if(custom::tunable_design_url($dirname)){
     array_push($tunable_designs, $dirname);
     }
    }
   }
  }
 }
closedir($dirhandle);
array_multisort($design_titles, $designs);
 foreach($designs as $key => $design){
  if($design === $sett['design']){
  $selected = ' selected="selected"';
  }
  else{
  $selected = '';
  }
 echo "<option value=\"$design\"$selected>$design_titles[$key] ($design)";
 }
}
?></select>
<div id="tuneDesign" style="padding:5px 0 10px 0;"><a href="?view=settings&settype=tune_styles&independ=1"><?php echo $lang['tune_styles']; ?></a></div>
<script type="text/javascript">
var tunableDesigns=new Array(<?php
 if(count($tunable_designs)){
  foreach($tunable_designs as $index => $design){
   if($index != 0){
   echo ',';
   }
  echo "'$design'";
  }
 }
?>);
function checkTunableDesign(selDesign){
 for(var i=0;i<tunableDesigns.length; i++){
  if(tunableDesigns[i]==selDesign){
  document.getElementById('tuneDesign').style.display='block';
  return;
  }
 }
document.getElementById('tuneDesign').style.display='none';
}
checkTunableDesign(document.getElementById('design').value);
</script>
 </td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['def_show_currency']; ?></td><td><select name="new_sett[def_show_currency]">
<?php
echo "<option value=\"0\">$lang[default_currency]</option>";
 if(! isset($sett['def_show_currency'])){
 $sett['def_show_currency'] = 0;
 }
echo get_currencies_list($sett['def_show_currency']);
function get_currencies_list($currency_id){
global $db;
$tbl=DB_PREFIX.'currencies';
$ret = '';
$res = $db->query("SELECT currency_id, brief, title FROM $tbl") or die($db->error());
 while($row=$db->fetch_array($res)){
 if($row['currency_id']==$currency_id){$selected=' selected="selected"';}else{$selected='';}
 $ret .= "<option value=\"$row[currency_id]\"$selected>$row[title] ($row[brief])</option>";
 }
return $ret;
}
?>

</select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['currency_selection'] . ' ' . custom::contextHelp($lang['currency_selection_help']); ?></td><td><input type="radio" name="new_sett[currency_selection]" value="1"<?php if(! empty($sett['currency_selection'])){echo ' checked="checked"';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[currency_selection]" value="0"<?php if(empty($sett['currency_selection'])){echo ' checked="checked"';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['no_price_fraction'] . ' ' . custom::contextHelp($lang['no_price_fraction_help']); ?></td><td><input type="radio" name="new_sett[no_price_fraction]" value="1"<?php if(! empty($sett['no_price_fraction'])){echo ' checked="checked"';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[no_price_fraction]" value="0"<?php if(empty($sett['no_price_fraction'])){echo ' checked="checked"';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['null_price_text'] . ' ' . custom::contextHelp($lang['null_price_text_help']); ?></td><td><input type="text" name="new_sett[null_price_text]" value="<?php echo isset($sett['null_price_text']) ? $sett['null_price_text'] : ''; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['mail_order_admin']; ?></td><td><input type="radio" name="new_sett[mail_order_admin]" value="1"<?php if($sett['mail_order_admin']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[mail_order_admin]" value="0"<?php if(! $sett['mail_order_admin']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['admin_order_subj']; ?></td><td><input type="text" name="new_sett[admin_order_subj]" value="<?php echo $sett['admin_order_subj']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['mail_order_shopper']; ?></td><td><input type="radio" name="new_sett[mail_order_shopper]" value="1"<?php if($sett['mail_order_shopper']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[mail_order_shopper]" value="0"<?php if(! $sett['mail_order_shopper']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['order_subject']; ?></td><td><input type="text" name="new_sett[order_subject]" value="<?php echo $sett['order_subject']; ?>"></td></tr>

<?php if(extension_loaded('gd')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['antibot_feedback']; ?></td><td><input type="radio" name="new_sett[antibot_feedback]" value="1"<?php if($sett['antibot_feedback']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[antibot_feedback]" value="0"<?php if(! $sett['antibot_feedback']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>
<?php } ?>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['paid_order_status']; ?></td>
<td>
<select name="new_sett[paid_order_status]"><?php
require_once(INC_DIR."/admin/orders.php");
$orders=new orders;
 foreach($orders->statuses as $status_id => $status_arr){
 if($status_id == $sett['paid_order_status']){$selected=' selected="selected"';}else{$selected='';}
 echo "<option value=\"$status_id\"$selected>$status_arr[name]</option>";
 }
?></select>
</td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>">
<td><?php echo $lang['autopay_status_only']; ?></td>
<td>
<select name="new_sett[autopay_status_only]"><?php
 if(! isset($sett['autopay_status_only']) || ! is_numeric($sett['autopay_status_only'])){
 $sett['autopay_status_only'] = -1;
 }
echo "<option value=\"-1\">$lang[any_status]</option>";
 foreach($orders->statuses as $status_id => $status_arr){
 if($status_id == $sett['autopay_status_only']){$selected=' selected="selected"';}else{$selected='';}
  if($status_id != $sett['paid_order_status']){
  echo "<option value=\"$status_id\"$selected>$status_arr[name]</option>";
  }
 }
?></select>
</td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pr_cnt_reduction']; ?></td><td class="nowrap"><input type="radio" name="new_sett[pr_cnt_reduction]" value="1"<?php if($sett['pr_cnt_reduction']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pr_cnt_reduction]" value="0"<?php if(! $sett['pr_cnt_reduction']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pub_group_discounts']; if(! empty($sett['pub_group_discounts'])){echo '<br><a href="' . @stdi2("view=discounts&dtype=group", "discounts/group.html") . "\" target=\"_blank\">($lang[watch])</a>";}else{echo "<br>($lang[disabled])";} ?></td><td><input type="radio" name="new_sett[pub_group_discounts]" value="1"<?php if(! empty($sett['pub_group_discounts'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pub_group_discounts]" value="0"<?php if(empty($sett['pub_group_discounts'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pub_all_discounts']; if(! empty($sett['pub_all_discounts'])){echo '<br><a href="' . @stdi2("view=discounts", "discounts/") . "\" target=\"_blank\">($lang[watch])</a>";}else{echo "<br>($lang[disabled])";} ?></td><td><input type="radio" name="new_sett[pub_all_discounts]" value="1"<?php if(! empty($sett['pub_all_discounts'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pub_all_discounts]" value="0"<?php if(empty($sett['pub_all_discounts'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['cart_add_q0'] . ' ' . custom::contextHelp($lang['cart_add_q0_info']); ?></td><td><input type="radio" name="new_sett[cart_add_q0]" value="1"<?php if(! empty($sett['cart_add_q0'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[cart_add_q0]" value="0"<?php if(empty($sett['cart_add_q0'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['nocart_add_price0']; ?></td><td><input type="radio" name="new_sett[nocart_add_price0]" value="1"<?php if(! empty($sett['nocart_add_price0'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[nocart_add_price0]" value="0"<?php if(empty($sett['nocart_add_price0'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['cart_add']; ?></td><td>
<select name="new_sett[cart_add]">
<option value="0"<?php if(empty($sett['cart_add'])){echo ' selected';} ?>><?php echo $lang['this_window']; ?></option>
<option value="1"<?php if(isset($sett['cart_add']) && $sett['cart_add'] == 1){echo ' selected';} ?>><?php echo $lang['popup_window']; ?></option>
<option value="2"<?php if(isset($sett['cart_add']) && $sett['cart_add'] == 2){echo ' selected';} ?>><?php echo $lang['no_refresh_page']; ?></option>
?>
</select>
</td></tr>

<?php
$selbox_values = array('nSImg', 'nOldPrice', 'nMnf', 'nCartFrm', 'nSDescr');
 if(! isset($sett['prLstNoMain'])){
 $sett['prLstNoMain'] = '';
 }
$sett_no_values = explode(',', $sett['prLstNoMain']);
?>
<tr class="<?php echo $admin_lib->sett_class(); ?>">
 <td><?php echo $lang['prLstNoMain']; ?></td>
 <td>
<select name="new_sett[prLstNoMain][]" multiple="multiple">
<?php
 foreach($selbox_values as $value){
  if(in_array($value, $sett_no_values)){
  $selected = ' selected="selected"';
  }
  else{
  $selected = '';
  }
 echo "<option value=\"$value\"$selected>$lang[$value]</option>";
 }
?>
</select>
</td>
</tr>

<?php
$selbox_values = array('nSImg', 'nOldPrice', 'nMnf', 'nCartFrm', 'nSDescr');
 if(! isset($sett['prLstNoCat'])){
 $sett['prLstNoCat'] = '';
 }
$sett_no_values = explode(',', $sett['prLstNoCat']);
?>
<tr class="<?php echo $admin_lib->sett_class(); ?>">
 <td><?php echo $lang['prLstNoCat']; ?></td>
 <td>
<select name="new_sett[prLstNoCat][]" multiple="multiple">
<?php
 foreach($selbox_values as $value){
  if(in_array($value, $sett_no_values)){
  $selected = ' selected="selected"';
  }
  else{
  $selected = '';
  }
 echo "<option value=\"$value\"$selected>$lang[$value]</option>";
 }
?>
</select>
</td>
</tr>

<?php
$selbox_values = array('nSImg', 'nOldPrice', 'nCartFrm', 'nSDescr');
 if(! isset($sett['prLstNoMnf'])){
 $sett['prLstNoMnf'] = '';
 }
$sett_no_values = explode(',', $sett['prLstNoMnf']);
?>
<tr class="<?php echo $admin_lib->sett_class(); ?>">
 <td><?php echo $lang['prLstNoMnf']; ?></td>
 <td>
<select name="new_sett[prLstNoMnf][]" multiple="multiple">
<?php
 foreach($selbox_values as $value){
  if(in_array($value, $sett_no_values)){
  $selected = ' selected="selected"';
  }
  else{
  $selected = '';
  }
 echo "<option value=\"$value\"$selected>$lang[$value]</option>";
 }
?>
</select>
</td>
</tr>

<?php
$selbox_values = array('nSImg', 'nOldPrice', 'nMnf', 'nCartFrm', 'nSDescr');
 if(! isset($sett['prLstNoSrch'])){
 $sett['prLstNoSrch'] = '';
 }
$sett_no_values = explode(',', $sett['prLstNoSrch']);
?>
<tr class="<?php echo $admin_lib->sett_class(); ?>">
 <td><?php echo $lang['prLstNoSrch']; ?></td>
 <td>
<select name="new_sett[prLstNoSrch][]" multiple="multiple">
<?php
 foreach($selbox_values as $value){
  if(in_array($value, $sett_no_values)){
  $selected = ' selected="selected"';
  }
  else{
  $selected = '';
  }
 echo "<option value=\"$value\"$selected>$lang[$value]</option>";
 }
?>
</select>
</td>
</tr>

<?php if($admin_lib->is_design_marker_exists('{header_text}', 'design.tpl')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['header_text'] . ' ' . custom::contextHelp($lang['header_text_help']); ?></td><td><textarea name="html_sett[header_text]" cols="29" rows="2"><?php echo isset($sett['header_text']) ? $sett['header_text'] : ''; ?></textarea></td></tr>
<?php } ?>

<?php if($admin_lib->is_design_marker_exists('{footer_text}', 'design.tpl')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['footer_text'] . ' ' . custom::contextHelp($lang['footer_text_help']); ?></td><td><textarea name="html_sett[footer_text]" cols="29" rows="2"><?php echo isset($sett['footer_text']) ? $sett['footer_text'] : ''; ?></textarea></td></tr>
<?php } ?>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>