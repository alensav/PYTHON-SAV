<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/export_csv');

 if(isset($_POST['act']) && $_POST['act'] == 'do_export'){
 require_once(INC_DIR."/admin/csv.php");
 $csv=new csv;
 echo $csv->export();
 }
 elseif(isset($_GET['act']) && $_GET['act'] == 'delete_export'){
 require_once(INC_DIR."/admin/csv.php");
 $csv = new csv;
 echo $csv->delete_export_file();
 }

 echo <<<HTMLDATA
<table width="100%" class="settbl">
 <tr class="htr">
  <td>$lang[download_file]</td>
  <td class="alignCenter">$lang[delete]</td>
 </tr>
HTMLDATA;


$files=array();
$dirhandle = opendir(SCRIPTCHF_DIR."/adm/dump");
 while(($filename = readdir($dirhandle)) !== false){
  $length_filename=strlen($filename);
  if( (substr($filename, 0, 7) === 'export_') && (substr($filename, $length_filename-4) === '.csv' || substr($filename, $length_filename-3) === '.gz') ){
  array_push($files, $filename);
  }
 }
closedir($dirhandle);
rsort($files);

 if(count($files) > 0){
  foreach($files as $filename){
  $def_class = $admin_lib->sett_class();
  echo "<tr class=\"$def_class\"><td><a href=\"?view=download_csv&df=$filename\">$filename</a></td><td class=\"alignCenter\"><a href=\"?view=tools&tname=export_csv&act=delete_export&df=$filename\" onclick=\"return q('$lang[delete_this_file]')\"><img src=\"adm/img/del.gif\" border=\"0\" alt=\"$lang[delete]\"></a></td></tr>";
  }
 }
 else{
 echo "<tr><td colspan=\"2\">$lang[no_files]</td></tr>";
 }

 echo <<<HTMLDATA
</table><br><table width="100%" class="settbl">
 <tr class="htr">
  <td colspan="2">$lang[export_csv]</td>
 </tr>
 <tr class="str">
  <td colspan="2"><br>
<form name="frm" action="?" method="POST" onsubmit="document.frm.submit.disabled=true;">
<input type="hidden" name="view" value="tools">
<input type="hidden" name="tname" value="export_csv">
<input type="hidden" name="act" value="do_export">
HTMLDATA;

$sort_by = isset($_POST['sort_by']) ? $sort_by = $_POST['sort_by'] : '';

echo "$lang[sort_products_by]:<br>"; ?>
<select name="sort_by">
<option value="itemid"<?php if($sort_by == 'itemid'){echo ' selected';} ?>><?php echo $lang['itemid']; ?></option>
<option value="itemname"<?php if($sort_by == 'itemname'){echo ' selected';} ?>><?php echo $lang['itemname']; ?></option>
<option value="catid"<?php if($sort_by == 'catid'){echo ' selected';} ?>><?php echo $lang['catid']; ?></option>
<option value="mnf_id"<?php if($sort_by == 'mnf_id'){echo ' selected';} ?>><?php echo $lang['mnf_id']; ?></option>
<option value="sku"<?php if($sort_by == 'sku'){echo ' selected';} ?>><?php echo $lang['sku']; ?></option>
<option value="title"<?php if($sort_by == 'title'){echo ' selected';} ?>><?php echo $lang['title']; ?></option>
<option value="price"<?php if($sort_by == 'price'){echo ' selected';} ?>><?php echo $lang['price']; ?></option>
<option value="old_price"<?php if($sort_by == 'old_price'){echo ' selected';} ?>><?php echo $lang['old_price']; ?></option>
<option value="quantity"<?php if($sort_by == 'quantity'){echo ' selected';} ?>><?php echo $lang['quantity']; ?></option>
<option value="quantity_txt"<?php if($sort_by == 'quantity_txt'){echo ' selected';} ?>><?php echo $lang['quantity_txt']; ?></option>
<option value="short_descript"<?php if($sort_by == 'short_descript'){echo ' selected';} ?>><?php echo $lang['short_descript']; ?></option>
<option value="long_descript"<?php if($sort_by == 'long_descript'){echo ' selected';} ?>><?php echo $lang['long_descript']; ?></option>
<option value="small_img"<?php if($sort_by == 'small_img'){echo ' selected';} ?>><?php echo $lang['small_img']; ?></option>
<option value="big_img"<?php if($sort_by == 'big_img'){echo ' selected';} ?>><?php echo $lang['big_img']; ?></option>
<option value="add_date"<?php if($sort_by == 'add_date'){echo ' selected';} ?>><?php echo $lang['add_date']; ?></option>
<option value="upd_date"<?php if($sort_by == 'upd_date'){echo ' selected';} ?>><?php echo $lang['upd_date']; ?></option>
<option value="meta_title"<?php if($sort_by == 'meta_title'){echo ' selected';} ?>><?php echo $lang['meta_title']; ?></option>
<option value="description"<?php if($sort_by == 'description'){echo ' selected';} ?>><?php echo $lang['description']; ?></option>
<option value="keywords"<?php if($sort_by == 'keywords'){echo ' selected';} ?>><?php echo $lang['keywords']; ?></option>
<option value="metatags"<?php if($sort_by == 'metatags'){echo ' selected';} ?>><?php echo $lang['metatags']; ?></option>
<option value="special"<?php if($sort_by == 'special'){echo ' selected';} ?>><?php echo $lang['special']; ?></option>
<option value="visible"<?php if($sort_by == 'visible'){echo ' selected';} ?>><?php echo $lang['visible']; ?></option>
</select>

<select name="desc">
<option value="0"<?php if(isset($_POST['desc']) && $_POST['desc'] == 0){echo ' selected="selected"';} ?>><?php echo $lang['direct_order']; ?></option>
<option value="1"<?php if(isset($_POST['desc']) && $_POST['desc'] == 1){echo ' selected="selected"';} ?>><?php echo $lang['inverse_order']; ?></option>
</select><br><br>

<?php echo $lang['delimiter']; ?> 
<select name="delimiter">
<option value=";"<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == ';'){echo ' selected="selected"';} ?>><?php echo $lang['semicolon']; ?></option>
<option value=","<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == ','){echo ' selected="selected"';} ?>><?php echo $lang['comma']; ?></option>
<option value="	"<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == "\x09"){echo ' selected="selected"';} ?>><?php echo $lang['tabulation']; ?></option>
<option value=" "<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == ' '){echo ' selected="selected"';} ?>><?php echo $lang['space']; ?></option>
</select>
<br>

<?php echo $lang['price_delimiter']; ?> 
<select name="price_delimiter">
<option value="comma"<?php if(isset($_POST['price_delimiter']) && $_POST['price_delimiter'] == 'comma'){echo ' selected="selected"';} ?>><?php echo $lang['comma']; ?></option>
<option value="point"<?php if(isset($_POST['price_delimiter']) && $_POST['price_delimiter'] == 'point'){echo ' selected="selected"';} ?>><?php echo $lang['point']; ?></option>
<option value="no_fractional_price"<?php if(isset($_POST['price_delimiter']) && $_POST['price_delimiter'] == 'no_fractional_price'){echo ' selected="selected"';} ?>><?php echo $lang['no_fractional_price']; ?></option>
</select>
<br><br>

<?php

 if(isset($_POST['sel_charset'])){
 $sel_charset = $_POST['sel_charset'];
 }
 elseif(isset($admset['csv_export_charset'])){
 $sel_charset = $admset['csv_export_charset'];
 }
 else{
 $sel_charset = 'utf-8';
 }

require_once(INC_DIR."/charset_conv.php");
$chc_select = charset_conv::charsets_selectbox($sel_charset);

 echo <<<HTMLDATA
<div>
$lang[file_charset] $chc_select<br>$lang[file_charset_info]<br><br>
</div>
<input type="checkbox" name="gzip_compress" id="gzip_compress"><label for="gzip_compress">$lang[gzip_compress]</label><br><br>
<input type="submit" name="submit" value="$lang[do_export]" class="button1">
</form>
</td>
 </tr>
</table>
HTMLDATA;
?>