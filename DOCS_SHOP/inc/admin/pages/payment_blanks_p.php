<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/payment_blanks');
require_once(INC_DIR."/admin/payment_blanks.php");
$pmblanks=new pmblanks;

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
 $blank_id = isset($_GET['blank_id']) ? intval($_GET['blank_id']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
 $blank_id=intval($_POST['blank_id']);
 }
 else{
 $blank_id=0;
 }

 switch($act){

 case 'payblank_edit':
 echo $pmblanks->payblank_form();
 break;

 case 'payblank_add';
 echo $pmblanks->payblank_form();
 break;

 case 'payblank_preview':
 echo $pmblanks->payblank_preview($blank_id);
 break;
 
 case 'payblank_delete':
 echo $pmblanks->delete_blank($blank_id);
 echo $pmblanks->get_all_blanks();
 break;

 default:
 echo $pmblanks->get_all_blanks();
 }

?>