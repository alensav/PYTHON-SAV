<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
global $max_img_quantity;
$max_img_quantity=5;
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
<title><?php echo $lang['images_gallery']; ?></title>
<link href="adm/pop-up.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function set_autoresize(is_checked){
var max_img_q=5;
 if(is_checked){
  for(i=0;i<max_img_q;i++){
  document.gal['smallimg_file'+i].disabled=true;
  }
 }
 else{
  for(i=0;i<max_img_q;i++){
  document.gal['smallimg_file'+i].disabled=false;
  }
 }
}
function showimg(img){window.open('<?php echo $sett['relative_url']; ?>viewimg.php?img='+img,'img','resizable,scrollbars,width=300,height=300');}
</script>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" <?php if($itemid){echo "onload=\"if(document.gal.auto_resize!=undefined && document.gal.auto_resize.checked){set_autoresize('on');}\"";} ?> bgcolor="#ffffff">
<table width="100%" bgcolor="#ffffff"><tr><td>

<?php
echo "<h4 style=\"margin:3px\">$lang[images_gallery]</h4>";

 if(! $itemid){
 echo "$lang[gallery_notfound_product]<br><br><a href=\"javascript:self.close()\">$lang[close_window]</a>";
 }
 else{


require_once(INC_DIR."/admin/items.php");
$items=new items;
$row=$items->get_item($itemid);
 if(! empty($_POST['save'])){
 echo $items->update_gallery($itemid);
 }
?>
<b><?php echo "\"<a href=\"?view=product&act=editem&itemid=$itemid&independ=1\">$row[title]</a>\""; ?></b><?php if($row['visible']){echo "<br>(<a href=\"". @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p')) ."\" target=\"_blank\">$lang[view_in_public]</a>)";} ?><br>

<form name="gal" action="?" method="POST" enctype="multipart/form-data">
<input type="hidden" name="view" value="product">
<input type="hidden" name="act" value="gallery">
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="independ" value="1">
<table width="100%" class="settbl">

<tr class="htr"><td colspan="3"><?php echo $lang['add_delete_images']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="3" align="center"><?php echo $items->get_gallery($itemid); ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="3"><?php echo $lang['prompts']; ?><br><br></td></tr>

<?php if(extension_loaded('gd')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="3"><br><input type="checkbox" name="auto_resize" onclick="set_autoresize(this.checked);"<?php if(! empty($_POST['auto_resize'])){echo ' checked';} ?>><?php echo "$lang[auto_resize] ($lang[size_can_be_set] <a href=\"?view=settings&settype=adminconfig\" target=\"_blank\">$lang[admin_config_category]</a>)."; ?><br><br></td></tr>
<?php } ?>


<tr class="<?php echo $admin_lib->sett_class(); ?>">

<td><?php echo $lang['upload_to_folder']; ?><br><select name="smallimg_subfolder"><option value="">img/small</option><?php echo $items->get_img_subfolders('small', $_POST['smallimg_subfolder'] . '/imitate.filename'); ?></select><br><br></td>

<td><?php echo $lang['upload_to_folder']; ?><br><select name="bigimg_subfolder"><option value="">img/big</option><?php echo $items->get_img_subfolders('big', $_POST['bigimg_subfolder'] . '/imitate.filename'); ?></select><br><br></td>

<td>&nbsp;</td>

</tr>


<?php
 for($i=0;$i<$max_img_quantity;$i++){
 $def_class=$admin_lib->sett_class();
echo <<<HTMLDATA
<tr class="$def_class"><td valign="top">$lang[small_image]<br><input type="file" name="smallimg_file$i" class="InputFile"></td><td valign="top">$lang[big_image]<br><input type="file" name="bigimg_file$i" class="InputFile"></td><td valign="top">$lang[alt]<br><input type="text" name="alt$i"><br><br></td></tr>
HTMLDATA;
 }
?>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="3">&nbsp;</td></tr>

<tr class="ftr"><td colspan="3" align="center"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"> &nbsp; <input type="reset" value="<?php echo $lang['reset']; ?>" class="button1"></td></tr>
</table>
</form>
<?php } ?>
</td></tr></table>
</body>
</html>