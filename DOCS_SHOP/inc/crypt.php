<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class crypting{


public function crypt_data($data, $key){
$ret = '';
$qb = 256;
$first_node = array();
$dorfs = array();
$ld = strlen($key);
$ls = strlen($data);
$n=0;
 while($n < $qb){
 $first_node[$n] = ord($key[$n % $ld]);
 $dorfs[$n] = $n;
 $n++;
 }
$n = 0;
$pr = 0;
 while($n < $qb){
 $pr = ($pr + $dorfs[$n] + $first_node[$n]) % $qb;
 $vdt = $dorfs[$n];
 $dorfs[$n] = $dorfs[$pr];
 $dorfs[$pr] = $vdt;
 $n++;
 }
$n = 0;
$pr = 0;
$clinch = 0;
 while($n < $ls){
 $clinch = ($clinch + 1) % $qb;
 $pr = ($pr + $dorfs[$clinch]) % $qb;
 $vdt = $dorfs[$clinch];
 $dorfs[$clinch] = $dorfs[$pr];
 $dorfs[$pr] = $vdt;
 $moncre = $dorfs[(($dorfs[$clinch] + $dorfs[$pr]) % $qb)];
 $ret .= chr(ord($data[$n]) ^ $moncre);
 $n++;
 }
return $ret;
}


}
?>