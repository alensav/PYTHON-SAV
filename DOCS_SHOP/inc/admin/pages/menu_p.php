<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/menu');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $menuid=intval($_GET['menuid']);
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $menuid=intval($_POST['menuid']);
 }

 if($act != 'add' || ! empty($_POST['additem'])){
?>
<br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=menu&act=add&menuid=<?php echo $menuid; ?>"><?php echo $lang['add_menu_item']; ?></a>
<?php
 }
require_once(INC_DIR."/admin/menu.php");
$menu=new menu;

 switch($act){
 case 'save':
 $err_code=$menu->save_menu($menuid);
 if($err_code==1){echo "<h3>$lang[changes_success]</h3>";}else{echo $err_code;}
 break;

 case 'add':
  if(empty($_POST['additem'])){
  include(INC_DIR.'/admin/pages/add_menu_item_p.php');
  }
  else{
  $err_code=$menu->add_menu_item($menuid);
  if($err_code == '1'){echo "<h3>$lang[changes_success]</h3>";}else{echo $err_code;}
  }
 break;

 }

 if($act != 'add' || ! empty($_POST['additem'])){
 echo '<br>'.$menu->get_menu($menuid);
?>
<br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=menu&act=add&menuid=<?php echo $menuid; ?>"><?php echo $lang['add_menu_item']; ?></a>
<?php }else{ ?>
<br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=menu&menuid=<?php echo $menuid; ?>"><?php echo $lang["menu$menuid"]; ?></a>
<?php } ?>