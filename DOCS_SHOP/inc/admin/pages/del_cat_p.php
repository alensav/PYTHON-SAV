<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/del_cat');
require_once(INC_DIR."/admin/ed_cat.php");
$ed_category=new ed_category;

 if(! empty($_POST['confirmdelcat'])){
 echo $ed_category->delete_category();
 }
 else{
 if(! empty($_POST['postdata'])){echo "<h3><span class=\"red\">$lang[need_confirm_delcat]</span></h3>";}
$chapter_path=$ed_category->get_chapter_path($cat);
?>
<script type="text/javascript">function userconfirm(defform){if(! defform.confirmdelcat.checked){alert('<?php echo $lang['need_confirm_delcat']; ?>');return false;}if(! confirm('<?php echo "$lang[want_delete] \"$chapter_path[ch_title]\" $lang[with_subsections]"; ?>')){return false;}else{return true;}}</script>
<form method="POST" action="?" onsubmit="return userconfirm(this);" style="display:inline;">
<input type="hidden" name="view" value="delcat">
<input type="hidden" name="postdata" value="1">
<input type="hidden" name="cat" value="<?php echo $cat; ?>">
<h1><?php echo $lang['deleting_cat']; ?></h1><b style="text-decoration:underline;"><?php echo $lang['warning']; ?></b> <?php echo "$lang[category] <b>\"$chapter_path[ch_title]\"</b> $lang[will_be_deleted]"; ?><br><br>
<input type="checkbox" name="confirmdelcat"><?php echo $lang['i_confirm']; ?><br><br>
<input type="submit" value="<?php echo $lang['delete_cat']; ?>" class="button1"></form> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <button class="button1" onclick="javascript:history.go(-1); return false;"><?php echo $lang['cancel']; ?></button>
<?php } ?>