<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class db_extend{


public static function num_fields($res){
return mysqli_num_fields($res);
}


public static function data_seek($res, $offset){
return mysqli_data_seek($res, $offset);
}


public static function multi_delete($tables, $value, &$db = null){
 if($db == null){
 global $db;
 }
$tables = str_replace(' ', '', $tables);
$arr = explode(',', $tables);
$tables = '';
$tables_arr = array();
$fnames_arr = array();
 foreach($arr as $tbl){
 $tmp = explode('.', $tbl);
 $tables .= "`$db->dbname`.`$tmp[0]`, ";
 array_push($tables_arr, $tmp[0]);
 array_push($fnames_arr, $tmp[1]);
 }
$tables = substr($tables, 0, strlen($tables)-2);
$sql = "DELETE FROM $tables USING `$tables_arr[0]`";
$sz = sizeof($tables_arr);
 for($i=1; $i<$sz; $i++){
 $sql .= " LEFT JOIN `$tables_arr[$i]` ON `$tables_arr[$i]`.`$fnames_arr[$i]` = `$tables_arr[0]`.`$fnames_arr[0]`";
 }
$value = $db->secstr($value);
$sql .= " WHERE `$tables_arr[0]`.`$fnames_arr[0]` = '$value'";
return $db->query($sql) or die($db->error());
}


}
?>