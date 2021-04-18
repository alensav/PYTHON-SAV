<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}

 if(! empty($_POST['save'])){
 $err_code=$news_adm->save_news();
  if($err_code==1){
  $act='edit';
  echo "<h3>$lang[changes_success]</h3>";
  }
  else{
  echo "<p class=\"red\">$err_code</p>";
  }
 $news_detail=$custom->stripslashes_array($_POST);
 }
 elseif($act=='edit'){
 $news_detail=$news_adm->get_news_detail($_GET['nid']);
 }

 if($act=='edit'){
 $news_action=$lang['changing_news'];
 }
 elseif($act=='add'){
 $news_action=$lang['adding_news'];
 $news_detail['year']=date("Y", time() + $sett['time_diff'] * 3600);
 $news_detail['month']=date("m", time() + $sett['time_diff'] * 3600);
 $news_detail['day']=date("d", time() + $sett['time_diff'] * 3600);
 }

?>
<form name="frm" action="?" method="POST">
<input type="hidden" name="view" value="news">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="newsid" value="<?php echo isset($news_detail['newsid']) ? $news_detail['newsid'] : 0; ?>">
<table class="settbl" width="100%">
<tr class="htr"><td colspan="2"><?php echo $news_action; ?></td></tr>

<tr class="str"><td>
<table width="150" height="79">
  <tr>
    <td><?php echo $lang['year']; ?></td>
    <td><?php echo $lang['month']; ?></td>
    <td><?php echo $lang['day']; ?></td>
  </tr>
  <tr>
    <td><input type="text" name="year" value="<?php echo isset($news_detail['year']) ? $news_detail['year'] : ''; ?>" maxlength="4" size="4"></td>
    <td><input type="text" name="month" value="<?php echo isset($news_detail['month']) ? $news_detail['month'] : ''; ?>" maxlength="2" size="2"></td>
    <td><input type="text" name="day" value="<?php echo isset($news_detail['day']) ? $news_detail['day'] : ''; ?>" maxlength="2" size="2"></td>
  </tr>
</table>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['news_title']; ?><br>
<textarea name="title" rows="3" cols="56"><?php echo isset($news_detail['title']) ? $news_detail['title'] : ''; ?></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['newsname']; ?><br><input type="text" name="newsname" size="32" maxlength="255" value="<?php echo isset($news_detail['newsname']) ? $news_detail['newsname'] : ''; ?>"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['menu_text']; ?><br>
<textarea id="menu_text" name="menu_text" rows="10" cols="56"><?php echo isset($news_detail['menu_text']) ? $news_detail['menu_text'] : ''; ?></textarea><div id="auto_br_menu_text"><input type="checkbox" name="auto_br_menu_text"><?php echo $lang['auto_br']; ?></div><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['text']; ?><br>
<textarea id="text" name="text" rows="22" cols="56"><?php echo isset($news_detail['text']) ? $news_detail['text'] : ''; ?></textarea><div id="auto_br_text"><input type="checkbox" name="auto_br_text"><?php echo $lang['auto_br']; ?></div><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_title']; ?><br>
<input type="text" name="meta_title" value="<?php echo isset($news_detail['meta_title']) ? $news_detail['meta_title'] : ''; ?>" size="72" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_description']; ?><br>
<input type="text" name="meta_description" value="<?php echo isset($news_detail['meta_description']) ? $news_detail['meta_description'] : ''; ?>" size="72" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_keywords']; ?><br>
<input type="text" name="meta_keywords" value="<?php echo isset($news_detail['meta_keywords']) ? $news_detail['meta_keywords'] : ''; ?>" size="72" maxlength="255"></textarea><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_tags']; ?><br>
<textarea name="meta_tags" cols="56" rows="4"><?php echo isset($news_detail['meta_tags']) ? $news_detail['meta_tags'] : ''; ?></textarea><br><br>
</td></tr>

<tr class="ftr"><td><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"> &nbsp; <input type="reset" value="<?php echo $lang['reset']; ?>" class="button1"></td></tr>
</table>
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=news"><?php echo $lang['all_news']; ?></a></p>
<?php if($admset['wysiwyg']){echo $editor->init_js(array('text', 'menu_text'));} ?>