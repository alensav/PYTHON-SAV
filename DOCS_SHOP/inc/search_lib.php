<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class search_lib{

function search_items(){
global $db, $sett, $shop, $custom, $lang, $page_tags;
require_once(INC_DIR."/msg.php");
$custom->get_lang('search');
$_GET['srchtext'] = stripslashes($_GET['srchtext']);
$_GET['srchtext'] = preg_replace('/\{[a-zA-Z0-9\-\_]{1,}\}/', '', $_GET['srchtext']);

$page_tags['meta_title'] = "$_GET[srchtext] - $lang[search] :: $sett[pages_title]";

$srchtext = trim(mb_substr($_GET['srchtext'], 0, 255));
$srchtext = preg_replace("([^\x09\x20\!\#\$\%\&\(\)\*\+\,\.\/0-9\:\;\=\?\@A-Z\[\]\^\_a-z\{\}\x7E-\xFF\-])", ' ', $srchtext);
 if(! isset($_GET['fullstr'])){
 $_GET['fullstr'] = '';
 }
$_GET['fullstr'] = preg_replace("([^0-9a-z])", '', $_GET['fullstr']);

$template = new template('search.tpl');

 if(! $srchtext){
 $template->not_condition('search_results');
 $template->assign('search_message', msg::error('', $lang['not_search_value']));
 return $template->out_content();
 }

$pg = 0;
 if(! empty($_GET['pg'])){
 $pg = preg_replace('/\D/', '', $_GET['pg']);
 }
 if(! $pg){
 $pg = 1;
 }

$sett['products_onpage']=intval($sett['products_onpage']);
 if($sett['products_onpage'] < 1){
 $sett['products_onpage'] = 10;
 }

$first_line=$pg * $sett['products_onpage'] - $sett['products_onpage'];
if($first_line < 0 ){return '';}

$q_products_onpage = $sett['products_onpage'] + 1;




$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$tbl_manufacturers=DB_PREFIX.'manufacturers';





	if($sett['search_type']==0 || $sett['search_type']==1){





 if(! $sett['search_type']){
 $boolean_mode=" IN BOOLEAN MODE";
 }

 if($boolean_mode){
 $search_str=str_replace('-', ' ', $srchtext);

 $pos=-1;
  while($pos){
  $pos=strpos($search_str, '  ');
  if($pos){$search_str=str_replace('  ', ' ', $search_str);}
  }

 $search_words=explode(' ', $search_str);
 $search_str='';

  foreach($search_words as $word){
  if(mb_strlen($word) > 2){$search_str .= "$word ";}
  }

 $search_str=rtrim(str_replace(' ', '* ', $search_str));

 }
 else{
 $search_str=$srchtext;
 }




$search_words=explode(' ', $search);

$search_str = $db->secstr($search_str);

$res=$db->query("SELECT `$tbl_items`.`itemid`, `$tbl_items`.`itemname`, `$tbl_items`.`catid`, `$tbl_items`.`mnf_id`, `$tbl_items`.`sku`, `$tbl_items`.`title`, `$tbl_items`.`price`, `$tbl_items`.`old_price`, `$tbl_items`.`quantity`, `$tbl_items`.`short_descript`, `$tbl_items`.`small_img`, `$tbl_items`.`big_img`, `$tbl_categories`.`fcatname`, `$tbl_categories`.`fulltitle`, `$tbl_manufacturers`.`mnfname`, `$tbl_manufacturers`.`title` as `manufacturer_title` FROM `$tbl_items`, `$tbl_categories`, `$tbl_manufacturers` WHERE MATCH(`$tbl_items`.`sku`, `$tbl_items`.`title`, `$tbl_items`.`short_descript`, `$tbl_items`.`long_descript`) AGAINST('$search_str'$boolean_mode) AND `$tbl_items`.`visible` = 1 AND `$tbl_categories`.`catid` = `$tbl_items`.`catid` AND `$tbl_manufacturers`.`mnf_id` = `$tbl_items`.`mnf_id` ORDER BY `$tbl_items`.`quantity` > 0 DESC LIMIT $first_line, $q_products_onpage") or die($db->error());






	}
	elseif($sett['search_type']==2){

 if($_GET['fullstr']){
 $search_words = array($srchtext);
 }
 else{
 $search_words = explode(' ', $srchtext);
 }

$search_query = '';



 foreach($search_words as $word){
  if($word && mb_strlen($word)>1){
  $word = $db->secstr($word);
  $search_query.=" OR `$tbl_items`.`sku` LIKE '%$word%' OR `$tbl_items`.`title` LIKE '%$word%' OR `$tbl_items`.`short_descript` LIKE '%$word%' OR `$tbl_items`.`long_descript` LIKE '%$word%'";
  }
 }


$search_query=substr($search_query, 4);
 if(empty($search_query)){
 return msg::success($_GET['srchtext'], $lang['nothing_finding']);
 }

$res=$db->query("SELECT `$tbl_items`.`itemid`, `$tbl_items`.`itemname`, `$tbl_items`.`catid`, `$tbl_items`.`mnf_id`, `$tbl_items`.`sku`, `$tbl_items`.`title`, `$tbl_items`.`price`, `$tbl_items`.`old_price`, `$tbl_items`.`quantity`, `$tbl_items`.`quantity_txt`, `$tbl_items`.`short_descript`, `$tbl_items`.`small_img`, `$tbl_items`.`big_img`, `$tbl_categories`.`fcatname`, `$tbl_categories`.`fulltitle`, `$tbl_manufacturers`.`mnfname`, `$tbl_manufacturers`.`title` as `manufacturer_title` FROM `$tbl_items`, `$tbl_categories`, `$tbl_manufacturers` WHERE ($search_query) AND `$tbl_items`.`visible` = 1 AND `$tbl_categories`.`catid` = `$tbl_items`.`catid` AND `$tbl_manufacturers`.`mnf_id` = `$tbl_items`.`mnf_id` ORDER BY `$tbl_items`.`quantity` > 0 DESC LIMIT $first_line, $q_products_onpage") or die($db->error());






	}




$num_rows = $db->num_rows($res);

 if($num_rows > 0){
 $template->condition('search_results');
 $template->get_cycle('products');
 $template->get_cycle('product_options', 'products');

  if($sett['smallimg_width']){
  $smallimg_width=" width=\"$sett[smallimg_width]\" ";
  }
  else{
  $smallimg_width='';
  }

  if($sett['bigimg_width']){
  $bigimg_width=" width=\"$sett[bigimg_width]\" ";
  }
  else{
  $bigimg_width='';
  }

 $shop->list_products($res, $template, 'prLstNoSrch', $sett['products_onpage']);

 $template->out_cycle();

 }
 else{
 $template->not_condition('search_results');
 $template->assign('search_message', msg::success($_GET['srchtext'], $lang['nothing_finding']));
 return $template->out_content();
 }


$full_pagebar='';

 $search_text = urlencode($_GET['srchtext']);

 if($pg>1){
 $prevpagenumber=$pg-1;
 $full_pagebar.="<a href=\"search.php?srchtext=$search_text&amp;pg=$prevpagenumber&amp;fullstr=$_GET[fullstr]\" rel=\"prev\" class=\"PglPrev\">$lang[previous]</a>&nbsp; ";
 }

 if($pg > 1 || $num_rows > $sett['products_onpage']){
 $def_pagenumber=1;
  while($def_pagenumber<=$pg){
   if($def_pagenumber!=$pg){
   $full_pagebar.="<a href=\"search.php?srchtext=$search_text&amp;pg=$def_pagenumber&amp;fullstr=$_GET[fullstr]\" class=\"PglA\">$def_pagenumber</a>&nbsp; ";
   }
   else{
   $full_pagebar.="<span class=\"PgOpen\">$def_pagenumber</span>&nbsp; ";
   }
  $def_pagenumber++;
  }

  if($num_rows > $sett['products_onpage']){
  $full_pagebar.="<a href=\"search.php?srchtext=$search_text&amp;pg=$def_pagenumber&amp;fullstr=$_GET[fullstr]\" class=\"PglA\">$def_pagenumber</a>&nbsp; ";
  }

 }


 if($num_rows > $sett['products_onpage']){
 $nextpagenumber=$pg+1;
 $full_pagebar.="<a href=\"search.php?srchtext=$search_text&amp;pg=$nextpagenumber&amp;fullstr=$_GET[fullstr]\" rel=\"next\" class=\"PglNext\">$lang[next]</a>&nbsp; ";
 }

$template->assign('search_message', msg::success('', $lang['search_results']));
$template->assign('pages_links', $full_pagebar);
return $template->out_content();
}


}
?>