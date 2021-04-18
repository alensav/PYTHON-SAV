<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}

$menu_title = $lang["menu$menuid"];

$disallow_menu_images = '';
 if(! $menu->is_allowed_menu_images($menuid)){
 $disallow_menu_images = 'display:none;';
 }

echo <<<HTMLDATA
<h3>$menu_title</h3>
<form action="?" method="POST">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="menu">
<input type="hidden" name="menuid" value="$menuid">
<input type="hidden" name="act" value="add">
<input type="hidden" name="additem" value="1">
<table class="settbl" width="100%"><tr class="htr"><td colspan="2">$lang[add_menu_item]</td></tr>
HTMLDATA;

$def_class = $admin_lib->sett_class();
echo <<<HTMLDATA
<tr class="$def_class">
<td>$lang[link_text]</td>
<td><input type="text" name="title" value=""></td>
</tr>
HTMLDATA;


$def_class = $admin_lib->sett_class();
$url_help = custom::contextHelp($lang['url_help']."\nhttp://www.example.com/page.html");
echo <<<HTMLDATA
<tr class="$def_class">
<td>$lang[link_url] $url_help</td>
<td><input type="text" name="url" value=""></td>
</tr>
HTMLDATA;

 if(empty($disallow_menu_images)){
 $def_class = $admin_lib->sett_class();
 }

$link_image1_help = custom::contextHelp($lang['link_image1_help']);
echo <<<HTMLDATA
<tr class="$def_class" style="$disallow_menu_images">
<td>$lang[link_image1]/$sett[design]/$lang[link_image2] $link_image1_help</td>
<td><input type="text" name="img" value=""></td>
</tr>
HTMLDATA;

 if(empty($disallow_menu_images)){
 $def_class = $admin_lib->sett_class();
 }

echo <<<HTMLDATA
<tr class="$def_class" style="$disallow_menu_images">
<td>$lang[image_width]<br>
<td><input type="text" name="img_width" value="" size="10"></td>
</tr>
HTMLDATA;

 if(empty($disallow_menu_images)){
 $def_class = $admin_lib->sett_class();
 }

echo <<<HTMLDATA
<tr class="$def_class" style="$disallow_menu_images">
<td>$lang[image_height]<br>
<td><input type="text" name="img_height" value="" size="10"></td>
</tr>
HTMLDATA;

$def_class = $admin_lib->sett_class();
echo <<<HTMLDATA
<tr class="$def_class">
<td>$lang[sort_index]</td>
<td><input type="text" name="sortid" value="0" size="10"></td>
</tr>
HTMLDATA;

$def_class = $admin_lib->sett_class();
echo <<<HTMLDATA
<tr class="ftr" align="center"><td colspan="2"><br><input type="submit" value="$lang[submit]" class="button1"> <input type="reset" value="$lang[reset]" class="button1"></td></tr>
</table>
HTMLDATA;
?>
