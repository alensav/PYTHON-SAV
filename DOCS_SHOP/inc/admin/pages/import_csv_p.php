<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/import_csv');

 if(isset($_POST['act']) && $_POST['act'] == 'do_import'){
 require_once(INC_DIR."/admin/csv.php");
 $csv = new csv;
 echo $csv->import();
 }

 echo <<<HTMLDATA
<br><center><table width="100%" class="settbl">
 <tr class="htr">
  <td colspan="2">$lang[import_csv]</td>
 </tr>
 <tr class="str">
  <td colspan="2">
<form name="frm" action="?" method="POST" enctype="multipart/form-data" onsubmit="if(this.delimiter.value==''){alert('$lang[select_delimiter]');return false;}else{document.frm.submit.disabled=true;}" style="margin:4px">

$lang[import_help]<hr><br>

<input type="hidden" name="view" value="tools">
<input type="hidden" name="tname" value="import_csv">
<input type="hidden" name="act" value="do_import">
$lang[delimiter] 
<select name="delimiter">
HTMLDATA;
?>
<option value=""><?php echo $lang['not_selected']; ?></option>
<option value=";"<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == ';'){echo ' selected';} ?>><?php echo $lang['semicolon']; ?></option>
<option value=","<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == ','){echo ' selected';} ?>><?php echo $lang['comma']; ?></option>
<option value="	"<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == "\x09"){echo ' selected';} ?>><?php echo $lang['tabulation']; ?></option>
<option value=" "<?php if(isset($_POST['delimiter']) && $_POST['delimiter'] == ' '){echo ' selected';} ?>><?php echo $lang['space']; ?></option>
</select>
<br><br>

<?php echo $lang['choose_update_fields']; ?><br>
<input type="checkbox" name="update_fields[itemname]"<?php if(! empty($_POST['update_fields']['itemname']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['itemname']; ?><br>
<input type="checkbox" name="update_fields[catid]"<?php if(! empty($_POST['update_fields']['catid']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['catid']; ?><br>
<input type="checkbox" name="update_fields[mnf_id]"<?php if(! empty($_POST['update_fields']['mnf_id']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['mnf_id']; ?><br>
<input type="checkbox" name="update_fields[sku]"<?php if(! empty($_POST['update_fields']['sku']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['sku']; ?><br>
<input type="checkbox" name="update_fields[title]"<?php if(! empty($_POST['update_fields']['title']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['title']; ?><br>
<input type="checkbox" name="update_fields[price]"<?php if(! empty($_POST['update_fields']['price']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['price']; ?><br>
<input type="checkbox" name="update_fields[old_price]"<?php if(! empty($_POST['update_fields']['old_price']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['old_price']; ?><br>
<input type="checkbox" name="update_fields[quantity]"<?php if(! empty($_POST['update_fields']['quantity']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['quantity']; ?><br>
<input type="checkbox" name="update_fields[quantity_txt]"<?php if(! empty($_POST['update_fields']['quantity_txt']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['quantity_txt']; ?><br>
<input type="checkbox" name="update_fields[short_descript]"<?php if(! empty($_POST['update_fields']['short_descript']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['short_descript']; ?><br>
<input type="checkbox" name="update_fields[long_descript]"<?php if(! empty($_POST['update_fields']['long_descript']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['long_descript']; ?><br>
<input type="checkbox" name="update_fields[small_img]"<?php if(! empty($_POST['update_fields']['small_img']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['small_img']; ?><br>
<input type="checkbox" name="update_fields[big_img]"<?php if(! empty($_POST['update_fields']['big_img']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['big_img']; ?><br>
<input type="checkbox" name="update_fields[add_date]"<?php if(! empty($_POST['update_fields']['add_date']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['add_date']; ?><br>
<input type="checkbox" name="update_fields[meta_title]"<?php if(! empty($_POST['update_fields']['meta_title']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['meta_title']; ?><br>
<input type="checkbox" name="update_fields[upd_date]" onclick="if(! this.checked){document.frm.autoupdate_upddate.checked=false;document.frm.autoupdate_upddate.disabled=true;}else{document.frm.autoupdate_upddate.disabled=false;}"<?php if(! empty($_POST['update_fields']['upd_date']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['upd_date']; ?><br>
<input type="checkbox" name="update_fields[description]"<?php if(! empty($_POST['update_fields']['description']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['description']; ?><br>
<input type="checkbox" name="update_fields[keywords]"<?php if(! empty($_POST['update_fields']['keywords']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['keywords']; ?><br>
<input type="checkbox" name="update_fields[metatags]"<?php if(! empty($_POST['update_fields']['metatags']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['metatags']; ?><br>
<input type="checkbox" name="update_fields[special]"<?php if(! empty($_POST['update_fields']['special']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['special']; ?><br>
<input type="checkbox" name="update_fields[visible]"<?php if(! empty($_POST['update_fields']['visible']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['visible']; ?><br>

<p><hr></p>

<input type="checkbox" name="autoset_adddate"<?php if(! empty($_POST['autoset_adddate']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['autoset_adddate']; ?><br>

<input type="checkbox" name="autoupdate_upddate"<?php if(! empty($_POST['autoupdate_upddate']) || $_SERVER['REQUEST_METHOD'] == 'GET'){echo ' checked';} ?>><?php echo $lang['autoupdate_upddate']; ?><br>

<input type="checkbox" name="del_all_products" onclick="if(this.checked){if(! q('<?php echo $lang['del_all_products']; ?>')){this.checked=false;}}"<?php if(! empty($_POST['del_all_products'])){echo ' checked';} ?>><?php echo "$lang[preliminary] $lang[del_all_products]"; ?><br><br>

<?php

 if(isset($_POST['sel_charset'])){
 $sel_charset = $_POST['sel_charset'];
 }
 elseif(isset($admset['csv_import_charset'])){
 $sel_charset = $admset['csv_import_charset'];
 }
 else{
 $sel_charset = 'utf-8';
 }

require_once(INC_DIR."/charset_conv.php");
$chc_select = charset_conv::charsets_selectbox($sel_charset);

echo <<<HTMLDATA
$lang[choose_import_file]<br>
<input type="file" name="csv_file" class="InputFile"><br><br>
<div>
$lang[file_charset] $chc_select<br>$lang[file_charset_info]<br>
</div>
<p>
$lang[time_is_required]<br>
$lang[backup_recommended] <a href="?view=tools&tname=dbcopy">$lang[make_backup]</a>.
</p>
<input type="submit" name="submit" value="$lang[do_import]" class="button1">
</form>
</td>
 </tr>
</table>
</center>
HTMLDATA;
?>