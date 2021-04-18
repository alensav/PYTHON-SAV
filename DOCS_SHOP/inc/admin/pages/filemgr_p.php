<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
global $dir, $sort;
$custom->get_lang('admin_lang/filemgr');
require_once(INC_DIR."/admin/filemgr.php");
$filemgr = new filemgr;
require_once(INC_DIR."/upload.php");
 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $dir =  isset($_GET['dir']) ? $_GET['dir'] : '';
 $sort =  isset($_GET['sort']) ? $_GET['sort'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $dir = $_POST['dir'];
 $sort = $_POST['sort'];
 }
 
$dir = preg_replace('([^a-zA-Z0-9\/\~\_\-])', '', $dir);
$dir = preg_replace('(\/\/)', '', $dir);
 if(substr($dir, 0, 1) === '/'){
 $dir = substr($dir, 1);
 }
 if(substr($dir, strlen($dir)-1) === '/'){
 $dir = substr($dir, 0, strlen($dir)-1);
 }

 switch($sort){
 case 'name': $sort = 'name'; break;
 case 'mtime': $sort = 'mtime'; break;
 case 'type': $sort = 'type'; break;
 case 'size': $sort = 'size'; break;
 default: $sort = 'name';
 }
 
$dirname = $dir;
 if(! $dirname || ! is_dir(SCRIPTCHF_DIR."/$filemgr->pubfiles_dname/$dir")){
 $dir='';
 $dirname=$filemgr->pubfiles_dname;
 }
 
echo $filemgr->show_files($dirname);

?>