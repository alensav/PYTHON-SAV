<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class add_fields{

public $order_email_fields = '';


public function get_fields($use_in, $template, $tpl_file, $tpl_text, $pmid){
global $db, $custom, $lang;
$custom->get_lang('add_fields');
$pmid=intval($pmid);

 if($tpl_file){
 $template = new template($tpl_file);
 }
 elseif($tpl_text){
 $template = new template();
 $template->set_content($tpl_text);
 }

$template->get_cycle('additional_fields');

 if(! isset($_POST['add_fields'])){
 $_POST['add_fields'] = array();
 }

$_POST['add_fields'] = $custom->replace_tags_and_quotes_array($custom->trim_array($custom->stripslashes_array($_POST['add_fields'])));

  if($use_in=='order'){
  $last_order_values = $this->lastOrderAddFieldsValues();
  }
  else{
  $last_order_values = array();
  }

$tbl_add_fields=DB_PREFIX.'add_fields';
$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';

$sql_use_in="use_in_$use_in";

$res = $db->query("SELECT * FROM `$tbl_add_fields` WHERE `$sql_use_in` = 1 AND `enabled` = 1 ORDER BY `sortid`, `title`") or die($db->error());

$def_class='ttr';

 while($row = $db->fetch_array($res)){
 
  if($use_in=='order'){
  $paymethods_arr=$this->paymethods_arr_from_str($row['pay_methods']);
   if(sizeof($paymethods_arr)>0 && ! in_array($pmid, $paymethods_arr)){
   continue;
   }
  }

 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}

 if($row['required']){$row['required']="<span class=\"red\">*</span>";}else{$row['required']='';}

 if($row['add_attributes']){$row['add_attributes'] = ' ' . $row['add_attributes'];}

  if($row['type']==1){
  $field = "<input type=\"text\" name=\"add_fields[$row[field_id]]\" ";
  if($row['width']){$field .= " size=\"$row[width]\"";}
   if(! isset($_POST['add_fields']["$row[field_id]"]) || ! $_POST['add_fields']["$row[field_id]"]){
    if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
    $_POST['add_fields']["$row[field_id]"] = $last_order_values["$row[field_name]"];
    }
    else{
    $_POST['add_fields']["$row[field_id]"] = $row['def_value'];
    }
   }
  $field .= " value=\"".$_POST['add_fields']["$row[field_id]"]."\" placeholder=\"$row[placeholder]\"$row[add_attributes]>";
  }
  elseif($row['type']==2){
  $field = "<textarea name=\"add_fields[$row[field_id]]\" ";
  if($row['width']){$field .= " cols=\"$row[width]\"";}
  if($row['height']){$field .= " rows=\"$row[height]\"";}
   if(! isset($_POST['add_fields']["$row[field_id]"]) || ! $_POST['add_fields']["$row[field_id]"]){
    if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
    $_POST['add_fields']["$row[field_id]"] = $last_order_values["$row[field_name]"];
    }
    else{
    $_POST['add_fields']["$row[field_id]"] = $row['def_value'];
    }
   }
  $field .= " placeholder=\"$row[placeholder]\"$row[add_attributes]>".$_POST['add_fields']["$row[field_id]"]."</textarea>";
  }
  elseif($row['type']==3){
  $field = "<input type=\"checkbox\" name=\"add_fields[$row[field_id]]\" ";
   if(! empty($_POST["add_fields"]["$row[field_id]"])){
   $checked = ' checked="checked"';
   }
   elseif(! isset($_POST["addFldCheckboxes"]["$row[field_id]"])){
    if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"]) && $last_order_values["$row[field_name]"] === $lang['yes']){
    $checked = ' checked="checked"';
    }
    elseif($row['def_value']){
    $checked = ' checked="checked"';
    }
    else{
    $checked = '';
    }
   }
   else{
   $checked = '';
   }
  $field .= "$checked$row[add_attributes]>$row[title]";
  $row['title'] = '';
  $field .= "<input type=\"hidden\" name=\"addFldCheckboxes[$row[field_id]]\" value=\"1\">";
  }
  elseif($row['type']==4){
  $field_variants = $this->get_field_variants($row['field_id']);
   if(sizeof($field_variants)){
    $field='';
    foreach($field_variants as $field_arr){
    $checked = '';
    $field .= "<div class=\"addFieldsVD\"><input type=\"radio\" name=\"add_fields[$row[field_id]]\" ";
     if(isset($_POST["add_fields"]["$row[field_id]"])){
      if($_POST["add_fields"]["$row[field_id]"] === $field_arr['value']){
      $checked = ' checked="checked"';
      }
     }
     elseif(! isset($_POST["add_fields"]["$row[field_id]"]) || ! $_POST["add_fields"]["$row[field_id]"]){

      if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
       if($last_order_values["$row[field_name]"] === $field_arr['value']){
       $checked = ' checked="checked"';
       }
      }
      elseif($field_arr['def']){
      $checked = ' checked="checked"';
      }

     }

    $field .= "value=\"$field_arr[value]\"$checked$row[add_attributes]>$field_arr[value]</div>";
    }
   }
  }
  elseif($row['type']==5){
  $field_variants = $this->get_field_variants($row['field_id']);
  $field = "<select name=\"add_fields[$row[field_id]]\"$row[add_attributes]>";
   if(sizeof($field_variants)){
    foreach($field_variants as $field_arr){
    $selected = '';
     if(isset($_POST["add_fields"]["$row[field_id]"])){
      if($_POST["add_fields"]["$row[field_id]"] === $field_arr['value']){
      $selected = ' selected="selected"';
      }
     }
     else{
      if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
       if($last_order_values["$row[field_name]"] === $field_arr['value']){
       $selected = ' selected="selected"';
       }
      }
      elseif($field_arr['def']){
      $selected = ' selected="selected"';
      }
     }

    $field .= "<option value=\"$field_arr[value]\"$selected>$field_arr[value]</option>";
    }
   }
  $field .= '</select>';
  }
  elseif($row['type']==6){
  $field_variants = $this->get_field_variants($row['field_id']);
  $field = "<select name=\"add_fields[$row[field_id]][]\" multiple=\"multiple\"$row[add_attributes]>";
   if(sizeof($field_variants)){

   $last_values = isset($last_order_values["$row[field_name]"]) ? explode(';', $last_order_values["$row[field_name]"]) : array();

    if(count($last_values)){
     foreach($last_values as $i => $last_value){
     $last_values[$i] = trim($last_values[$i]);
      if(! $last_values[$i]){
      unset($last_values[$i]);
      }
     }
    }

    foreach($field_variants as $field_arr){
    $selected = '';
     if(isset($_POST["add_fields"]["$row[field_id]"]) && is_array($_POST["add_fields"]["$row[field_id]"])){
      if(in_array($field_arr['value'], $_POST["add_fields"]["$row[field_id]"])){
      $selected = ' selected="selected"';
      }

     }
     elseif($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
      if(in_array($field_arr['value'], $last_values)){
      $selected = ' selected="selected"';
      }
     }
     elseif((! isset($_POST["add_fields"]["$row[field_id]"]) || ! is_array($_POST["add_fields"]["$row[field_id]"])) && $field_arr['def']){
     $selected = ' selected="selected"';
     }
    $field .= "<option value=\"$field_arr[value]\"$selected>$field_arr[value]</option>";
    }

   }
  $field .= '</select>';
  }
  elseif($row['type']==7){
  $field = "<input type=\"password\" name=\"add_fields[$row[field_id]]\" ";
  if($row['width']){$field .= " size=\"$row[width]\"";}
   if(empty($_POST['add_fields']["$row[field_id]"])){
    if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
    $_POST['add_fields']["$row[field_id]"] = $last_order_values["$row[field_name]"];
    }
    else{
    $_POST['add_fields']["$row[field_id]"] = $row['def_value'];
    }
   }
  $field .= ' value="'.$_POST['add_fields']["$row[field_id]"]."\" placeholder=\"$row[placeholder]\"$row[add_attributes]>";
  }
  elseif($row['type']==8){
  $field = "<input type=\"hidden\" name=\"add_fields[$row[field_id]]\" ";
  if($row['width']){$field .= " size=\"$row[width]\"";}
   if(empty($_POST['add_fields']["$row[field_id]"])){
    if($row['def_from_last_order'] && isset($last_order_values["$row[field_name]"])){
    $_POST['add_fields']["$row[field_id]"] = $last_order_values["$row[field_name]"];
    }
    else{
    $_POST['add_fields']["$row[field_id]"] = $row['def_value'];
    }
   }
  $field .= ' value="'.$_POST['add_fields']["$row[field_id]"]."\"$row[add_attributes]>";
  }
  else{
  $field='';
  }
  


 $template->assign_cycle('def_class', $def_class);
 $template->assign_cycle('required', $row['required']);
  if($row['type']==8){
  $template->assign_cycle('field_description', '');
  }
  else{
  $contexthelp = '';
   if($row['contexthelp']){
   $contexthelp = ' ' . custom::contextHelp($row['contexthelp']);
   }
  $template->assign_cycle('field_description', $row['title'] . $contexthelp);
  }
 $template->assign_cycle('field', $field);
 $template->next_loop();

 }

$template->out_cycle();

 if($tpl_file || $tpl_text){
 return $template->out_content();
 }
 else{
 return $template;
 }

}


public function get_field_variants($field_id){
global $db;
$field_id=intval($field_id);
$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';
$res = $db->query("SELECT * FROM $tbl_add_fields_variants WHERE field_id = $field_id ORDER BY sortid, value") or die($db->error());
$field_variants = array();
 while($row=$db->fetch_array($res)){
 array_push($field_variants, $row);
 }
return $field_variants;
}



public function check_fields($use_in, $where_save='', $orderid=0, $pmid=0){
global $db, $lang, $custom;
$custom->get_lang('add_fields');
$orderid = intval($orderid);

$use_in="use_in_$use_in";

 if($where_save === 'session'){
 $fileds_arr = $_POST['add_fields'];
 unset($_SESSION['arwshop_mk']['add_fields']);
 }
 elseif($where_save === 'db'){
 $fileds_arr = $_SESSION['arwshop_mk']['add_fields'];
 unset($_SESSION['arwshop_mk']['add_fields']);
 }
 else{
 $fileds_arr = $_POST['add_fields'];
 }

 if(! is_array($fileds_arr)){
 $fileds_arr = array();
 }

$fileds_arr = $custom->replace_tags_and_quotes_array($custom->trim_array($custom->stripslashes_array($fileds_arr)));

$tbl_add_fields=DB_PREFIX.'add_fields';
$tbl_add_fields_variants=DB_PREFIX.'add_fields_variants';
$tbl_orders_add_fields_values=DB_PREFIX.'orders_add_fields_values';

$res = $db->query("SELECT * FROM $tbl_add_fields WHERE $use_in = 1 AND enabled = 1 ORDER BY sortid, title") or die($db->error());

$err = '';



 while($row=$db->fetch_array($res)){
 $size = isset($fileds_arr["$row[field_id]"]) ? $this->value_size($fileds_arr["$row[field_id]"]) : 0;

  if($row['required']){
   if($pmid && $row['pay_methods']){
   $paymethods_arr=$this->paymethods_arr_from_str($row['pay_methods']);
    if(in_array($pmid, $paymethods_arr)){
     if(! $size){
     $err .= "$lang[empty_field] &quot;$row[title]&quot;<br />";
     }
    }
   }
   else{
    if(! $size){
    $err .= "$lang[empty_field] &quot;$row[title]&quot;<br />";
    }
   }
  }




  if($size){

   if(is_array($fileds_arr["$row[field_id]"])){
   $values = implode('; ', $fileds_arr["$row[field_id]"]);
   }
   else{
   $values = $fileds_arr["$row[field_id]"];
   }

   if($row['type']==3){
    if($values){
    $values = $lang['yes'];
    }
   }

   $values = $db->cutstr($values, 65535, true);

   if(! $err){
    if($where_save === 'session'){
    $_SESSION['arwshop_mk']["add_fields"]["$row[field_id]"] = $fileds_arr["$row[field_id]"];
    }
    elseif($where_save === 'db' && $orderid){
    $values=$db->secstr($values);
    $db->query("INSERT INTO $tbl_orders_add_fields_values (oafvid, orderid, field_name, field_title, field_values) VALUES(NULL, $orderid, '$row[field_name]', '$row[title]', '$values')") or die($db->error());
    $this->order_email_fields .= "$row[title]: $values\n";
    }
    elseif($where_save === 'feedback'){
    $this->order_email_fields .= "$row[title]: $values\n";
    }
   }

  }


 }


if($err){return $err;}
return '';
}



public function value_size($value){
 if(is_array($value)){
 return sizeof($value);
 }
 else{
 return mb_strlen($value);
 }
}


public function save_fields_in_session($pmid){
return $this->check_fields('order', 'session', 0, $pmid);
}


public function save_fields_in_db($orderid, $pmid){
return $this->check_fields('order', 'db', $orderid, $pmid);
}


public function paymethods_arr_from_str($pm_str){
$test_arr=explode(',', $pm_str);
$paymethods_arr=array();
 if(sizeof($test_arr)){
  foreach($test_arr as $pmid){
   if(is_numeric($pmid)){
   array_push($paymethods_arr, $pmid);
   }
  }
 }
return $paymethods_arr;
}


private function lastOrderAddFieldsValues(){
global $db;

$ret = array();
$userid = isset($_SESSION['arwshop_mk']['user']['userid']) ? intval($_SESSION['arwshop_mk']['user']['userid']) : 0;

 if(! $userid){
 return $ret;
 }

$tbl = DB_PREFIX.'orders';
$res = $db->query("SELECT MAX(`orderid`) FROM `$tbl` WHERE `userid` = '$userid'") or die($db->error());
$orderid = $db->result($res);

 if(! $orderid){
 return $ret;
 }

$tbl = DB_PREFIX.'orders_add_fields_values';
$res = $db->query("SELECT `field_name`, `field_values` FROM `$tbl` WHERE `orderid` = '$orderid' AND `field_name` <> ''") or die($db->error());
 while($row = $db->fetch_assoc($res)){
 $ret["$row[field_name]"] = $row['field_values'];
 }

return $ret;
}


}
?>