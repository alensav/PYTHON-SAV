<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/delitem');
?><!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html; charset=<?php echo $sett['charset']; ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo $lang['deleting_product']; ?></title><link href="adm/pop-up.css" rel="stylesheet" type="text/css"></head><body>
<?php
require_once(INC_DIR."/admin/items.php");
require_once(INC_DIR."/admin/ed_cat.php");
$items=new items;
$ed_category=new ed_category;
echo $items->delete_item_with_msg($_GET['id']); 
?>
</body></html>