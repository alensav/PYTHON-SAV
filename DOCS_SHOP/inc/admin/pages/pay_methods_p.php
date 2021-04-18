<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/pay_methods');
require_once(INC_DIR."/admin/pay_methods.php");
$pay_methods=new pay_methods;

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $act = isset($_GET['act']) ? $_GET['act'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $act=$_POST['act'];
 }

 switch($act){
 case 'edit':
 include(INC_DIR."/admin/pages/paymethod_form_p.php");
 break;

 case 'add_paymethod':
 include(INC_DIR."/admin/pages/paymethod_form_p.php");
 break;

 default:
  if($act=='del_paymethod'){
  echo $pay_methods->delete_pay_method($_GET['pmid']);
  }

 echo "<h3>$lang[pay_methods]</h3>".$pay_methods->get_pay_methods() . "<br><img src=\"adm/img/st.gif\" class=\"stimg\">&nbsp;<a href=\"?view=settings&settype=pay_methods&act=add_paymethod\">$lang[add_pay_method]</a>";
 }

function pm_modules_select($def_advname){
global $lang, $admin_lib;
$options='';
 if(is_dir(PM_MODULES_DIR)){
 $dirhandle=opendir(PM_MODULES_DIR);
  while(($dirname = readdir($dirhandle)) !== false){
   if($dirname != '.' && $dirname != '..' && $admin_lib->is_valid_pmmod_name($dirname) && is_dir(PM_MODULES_DIR."/$dirname")){
   $pmmod_name = $dirname;
   $pmmod_conf=array();
   $pmmod_conf['pmmod_title'] = $dirname;
    if(is_file(PM_MODULES_DIR."/$dirname/pmmod_conf.php")){
    include(PM_MODULES_DIR."/$dirname/pmmod_conf.php");
    }
   if($dirname==$def_advname){$selected=' selected="selected"';}else{$selected='';}
   $options.="<option value=\"$dirname\"$selected>$pmmod_conf[pmmod_title]</option>";
   }
  }
 closedir($dirhandle);
 }
 if($options){
 return "<select name=\"advname\"><option value=\"\">$lang[not_use]</option>$options</select>";
 }
return '';
}


?>
