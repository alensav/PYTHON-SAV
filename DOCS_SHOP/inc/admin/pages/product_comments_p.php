<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
require_once(INC_DIR."/admin/product_comments_adm.php");
$prcomm_adm=new prcomm_adm;

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
 $pcsub = $_GET['pcsub'];
 $comid = isset($_GET['comid']) ? intval($_GET['comid']) : 0;
 $pg = isset($_GET['pg']) ? intval($_GET['pg']) : 0;
 }
 elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
 $pcsub = $_POST['pcsub'];
 $comid = isset($_POST['comid']) ? intval($_POST['comid']) : 0;
 }

 switch($pcsub){

 case 'list':
 echo $prcomm_adm->get_comments($_GET['itemid']);
 break;
 
 case 'reply':
 echo $prcomm_adm->comment_form($comid, 'reply');
 break;
 
 case 'edit':
 echo $prcomm_adm->comment_form($comid, 'edit');
 break;
 
 case 'new':
 echo $prcomm_adm->new_comments();
 break;
 
 case 'delete':
 echo $prcomm_adm->delete_comment($comid);
 break;
 
 default:
 echo 'Invalid parameters';
 }


?>