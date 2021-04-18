<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class menu {

public function get_menu($menuid){
global $db, $admin_lib, $sett, $lang;
$menuid = intval($menuid);
$tbl = DB_PREFIX.'menu';
$res = $db->query("SELECT * FROM $tbl WHERE menuid = $menuid ORDER BY sortid, title") or die($db->error());
$menu_title = $lang["menu$menuid"];
$ret = '';
$disallow_menu_images = '';
 if(! $this->is_allowed_menu_images($menuid)){
 $disallow_menu_images = 'display:none;';
 }
 if($menuid == 2 && $sett['s_mVertAdv'] === 'no'){
 $ret.="<p class=\"warn\">$lang[menu2_disabled]</p>";
 }
$ret .= <<<HTMLDATA
<h3>$menu_title</h3>
<form action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="menu">
<input type="hidden" name="menuid" value="$menuid">
<input type="hidden" name="act" value="save">
<table class="settbl" width="100%"><tr class="htr"><td colspan="2">&nbsp;</td></tr>
HTMLDATA;

 while($row=$db->fetch_array($res)){

 if($row['img_width']){$img_width=" width=\"$row[img_width]\"";}else{$img_width='';}
 if($row['img_height']){$img_height=" height=\"$row[img_height]\"";}else{$img_height='';}

$image = '';
 if($row['img']){
  if(is_file(DESIGN_DIR."/$sett[design]/img/$row[img]")){
  $image = "<a href=\"$sett[relative_url]design/$sett[design]/img/$row[img]\" target=\"_blank\"><img src=\"$sett[relative_url]design/$sett[design]/img/$row[img]\" border=\"0\"$img_width$img_height></a>";
  }
 }

 $def_class = $admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class">
<td>$lang[link_text]</td>
<td><input type="text" name="title[$row[itemid]]" value="$row[title]"></td>
</tr>
HTMLDATA;

 $url_help = custom::contextHelp($lang['url_help']."\nhttp://www.example.com/page.html");
 $def_class = $admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class">
<td>$lang[link_url] $url_help<br>
<td><input type="text" name="url[$row[itemid]]" value="$row[url]"></td>
</tr>
HTMLDATA;

 $link_image1_help = custom::contextHelp($lang['link_image1_help']);

  if(empty($disallow_menu_images)){
  $def_class = $admin_lib->sett_class();
  }

 $ret.=<<<HTMLDATA
<tr class="$def_class" style="$disallow_menu_images">
<td>$lang[link_image1]/$sett[design]/$lang[link_image2] $link_image1_help<br>
<td><input type="text" name="img[$row[itemid]]" value="$row[img]"> $image</td>
</tr>
HTMLDATA;

  if(empty($disallow_menu_images)){
  $def_class = $admin_lib->sett_class();
  }

 $ret.=<<<HTMLDATA
<tr class="$def_class" style="$disallow_menu_images">
<td>$lang[image_width]<br>
<td><input type="text" name="img_width[$row[itemid]]" value="$row[img_width]" size="10"></td>
</tr>
HTMLDATA;

  if(empty($disallow_menu_images)){
  $def_class = $admin_lib->sett_class();
  }

 $ret.=<<<HTMLDATA
<tr class="$def_class" style="$disallow_menu_images">
<td>$lang[image_height]<br>
<td><input type="text" name="img_height[$row[itemid]]" value="$row[img_height]" size="10"></td>
</tr>
HTMLDATA;

 $def_class = $admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class">
<td>$lang[sort_index]<br>
<td><input type="text" name="sortid[$row[itemid]]" value="$row[sortid]" size="10"></td>
</tr>
HTMLDATA;

 $def_class = $admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class">
<td colspan="2"><input type="checkbox" name="delete[$row[itemid]]">$lang[delete_menu_item]</td>
</tr>
HTMLDATA;

 $def_class = $admin_lib->sett_class();
 $ret.=<<<HTMLDATA
<tr class="$def_class"><td colspan="2"><p><br><hr></p></td></tr>
HTMLDATA;


 $begin=1;

 }

$def_class = $admin_lib->sett_class();

 if($menuid == 1){
 $ret.="<tr class=\"$def_class\"><td colspan=\"2\"><br><input type=\"checkbox\" name=\"new_sett[not_show_auth_links]\"";
 if($sett['not_show_auth_links']){$ret.=' checked';}
 $ret.=">$lang[not_show_auth_links]</td></tr>";
 }

$ret.="<tr class=\"ftr\"><td colspan=\"2\"><br><input type=\"submit\" value=\"$lang[submit]\" class=\"button1\"></td></tr></table>";

return $ret;
}


public function save_menu($menuid){
global $db, $admin_lib, $sett, $custom;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$menuid=intval($menuid);
$tbl=DB_PREFIX.'menu';

 if(is_array($_POST['title'])){
  if(sizeof($_POST['title'])){
   foreach($_POST['title'] as $itemid => $value){
   $itemid=intval($itemid);
   $_POST['url']=$admin_lib->replace_amp($_POST['url']);
   $_POST['img_width'][$itemid]=intval($_POST['img_width'][$itemid]);
   $_POST['img_height'][$itemid]=intval($_POST['img_height'][$itemid]);
   $_POST['sortid'][$itemid]=intval($_POST['sortid'][$itemid]);

    if(! empty($_POST["delete"]["$itemid"])){
    $db->query("DELETE FROM `$tbl` WHERE `itemid` = '$itemid'") or die($db->error());
    }
    else{
    $db->query("UPDATE `$tbl` SET `url` = '".$db->secstr($_POST['url'][$itemid])."', `title` = '".$db->secstr($_POST['title'][$itemid])."', `img` = '".$db->secstr($_POST['img'][$itemid])."', `img_width` = '".$_POST['img_width'][$itemid]."', `img_height` = '".$_POST['img_height'][$itemid]."', `sortid` = '".$_POST['sortid'][$itemid]."' WHERE `itemid` = '$itemid'") or die($db->error());
    }

   }
  }
 }


 if($menuid == 1){
  if(! empty($_POST['new_sett']['not_show_auth_links'])){
  $_POST['new_sett']['not_show_auth_links']=1;
  }
  else{
  $_POST['new_sett']['not_show_auth_links']=0;
  }
 $admin_lib->save_settings(2, $_POST['new_sett']);
 $sett=$custom->get_settings(2);
 }


return 1;
}



public function add_menu_item($menuid){
global $db, $admin_lib;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$menuid=intval($menuid);
$tbl=DB_PREFIX.'menu';
$_POST['url']=$admin_lib->replace_amp($_POST['url']);
$_POST['sortid']=intval($_POST['sortid']);
$_POST['img_width']=intval($_POST['img_width']);
$_POST['img_height']=intval($_POST['img_height']);

$res=$db->query("INSERT INTO $tbl (itemid, menuid, url, title, img, img_width, img_height, sortid) VALUES(NULL, $menuid, '$_POST[url]', '$_POST[title]', '$_POST[img]', $_POST[img_width], $_POST[img_height], $_POST[sortid])") or die($db->error());

return '1';
}



public function is_allowed_menu_images($menuid){
global $admin_lib;
$menuid = intval($menuid);
$menu_tpl_file = '';

 switch($menuid){

  case 1:
  $menu_tpl_file = 'horizontal_menu.tpl';
  break;

  case 2:
  $menu_tpl_file = 'vertical_menu.tpl';
  break;

  default:
  return false;

 }

 if($admin_lib->is_design_marker_exists('{item_image}', $menu_tpl_file)){
 return true;
 }
return false;
}



}
?>
