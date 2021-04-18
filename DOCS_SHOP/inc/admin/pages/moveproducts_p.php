<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/moveproducts');
if(! empty($_POST['save'])){
require_once(INC_DIR."/admin/ed_cat.php");
$ed_category=new ed_category;
echo $ed_category->moveallitems_fromcategory();
}
else{
?>
<form action="?" method="POST">
<input type="hidden" name="view" value="moveproducts">
<input type="hidden" name="save" value="1">
<input type="hidden" name="oldcat" value="<?php echo $cat; ?>">
<?php
require_once(INC_DIR."/admin/view_cat.php");
$view_category=new view_category;
$chain_chapter_title=$view_category->adm_chain_chapter_title($cat, ' / ');
echo "$lang[choose_category] \"$chain_chapter_title[ch_title_link]\""; ?><br><br><select name="newcat">
<?php echo $view_category->get_chapters_list($cat); ?>
</select>
<br><br>
<input type="submit" value="<?php echo $lang['move_all_products']; ?>" class="button1"> &nbsp; <button class=button1 onclick="javascript:history.go(-1); return false;"><?php echo $lang['cancel']; ?></button></form>
<?php } ?>