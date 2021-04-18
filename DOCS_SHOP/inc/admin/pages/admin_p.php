<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?><!DOCTYPE html><html><head><meta charset="<?php echo $sett['charset']; ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo $lang['adm_title']; ?></title>
<link href="adm/admin2.css" rel="stylesheet" type="text/css">
<link href="ht/custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var lng_do_you_want='<?php echo $lang['do_you_want']; ?>';
</script>
<script type="text/javascript" src="adm/admin.js"></script>
<?php
 if($admset['wysiwyg']){
 require_once(INC_DIR."/editor.php");
 $editor=new editor;
 echo $editor->script_link();
 }
?>
</head><body>
<div class="header">
 <div class="heaBl">
  <div class="hdrLeft"><img src="adm/img/logo.gif" alt=""></div>
  <div class="hdrRight">
   <div class="hrightText"><img src="adm/img/c-shop.gif" alt=""><a href="<?php echo "$sett[relative_url]$sett[index_file]"; ?>" target="_blank" class="comlnk"><?php echo $lang['shop']; ?></a></div>
  </div>
 </div>
</div>

 <div class="wrapper">

     <div class="right">

      <div class="content">
 <noscript><p class="red"><?php echo $lang['js_disabled']; ?></p></noscript>
 <?php include(INC_DIR."/admin/pages/independ_p.php"); ?>
     </div><!--end content-->

    </div><!--end right-->

<div class="lftMenuWrp">

 <div class="leftMenuButton" onclick="showHideBlock('leftMenu');">
  <div></div>
  <div></div>
  <div></div>
 </div><!--end leftMenuButton -->

 <div id="leftMenu">
<ul>
<li><a href="?"><?php echo $lang['main']; ?></a></li>
<li><a href="?view=settings"><?php echo $lang['settings']; ?></a></li>
<li><a href="?view=cts"><?php echo $lang['the_categories']; ?></a></li>
<li><a href="?view=makecat"><?php echo $lang['mk_cat']; ?></a></li>
<li><a href="javascript:additem()"><?php echo $lang['add_product']; ?></a></li>
<li><a href="?view=settings&settype=items_options"><?php echo $lang['products_options']; ?></a></li>
<li><a href="?view=manufacturers"><?php echo $lang['manufacturers']; ?></a></li>
<li><a href="?view=orders"><?php echo $lang['orders']; ?></a></li>
<li><a href="?view=orders_statistics"><?php echo $lang['orders_statistics']; ?></a></li>
<li><a href="?view=users"><?php echo $lang['users']; ?></a></li>
<li><a href="?view=settings&settype=users_groups"><?php echo $lang['users_groups']; ?></a></li>
<li><a href="?view=news"><?php echo $lang['news']; ?></a></li>
<li><a href="?view=content"><?php echo $lang['add_pages']; ?></a></li>
<li><a href="javascript:window.open('?view=editor&act=ed_ins_img&independ=1','','status,scrollbars,resizable,width=680,height=360');void(0);"><?php echo $lang['images_mgr']; ?></a></li>
<li><a href="?view=filemgr"><?php echo $lang['files']; ?></a></li>
<li><a href="?view=tools"><?php echo $lang['tools']; ?></a></li>
<?php if($sett['counter'] && $sett['visitlog']){ ?>
<li><a href="?view=visitlog"><?php echo $lang['visits_log']; ?></a></li>
<?php
 }
 if(file_exists(INC_DIR.'/admin/pages/about_p.php')){
 echo "<li><a href=\"?view=about\">$lang[about_program]</a></li>";
 }
?>
<?php
$modules_arr = $admin_lib->get_modules_arr();
 if(sizeof($modules_arr)){
 echo "<li>$lang[modules]</li>";
  foreach($modules_arr as $num => $def_module){
  echo <<<HTMLDATA
<li><a href="?mod=$def_module[mod_name]">$def_module[mod_title]</a></li>
HTMLDATA;
  }
 }
?>
<li><?php
mt_srand((double) microtime() * 1000000);
$rnd=mt_rand(0,999999).mt_rand(0, 999999);
echo "<a href=\"?view=logout&amp;nc=$rnd\">$lang[logout]</a>";
unset($rnd);
?></li>
</ul>
<?php
 if($sett['counter']){
 $tbl=DB_PREFIX.'counter';
 $res = $db->query("SELECT * FROM $tbl")or die($db->error());
 $row = $db->fetch_array($res);
 echo "<div class=\"sm1\">$lang[visits_total]: $row[allvisits]<br>$lang[total_unique]: $row[allhosts]<br>$lang[visits_today]: $row[todayvisits]<br>$lang[today_unique]: $row[todayhosts]<br></div>";
 }
?>
 </div><!--end leftMenu-->
</div><!--end lftMenuWrp-->

 </div> <!--end wrapper-->

<div class="footer">
 <div class="fooBl">
<?php if(file_exists(SCRIPT_DIR."/admin_copyright.php")){include(SCRIPT_DIR."/admin_copyright.php");} ?>
 </div>
</div>

</body></html>