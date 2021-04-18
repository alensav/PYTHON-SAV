<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}

 if(! empty($_POST['save'])){
 $err_code = $content_adm->save_page();
 $page_detail = $custom->stripslashes_array($_POST);

  if($_SERVER['REQUEST_METHOD'] == 'GET'){
  $pname = $_GET['pname'];
  }
  elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  $pname = $_POST['pname'];
  }

  if($err_code == 1){
  $act='edit';
  $page_url_address = $admin_lib->site_base_url() . substr(@stdi2("view=content&amp;pname=$page_detail[pname]", "content/$page_detail[pname].html"), 1);
  echo "<p><b>$lang[changes_success]<br>$lang[page_url_address] <a href=\"$page_url_address\" target=\"_blank\">$page_url_address</a></b></p>";
  }
  else{
  echo $admin_lib->err_msg($err_code);
  }
 }

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $pname = isset($_GET['pname']) ? $_GET['pname'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $pname = $_POST['pname'];
 }

 if($act == 'edit'){
 $page_detail = $content_adm->get_page($pname);
 $page_action = "$lang[changing_page] \"<a href=\"" . @stdi2("view=content&amp;pname=$page_detail[pname]", "content/$page_detail[pname].html") . "\" target=\"_blank\">$page_detail[menutitle]</a>\"";
 }
 elseif($act == 'add'){
 $page_action = $lang['adding_page'];
 }

?>
<form name="frm" action="?" method="POST">
<input type="hidden" name="view" value="content">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="old_pname" value="<?php echo isset($page_detail['pname']) ? $page_detail['pname'] : ''; ?>">
<table class="settbl" width="100%">
<tr class="htr"><td colspan="2"><?php echo $page_action; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['page_title']; ?><br>
<input type="text" name="title" value="<?php echo isset($page_detail['title']) ? $page_detail['title'] : ''; ?>" size="72" maxlength="255"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['menu_title']; ?><br>
<input type="text" name="menutitle" value="<?php echo isset($page_detail['menutitle']) ? $page_detail['menutitle'] : ''; ?>" size="72" maxlength="255"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['page_name']; ?><br>
<input type="text" name="pname" value="<?php echo isset($page_detail['pname']) ? $page_detail['pname'] : ''; ?>" size="72" maxlength="128"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['page_text']; ?><br>
<textarea id="text" name="text" rows="22" cols="56"><?php echo isset($page_detail['text']) ? $page_detail['text'] : ''; ?></textarea><div id="auto_br_text"><input type="checkbox" name="auto_br_text"><?php echo $lang['auto_br']; ?></div>
<br>
</td></tr>


<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['sort_index']; ?><br>
<input type="text" name="sortid" value="<?php $page_detail['sortid'] = isset($page_detail['sortid']) ? intval($page_detail['sortid']) : 0; echo $page_detail['sortid']; ?>" size="10"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><br><b><i><?php echo $lang['optional_fields']; ?></i></b></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_description']; ?><br>
<input type="text" name="description" value="<?php echo isset($page_detail['description']) ? $page_detail['description'] : ''; ?>" size="72" maxlength="255"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td>
<?php echo $lang['meta_keywords']; ?><br>
<input type="text" name="keywords" value="<?php echo isset($page_detail['keywords']) ? $page_detail['keywords'] : ''; ?>" size="72" maxlength="255"><br><br>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['meta_tags']; ?><br>
<textarea name="metatags" cols="56" rows="4"><?php echo isset($page_detail['metatags']) ? $page_detail['metatags'] : ''; ?></textarea><br><br></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['banner_code']; ?><br>
<textarea name="special" cols="56" rows="4"><?php echo isset($page_detail['special']) ? $page_detail['special'] : ''; ?></textarea><br>
<input type="checkbox" name="auto_br_special"><?php echo $lang['auto_br']; ?><br><br></td></tr>

<tr class="ftr"><td><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"> &nbsp; <input type="reset" value="<?php echo $lang['reset']; ?>" class="button1"></td></tr>
</table>
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=content"><?php echo $lang['all_pages']; ?></a></p>

<?php if($admset['wysiwyg']){echo $editor->init_js(array('text'));} ?>