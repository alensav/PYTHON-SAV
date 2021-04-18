<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
global $lang;
$custom->get_lang('detail');

echo get_product_detail($product);

function get_product_detail($itemid){
global $db, $sett, $page_tags, $lang, $shop, $prname, $fcat, $cat;
$itemid=intval($itemid);
$tbl_items=DB_PREFIX.'items';
$tbl_options_match=DB_PREFIX.'item_options_match';
$tbl_gallery=DB_PREFIX.'gallery';
$tbl_manufacturers=DB_PREFIX.'manufacturers';
$tbl_categories=DB_PREFIX.'categories';

 if(! $prname){
  if($sett['static_urls']){
   if(! $sett['old_static'] && ! $_POST['add_product_comment']){
   $res = $db->query("SELECT $tbl_items.itemname, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.itemid = $itemid AND $tbl_categories.catid = $tbl_items.catid") or die($db->error());
   $row=$db->fetch_array($res);
    if($row['itemname'] && $row['fcatname'] && $row['itemname'] !== 'product'.$itemid){
    global $pg;
     if($_GET['sub']==='product_comments' && $pg){
     $url="$sett[relative_url]product_comments/$row[itemname]/pg$pg.html";
     }
     else{
     global $custom;
     $url=$sett['relative_url'].$custom->statlink($row['fcatname'], "$row[itemname].html", '', 'p');
     }
    header('HTTP/1.1 301 Moved Permanently');
    header("Location: $url");
    exit;
    }
   }
  }
 }

 if(! empty($sett['on_pcomm'])){
 global $pcomset;
 require_once(INC_DIR."/product_comments.php");
 $prcomm = new prcomm;
  if(! empty($_POST['add_product_comment']) || ! empty($_GET['add_product_comment'])){
  return $prcomm->add_comment($itemid);
  }
  elseif( (isset($_GET['sub']) && $_GET['sub'] == 'product_comments') && $_GET['pg'] && ! $pcomset['productonpg']){
  $comments_arr = $prcomm->get_comments($itemid, $prname, array());
  return $comments_arr['content'];
  }
 }

 if($prname){
 $where1="`$tbl_items`.`itemname` = '".$db->secstr($prname)."'";
  if($fcat){
  $catid=$shop->catid_from_catname($fcat);
  $where1.=" AND `$tbl_items`.`catid` = $catid";
  }
 $from1='';
 }
 else{
 $where1="`$tbl_items`.`itemid` = $itemid ";
 $from1='';
 }
$options = $shop->get_product_options();


$res = $db->query("SELECT $tbl_items.*, $tbl_manufacturers.mnfname, $tbl_manufacturers.title AS manufacturer_title FROM $tbl_items, $from1 $tbl_manufacturers WHERE $where1 AND $tbl_manufacturers.mnf_id = $tbl_items.mnf_id") or die($db->error());

$row = $db->fetch_array($res);
$itemid=intval($row['itemid']);
$prname=$row['itemname'];
$catid=$row['catid'];
$cat=$row['catid'];
$product_title = $row['title'];

 if(! $row['visible']){
 return header404();
 }


 if($row['meta_title']){
 $page_tags['meta_title'] = $row['meta_title'];
 }
 elseif($sett['item_title_cat']){
  if(! $page_tags['meta_title']){
  $shop->get_page_tags($row['catid'], '');
  $page_tags['meta_title'] = "$row[title] - $page_tags[meta_title]";
  }
  else{
  $page_tags['meta_title'] = "$row[title] - $page_tags[inv_chain_title]";
  }
 }
 else{
 $page_tags['meta_title'] = $row['title'];
 }


$chaintitle=$shop->get_chain_chapter_title($row['catid'], ' &#47; ');
$page_tags['page_title']=$row['title'];

 if($row['description']){
 $page_tags['metatags'].="<meta name=\"description\" content=\"$row[description]\">\n";
 }

 if($row['keywords']){
 $page_tags['metatags'].="<meta name=\"keywords\" content=\"$row[keywords]\">\n";
 }

$page_tags['metatags'].=$row['metatags'];
$page_tags['special']=$row['special'];
$page_tags['chain_title']=$chaintitle['ch_title'];
$page_tags['inv_chain_title']=$chaintitle['inv_ch_title'];
$page_tags['chain_title_link']=$chaintitle['ch_title_link'];

$template = new template('product_detail.tpl');




$template->get_cycle('product_options');


 $res2 = $db->query("SELECT $tbl_options_match.option_id, $tbl_options_match.option_value_id, $tbl_options_match.price_difference, $tbl_options_match.def FROM $tbl_options_match WHERE $tbl_options_match.itemid = $itemid")or die($db->error());

 $options_match = array();

  while($row2=$db->fetch_array($res2)){
  $options_match["$row2[option_id]"]["$row2[option_value_id]"]["price_difference"] = $row2['price_difference'];
  $options_match["$row2[option_id]"]["$row2[option_value_id]"]["def"] = $row2['def'];
  }


   if(count($options_match)){
   $template->condition('product_options');
   }
   else{
   $template->not_condition('product_options');
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
       $price_difference = " (+".$shop->format_price($shop->calc_price($options_match["$name"]["$name2"]["price_difference"]))." $sett[show_curr_brief])";
       }
       elseif($options_match["$name"]["$name2"]["price_difference"] < 0){
       $price_difference = " (".$shop->format_price($shop->calc_price($options_match["$name"]["$name2"]["price_difference"]))." $sett[show_curr_brief])";
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





 if($row['sku']){
 $template->condition('sku');
 }
 else{
 $template->not_condition('sku');
 }

 if($row['old_price'] > 0){
 $template->condition('old_price');
 }
 else{
 $template->not_condition('old_price');
 }


 if($sett['smallimg_width']){
 $smallimg_width=" width=\"$sett[smallimg_width]\" ";
 }
 else{
 $smallimg_width='';
 }

 if($sett['bigimg_width']){
 $bigimg_width = " width=\"$sett[bigimg_width]\"";
 }
 else{
 $bigimg_width = '';
 }

$image = '';

 if($row['big_img']){
  if($sett['pd_big_img'] || ! $row['small_img']){
  $image="<a href=\"$sett[relative_url]img/big/$row[big_img]\"><img src=\"$sett[relative_url]img/big/$row[big_img]\" alt=\"$row[title]\" title=\"$row[title]\" onclick=\"showimg('$sett[relative_url]img/big/$row[big_img]');return false;\"$bigimg_width></a>";
  $template->assign('image_url', "$sett[relative_url]img/big/$row[big_img]");
  }
  elseif($row['small_img']){
  $image="<a href=\"$sett[relative_url]img/big/$row[big_img]\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" alt=\"$row[title]\" title=\"$row[title]\" onclick=\"showimg('$sett[relative_url]img/big/$row[big_img]');return false;\"$smallimg_width></a>";
  $template->assign('image_url', "$sett[relative_url]img/small/$row[small_img]");
  }
 }
 elseif($row['small_img']){
 $image="<a href=\"$sett[relative_url]img/small/$row[small_img]\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" alt=\"$row[title]\" title=\"$row[title]\" onclick=\"showimg('$sett[relative_url]img/small/$row[small_img]');return false;\"$smallimg_width></a>";
 $template->assign('image_url', "$sett[relative_url]img/small/$row[small_img]");
 }
 else{
 $template->assign('image_url', '');
 }


 if($image){
 $template->condition('product_image');
 }
 else{
 $template->not_condition('product_image');
 }

 if($row['quantity']>0 && $row['quantity']<4294967295){
 $quantity_text="$lang[in_stock]: $row[quantity]";
 }
 elseif($row['quantity']==4294967295){
 $quantity_text="$lang[in_stock]: $lang[unlim]";
 }
 else{
 $quantity_text="$lang[no_in_stock].";
 }

$descript = '';
 if($row['long_descript']){
 $descript="$row[long_descript]";
 }
 elseif($row['short_descript']){
 $descript=$row['short_descript'];
 }

if($row['quantity']<1){$no_in_stock="$lang[no_in_stock].";}

 if( ($row['quantity'] > 0 || $sett['cart_add_q0']) && (empty($sett['nocart_add_price0']) || $row['price'] > 0) ){
 $template->condition('in_stock');
 }
 else{
 $template->not_condition('in_stock');
 }

 if($row['mnf_id'] > 0){
 $template->condition('manufacturer');
 }
 else{
 $template->not_condition('manufacturer');
 }
 
 if($row['quantity_txt']){
 $template->condition('quantity_txt');
 $template->not_condition('not_quantity_txt');
 }
 else{
 $template->not_condition('quantity_txt');
 $template->condition('not_quantity_txt');
 }

$template->assign('special_text', $page_tags['special']);
$template->assign('category_chain_link', $page_tags['chain_title_link']);
$template->assign('product_title', $row['title']);
$template->assign('product_price', $shop->format_price($shop->calc_price($row['price'])));
$template->assign('product_descript', $descript);
$template->assign('short_descript', $row['short_descript']);
$template->assign('long_descript', $row['long_descript']);
$template->assign('product_quantity', $quantity_text);
$template->assign('quantity_txt', $row['quantity_txt']);
$template->assign('product_numeric_quantity', $row['quantity']);
$template->assign('product_sku', $row['sku']);
$template->assign('old_price', $shop->format_price($shop->calc_price($row['old_price'])));
$template->assign('product_image', $image);
$template->assign('product_id', $itemid);
$template->assign('small_img', $row['small_img']);
$template->assign('big_img', $row['big_img']);
$template->assign('small_img_width', $smallimg_width);
$template->assign('small_img_numeric_width', intval($sett['smallimg_width']));
$template->assign('big_img_width', $bigimg_width);
$template->assign('big_img_numeric_width', intval($sett['bigimg_width']));
$template->assign('currency_brief', $sett['show_curr_brief']);
$template->assign('manufacturer_url', @stdi2("view=manufacturers&amp;mnf=$row[mnf_id]", "manufacturers/$row[mnfname]/"));
$template->assign('manufacturer_title', $row['manufacturer_title']);



$template->get_cycle('product_gallery');


if($sett['gallery_q_columns']<1){$sett['gallery_q_columns']=2;}


$res = $db->query("SELECT * FROM $tbl_gallery WHERE itemid = $itemid ORDER BY imgid DESC") or die($db->error());

 if($db->num_rows($res) < 1){
 $template->not_condition('product_gallery');
 }
 else{
 $template->condition('product_gallery');
 }

 if($sett['gal_smimg_width']){
 $def_img_width=" width=\"$sett[gal_smimg_width]\" ";
 }
 else{
 $def_img_width='';
 }

 while($row=$db->fetch_array($res)){

  if(! $row['small_img']){
  $row['small_img'] = 'none.gif';
  }

 $img_src = "$sett[relative_url]img/small/$row[small_img]";

  if($row['big_img']){
  $img_url = "$sett[relative_url]img/big/$row[big_img]";
  $image = "<a href=\"$img_url\"><img src=\"$img_src\" alt=\"$row[alt]\" title=\"$row[alt]\" onclick=\"showimg('$img_url');return false;\"$def_img_width></a>";
  }
  else{
  $img_url = "$sett[relative_url]img/small/$row[small_img]";
  $image = "<a href=\"$img_url\"><img src=\"$img_src\" alt=\"$row[alt]\" title=\"$row[alt]\" onclick=\"showimg('$img_url');return false;\"$def_img_width></a>";
  }

 $template->assign_cycle('gallery_quantity_columns', $sett['gallery_q_columns']);
 $template->assign_cycle('gallery_image', $image);
 $template->assign_cycle('gallery_image_url', $img_url);
 $template->assign_cycle('gallery_image_src', $img_src);
 $template->assign_cycle('gallery_big_image_url', "$sett[relative_url]img/big/$row[big_img]");
 $template->assign_cycle('gallery_small_image', $row['small_img']);
 $template->assign_cycle('gallery_big_image', $row['big_img']);
 $template->assign_cycle('gallery_image_alt', $row['alt']);
 $template->assign_cycle('gallery_image_width', $def_img_width);
 $template->assign_cycle('gallery_image_numeric_width', intval($sett['gal_smimg_width']));

 $template->between_cycles('product_gallery');
 $template->next_loop();

 }


$template->out_cycle('product_gallery');



 if($sett['similar']){
 require_once(INC_DIR."/similar_products.php");
 $similar_products=new similar_products;
 $similar_products->get_similar_products($itemid, $template);
 }
 else{
 $template->not_condition('similar_products');
 }

 if(! empty($sett['on_pcomm'])){
 require_once(INC_DIR."/product_comments.php");
 $prcomm = new prcomm;
 $comments_arr = $prcomm->get_comments($itemid, $prname, array('itemname' => $prname, 'catid' => $catid, 'title' => $product_title));
 $template->assign('product_comments', $comments_arr['content']);
 $template->assign('quantity_comments', $comments_arr['quantity']);
 }
 else{
 $template->assign('product_comments', '');
 $template->assign('quantity_comments', '0');
 }

return $template->out_content();
}

?>