<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class csv{

private $output_fh = '';

public $fields = array('itemid', 'itemname', 'catid', 'mnf_id', 'sku', 'title', 'price', 'old_price', 'quantity', 'quantity_txt', 'short_descript', 'long_descript', 'small_img', 'big_img', 'add_date', 'upd_date', 'meta_title', 'description', 'keywords', 'metatags', 'special', 'visible');

public $fields_size = 0;


function __construct(){
$this->fields_size = sizeof($this->fields);
}

function export(){
global $admin_lib, $lang, $db, $sett, $admset;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(function_exists('set_time_limit')){
 @set_time_limit(600);
 }

$dirname=SCRIPTCHF_DIR."/adm/dump";
$filename='export_'.date("Y-m-d_H-i-s", time() + $sett['time_diff'] * 3600).'.csv';
$crlf = "\x0D\x0A";

 if(! empty($_POST['gzip_compress'])){
  if(! extension_loaded('zlib')){
  return $lang['not_zlib_loaded'];
  }
 $filename.='.gz';
 $level=9;
 $this->output_fh=@gzopen("$dirname/$filename", "w$level");
 }
 else{
 $this->output_fh=@fopen("$dirname/$filename", "wb");
 }

 if(! $this->output_fh){
 return "<span class=\"red\">$lang[cant_open_file] \"$dirname/$filename\". $lang[check_folder_chmod] 0777 $lang[on_the_folder] \"$dirname\"</span>";
 }


$sel_charset = $_POST['sel_charset'];

 if(empty($sel_charset)){
 $sel_charset = 'utf-8';
 }

 if($sel_charset !== 'utf-8'){
 require_once(INC_DIR."/charset_conv.php");
 }

$admin_lib->save_settings(1, array('csv_export_charset' => $sel_charset), 0);


$delim = '';
$str = '';
 foreach($this->fields as $fname){
  if($sel_charset !== 'utf-8'){
  $ftitle = charset_conv::recode_str($lang["$fname"], 'utf-8', $sel_charset);
  }
  else{
  $ftitle = $lang["$fname"];
  }
 $str .= "$delim\"$ftitle\"";
 $delim = $_POST['delimiter'];
 }
$this->put_to_file($str.$crlf);

 switch($_POST['sort_by']){
 case 'itemid': $orderby='itemid'; break;
 case 'itemname': $orderby='itemname'; break;
 case 'catid': $orderby='catid'; break;
 case 'mnf_id': $orderby='mnf_id'; break;
 case 'sku': $orderby='sku'; break;
 case 'title': $orderby='title'; break;
 case 'price': $orderby='price'; break;
 case 'old_price': $orderby='old_price'; break;
 case 'quantity': $orderby='quantity'; break;
 case 'quantity_txt': $orderby='quantity_txt'; break;
 case 'short_descript': $orderby='short_descript'; break;
 case 'long_descript': $orderby='long_descript'; break;
 case 'small_img': $orderby='small_img'; break;
 case 'big_img': $orderby='big_img'; break;
 case 'add_date': $orderby='add_date'; break;
 case 'upd_date': $orderby='upd_date'; break;
 case 'description': $orderby='description'; break;
 case 'keywords': $orderby='keywords'; break;
 case 'metatags': $orderby='metatags'; break;
 case 'special': $orderby='special'; break;
 case 'visible': $orderby='visible'; break;
 default: $orderby='itemid';
 }

if($_POST['desc']==1){$desc=' DESC';}else{$desc='';}

$tbl_items=DB_PREFIX.'items';

$res=$db->query("SELECT * FROM $tbl_items ORDER BY $orderby$desc") or die($db->error());

 while($row = $db->fetch_assoc($res)){
 $delim = '';
 $str = '';
 
  switch($_POST['price_delimiter']){

  case 'comma':
  $row['price'] = str_replace('.', ',', $row['price']);
  $row['old_price'] = str_replace('.', ',', $row['old_price']);
  break;

  case 'no_fractional_price':
  $row['price'] = round($row['price']);
  $row['old_price'] = round($row['old_price']);
  break;

  }
  
  foreach($this->fields as $fname){
  
   if($sel_charset !== 'utf-8'){
   $row["$fname"] = charset_conv::recode_str($row["$fname"], 'utf-8', $sel_charset);
   }

   if($fname === 'sku' || $fname === 'title'){
   $row["$fname"] = str_replace('&#39;', "'", $row["$fname"]);
   $row["$fname"] = str_replace('&quot;', '"', $row["$fname"]);
   }

   if($fname == 'add_date' || $fname == 'upd_date'){
   $row["$fname"] = date('d.m.Y H:i', $row["$fname"]);
   }

  $str .= $delim . $this->format_export($row["$fname"]);
  $delim = $_POST['delimiter'];
  }
 $this->put_to_file($str.$crlf);
 }

 if(! empty($_POST['gzip_compress'])){
 gzclose($this->output_fh);
 }
 else{
 fclose($this->output_fh);
 }

 if($admset['set_rfiles_chmod']){
  if(is_numeric($admset['rfiles_chmod']) && is_file("$dirname/$filename")){
  @chmod("$dirname/$filename", octdec($admset['rfiles_chmod']));
  }
 }

return "<h3>$lang[export_success]</h3>";
}


function format_export($value){
$value = custom::rn_to_n($value);
$value = str_replace("\n", '\r\n', $value);
$value = str_replace('"', '""', $value);
return '"'.$value.'"';
}


function delete_export_file(){
global $lang, $admin_lib;
if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}
$dirname=SCRIPTCHF_DIR."/adm/dump";
$filename=preg_replace("([^a-z0-9\_\.\-])", '', $_GET['df']);

 if(substr($filename, strlen($filename)-4) !== '.csv' && substr($filename, strlen($filename)-3) !== '.gz'){
 return '';
 }

 if(file_exists("$dirname/$filename") && @unlink("$dirname/$filename")){
 return "<h3>$lang[file_deleted]</h3>";
 }
}


function put_to_file($data){
 if(! empty($_POST['gzip_compress'])){
 gzwrite($this->output_fh, $data);
 }
 else{
 fputs($this->output_fh, $data);
 }
}


function import(){
global $admin_lib, $lang, $db, $custom;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

 if(function_exists('set_time_limit')){
 @set_time_limit(600);
 }

require_once(INC_DIR.'/admin/chpu.php');

$tbl_items=DB_PREFIX.'items';
$tbl_item_categories=DB_PREFIX.'item_categories';

require_once(INC_DIR."/upload.php");
$upload=new upload;

require_once(INC_DIR."/admin/items.php");
$items = new items;

$err_msg = '';

if(! $_POST['delimiter']){$err_msg.="$lang[select_delimiter]<br>";}
if(! $upload->is_upload_file('csv_file')){$err_msg.="$lang[file_not_uploaded]<br>";}
if($err_msg){return "<span class=\"red\">$err_msg</span>";}

$sel_charset = $_POST['sel_charset'];

 if(empty($sel_charset)){
 $sel_charset = 'utf-8';
 }

 if($sel_charset !== 'utf-8'){
 require_once(INC_DIR."/charset_conv.php");
 }

$admin_lib->save_settings(1, array('csv_import_charset' => $sel_charset), 0);

require_once(INC_DIR."/admin/ed_cat.php");
$ed_category=new ed_category;

$date_now = time();

 if(! empty($_POST['del_all_products'])){
 $res = $db->query("SELECT itemid FROM $tbl_items") or die($db->error());
  while($row=$db->fetch_array($res)){
  $items->delete_item($row['itemid']);
  }
 }

$catsid_arr = $this->get_catsid_arr();
$mnfsid_arr = $this->get_mnfsid_arr();

$fh=fopen($_FILES['csv_file']['tmp_name'],"rb");
if(! $fh){return 'File not uploaded!';}
if(filesize($_FILES['csv_file']['tmp_name'])<1){return 'File size is equal the zero!';}

$str = @fgets($fh, 65536);

$line_number = 2;
$update_count = 0;
$insert_count = 0;

 while(! feof($fh)){
 $str = trim(@fgets($fh, 65536));

  if($sel_charset !== 'utf-8'){
  $str = charset_conv::recode_str($str, $sel_charset, 'utf-8');
  }

 $row=array();
 $str_const=$str;
 $line='';
 $field_id=0;

   if($str && ! $this->is_null_all_fields($str, $_POST['delimiter'])){

     while($str !== ''){

     $first_str=$this->first_str_part($str, $_POST['delimiter']);

       if($this->is_even(substr_count($line.$first_str, '"'))){
       $row[$this->fields[$field_id]] = addslashes($this->transform_quotes($line . $first_str));
       $line='';
       $field_id++;
       }
       else{
       $line.=$first_str.$_POST['delimiter'];
       }

     }

    if(! empty($row['add_date']) && ! is_numeric($row['add_date'])){
    $row['add_date'] = @strtotime($row['add_date']);
    }
   $row['add_date'] = intval($row['add_date']);
    if($row['add_date'] < 0){
    $row['add_date'] = 0;
    }

    if(! empty($row['upd_date']) && ! is_numeric($row['upd_date'])){
    $row['upd_date'] = @strtotime($row['upd_date']);
    }
   $row['upd_date'] = intval($row['upd_date']);
    if($row['upd_date'] < 0){
    $row['upd_date'] = 0;
    }

   $check_item_res = $this->check_item($row);
   if($check_item_res != 1){
   if(is_numeric($row['itemid'])){$itemid=$row['itemid'];}else{$itemid='unknown';}
   $ed_category->update_totalitemcount(0);
   return $admin_lib->err_msg("<b>$lang[errors_found_in_file]</b><br>$lang[line_number] $line_number<br>$lang[itemid] $itemid<br><b>$lang[error_descript]</b><br>$check_item_res<br><b>$lang[line_text]</b><br><i>".$custom->replace_tags_and_quotes($str_const)."</i><br><br>$lang[import_aborted] $line_number. $lang[to_correct_errors].");
   }


    if($_POST['update_fields']['catid'] && ! in_array($row['catid'], $catsid_arr)){
    return $admin_lib->err_msg("<b>$lang[errors_found_in_file]</b><br>$lang[line_number] $line_number<br>$lang[itemid] $row[itemid]<br><b>$lang[error_descript]</b><br>$lang[invalid_category] ($row[catid])<br><b>$lang[line_text]</b><br><i>".$custom->replace_tags_and_quotes($str_const)."</i><br><br>$lang[import_aborted] $line_number. $lang[to_correct_errors].");
    }

    if($_POST['update_fields']['mnf_id'] && $row['mnf_id'] != 0 && ! in_array($row['mnf_id'], $mnfsid_arr)){
    return $admin_lib->err_msg("<b>$lang[errors_found_in_file]</b><br>$lang[line_number] $line_number<br>$lang[itemid] $row[itemid]<br><b>$lang[error_descript]</b><br>$lang[invalid_manufacturer] ($row[mnf_id])<br><b>$lang[line_text]</b><br><i>".$custom->replace_tags_and_quotes($str_const)."</i><br><br>$lang[import_aborted] $line_number. $lang[to_correct_errors].");
    }



   $trial_msg = '';
    if(defined('SV_MODE') && SV_MODE == 1){
    global $svc_sadpadm;
     if(($update_count + $insert_count) >= $svc_sadpadm->max_user_products()){
     $trial_msg = $svc_sadpadm->many_products();
     break;
     }
    }
    elseif(TDTC == 1){
     if(($update_count + $insert_count) >= 50){
     $trial_msg = mdmogrn("$lang[130] 50 $lang[143]");
     break;
     }
    }


   $row['itemid'] = intval($row['itemid']);

    if($row['itemid']>0){
    $res = $db->query("SELECT itemid, catid as catid FROM $tbl_items WHERE itemid = $row[itemid]")or die($db->error());
    $old_item = $db->fetch_array($res);

     if($old_item['itemid']){
     $is_exist_item=1;
     }
     else{
     $is_exist_item=0;
     }

    }
    else{
    $is_exist_item=0;
    }

   $row['itemname'] = chpu::autoName($row['itemname'], $row['title'], $row['itemid'], true);
   $row['itemname'] = $db->cutstr($row['itemname'], 255);

   $sort_row=array();
   $sort_row['sortid']=0;
    if($is_exist_item){
    $res = $db->query("SELECT sortid FROM $tbl_item_categories WHERE itemid = $old_item[itemid] AND catid = $old_item[catid]") or die($db->error());
    $sort_row=$db->fetch_array($res);
    $old_item['sortid']=intval($sort_row['sortid']);
    }
   $old_item['sortid']=intval($sort_row['sortid']);

    $row['sku'] = str_replace("'", '&#39;', $row['sku']);
    $row['sku'] = str_replace('"', '&quot;', $row['sku']);
    $row['sku'] = $db->cutstr($row['sku'], 255);
    $row['title'] = str_replace("'", '&#39;', $row['title']);
    $row['title'] = str_replace('"', '&quot;', $row['title']);
    $row['title'] = $db->cutstr($row['title'], 255);
    $row['quantity_txt'] = $db->cutstr($row['quantity_txt'], 255);
    $row['meta_title'] = $db->cutstr($row['meta_title'], 255);
    $row['description'] = $db->cutstr($row['description'], 255);
    $row['keywords'] = $db->cutstr($row['keywords'], 255);

     if(! empty($_POST['autoupdate_upddate'])){
     $row['upd_date'] = $date_now;
     }

    $row['price']=$items->correct_price($row['price']);
    $row['old_price']=$items->correct_price($row['old_price']);

    if($is_exist_item){
    $query = "UPDATE $tbl_items SET itemid=$row[itemid]";
    if($_POST['update_fields']['itemname']){$query .= ", itemname = '$row[itemname]'";}
    if($_POST['update_fields']['catid']){$query .= ", catid = $row[catid]";}
    if($_POST['update_fields']['mnf_id']){$query .= ", mnf_id = $row[mnf_id]";}
    if($_POST['update_fields']['sku']){$query .= ", sku = '$row[sku]'";}
    if($_POST['update_fields']['title']){$query .= ", title = '$row[title]'";}
    if($_POST['update_fields']['price']){$query .= ", price = $row[price]";}
    if($_POST['update_fields']['old_price']){$query .= ", old_price = $row[old_price]";}
    if($_POST['update_fields']['quantity']){$query .= ", quantity = $row[quantity]";}
    if($_POST['update_fields']['quantity_txt']){$query .= ", quantity_txt = '$row[quantity_txt]'";}
    if($_POST['update_fields']['short_descript']){$query .= ", short_descript = '$row[short_descript]'";}
    if($_POST['update_fields']['long_descript']){$query .= ", long_descript = '$row[long_descript]'";}
    if($_POST['update_fields']['small_img']){$query .= ", small_img = '$row[small_img]'";}
    if($_POST['update_fields']['big_img']){$query .= ", big_img = '$row[big_img]'";}
    if($_POST['update_fields']['add_date']){$query .= ", add_date = $row[add_date]";}
    if($_POST['update_fields']['upd_date']){$query .= ", upd_date = $row[upd_date]";}
    if($_POST['update_fields']['meta_title']){$query .= ", meta_title = '$row[meta_title]'";}
    if($_POST['update_fields']['description']){$query .= ", description = '$row[description]'";}
    if($_POST['update_fields']['keywords']){$query .= ", keywords = '$row[keywords]'";}
    if($_POST['update_fields']['metatags']){$query .= ", metatags = '$row[metatags]'";}
    if($_POST['update_fields']['special']){$query .= ", special = '$row[special]'";}
    if($_POST['update_fields']['visible']){$query .= ", visible = $row[visible]";}
    $query .=  " WHERE itemid = $row[itemid]";

    $db->query($query) or die($db->error());


    $update_count++;
    }
    else{
     if($row['itemid'] < 1){
     $row['itemid'] = 'NULL';
     }
    if($_POST['autoset_adddate']){$row['add_date']=$date_now;}
    $db->query("INSERT INTO $tbl_items (itemid, itemname, catid, mnf_id, sku, title, price, old_price, quantity, quantity_txt, short_descript, long_descript, small_img, big_img, add_date, upd_date, meta_title, description, keywords, metatags, special, visible) VALUES($row[itemid], '$row[itemname]', '$row[catid]', '$row[mnf_id]', '$row[sku]', '$row[title]', '$row[price]', '$row[old_price]', '$row[quantity]', '$row[quantity_txt]', '$row[short_descript]', '$row[long_descript]', '$row[small_img]', '$row[big_img]', '$row[add_date]', '$row[upd_date]', '$row[meta_title]', '$row[description]', '$row[keywords]', '$row[metatags]', '$row[special]', '$row[visible]')") or die($db->error());

    $row['itemid'] = $db->insert_id();

    $insert_count++;
    }




   if($_POST['update_fields']['catid'] || ! $is_exist_item){

   $old_item['catid'] = intval($old_item['catid']);
    if($old_item['catid'] && $row['catid'] != $old_item['catid']){
    $db->query("DELETE FROM $tbl_item_categories WHERE itemid = $row[itemid] AND catid = $old_item[catid]") or die($db->error());
    }

   $db->query("DELETE FROM $tbl_item_categories WHERE itemid = $row[itemid] AND catid = $row[catid]") or die($db->error());

   $db->query("INSERT INTO $tbl_item_categories (catid, itemid, sortid) VALUES ($row[catid], $row[itemid], $old_item[sortid])") or die($db->error());
   }





  }

 $line_number++;

 }

$ed_category->update_totalitemcount(0);

return "<h3>$lang[import_success]</h3>$lang[products_added] $insert_count<br>$lang[products_updated] $update_count<br>$trial_msg";
}


function first_str_part(&$str, $delimiter){
$pos=strpos("\x01".$str, $delimiter);
 if($pos){
 $pos--;
 $first_str=substr($str, 0, $pos);
 $str=substr($str, $pos+1);
 }
 else{
 $first_str=$str;
 $str='';
 }
return $first_str;
}



function is_even($number){
$number=substr($number, strlen($number)-1);
 switch($number){
 case 0: return 1;
 case 1: return 0;
 case 2: return 1;
 case 3: return 0;
 case 4: return 1;
 case 5: return 0;
 case 6: return 1;
 case 7: return 0;
 case 8: return 1;
 case 9: return 0;
 }
}


function transform_quotes($str){
$str=str_replace('""', '"', $str);

$strlen=strlen($str);
 if(substr($str, 0, 1)=='"' && substr($str, $strlen-1)=='"'){
 $str=substr($str, 1, $strlen-2);
 }

$str=str_replace('\r\n', "\n", $str);

return $str;
}


function check_item(&$row){
global $lang;
 if(sizeof($row) != $this->fields_size){
  if(sizeof($row) > $this->fields_size){
  $q_fields="$lang[more] $this->fields_size";
  }
  else{
  $q_fields=sizeof($row);
  }
 return "$lang[not_condition_quantity_field].<br>$lang[required_quantity_fields] $this->fields_size.<br>$lang[is_present_fields] $q_fields.";
 }

$row['catid']=str_replace(',', '.', $row['catid']);
if(! is_numeric($row['catid'])){return "$lang[catid] $lang[is_not_numeric]";}

if(! is_numeric($row['mnf_id'])){return "$lang[mnf_id] $lang[is_not_numeric]";}

if(! $row['title']){return "$lang[title]";}

$row['price']=str_replace(',', '.', $row['price']);
if(! is_numeric($row['price'])){return "$lang[price] $lang[is_not_numeric]";}

$row['old_price']=str_replace(',', '.', $row['old_price']);
if(! is_numeric($row['old_price'])){return "$lang[old_price] $lang[is_not_numeric]";}

if(! is_numeric($row['quantity'])){return "$lang[quantity] $lang[is_not_numeric]";}

if(! is_numeric($row['add_date'])){return "$lang[add_date] $lang[is_not_numeric]";}

if(! is_numeric($row['upd_date'])){return "$lang[upd_date] $lang[is_not_numeric]";}

if(! is_numeric($row['visible'])){return "$lang[visible] $lang[is_not_numeric]";}

return 1;
}


function is_null_all_fields($str, $delimiter){
$str=str_replace($delimiter, '', $str);
if($str !== ''){return 0;}
return 1;
}


function get_catsid_arr(){
global $db;
$tbl_categories=DB_PREFIX.'categories';
$catsid_arr = array();
$res = $db->query("SELECT `catid` FROM `$tbl_categories` WHERE `catid` <> 0") or die($db->error());
 while($row = $db->fetch_array($res)){
 array_push($catsid_arr, $row['catid']);
 }
return $catsid_arr;
}


function get_mnfsid_arr(){
global $db;
$tbl_manufacturers=DB_PREFIX.'manufacturers';
$mnfsid_arr = array();
$res = $db->query("SELECT `mnf_id` FROM `$tbl_manufacturers` WHERE `mnf_id` <> 0") or die($db->error());
 while($row = $db->fetch_array($res)){
 array_push($mnfsid_arr, $row['mnf_id']);
 }
return $mnfsid_arr;
}


}
?>