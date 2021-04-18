<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class mainconf{

function get_mainconf(){
global $db;
$tbl=DB_PREFIX.'categories';
$res=$db->query("SELECT description, meta_title, meta_description, keywords, metatags, special FROM $tbl WHERE catid = 0") or die($db->error());
return $db->fetch_array($res);
}


function save_mainconf(){
global $db, $admin_lib, $lang;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(! empty($_POST['auto_br_special'])){
 $_POST['special'] = nl2br($_POST['special'], false);
 }

 if(! empty($_POST['auto_br_description'])){
 $_POST['description'] = nl2br($_POST['description'], false);
 }

$_POST['meta_title']=$db->cutstr($_POST['meta_title'], 255);
$_POST['meta_description']=str_replace('"', '&quot;', trim($_POST['meta_description']));
$_POST['meta_description']=$db->cutstr($_POST['meta_description'], 255);
$_POST['keywords']=str_replace('"', '&quot;', trim($_POST['keywords']));
$_POST['keywords']=$db->cutstr($_POST['keywords'], 255);
$_POST['metatags']=$db->cutstr($_POST['metatags'], 65535, true);
$_POST['description']=$db->cutstr($_POST['description'], 65535, true);
$_POST['special']=$db->cutstr($_POST['special'], 65535, true);

$tbl=DB_PREFIX.'categories';
$res=$db->query("UPDATE $tbl SET description='$_POST[description]', meta_title='$_POST[meta_title]', meta_description='$_POST[meta_description]', keywords='$_POST[keywords]', metatags='$_POST[metatags]', special='$_POST[special]' WHERE catid = 0") or die($db->error());
if($res){return "<h3>$lang[changes_success]</h3>";}else{return "$lang[err_savechanges]<br>";}
}


}
?>
