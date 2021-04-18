<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
chdir(dirname(__FILE__));
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if(isset($_GET['pmmod'])){
   $_POST['pmmod'] = $_GET['pmmod'];
   }
   if(isset($_GET['act'])){
   $_POST['act'] = $_GET['act'];
   }
   if(isset($_GET['independ'])){
   $_POST['independ'] = $_GET['independ'];
   }
  }
include('./index.php');
?>