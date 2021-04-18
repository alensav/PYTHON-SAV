<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/itemsform');
?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if($act=='editem'){echo $lang['editing_product'];}elseif($act=='additem'){echo $lang['adding_product'];} ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<?php
 if($admset['wysiwyg']){
 require_once(INC_DIR."/editor.php");
 $editor=new editor;
 echo $editor->script_link();
 }
?>
</head>
<?php

$itemid = 0;
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $itemid = isset($_GET['itemid']) ? intval($_GET['itemid']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $itemid = isset($_POST['itemid']) ? intval($_POST['itemid']) : 0;
 }

require_once(INC_DIR."/admin/items.php");
$items = new items;
$save_msg = '';

 if(! empty($_POST['save'])){
 require_once(INC_DIR."/admin/ed_cat.php");
 $ed_category = new ed_category;
 





 $save_msg = $items->save_item($itemid);

 $row = $_POST;

  if($act == 'editem'){
  
  $tmp_row=$items->get_item($itemid);
  $row['small_img'] = $tmp_row['small_img'];
  $row['big_img'] = $tmp_row['big_img'];
  $row['fcatname'] = $tmp_row['fcatname'];
  }

 }
 elseif($act == 'editem'){
 $row = $items->get_item($itemid);
 }

 if(empty($row['price'])){
 $row['price'] = '0.00';
 }

 if(empty($row['old_price'])){
 $row['old_price']='0.00';
 }

 if(! isset($row['quantity'])){
 $row['quantity'] = 'unlim';
 }
 elseif(! $row['quantity']){
 $row['quantity'] = 0;
 }

$row['title'] = isset($row['title']) ? stripslashes($row['title']) : '';
$row['sku'] = isset($row['sku']) ? stripslashes($row['sku']) : '';
$row['short_descript'] = isset($row['short_descript']) ? stripslashes($row['short_descript']) : '';
$row['long_descript'] = isset($row['long_descript']) ? stripslashes($row['long_descript']) : '';
$row['metatags'] = isset($row['metatags']) ? stripslashes($row['metatags']) : '';
$row['special'] = isset($row['special']) ? stripslashes($row['special']) : '';
$row['meta_title'] = isset($row['meta_title']) ? stripslashes($row['meta_title']) : '';
$row['description'] = isset($row['description']) ? stripslashes($row['description']) : '';
$row['keywords'] = isset($row['keywords']) ? stripslashes($row['keywords']) : '';

 if($row['quantity'] >= 4294967295){
 $row['quantity'] = 'unlim';
 }

 if($act=='editem' && $row['visible']){
 $product_url = '<a href="' . @stdi2("product=$itemid", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$itemid.html", 'p')) . '" target="_blank">' . $row['title'] . '</a>';
 }
 elseif($act=='editem'){
 $product_url="\"$row[title]\"";
 }

 if(! isset($row['catid'])){
 $row['catid'] = 0;
 }

 if($items->show_form){
?>
<script type="text/javascript">
function set_autoresize(is_checked){
var max_img_q=5;
 if(is_checked){
 document.frm.smallimg_file.disabled=true;
 document.frm.smallimg_efile.disabled=true;
 }
 else{
 document.frm.smallimg_file.disabled=false;
 if(! document.frm.smallimg_file.value){document.frm.smallimg_efile.disabled=false;}
 }
}
function showimg(img){window.open('<?php echo $sett['relative_url']; ?>viewimg.php?img='+img,'','resizable,scrollbars,width=300,height=300');}
</script>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0"><table width="100%" bgcolor="#ffffff"><tr><td><?php echo $save_msg; ?>
<form name="frm" action="?" method="POST" enctype="multipart/form-data">
<input type="hidden" name="view" value="<?php echo $view; ?>">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
<input type="hidden" name="independ" value="1">
<?php if(! empty($row['catid'])){echo "<input type=\"hidden\" name=\"old_catid\" value=\"$row[catid]\">";} ?>
<input type="hidden" name="save" value="1">
<table width="100%" class="settbl">
<tr class="htr"><td>
<?php
 if($act=='editem'){
 echo $lang['editing_product'];
 }
 elseif($act=='additem'){
 echo $lang['adding_product'];
 }
 if(isset($product_url)){
 echo " $product_url";
 }
?></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><br><?php echo $lang['product_name']; ?> *<br>
<input type="text" name="title" size="46" maxlength="255" value="<?php echo $row['title']; ?>"><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['product_sku']; ?><br>
<input type="text" name="sku" size="46" maxlength="255" value="<?php echo $row['sku']; ?>"><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php
require_once(INC_DIR."/admin/view_cat.php");
$view_category=new view_category;
echo $lang['category'];
?> *<br><select name="catid"><option value=""><?php echo $lang['not_selected'] . $view_category->get_chapters_list($row['catid']); ?></select>
<br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['pr_link_name']; ?><br>
<input type="text" name="itemname" value="<?php if(isset($row['itemname'])){echo $row['itemname'];} ?>" size="32" maxlength="255"><br><br>
</td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['sort_index']; ?><br>
<input type="text" name="sortid" value="<?php $row['sortid'] = isset($row['sortid']) ? intval($row['sortid']) : 0; echo $row['sortid']; ?>" size="10"><br><br>
</td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<br><a href="javascript:window.open('?view=product&act=addition_categories&itemid=<?php echo $itemid; ?>&independ=1','addition_categories<?php echo $itemid; ?>','status,scrollbars,resizable,width=540,height=500');void(0);"><?php echo $lang['addition_categories']; ?></a><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['manufacturer']; ?><br><select name="mnf_id"><option value="0"><?php $row['mnf_id'] = isset($row['mnf_id']) ? intval($row['mnf_id']) : 0; echo $lang['not_used'] . $items->get_manufacturers_list($row['mnf_id']); ?></select>
<br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['price']; ?><br>
<input type="text" name="price" size="20" maxlength="15" value="<?php echo $row['price']; ?>"> <?php echo $sett['curr_brief']; ?><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['old_price']; ?><br>
<input type="text" name="old_price" size="20" maxlength="15" value="<?php echo $row['old_price']; ?>"> <?php echo $sett['curr_brief']; ?><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['quantity']; ?><br><input type="text" name="quantity" size="10" maxlength="10" value="<?php echo $row['quantity']; ?>"> <span style="cursor:hand" onclick="document.frm.quantity.value='unlim';"><u><?php echo $lang['unlim']; ?></u></span><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['quantity_txt']; ?><br><input type="text" name="quantity_txt" size="46" maxlength="255" value="<?php if(isset($row['quantity_txt'])){echo $row['quantity_txt'];} ?>"><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['short_descript']; ?><br>
<textarea id="short_descript" name="short_descript" cols="56" rows="8"><?php echo $row['short_descript']; ?></textarea><div id="auto_br_short_descript"><input type="checkbox" name="auto_br_short_descript"><?php echo $lang['auto_br']; ?></div><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['long_descript']; ?><br>
<textarea id="long_descript" name="long_descript" cols="56" rows="16"><?php echo $row['long_descript']; ?></textarea><div id="auto_br_long_descript"><input type="checkbox" name="auto_br_long_descript"><?php echo $lang['auto_br']; ?></div><br><br></td></tr>
<?php
 if($sett['smallimg_width']){
 $def_img_width=" width=\"$sett[smallimg_width]\" ";
 }
 else{
 $def_img_width='';
 }
?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php if(! isset($row['small_img'])){$row['small_img'] = '';} if($row['small_img']){echo $lang['small_image']; ?> &nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" name="del_smallimg"><?php echo $lang['del_image']; ?><br>
<a href="<?php echo "$sett[relative_url]img/small/$row[small_img]"; ?>" target="_blank"><img src="<?php echo "$sett[relative_url]img/small/$row[small_img]"; ?>" style="max-width:730px;"<?php echo $def_img_width; ?>></a><br>
<?php } ?><table><tr><td>
<?php echo $lang['upload_small_image']; ?><br>
<?php echo $lang['in_folder']; ?> <select name="smallimg_subfolder"><option value="">img/small</option><?php echo $items->get_img_subfolders('small', $row['small_img']); ?></select><br>
<input type="file" name="smallimg_file" class="InputFile" onchange="if(this.value){document.frm.smallimg_efile.disabled=true;}else{document.frm.smallimg_efile.disabled=false;}"></td><td><br>&nbsp;<?php echo $lang['already_uploaded_file']; ?><br>&nbsp;<input type="text" name="smallimg_efile" value="<?php echo $items->get_filename_from_fullfilename($row['small_img']); ?>">
</td></tr></table>
<?php
if(extension_loaded('gd')){
echo '<br><input type="checkbox" name="auto_resize" onclick="set_autoresize(this.checked);"';
if(! empty($_POST['auto_resize'])){echo ' checked';}
echo ">$lang[auto_resize]<br>($lang[size_can_be_set] <a href=\"?view=settings&settype=adminconfig\" target=\"_blank\">$lang[admin_config_category]</a>).";} ?>
<br><br></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php if(! isset($row['big_img'])){$row['big_img'] = '';} if($row['big_img']){echo $lang['big_image']; ?> &nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" name="del_bigimg"><?php echo $lang['del_image']; ?><br>
<a href="<?php echo "$sett[relative_url]img/big/$row[big_img]"; ?>" target="_blank"><img src="<?php echo "$sett[relative_url]img/big/$row[big_img]"; ?>" style="max-width:730px;"></a><br>
<?php } ?><table><tr><td>
<?php echo $lang['upload_big_image']; ?><br>
<?php echo $lang['in_folder']; ?> <select name="bigimg_subfolder"><option value="">img/big</option><?php echo $items->get_img_subfolders('big', $row['big_img']); ?></select><br>
<input type="file" name="bigimg_file" class="InputFile" onchange="if(this.value){document.frm.bigimg_efile.disabled=true;}else{document.frm.bigimg_efile.disabled=false;}"></td><td><br>&nbsp;<?php echo $lang['already_uploaded_file']; ?><br>&nbsp;<input type="text" name="bigimg_efile" value="<?php echo $items->get_filename_from_fullfilename($row['big_img']); ?>"></td></tr></table><br><br></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<a href="javascript:window.open('?view=product&act=gallery&itemid=<?php echo $itemid; ?>&independ=1','product_gal<?php echo $itemid; ?>','status,scrollbars,resizable,width='+screen.width/1.6+',height='+screen.height/1.6+'\'');void(0);"><?php echo $lang['images_gallery']; ?></a></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<a href="javascript:window.open('?view=product&act=item_options&itemid=<?php echo $itemid; ?>&independ=1','item_options<?php echo $itemid; ?>','status,scrollbars,resizable,width=540,height=500');void(0);"><?php echo $lang['product_options'].' '.$lang['color_size_etc']; ?></a></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<a href="javascript:window.open('?view=product&act=item_similar&itemid=<?php echo $itemid; ?>&independ=1','item_similar<?php echo $itemid; ?>','status,scrollbars,resizable,width=640,height=500');void(0);"><?php echo $lang['item_similar']; ?></a></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><br><b><i><?php echo $lang['optional_fields']; ?></i></b></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_title']; ?><br>
<input type="text" name="meta_title" value="<?php echo $row['meta_title']; ?>" size="70" maxlength="255"><br><br>
</td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_description']; ?><br>
<input type="text" name="description" value="<?php echo $row['description']; ?>" size="70" maxlength="255"><br><br>
</td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_keywords']; ?><br>
<input type="text" name="keywords" value="<?php echo $row['keywords']; ?>" size="70" maxlength="255"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['meta_tags']; ?><br>
<textarea name="metatags" cols="56" rows="4"><?php echo $row['metatags']; ?></textarea><br><br></td></tr>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['banner_code']; ?><br><textarea name="special" cols="56" rows="4"><?php echo $row['special']; ?></textarea><br>
<input type="checkbox" name="auto_br_special"><?php echo $lang['auto_br']; ?><br><br></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><input type="checkbox" name="visible"<?php if(! empty($row['visible']) || (isset($_GET['act']) && $_GET['act'] == 'additem') ){echo ' checked';} ?>><?php echo $lang['product_visible']; ?><br><br></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><input type="checkbox" name="show_on_main"<?php if(! empty($row['main_itemid']) || ! empty($_POST['show_on_main'])){echo ' checked';} ?> onclick="if(this.checked){document.frm.main_sortid.disabled=false;}else{document.frm.main_sortid.disabled=true;}"><?php echo $lang['show_on_main']; ?><br><br>
<?php echo $lang['main_sort_index']; ?><br>
<input type="text" name="main_sortid" value="<?php $row['main_sortid'] = isset($row['main_sortid']) ? intval($row['main_sortid']) : 0; echo $row['main_sortid']; ?>" size="10"<?php if(empty($row['main_itemid']) && empty($_POST['show_on_main'])){echo ' disabled';} ?>><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><input type="checkbox" name="special_offer"<?php if(! empty($row['sp_itemid']) || ! empty($_POST['special_offer'])){echo ' checked';} ?> onclick="if(this.checked){document.frm.sp_sortid.disabled=false;}else{document.frm.sp_sortid.disabled=true;}"><?php echo $lang['special_offer']; ?><br><br>
<?php echo $lang['special_sort_index']; ?><br>
<input type="text" name="sp_sortid" value="<?php $row['sp_sortid'] = isset($row['sp_sortid']) ? intval($row['sp_sortid']) : 0; echo $row['sp_sortid']; ?>" size="10"<?php if(empty($row['sp_itemid']) && empty($_POST['special_offer'])){echo ' disabled';} ?>><br><br>
</td></tr>

<tr class="ftr"><td><br>&nbsp; <input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"> &nbsp; <input type="reset" value="<?php echo $lang['reset']; ?>" class="button1"><br></td></tr>
</table>
<br>*<i> - <?php echo $lang['required_fields']; ?></i>
</form>
<?php } ?>
</td></tr></table>
<?php if($admset['wysiwyg']){echo $editor->init_js(array('short_descript', 'long_descript'));} ?>
<script type="text/javascript">
if(document.frm.auto_resize!=undefined && document.frm.auto_resize.checked){set_autoresize('on');}
</script>
</body>
</html>