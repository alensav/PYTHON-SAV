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
$view_category = new view_category;
require_once(INC_DIR."/shop.php");

$chain_chapter_title = $view_category->adm_chain_chapter_title($cat, ' &#47; ');

echo $view_category->search_form();
 if($cat){
 $view_category->print_chapters($cat);
 }
 else{
 $view_category->print_chapters(0);
 }
echo '<br>';

if($cat){echo "$lang[category]: <a href=\"?view=cts\">$lang[shop]</a> / $chain_chapter_title[ch_title_link]<br><br><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=movecat&cat=$cat\">$lang[edit_category]</a> &nbsp; <img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=delcat&cat=$cat\">$lang[del_category]</a> &nbsp; <img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=moveproducts&cat=$cat\">$lang[move_all_products]</a><br>";}
?>

<?php if($cat){ ?>
<form name="sortfrm" method="GET" action="?" style="margin:3px">
<input type="hidden" name ="view" value="cts">
<input type="hidden" name ="cat" value="<?php echo $cat; ?>">
<?php echo $lang['order_by']; ?> 
<select name="sort">
<?php
require_once(INC_DIR."/shop.php");
$shop=new shop;
echo $shop->get_sort_options();
?>
</select>
<select name="desc"><?php echo $shop->get_desc_options(); ?></select>
<input type="submit" value="OK" class="button1">
</form>
<?php } ?>

<?php
if($cat){echo $view_category->get_cat_products();}else{echo "<div><div style=\"display:inline-block;margin:4px;\"><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=makecat\">$lang[mk_category]</a></div><div style=\"display:inline-block;margin:4px;\"><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=invisible_items\">$lang[invisible_products]</a></div></div>";}
?>
