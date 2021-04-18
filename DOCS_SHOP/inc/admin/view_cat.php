<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class view_category{

function print_chapters($parent){
global $db, $sett;
$tablename=DB_PREFIX.'categories';

$query=$db->query("SELECT COUNT(*) from $tablename WHERE parent = '$parent'") or die($db->error());
$chapters_count=$db->result($query,0,0);

if($parent==0){$chapters_count--;}

$quantity_chapters_in_column = ceil($chapters_count / $sett['quantity_columns']);
$chapter_number=0;

$query=$db->query("SELECT catid, title, count from $tablename WHERE parent = '$parent' ORDER BY sortid, title")or die($db->error());

echo '<div class="subcatList">';

 while($row=$db->fetch_array($query)){
  if($row['catid']){
  echo "<a href=\"?view=cts&cat=$row[catid]\">$row[title]&nbsp;($row[count])</a>, ";
  }
 }

echo '</div>';
}


function get_cat_products(){
global $db, $sett, $admset, $pg, $page_tags, $cat, $custom, $lang, $shop;

$tbl_items=DB_PREFIX.'items';
$tbl_options=DB_PREFIX.'item_options';
$tbl_options_values=DB_PREFIX.'item_options_values';
$tbl_options_match=DB_PREFIX.'item_options_match';
$tbl_item_categories=DB_PREFIX.'item_categories';
$tbl_manufacturers=DB_PREFIX.'manufacturers';

$shop->get_categories_arr();

$ret='';

$check_def_cat=preg_replace('/\D/', '', $cat);
if($check_def_cat !== $cat){return '';}

 if(! empty($admset['show_inv_pr'])){
 $where_visible='';
 }
 else{
 $where_visible="AND $tbl_items.visible = 1";
 }

$res = $db->query("SELECT COUNT(*) FROM $tbl_item_categories, $tbl_items WHERE $tbl_item_categories.catid = $cat AND $tbl_items.itemid = $tbl_item_categories.itemid $where_visible") or die($db->error());

$quantity_products=$db->result($res,0,0);


 if($quantity_products<1){
 $pg=preg_replace('/\D/', '', $pg);
  if($pg != ''){
  return '';
  }
  else{
  $ret.='<br><br>';
  return $ret;
  }
 }


if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(!$pg){$pg=1;}

$first_line=intval($pg * $sett['products_onpage'] - $sett['products_onpage']);
if(! $sett['products_onpage']){$sett['products_onpage']= 20;}

if($first_line < 0 ){return '';}

 if($sett['smallimg_width']){
 $def_img_width=" width=\"$sett[smallimg_width]\"";
 }
 else{
 $def_img_width='';
 }

 if(! isset($_GET['sort'])){
 $_GET['sort'] = '';
 }

 if(! isset($_GET['desc'])){
 $_GET['desc'] = '';
 }

 if(! empty($_GET['sort'])){
   switch($_GET['sort']){
   case 'id': $orderby="$tbl_items.itemid"; break;
   case 'udate': $orderby="$tbl_items.upd_date"; break;
   case 'price': $orderby="$tbl_items.price"; break;
   case 'title': $orderby="$tbl_items.title"; break;
   case 'sku': $orderby="$tbl_items.sku"; break;
   case 'mnf': $orderby="$tbl_manufacturers.title"; break;

   default: $orderby="$tbl_items.itemid";
   }
  if($_GET['desc']){$orderby.=' DESC';}
 }
 elseif($sett['sort_products']){
   switch($sett['sort_products']){
   case 'id': $orderby="$tbl_item_categories.sortid, $tbl_items.itemid"; break;
   case 'udate': $orderby="$tbl_item_categories.sortid, $tbl_items.upd_date"; break;
   case 'price': $orderby="$tbl_item_categories.sortid, $tbl_items.price"; break;
   case 'title': $orderby="$tbl_item_categories.sortid, $tbl_items.title"; break;
   case 'sku': $orderby="$tbl_item_categories.sortid, $tbl_items.sku"; break;
   case 'mnf': $orderby="$tbl_item_categories.sortid, $tbl_manufacturers.title"; break;
   default: $orderby="$tbl_item_categories.sortid, $tbl_items.itemid";
   }
  if($sett['sortpr_desc']){$orderby.=' DESC';}
 }
 else{
 $orderby="$tbl_item_categories.sortid, $tbl_items.itemid DESC";
 }


$res = $db->query("SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.mnf_id, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.old_price, $tbl_items.quantity, $tbl_items.short_descript, $tbl_items.small_img, $tbl_items.big_img, $tbl_items.visible, $tbl_manufacturers.title as manufacturer_title FROM $tbl_item_categories, $tbl_items, $tbl_manufacturers WHERE $tbl_item_categories.catid = $cat AND $tbl_items.itemid = $tbl_item_categories.itemid $where_visible AND $tbl_manufacturers.mnf_id = $tbl_items.mnf_id ORDER BY $orderby LIMIT $first_line, $sett[products_onpage]") or die($db->error());

$ret.= "<hr><table>";

 while($row=$db->fetch_array($res)){
 $row['fcatname']=$shop->categories["$row[catid]"]['fcat'];

  if($row['small_img']){
  $img="<img src=\"$sett[relative_url]img/small/$row[small_img]\" border=\"0\" alt=\"$row[title]\" title=\"$row[title]\" style=\"max-width:100%;\"$def_img_width>";
  }
  else{
  $img='';
  }

  if($row['visible']){
  $product_url = @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'));
  $product_link="<a href=\"$product_url\" target=\"_blank\">$row[title]</a>";
  $img_link="<a href=\"$product_url\" target=\"_blank\">$img</a>";
  }
  else{
  $product_url='';
  $product_link=$row['title'];
  $img_link=$img;
  }

 $ret.="<tr><td valign=\"top\">";

 $ret.="<h3 style=\"margin:0;\">$product_link</h3>";

 if($row['sku']){$ret.="$lang[sku]: $row[sku]<br>";}

 $ret.="<b>$lang[price]: $row[price]  $sett[curr_brief]</b><br>";

  if($row['small_img']){
  $ret .= "<div class=\"CatPrImg\">$img_link</div>";
  }

 $ret .= "$row[short_descript]<br><a href=\"javascript:editem($row[itemid])\">$lang[edit]</a> | <a href=\"?view=product&act=comments&pcsub=list&itemid=$row[itemid]\" target=\"_blank\">$lang[product_comments]</a> | <a href=\"javascript:delitem($row[itemid])\">$lang[delete]</a>\n";

  $ret.='</td></tr><tr><td><hr></td></tr>';

 }

$ret.= "</table>";

$kolvopagesconst=ceil($quantity_products / $sett['products_onpage']);

 if($pg>1 && $pg>$kolvopagesconst){
 return '';
 }

if($kolvopagesconst>1)			{

$kolvopages = $kolvopagesconst;
$pagenumber = 1;
$pagebar = '';
$full_pagebar = '';

 while($kolvopages>0){
  if($pagenumber == $pg){
  $pagebar.="<B>$pagenumber</B> &nbsp;";
  }
  else{
   if($pagenumber==1){
   $pagebar.="<a href=\"?view=cts&cat=$cat&sort=$_GET[sort]&desc=$_GET[desc]\"><B>$pagenumber</B></a> &nbsp;";
   }
   else{
   $pagebar.="<a href=\"?view=cts&cat=$cat&pg=$pagenumber&sort=$_GET[sort]&desc=$_GET[desc]\"><B>$pagenumber</B></a> &nbsp;";
   }
  }
$kolvopages--;
$pagenumber++;
 }

if($pg>=$kolvopagesconst){$nextpage='';}else{$nextpage=$lang['next'];}
if($pg<=1){$prevpage='';}else{$prevpage=$lang['previous'];}

$nextpagenumber=$pg+1;
$prevpagenumber=$pg-1;

 if($prevpagenumber==1 && $prevpage){
 $full_pagebar.="<a href=\"?view=cts&cat=$cat&sort=$_GET[sort]&desc=$_GET[desc]\"><B>$prevpage</B></a> &nbsp;";
 }
 elseif($prevpage){
  $full_pagebar.="<a href=\"?view=cts&cat=$cat&pg=$prevpagenumber&sort=$_GET[sort]&desc=$_GET[desc]\"><B>$prevpage</B></a> &nbsp;";
  }

$full_pagebar .= $pagebar;

if($nextpage){$full_pagebar.="<a href=\"?view=cts&cat=$cat&pg=$nextpagenumber&sort=$_GET[sort]&desc=$_GET[desc]\"><B>$nextpage</B></a><br>";}

$ret.=$full_pagebar;
				}

return $ret;
}


function get_chapters_list($selected_chapter){
global $db;
$ret = '';
$tablename=DB_PREFIX.'categories';
$query=$db->query("SELECT catid, parent, title, fulltitle FROM $tablename ORDER BY fulltitle")or die($db->error());
 while($row=$db->fetch_array($query)){
  if($row['catid']){
  if($row['catid']==$selected_chapter){$sel_value=' selected';}else{$sel_value='';}
  $ret.= "<option value=\"".$row['catid']."\"$sel_value>$row[fulltitle]";
  }
 }
return $ret;
}


function adm_chain_chapter_title($def_cat, $delimiter){
global $custom, $db;
$tablename = DB_PREFIX.'categories';
$row=Array();
$row['parent'] = $def_cat;
$first_circle = 1;
$ch_title = '';
$inv_ch_title = '';
$ch_title_link = '';
$slash = '';
 while($row['parent'] != 0){
 $query=$db->query("SELECT catid, parent, title from $tablename WHERE catid = '$row[parent]'")or die($db->error());
 $row=$db->fetch_array($query);
 $ch_title=$row['title'] . $slash . $ch_title;
 $inv_ch_title.=$slash . $row['title'];
  $ch_title_link = "<a href=\"?view=cts&cat=$row[catid]\">$row[title]</a>" . $slash . $ch_title_link;
 $slash = $delimiter;
 }
$ret=Array();
$ret['ch_title']=trim($ch_title);
$ret['inv_ch_title']=trim($inv_ch_title);
$ret['ch_title_link']=trim($ch_title_link);
return $ret;
}


function get_invisible_items(){
global $db, $sett, $pg, $page_tags, $custom, $lang;
$ret = '';
$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';

$res=$db->query("SELECT COUNT(*) FROM `$tbl_items` WHERE `visible` = 0")or die($db->error());
$quantity_products=$db->result($res,0,0);


 if($quantity_products<1){
 return "$lang[no_invisproducts]";
 }

if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(!$pg){$pg=1;}

$first_line=intval($pg * $sett['products_onpage'] - $sett['products_onpage']);

if($first_line < 0 ){return '';}

 if($sett['smallimg_width']){
 $def_img_width=" width=\"$sett[smallimg_width]\"";
 }
 else{
 $def_img_width='';
 }

$res=$db->query("SELECT `$tbl_items`.`itemid`, `$tbl_items`.`catid`, `$tbl_items`.`sku`, `$tbl_items`.`title`, `$tbl_items`.`price`, `$tbl_items`.`old_price`, `$tbl_items`.`quantity`, `$tbl_items`.`short_descript`, `$tbl_items`.`small_img`, `$tbl_categories`.`fcatname`, `$tbl_categories`.`fulltitle` AS `cat_title` FROM `$tbl_items`, `$tbl_categories` WHERE `$tbl_items`.`visible` = 0 AND `$tbl_categories`.`catid` = `$tbl_items`.`catid` ORDER BY `$tbl_items`.`itemid` DESC LIMIT $first_line, $sett[products_onpage]") or die($db->error());

$ret .= "<hr><table>";

 while($row = $db->fetch_array($res)){
 $cat_url=@stdi2("cat=$row[catid]", $custom->statlink($row['fcatname'], '', "cat$row[catid]/", 'c'));
 $ret.="<tr><td valign=\"top\">";
 $ret.="<h3 style=\"margin:0;\">$row[title]</h3>$lang[category]: <a href=\"$cat_url\" target=\"_blank\">$row[cat_title]</a><br>";

  if($row['sku']){
  $ret.="$lang[sku]: $row[sku]<br>";
  }

 $ret.="<b>$lang[price]: $row[price]  $sett[curr_brief]</b><br>";

  if($row['small_img']){
  $ret.="<div class=\"CatPrImg\"><img src=\"$sett[relative_url]img/small/$row[small_img]\" border=\"0\" alt=\"$row[title]\" title=\"$row[title]\"$def_img_width></div>";
  }

 $ret.="$row[short_descript]<br><a href=\"javascript:editem($row[itemid])\">$lang[edit]</a> &nbsp; <a href=\"javascript:delitem($row[itemid])\">$lang[delete]</a>";

 $ret.='</td></tr><tr><td><hr></td></tr>';

 }

$ret.= "</table>";

$kolvopagesconst=ceil($quantity_products / $sett['products_onpage']);

 if($pg>1 && $pg>$kolvopagesconst){
 return '';
 }

if($kolvopagesconst>1)			{

$kolvopages=$kolvopagesconst;
$pagenumber=1;

 while($kolvopages>0){
  if($pagenumber == $pg){
  $pagebar.="<B>$pagenumber</B> &nbsp;";
  }
  else{
   if($pagenumber==1){
   $pagebar.="<a href=\"?view=invisible_items\"><B>$pagenumber</B></a> &nbsp;";
   }
   else{
   $pagebar.="<a href=\"?view=invisible_items&pg=$pagenumber\"><B>$pagenumber</B></a> &nbsp;";
   }
  }
$kolvopages--;
$pagenumber++;
 }

if($pg>=$kolvopagesconst){$nextpage='';}else{$nextpage=$lang['next'];}
if($pg<=1){$prevpage='';}else{$prevpage=$lang['previous'];}

$nextpagenumber=$pg+1;
$prevpagenumber=$pg-1;

 if($prevpagenumber==1 && $prevpage){
 $full_pagebar.="<a href=\"?view=invisible_items\"><B>$prevpage</B></a> &nbsp;";
 }
 elseif($prevpage){
  $full_pagebar.="<a href=\"?view=invisible_items&pg=$prevpagenumber\"><B>$prevpage</B></a> &nbsp;";
  }

$full_pagebar.=$pagebar;

if($nextpage){$full_pagebar.="<a href=\"?view=invisible_items&pg=$nextpagenumber\"><B>$nextpage</B></a><br>";}

$ret.=$full_pagebar;
				}

return $ret;
}


function search_form(){
global $lang, $custom;
$custom->get_lang('admin_lang/search_products');
$mnf_id = isset($_GET['mnf_id']) ? $_GET['mnf_id'] : 0;
$mnf_options = $this->manufacturers_options($mnf_id);
$srchtext = isset($_GET['srchtext']) ? stripslashes($_GET['srchtext']) : '';
$srchtext = trim(mb_substr($srchtext, 0, 2048));
$srchtext = preg_replace("([^\x09\x20\!\#\$\%\&\(\)\*\+\,\.\/0-9\:\;\=\?\@A-Z\[\]\^\_a-z\{\}\x7E-\xFF\-])", ' ', $srchtext);
$ret=<<<HTMLDATA
<form name="srchfrm" action="?" method="GET" style="margin:0px">
<input type="hidden" name="view" value="search_products">
<input type="hidden" name="go" value="1">
<table cellspacing="0" cellpadding="0">
<tr><td colspan="2">$lang[search_products] 
<select name="search_by">
HTMLDATA;
$search_by = isset($_GET['search_by']) ? $_GET['search_by'] : '' ;
$ret.= '<option value="title"';
 if($search_by == 'title'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['by_title'].'</option>';
$ret.='<option value="sku"';
 if($search_by == 'sku'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['by_sku'].'</option>';
$ret.='<option value="itemid"';
 if($search_by == 'itemid'){
 $ret.=' selected="selected"';
 }
$ret.='>'.$lang['by_id'].'</option>';
$ret.=<<<HTMLDATA
</select>
<input type="text" name="srchtext" value="$srchtext" maxlength="255"></td></tr>
<tr><td>$lang[manufacturer]<select name="mnf_id"><option value="0">$lang[all_manufacturers]</option>$mnf_options</select></td><td align="right"><input type="submit" value="$lang[search]" class="button1"></td></tr>
</table>
</form>
HTMLDATA;
 if(! empty($_GET['go'])){
 $ret.=$this->search_products($srchtext);
 }
return $ret;
}


function search_products($srch){
global $lang, $db, $custom, $sett;

$tbl_items=DB_PREFIX.'items';
$tbl_categories=DB_PREFIX.'categories';
$tbl_manufacturers=DB_PREFIX.'manufacturers';
$query='';
$limit = 100 ;

$mnf_id=intval($_GET['mnf_id']);

 if($mnf_id){
 $where_mnf="AND $tbl_items.mnf_id = $mnf_id";
 $sql_limit='';
 }
 else{
 $where_mnf='';
 $sql_limit="LIMIT $limit";
 }

$lng_srch_results = '';

 switch($_GET['search_by']){

 case 'title':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku, $tbl_items.title, $tbl_items.price, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.title LIKE '%".$db->secstr($srch)."%' $where_mnf AND $tbl_categories.catid = $tbl_items.catid $sql_limit";
 $lng_srch_by = $lang['by_title'];
 $lng_srch_results = "$lang[shows_first] $limit $lang[search_results] $lang[by_title]:";
 break;

 case 'sku':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid, $tbl_items.sku,  $tbl_items.title, $tbl_items.price, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.sku LIKE '%".$db->secstr($srch)."%' $where_mnf AND $tbl_categories.catid = $tbl_items.catid $sql_limit";
 $lng_srch_by = $lang['by_sku'];
 $lng_srch_results = "$lang[shows_first] $limit $lang[search_results] $lang[by_sku]:";
 break;

 case 'itemid':
 $query = "SELECT $tbl_items.itemid, $tbl_items.itemname, $tbl_items.catid,  $tbl_items.title, $tbl_items.price, $tbl_items.visible, $tbl_categories.fcatname FROM $tbl_items, $tbl_categories WHERE $tbl_items.itemid = '".intval($srch)."' $where_mnf AND $tbl_categories.catid = $tbl_items.catid";
 break;

 default: $query=''; 
 }

$err='';

 if(! $query){
 $err .= "$lang[not_search_by]!<br>";
 }

 if(! $srch && (! $mnf_id || $_GET['search_by'] === 'itemid')){
 $err .= "$lang[not_search_value]!<br>";
 }

 if($err){
 return "<p class=\"red\">$err</p>";
 }

$ret=<<<HTMLDATA
<script type="text/javascript">
function delitem(id){if(q('$lang[delete_product]')){window.open('?view=product&act=delitem&id='+id+'&independ=1','','width=300,height=200');}}
</script>
HTMLDATA;
$sresults='';
$res = $db->query($query) or die($db->error());

 while($row=$db->fetch_array($res)){

  if($row['visible']){
  $product_url = @stdi2("product=$row[itemid]", $custom->statlink($row['fcatname'], "$row[itemname].html", "product$row[itemid].html", 'p'));
  $product_link="<a href=\"$product_url\" target=\"_blank\">$row[title]</a>";
  }
  else{
  $product_url='';
  $product_link=$row['title'];
  }

 $sresults.="<h3 style=\"margin:0;\">$product_link</h3>";

 if(! empty($row['sku'])){$sresults.="$lang[sku]: $row[sku]<br>";}

 $sresults.="<b>$lang[price]: $row[price] $sett[curr_brief]</b><br>";

$sresults.="<a href=\"javascript:editem($row[itemid])\">$lang[edit]</a> | <a href=\"?view=product&act=comments&pcsub=list&itemid=$row[itemid]\" target=\"_blank\">$lang[product_comments]</a> | <a href=\"javascript:delitem($row[itemid])\">$lang[delete]</a>";

  $sresults.='<br><hr><br>';

 }

 if(! $sresults){
 return "<p>$lang[not_found].</p>";
 }

 if($mnf_id){
 $lng_srch_results=$lang['s_results'].':';
 }

$ret.='<h3>'.$lng_srch_results.'</h3>'.$sresults;

return $ret;
}

function manufacturers_options($def_mnf){
global $db, $sett;
$tbl=DB_PREFIX.'manufacturers';
$res = $db->query("SELECT `mnf_id`, `title` FROM `$tbl` WHERE `mnf_id` <> 0 ORDER BY `sortid`, `title`") or die($db->error());
$ret='';
 while($row=$db->fetch_array($res)){
  if($row['mnf_id']==$def_mnf){
  $selected=' selected="selected"';
  }
  else{
  $selected='';
  }
 $ret.="<option value=\"$row[mnf_id]\"$selected>$row[title]</option>";
 }
return $ret;
}


}
?>
