<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class shop{

public $manufacturers = array();
public $onlycatmnfs = array();
public $categories = array();
public $menus = array();

function get_page_tags($defcatid, $full_catname){
global $db, $page_tags, $sett, $view, $product, $prname, $cat, $fcat, $pg, $custom;

 if(! is_numeric($defcatid) && ! $full_catname){
 return '';
 }

$defcatid=intval($defcatid);



 if($full_catname){
 $cat=$this->catid_from_catname($full_catname);
 }
 else{
 $cat=$defcatid;
 }
$where="`catid` = $cat";
 

$tbl = DB_PREFIX.'categories';
$query = $db->query("SELECT catid, fcatname, title, description, image, meta_title, meta_description, keywords, metatags, special FROM $tbl WHERE $where") or die($db->error());
$row=$db->fetch_array($query);


 if(! $product && ! $prname){
  if($sett['static_urls'] && ! $fcat && $custom->catname_from_fullcatname($row['fcatname']) !== 'cat'.$row['catid']){
   if($defcatid && ! $sett['old_static'] && ! $_GET['sort'] && ! empty($row['fcatname'])){
    if($pg){
    $url=$sett['relative_url'].$custom->statlink($row['fcatname'], "pg$pg.html", '', 'c');
    }
    else{
    $url=$sett['relative_url'].$custom->statlink($row['fcatname'], '', '', 'c');
    }
   header('HTTP/1.1 301 Moved Permanently');
   header("Location: $url");
   exit;
   }
  }
 }

$defcatid=$row['catid'];
$cat=$defcatid;
$chaintitle = $this->get_chain_chapter_title($defcatid,' &#47; ');
$fcat=$row['fcatname'];
$page_tags['page_title'] = $row['title'];
$page_tags['description'] = $row['description'];
$page_tags['image'] = $row['image'];

 if(! $product && ! $prname){

  if($row['meta_description']){
  $page_tags['metatags'] .= "<meta name=\"description\" content=\"$row[meta_description]\">\n";
  }

  if($row['keywords']){
  $page_tags['metatags'] .= "<meta name=\"keywords\" content=\"$row[keywords]\">\n";
  }

 }


$page_tags['metatags'] .= $row['metatags'];
$page_tags['special'] = $row['special'];
$page_tags['chain_title'] = $chaintitle['ch_title'];
$page_tags['inv_chain_title'] = $chaintitle['inv_ch_title'];
$page_tags['chain_title_link'] = $chaintitle['ch_title_link'];

 if($defcatid){
  if($row['meta_title']){
  $page_tags['meta_title'] = $row['meta_title'];
  }
  else{
  $page_tags['meta_title'] = "$page_tags[inv_chain_title] - $sett[pages_title]";
  }
 }
 elseif($view == 'main'){
 $page_tags['meta_title'] = $row['meta_title'];
 }

}


function get_chain_chapter_title($def_cat, $delimiter=' / '){
global $custom, $shop;
$ch_title = '';
$inv_ch_title = '';
$ch_title_link = '';
$slash = '';
$row = array();
$row['parent'] = $def_cat;
 while($row['parent'] != 0){
 $row['catid']=$row['parent'];
 $row['fcat']=$shop->categories["$row[parent]"]['fcat'];
 $row['title']=$shop->categories["$row[parent]"]['title'];
 $row['parent']=$shop->categories["$row[parent]"]['parent'];
  if($row['catid']){
  $ch_title=$row['title'] . $slash . $ch_title;
  $inv_ch_title.=$slash . $row['title'];
   $ch_title_link = '<a href="' . @stdi2("cat=$row[catid]", $custom->statlink($row['fcat'], '', "cat$row[catid]/", 'c')) . "\">$row[title]</a>" . $slash . $ch_title_link;
  $slash=$delimiter;
  }
 }
$ret=array();
$ret['ch_title']=trim($ch_title);
$ret['inv_ch_title']=trim($inv_ch_title);
$ret['ch_title_link']=trim($ch_title_link);
return $ret;
}


function get_currencies($select_all){
global $db, $sett;
$table=DB_PREFIX.'currencies';
$currencies=array();
$query="SELECT * FROM $table";
if(! $select_all){$query.=" WHERE enabled = '1'";}
$res=$db->query("SELECT * FROM $table");
 while($row=$db->fetch_array($res)){
 $currencies["$row[currency_id]"]['currency_id']=$row['currency_id'];
 $currencies["$row[currency_id]"]['brief']=$row['brief'];
 $currencies["$row[currency_id]"]['title']=$row['title'];
 $currencies["$row[currency_id]"]['iso_alpha']=$row['iso_alpha'];
 $currencies["$row[currency_id]"]['iso_numeric']=$row['iso_numeric'];
 $currencies["$row[currency_id]"]['course']=$row['course'];
 $currencies["$row[currency_id]"]['enabled']=$row['enabled'];
 }
 if(! isset($currencies["$sett[def_show_currency]"])){
 $sett['def_show_currency'] = $sett['def_currency'];
 }
return $currencies;
}


function check_cookie(){
global $lang;
$sess_name=session_name();
 if(empty($_COOKIE["$sess_name"])){
 return "$lang[not_cookie]<br>";
 }
 else{
 return '';
 }
}


function format_price($price){
global $sett;
 if(! empty($sett['no_price_fraction'])){
 $fraction = 0;
 }
 else{
 $fraction = 2;
 }
return number_format($price, $fraction, '.', ' ');
}




function get_categories_arr(){
global $db;
$tbl=DB_PREFIX.'categories';
$res = $db->query("SELECT catid, fcatname, parent, title, image, menu_img, main_img, count FROM $tbl WHERE catid <> 0 ORDER BY sortid, title") or die($db->error());
 while($row=$db->fetch_array($res)){
 $this->categories["$row[catid]"]['fcat']=$row['fcatname'];
 $this->categories["$row[catid]"]['parent']=$row['parent'];
 $this->categories["$row[catid]"]['title']=$row['title'];
 $this->categories["$row[catid]"]['count']=$row['count'];
  if($row['image']){
  $this->categories["$row[catid]"]['image']=$row['image'];
  }
  if($row['menu_img']){
  $this->categories["$row[catid]"]['menu_img']=$row['menu_img'];
  }
  if($row['main_img']){
  $this->categories["$row[catid]"]['main_img']=$row['main_img'];
  }
 }
}



function get_menu_categories(){
global $custom, $lang, $sett, $cat, $product;
 if(! $this->showBlock('s_mCat')){
 return '';
 }

$sett['q_mcat'] = intval($sett['q_mcat']);
 if($sett['q_mcat'] < 1){
 return '';
 }

 if($product){
 $opened_cat=$this->get_item_category($product);
 }
 else{
 $opened_cat=$cat;
 }

$parents_arr=array($cat);
$this->get_all_parents($opened_cat, $parents_arr);


$template = new template('menu_categories.tpl');
$template->get_cycle('menu_categories');
$template->get_cycle('subcategories', 'menu_categories');

$q_cat = 0;

 foreach($this->categories as $def_catid => $row){

  if($row['parent'] == 0 && $def_catid != 0){
  $q_cat++;
   if($q_cat > $sett['q_mcat']){
   break;
   }


  $template->assign_cycle('category_url', @stdi2("cat=$def_catid", $custom->statlink($row['fcat'], '', "cat$def_catid/", 'c')), 'menu_categories');

    if($sett['show_quantity']){
    $template->assign_cycle('category_title', $row['title'].'&nbsp;('.$row['count'].')', 'menu_categories');
    }
    else{
    $template->assign_cycle('category_title', $row['title'], 'menu_categories');
    }

   if(! empty($row['menu_img'])){
   $template->assign_cycle('menu_image', "<img src=\"$sett[relative_url]img/small/$row[menu_img]\" alt=\"\">", 'menu_categories');
   }
   else{
   $template->assign_cycle('menu_image', '', 'menu_categories');
   }

  $submenu='';

   if(! empty($sett['show_all_subcategories']) || ($def_catid == $opened_cat || in_array($def_catid, $parents_arr)) ){
   $submenu=$this->get_submenu_categories($def_catid, $opened_cat, $parents_arr, 0, $template);
   
   }

   if(! empty($submenu)){
   $template->condition_cycle('subcategories_exists', 'menu_categories');
   }
   else{
   $template->not_condition_cycle('subcategories_exists', 'menu_categories');
   }

  $template->set_cycle_out($submenu, 'subcategories');
  $template->out_cycle('subcategories');
  $template->next_loop('menu_categories');

  }


 }



$template->out_cycle('menu_categories');
return $template->out_content('menu_categories');
}



function get_submenu_categories($cat_id, $opened_cat, $parents_arr, $level, &$template){
global $sett, $cat, $custom;
$level++;
 if($level > $sett['submenu_level']){
 return '';
 }

$template->get_cycle_virtual('subcategories', 'subcat'.$level);

 foreach($this->categories as $def_catid => $row){

  if($row['parent'] == $cat_id && $def_catid != 0){

  $template->assign_cycle('category_level', $level+1);

  $template->assign_cycle('subcategory_url', @stdi2("cat=$def_catid", $custom->statlink($row['fcat'], '', "cat$def_catid/", 'c')), 'subcat'.$level);

    if($sett['show_quantity']){
    $template->assign_cycle('subcategory_title', $row['title'].'&nbsp;('.$row['count'].')', 'subcat'.$level);
    }
    else{
    $template->assign_cycle('subcategory_title', $row['title'], 'subcat'.$level);
    }

   if(! empty($row['menu_img'])){
   $template->assign_cycle('submenu_image', "<img src=\"$sett[relative_url]img/small/$row[menu_img]\" alt=\"\">", 'subcat'.$level);
   }
   else{
   $template->assign_cycle('submenu_image', '', 'subcat'.$level);
   }

  $submenu='';



   if($def_catid == $opened_cat || in_array($def_catid, $parents_arr)){
   $submenu=$this->get_submenu_categories($def_catid, $opened_cat, $parents_arr, $level, $template);
   }

   if(! empty($submenu)){
   $template->condition_cycle('recursion_exists', 'subcat'.$level);
   }
   else{
   $template->not_condition_cycle('recursion_exists', 'subcat'.$level);
   }

  $template->assign_cycle('recursion_cycle', $submenu, 'subcat'.$level);
  $template->next_loop('subcat'.$level);
  }

 }

return $template->out_cycle_virtual('subcat'.$level);
}



function get_menu_manufacturers(){
global $sett, $prname;
 if(! $this->showBlock('s_mMnf')){
 return '';
 }

$sett['q_mmnf'] = intval($sett['q_mmnf']);
 if($sett['q_mmnf'] < 1){
 return '';
 }

 if(! empty($sett['mnu_onlycatmnf']) && ($_GET['cat'] || ($_GET['fcat'] && ! $prname))){
 $manufacturers=array();
  if(sizeof($this->onlycatmnfs)){
   foreach($this->onlycatmnfs as $mnf_id){
   $manufacturers["$mnf_id"]=$this->manufacturers["$mnf_id"];
   }
  }
 }
 else{
 $manufacturers=$this->manufacturers;
 }

 if(sizeof($manufacturers) < 1){
 return '';
 }

$template = new template('menu_manufacturers.tpl');
$template->assign('manufacturers_url', @stdi2("view=manufacturers", "manufacturers/"));
$template->get_cycle('manufacturers');

$q_mnf = 0;

 foreach($manufacturers as $mnf_id => $mnf_row){
  if($mnf_id){
  $q_mnf++;
   if($q_mnf > $sett['q_mmnf']){
   break;
   }
  $link='<a href="' . @stdi2("view=manufacturers&amp;mnf=$mnf_id", "manufacturers/$mnf_row[mnfname]/") . "\">$mnf_row[title]</a>";
  $template->assign_cycle('page_link', $link, 'manufacturers');
  $template->next_loop();
  }
 }

$template->out_cycle();

return $template->out_content();
}



function get_manufacturers_arr(){
global $db, $sett;
$sett['q_mmnf'] = intval($sett['q_mmnf']);
 if(! isset($sett['s_mMnf'])){
 $sett['s_mMnf'] = '';
 }
 if($sett['q_mmnf'] < 1 || $sett['s_mMnf'] == 'no'){
 return false;
 }
$tbl=DB_PREFIX.'manufacturers';
$res = $db->query("SELECT `mnf_id`, `mnfname`, `title` FROM `$tbl` WHERE `mnf_id` <> 0 ORDER BY `sortid`, `title` LIMIT $sett[q_mmnf]") or die($db->error());
 while($row=$db->fetch_array($res)){
 $this->manufacturers["$row[mnf_id]"]['title']=$row['title'];
 $this->manufacturers["$row[mnf_id]"]['mnfname']=$row['mnfname'];
 }
}


function get_item_category($itemid){
global $db;
$tbl=DB_PREFIX.'items';
$res=$db->query("SELECT catid FROM $tbl WHERE itemid = $itemid") or die($db->error());
$row=$db->fetch_array($res);
return $row['catid'];
}


function get_all_parents($cat, &$parents_arr){
$def_parent=0;
$row=array();
$row['parent']=$cat;

 while($row['parent']> 0){
 $row=$this->categories["$row[parent]"];

  if($row['parent'] > 0){
  array_push($parents_arr, $row['parent']);
  $def_parent=$row['parent'];
  $row['parent']=$this->get_all_parents($row['parent'], $parents_arr);
  }

  if($row['parent'] > 0){
  $def_parent=$row['parent'];
  }

 }

 if($def_parent > 0){
 return $def_parent;
 }
 else{
 return $cat;
 }
}





function show_cart_info(){
global $lang, $db, $sett;
 if(! $sett['on_mcart']){
 return '';
 }

 if($sett['cart_add']){
 return "<script type=\"text/javascript\">var lang=new Array();lang['product_sended']='$lang[product_sended]';</script><script type=\"text/javascript\" src=\"$sett[relative_url]ht/jscart.js?cart_add=" . intval($sett['cart_add']) . '"></script>';
 }

$tbl_items=DB_PREFIX.'items';
$tbl_options_match=DB_PREFIX.'item_options_match';

 if(isset($_SESSION['arwshop_mk']['cart_products']) && count($_SESSION['arwshop_mk']['cart_products'])){
 $template = new template('menu_filled_cart.tpl');
 }
 else{
 $template = new template('menu_empty_cart.tpl');
 return $template->out_content();
 }

$total_cost=0;
$total_products_quantity=0;


  foreach($_SESSION['arwshop_mk']['cart_products'] as $product_id => $var_arr){

  $product_id = intval($product_id);

   foreach($var_arr as $variant => $prod){

   $res = $db->query("SELECT price, quantity FROM $tbl_items WHERE itemid = $product_id") or die($db->error());

   $row = $db->fetch_array($res);
   $prod['quantity'] = intval($prod['quantity']);
   $row['price'] = $this->calc_price($row['price']);




    $options_str = '';

     if(is_array($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"])){

      if(sizeof($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"])){

      $options_id = '';
      $values_id = '';
       foreach($_SESSION['arwshop_mk']["cart_products"]["$product_id"]["$variant"]["options"] as $name => $value){
       $name = intval($name);
       $value = intval($value);
       $options_id .= ", $name";
       $values_id .= ", $value";
       }
      if(substr($options_id, 0, 2) === ', '){$options_id = substr($options_id, 2);}
      if(substr($values_id, 0, 2) === ', '){$values_id = substr($values_id, 2);}

      $res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference FROM $tbl_options_match WHERE $tbl_options_match.itemid = $product_id AND $tbl_options_match.option_id IN ($options_id) AND $tbl_options_match.option_value_id IN ($values_id)")or die($db->error());

       while($row2 = $db->fetch_array($res2)){
       $row['price'] += $this->calc_price($row2['price_difference']);
       }

      }

     }






    if($prod['quantity'] > $row['quantity']){
    $prod['quantity'] = $row['quantity'];
    }

   $cost = pricef($row['price'] * $prod['quantity']);
   $total_cost += $cost;
   $total_products_quantity += $prod['quantity'];

   }

 }


$total_cost=pricef($total_cost);

$template->assign('products_quantity', $total_products_quantity);
$template->assign('total_cost', number_format($total_cost, 2, '.', ''));
$template->assign('currency_brief', $sett['show_curr_brief']);

return $template->out_content();
}



function get_menu($menuid){
global $db, $sett, $lang;
$menuid = intval($menuid);

 switch($menuid){
 case 1:
 $menu_name = 'horizontal';
 break;

 case 2:
 if(! $this->showBlock('s_mVertAdv')){
 return '';
 }
 $menu_name = 'vertical';
 break;

 default: return '';
 }

 if(! sizeof($this->menus)){
 $this->get_menus_arr();
 }

 if(! isset($this->menus[$menuid])){
 return '';
 }

$def_menu = $this->menus[$menuid];

 if(! sizeof($def_menu)){
 return '';
 }

$template = new template($menu_name.'_menu.tpl');
$template->get_cycle($menu_name.'_menu');

 foreach($def_menu as $row){

 if($row['img_width']){$row['img_width']=" width=\"$row[img_width]\"";}else{$row['img_width']='';}
 if($row['img_height']){$row['img_height']=" height=\"$row[img_height]\"";}else{$row['img_height']='';}

 if($row['img']){$img="<img src=\"$sett[relative_url]design/$sett[design]/img/$row[img]\" alt=\"\"$row[img_width]$row[img_height]>";}else{$img='';}

 $template->assign_cycle('item_image', $img);
 $template->assign_cycle('item_url', $row['url']);
 $template->assign_cycle('item_title', $row['title']);
 $template->next_loop();
 }

 if($menuid == 1){
  if(! $sett['not_show_auth_links']){

   if(! empty($_SESSION['arwshop_mk']['user']['userid'])){

   $template->assign('item_image', "<img src=\"$sett[relative_url]design/$sett[design]/img/hm-profile.gif\" alt=\"\">");
   $template->assign_cycle('item_url', "$sett[relative_url]pages.php?view=profile");
   $template->assign_cycle('item_title', $lang['your_profile']);
   $template->next_loop();

   $template->assign_cycle('item_image', "<img src=\"$sett[relative_url]design/$sett[design]/img/hm-logout.gif\" alt=\"\">");
  mt_srand((double) microtime() * 1000000);
   $rnd = mt_rand(0,999999) . mt_rand(0, 999999);
   $template->assign_cycle('item_url', "$sett[relative_url]pages.php?view=logout&amp;nc=$rnd");
   $template->assign_cycle('item_title', $lang['logout']);
   $template->next_loop();

   }

   else{

   $template->assign_cycle('item_image', "<img src=\"$sett[relative_url]design/$sett[design]/img/hm-login.gif\" alt=\"\">");
   $template->assign_cycle('item_url', "$sett[relative_url]pages.php?view=login");
   $template->assign_cycle('item_title', $lang['enter_for_users'] );
   $template->next_loop();

   $template->assign_cycle('item_image', "<img src=\"$sett[relative_url]design/$sett[design]/img/hm-register.gif\" alt=\"\">");
   $template->assign_cycle('item_url', "$sett[relative_url]pages.php?view=register");
   $template->assign_cycle('item_title', $lang['register']);
   $template->next_loop();
   }

  }

 }

$template->out_cycle();

 if($menuid == 1){
 $template->assign('about_url', @stdi2("view=content&amp;pname=about", "content/about.html"));
 $template->assign('contacts_url', @stdi2("view=content&amp;pname=contacts", "content/contacts.html"));
 }

return $template->out_content();
}


function get_menus_arr(){
global $db;
$tbl=DB_PREFIX.'menu';
$res = $db->query("SELECT * FROM `$tbl` ORDER BY `menuid`, `sortid`, `title`") or die($db->error());
 while($row=$db->fetch_array($res)){
  foreach($row as $name => $value){
   if(! is_numeric($name) && $name!=='itemid' && $name!=='menuid'){
   $this->menus["$row[menuid]"]["$row[itemid]"]["$name"] = $value;
   }
  }
 }
 if(! sizeof($this->menus)){
 $this->menus['0']['0']['0'] = 0;
 }
}


function get_new_products(){
global $db, $sett, $custom;

 if(! $this->showBlock('s_mNewProd')){
 return '';
 }

$sett['q_new_products'] = intval($sett['q_new_products']);
 if($sett['q_new_products'] < 1){
 return '';
 }

$tbl=DB_PREFIX.'items';

$res = $db->query("SELECT * FROM $tbl WHERE visible = 1 ORDER BY itemid DESC LIMIT $sett[q_new_products]") or die($db->error());

if($db->num_rows($res)<1){return '';}

$template = new template('menu_new_products.tpl');
$template->get_cycle('new_products');

 while($row=$db->fetch_array($res)){
 $row['fcatname']=$this->categories["$row[catid]"]['fcat'];
 $product_url = @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'));
 $template->assign_cycle('small_img', $row['small_img']);

  if($sett['mnu_smimg_width']){
  $mnu_smimg_width=" width=\"$sett[mnu_smimg_width]\" ";
  }
  else{
  $mnu_smimg_width='';
  }

  if($row['small_img']){
  $row['small_img'] = "<a href=\"$product_url\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" alt=\"$row[title]\" title=\"$row[title]\"$mnu_smimg_width></a>";
  }

 $template->assign_cycle('small_image', $row['small_img']);
 $template->assign_cycle('small_img_width', $mnu_smimg_width);
 $template->assign_cycle('small_img_numeric_width', intval($sett['mnu_smimg_width']));

  if($row['small_img'] && $sett['imgin_newpr']){
  $template->condition_cycle('small_image');
  }
  else{
  $template->not_condition_cycle('small_image');
  }

  if($row['old_price'] > 0){
  $template->condition_cycle('old_price');
  }
  else{
  $template->not_condition_cycle('old_price');
  }

 $template->assign_cycle('product_url', $product_url);
 $template->assign_cycle('product_title', $row['title']);
 $template->assign_cycle('old_price', $this->format_price($this->calc_price($row['old_price'])));
 $template->assign_cycle('product_price', $this->format_price($this->calc_price($row['price'])));
 $template->assign_cycle('currency_brief', $sett['show_curr_brief']);
 $template->next_loop();

 }

$template->out_cycle();
return $template->out_content();
}


function get_menu_news(){
global $lang, $db, $sett, $custom, $view;

 if(! $this->showBlock('s_mNews')){
 return '';
 }

$sett['q_new_news']=intval($sett['q_new_news']);
 if($sett['q_new_news'] < 1){
 return '';
 }

$tbl=DB_PREFIX.'news';

 if($view !== 'main' && ! empty($sett['nmtext_om'])){
 $sel_menu_text = '';
 }
 else{
 $sel_menu_text = ', `menu_text`';
 }

$res=$db->query("SELECT `newsid`, `newsname`, `date`, `title` $sel_menu_text FROM `$tbl` ORDER BY `date` DESC, `newsid` DESC LIMIT $sett[q_new_news]")or die($db->error());

$template = new template('menu_news.tpl');
$template->get_cycle('menu_news');

$template->assign('all_news_url', @stdi2("view=news", "news/"));

 while($row=$db->fetch_array($res)){
 $news_url=@stdi2("view=news&amp;nid=$row[newsid]", "news/$row[newsname].html");
 $template->assign_cycle('news_date', $row['date']);
 $template->assign_cycle('news_url', $news_url);
 $template->assign_cycle('news_title', $row['title']);
 $template->assign_cycle('menu_text', $row['menu_text']);
 $template->next_loop();
 }

$template->out_cycle();

return $template->out_content();;
}


function get_menu_content_pages(){
global $db, $custom, $lang, $sett;

 if(! $this->showBlock('s_mContent')){
 return '';
 }

$sett['max_contentmenuitems'] = intval($sett['max_contentmenuitems']);
 if($sett['max_contentmenuitems'] < 1){
 return '';
 }

$tbl=DB_PREFIX.'content';
$res=$db->query("SELECT pname, menutitle FROM $tbl ORDER BY sortid LIMIT $sett[max_contentmenuitems]");

$template = new template('menu_content.tpl');
$template->get_cycle('content_pages');

 $template->assign('content_url', @stdi2("view=content", "content/"));

 while($row=$db->fetch_array($res)){
 $template->assign_cycle('page_link', '<a href="' . @stdi2("view=content&amp;pname=$row[pname]", "content/$row[pname].html") . "\">$row[menutitle]</a>");
 $template->next_loop();
 }

$template->out_cycle();
return $template->out_content();
}



function rparams($dinamic, $static){
 if(empty($_GET['sort']) && $static != 'show_all'){
 return @stdi2($dinamic, $static);
 }
global $sett;
$sort = $this->get_sort();
$desc = $this->get_desc();
$ret = "$sett[relative_url]sort.php?$dinamic&amp;sort=$sort&amp;desc=$desc";
 if(! empty($_GET['only_mnf'])){
 $ret .= "&amp;only_mnf=$_GET[only_mnf]";
 }
 if($static == 'show_all'){
 $ret .= '&amp;show_all=1';
 }
return $ret;
}


function get_sort(){
global $sett, $lang, $view, $cat;
 if(! $_GET['sort']){
  if($cat && $view !== 'manufacturers'){
  $sort = $sett['sort_products'];
  }
  else{
  $sort = $sett['mnf_sort_products'];
  }
 }
 else{
 $sort = $_GET['sort'];
 }
return $sort;
}


function get_sort_options(){
global $lang, $view, $cat;
$sort = $this->get_sort();

$ret='<option value="id"';
if($sort==='id'){$ret.=' selected';}
$ret.=">$lang[by_date]</option>";

$ret.='<option value="udate"';
if($sort==='udate'){$ret.=' selected';}
$ret.=">$lang[by_udate]</option>";

$ret.='<option value="price"';
if($sort==='price'){$ret.=' selected';}
$ret.=">$lang[by_price]</option>";

$ret.='<option value="title"';
if($sort==='title'){$ret.=' selected';}
$ret.=">$lang[by_title]</option>";

$ret.='<option value="sku"';
if($sort==='sku'){$ret.=' selected';}
$ret.=">$lang[by_sku]</option>";

 if($cat && $view !== 'manufacturers'){
 $ret.='<option value="mnf"';
 if($sort==='mnf'){$ret.=' selected';}
 $ret.=">$lang[by_manufacturer]</option>";
 }
 elseif($view === 'manufacturers'){
 $ret.='<option value="cat"';
 if($sort==='cat'){$ret.=' selected';}
 $ret.=">$lang[by_category]</option>";
 }

return $ret;
}


function get_desc(){
global $sett, $view, $cat;
 if(strpos($_SERVER['REQUEST_URI'], '/sort.php?') === false){
  if($cat && $view != 'manufacturers'){
  $desc = $sett['sortpr_desc'];
  }
  else{
  $desc = $sett['mnf_sortpr_desc'];
  }
 }
 else{
 $desc = $_GET['desc'];
 }
return $desc;
}


function get_desc_options(){
global $lang;
$desc = $this->get_desc();

$ret='<option value="1"';
if($desc==1){$ret.=' selected';}
$ret.=">$lang[inverse_order]</option>";

$ret.='<option value="0"';
if(! $desc){$ret.=' selected';}
$ret.=">$lang[direct_order]</option>";

return $ret;
}



function get_product_options(){
global $db;
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_values=DB_PREFIX.'item_options_values';
$options = array();
$res = $db->query("SELECT $tbl_options.option_id, $tbl_options.option_name, $tbl_options_values.option_value_id, $tbl_options_values.option_value FROM $tbl_options, $tbl_options_values WHERE $tbl_options_values.option_id = $tbl_options.option_id ORDER BY $tbl_options.sortid, $tbl_options.option_name, $tbl_options_values.sortid, $tbl_options_values.option_value")or die($db->error());
 while($row=$db->fetch_array($res)){
 $options["$row[option_id]"]["option_name"] = $row['option_name'];
 $options["$row[option_id]"]["$row[option_value_id]"] = $row['option_value'];
 }
return $options;
}


function get_pr_options_match($items_ids){
global $db;
$tbl_options_match=DB_PREFIX.'item_options_match';

$res = $db->query("SELECT `itemid`, `option_id`, `option_value_id`, `price_difference`, `def` FROM `$tbl_options_match` WHERE `itemid` IN($items_ids)") or die($db->error());

$options_match = array();

 while($row=$db->fetch_array($res)){
 $options_match["$row[itemid]"]["$row[option_id]"]["$row[option_value_id]"]["price_difference"] = $row['price_difference'];
 $options_match["$row[itemid]"]["$row[option_id]"]["$row[option_value_id]"]["def"] = $row['def'];
 }

return $options_match;
}


function get_sel_currencies_options(){
global $db;
$ret = '';
$currency_id = def_show_curr_id();
$tbl = DB_PREFIX.'currencies';
$res=$db->query("SELECT currency_id, brief, title FROM $tbl WHERE enabled = 1") or die($db->error());
 while($row=$db->fetch_array($res)){
 if($row['currency_id']==$currency_id){$selected=' selected="selected"';}else{$selected='';}
 $ret .= "<option value=\"$row[currency_id]\"$selected>$row[title]</option>";
 }
return $ret;
}



function calc_price($price, $currency_id = 0){
global $currencies;

 if($currency_id){
 $currency_id = intval($currency_id);
 }
 else{
 $currency_id = def_show_curr_id();
 }



$new_price = pricef($price / $currencies["$currency_id"]["course"]);
 
 if($price > 0 && $new_price < 0.01){
 $new_price = '0.01';
 }
 elseif($price < 0 && $new_price > -0.01){
 $new_price = '-0.01';
 }

return $new_price;
}



function get_special_offers(){
global $db, $sett, $custom;

 if(! $this->showBlock('s_mSpecOff')){
 return '';
 }

 if($sett['s_mSpecOff'] === 'no'){
 return '';
 }

$tbl_items=DB_PREFIX.'items';
$tbl_item_special=DB_PREFIX.'item_special';

$template = new template('menu_special_offers.tpl');
$template->get_cycle('special_offers');

$res = $db->query("SELECT $tbl_item_special.sp_itemid, $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.old_price, $tbl_items.small_img, $tbl_items.big_img FROM $tbl_item_special, $tbl_items WHERE $tbl_items.itemid = $tbl_item_special.sp_itemid AND $tbl_items.visible = 1 ORDER BY $tbl_item_special.sp_sortid") or die($db->error());

$q_offers = 0;

 while($row=$db->fetch_array($res)){
 $q_offers++;
 $row['fcatname']=$this->categories["$row[catid]"]['fcat'];
 $product_url = @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'));
 $template->assign_cycle('small_img', $row['small_img']);

  if($sett['mnu_smimg_width']){
  $mnu_smimg_width=" width=\"$sett[mnu_smimg_width]\" ";
  }
  else{
  $mnu_smimg_width='';
  }

  if($row['small_img']){
  $row['small_img'] = "<a href=\"$product_url\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" alt=\"$row[title]\" title=\"$row[title]\"$mnu_smimg_width></a>";
  }

 $template->assign_cycle('small_image', $row['small_img']);
 $template->assign_cycle('small_img_width', $mnu_smimg_width);
 $template->assign_cycle('small_img_numeric_width', intval($sett['mnu_smimg_width']));

  if($row['small_img'] && $sett['imgin_special']){
  $template->condition_cycle('small_image');
  }
  else{
  $template->not_condition_cycle('small_image');
  }

  if($row['old_price'] > 0){
  $template->condition_cycle('old_price');
  }
  else{
  $template->not_condition_cycle('old_price');
  }

 $template->assign_cycle('product_url', $product_url);
 $template->assign_cycle('product_title', $row['title']);
 $template->assign_cycle('old_price', $this->format_price($this->calc_price($row['old_price'])));
 $template->assign_cycle('product_price', $this->format_price($this->calc_price($row['price'])));
 $template->assign_cycle('currency_brief', $sett['show_curr_brief']);
 $template->next_loop();

 }

 if($q_offers < 1){
 return '';
 }

$template->out_cycle();
return $template->out_content();
}


function catid_from_catname($catname){
 if(! sizeof($this->categories)){
 return 0;
 }
$catname = mb_strtolower($catname);
$len = strlen($catname)+1;
 foreach($this->categories as $catid => $row){
 $row['fcat'] = mb_strtolower($row['fcat']);
  if($row['fcat'] === $catname || substr($row['fcat'], strlen($row['fcat'])-$len) === '/'.$catname){
  return intval($catid);
  }
 }
 return 0;
}


function list_products($dbres, &$template, $no_pr_lst_type, $limit = 0){
global $db, $sett;
 if(isset($sett["$no_pr_lst_type"]) && ! empty($sett["$no_pr_lst_type"])){
 $no_show_fields = explode(',', $sett["$no_pr_lst_type"]);
 }
 else{
 $no_show_fields = array();
 }

$products = array();
$items_ids = '';
$count = 0;
 while($row=$db->fetch_assoc($dbres)){
 array_push($products, $row);
 $items_ids.=$row['itemid'].',';
 $count++;
  if($limit > 0 && $count == $limit){
  break;
  }
 }
$len = strlen($items_ids);
 if($len > 0){
 $items_ids=substr($items_ids, 0, $len-1);
 }
 if($count > 0){
 $options=$this->get_product_options();
 $all_options_match=$this->get_pr_options_match($items_ids);
  foreach($products as $product){
  $this->pattern_product($product, $options, $all_options_match, $template, $no_show_fields);
  }
 unset($template->cycles['product_options']);
 }
return $count;
}


function pattern_product($row, $options, $all_options_match, &$template, $no_show_fields){
global $sett, $custom, $lang, $db;
 if(! isset($row['fcatname'])){
 $row['fcatname']=$this->categories["$row[catid]"]['fcat'];
 }
$product_url = @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'));

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

$template->assign_cycle('small_img', $row['small_img'], 'products');
$template->assign_cycle('big_img', $row['big_img']);
$template->assign_cycle('small_img_width', $smallimg_width);
$template->assign_cycle('small_img_numeric_width', intval($sett['smallimg_width']));
$template->assign_cycle('big_img_width', $bigimg_width);
$template->assign_cycle('big_img_numeric_width', intval($sett['bigimg_width']));

 if($row['small_img']){
 $row['small_img'] = "<a href=\"$product_url\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" alt=\"$row[title]\" title=\"$row[title]\"$smallimg_width></a>";
 }

 if($row['old_price'] > 0 && ! in_array('nOldPrice', $no_show_fields)){
 $template->condition_cycle('old_price');
 }
 else{
 $template->not_condition_cycle('old_price');
 }

 if( (! in_array('nCartFrm', $no_show_fields) && ($row['quantity'] > 0 || $sett['cart_add_q0']) ) && (empty($sett['nocart_add_price0']) || $row['price'] > 0) ){
 $template->condition_cycle('in_stock');
 }
 else{
 $template->not_condition_cycle('in_stock');
 }

 if($row['small_img'] && ! in_array('nSImg', $no_show_fields)){
 $template->condition_cycle('product_small_image');
 }
 else{
 $template->not_condition_cycle('product_small_image');
 }

 if(! empty($row['mnf_id']) && ! in_array('nMnf', $no_show_fields)){
 $template->condition_cycle('manufacturer');
 }
 else{
 $template->not_condition_cycle('manufacturer');
 }

 if(in_array('nSDescr', $no_show_fields)){
 $row['short_descript']='';
 }
 
$template->assign_cycle('product_url', $product_url);
$template->assign_cycle('product_title', $row['title']);
$template->assign_cycle('product_sku', $row['sku']);
$template->assign_cycle('short_descript', $row['short_descript']);
$template->assign_cycle('old_price', $this->format_price($this->calc_price($row['old_price'])));
$template->assign_cycle('product_price', $this->format_price($this->calc_price($row['price'])));
$template->assign_cycle('product_small_image', $row['small_img']);
$template->assign_cycle('product_id', $row['itemid']);
$template->assign_cycle('currency_brief', $sett['show_curr_brief']);
 if(isset($row['fulltitle'])){
 $template->assign_cycle('category_title', $row['fulltitle']);
 $template->assign_cycle('category_url', @stdi2("cat=$row[catid]", $custom->statlink($row['fcatname'], '', "cat$row[catid]/", 'c')));
 }
 if(isset($row['manufacturer_title'])){
 $template->assign_cycle('manufacturer_title', $row['manufacturer_title']);
 $template->assign_cycle('manufacturer_url', @stdi2("view=manufacturers&amp;mnf=$row[mnf_id]", "manufacturers/$row[mnfname]/"));
 }
  if($row['quantity'] >= 4294967295){
  $row['quantity']=$lang['unlim'];
  }
$template->assign_cycle('product_quantity', $row['quantity']);
$template->assign_cycle('quantity_txt', $row['quantity_txt']);

 if(isset($all_options_match["$row[itemid]"])){
 $this->pattern_product_options($row, $options, $all_options_match["$row[itemid]"], $template);
 }
 else{
 $this->pattern_product_options($row, $options, array(), $template);
 }

$template->between_cycles('products');
$template->next_loop();
}



function pattern_product_options($row, $options, $options_match, &$template){
global $sett;
 if(count($options_match)){
 $template->condition_cycle('product_options');
 }
 else{
 $template->not_condition_cycle('product_options');
 }

 foreach($options as $name => $value){

  if(isset($options_match["$name"]) && is_array($options_match["$name"])){

  $template->assign_cycle('option_name', $options["$name"]["option_name"], 'product_options');
  $template->assign_cycle('option_id', $name, 'product_options');
  $options_out = '';

   foreach($options["$name"] as $name2 => $value2){

    if(isset($options_match["$name"]["$name2"]) && is_array($options_match["$name"]["$name2"])){

     if($options_match["$name"]["$name2"]["def"]){
     $selected = ' selected';
     }
     else{
     $selected = '';
     }

     if($options_match["$name"]["$name2"]["price_difference"] > 0){
     $price_difference = " (+".$this->format_price($this->calc_price($options_match["$name"]["$name2"]["price_difference"]))." $sett[show_curr_brief])";
     }
     elseif($options_match["$name"]["$name2"]["price_difference"] < 0){
     $price_difference = " (".$this->format_price($this->calc_price($options_match["$name"]["$name2"]["price_difference"]))." $sett[show_curr_brief])";
     }
     else{
     $price_difference = '';
     }

    $options_out .= "<option value=\"$name2\"$selected>$value2$price_difference</option>";

    }

   }

  $template->assign_cycle('product_option_values', $options_out, 'product_options');
  $template->next_loop('product_options');

  }

 }

$template->out_cycle('product_options');
}


function showBlock($setname){
global $sett;
 if(isset($sett[$setname]) && $sett[$setname] == 'no'){
 return false;
 }
 elseif(isset($sett[$setname]) && $sett[$setname] == 'noMain' && $this->isMainPage()){
 return false;
 }
 elseif(isset($sett[$setname]) && $sett[$setname] == 'main' && ! $this->isMainPage()){
 return false;
 }
return true;
}


function isMainPage(){
global $view;
 if($view == 'main'){
 return true;
 }
return false;
}


}
?>