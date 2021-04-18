<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
$disallow_filemgr_expansions = array('.htaccess', '.config', '.php', '.php2', '.php3', '.php4', '.php5', '.php6', '.php7', '.php8', '.php9', '.inc', '.phtml', '.phps', '.fcgi', '.cgi', '.pl', '.shtml', '.asp', '.aspx', '.tpl');

 foreach($disallow_filemgr_expansions as $name => $value){
 $disallow_filemgr_expansions[$name] = strtolower($value);
 }

?>