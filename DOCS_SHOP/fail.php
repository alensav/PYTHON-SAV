<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
chdir(dirname(__FILE__));
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
 $_POST['pmmod'] = 'wm_merchant';
 $_GET['pmmod'] = 'wm_merchant';
 $_POST['act'] = 'fail';
 $_GET['act'] = 'fail';
 include('./index.php');
 }
?>