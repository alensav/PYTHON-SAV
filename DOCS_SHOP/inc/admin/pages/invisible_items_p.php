<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/categories');
?>
<script type="text/javascript">
function delitem(id){if(q('<?php echo $lang['delete_product']; ?>')){window.open('?view=product&act=delitem&id='+id+'&independ=1','','width=300,height=200');}}
</script>
<?php
require_once(INC_DIR."/admin/view_cat.php");
$view_category=new view_category;
echo "<h3>$lang[invisible_products]</h3>";
echo $view_category->get_invisible_items();
?>
