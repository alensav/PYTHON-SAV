<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

echo get_all_manufacturers();


function get_all_manufacturers(){
global $db, $sett, $page_tags, $lang, $pg;
$q_on_page = 1000 ;
$tbl_manufacturers=DB_PREFIX.'manufacturers';
$page_tags['meta_title'] = "$lang[manufacturers] - $sett[pages_title]";

$template = new template('manufacturers.tpl');

 if(strpos(' '.$template->content, '{pages_links}') === false){
 $q_on_page = 100000;
 }

$res = $db->query("SELECT COUNT(*) FROM `$tbl_manufacturers`") or die($db->error());
$quantity_mnfs = $db->result($res);
if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(!$pg){$pg=1;}
$tstfirst_line = $pg * $q_on_page - $q_on_page;
$first_line = intval($tstfirst_line);
if($first_line != $tstfirst_line){return header404();}
if($first_line < 0 ){return '';}

$res = $db->query("SELECT * FROM `$tbl_manufacturers` WHERE `mnf_id` <> 0 ORDER BY `sortid`, `title` LIMIT $first_line, $q_on_page") or die($db->error());

$template->get_cycle('manufacturers');
 while($row=$db->fetch_array($res)){
 $template->assign_cycle('manufacturer_id', $row['mnf_id']);
 $template->assign_cycle('manufacturer_name', $row['title']);
 $template->assign_cycle('manufacturer_description', $row['description']);
 $template->assign_cycle('manufacturer_image', $row['image']);
 $template->assign_cycle('manufacturer_url', $row['url']);
 $template->assign_cycle('manufacturer_local_url', @stdi2("view=manufacturers&amp;mnf=$row[mnf_id]", "manufacturers/$row[mnfname]/"));
 $template->assign_cycle('meta_title', $row['meta_title']);
 $template->assign_cycle('meta_description', $row['meta_description']);
 $template->assign_cycle('meta_keywords', $row['meta_keywords']);
 $template->assign_cycle('meta_tags', $row['meta_tags']);
 
  if($row['url']){
  $template->condition_cycle('manufacturer_url');
  }
  else{
  $template->not_condition_cycle('manufacturer_url');
  }

  if($row['image']){
  $template->condition_cycle('manufacturer_image');
  }
  else{
  $template->not_condition_cycle('manufacturer_image');
  }
 
 $template->next_loop();
 }
 
$template->out_cycle();

$full_pagebar='';
$kolvopagesconst=ceil($quantity_mnfs / $q_on_page);

 if($pg>1 && $pg>$kolvopagesconst){
 return header404();
 }

if($kolvopagesconst>1)			{

$kolvopages=$kolvopagesconst;
$pagenumber=1;

 while($kolvopages>0){
  if($pagenumber == $pg){
  $pagebar.="<span class=\"PgOpen\">$pagenumber</span> &nbsp;";
  }
  else{
   if($pagenumber==1){
   $pagebar.='<a href="' . @stdi2("view=manufacturers", "manufacturers/") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
   }
   else{
   $pagebar.='<a href="' . @stdi2("view=manufacturers&pg=$pagenumber", "manufacturers/pg$pagenumber.html") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
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
 $full_pagebar.='<a href="' . @stdi2("view=manufacturers", "manufacturers/") . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
 }
 elseif($prevpage){
  $full_pagebar.='<a href="' . @stdi2("view=manufacturers&pg=$prevpagenumber", "manufacturers/pg$prevpagenumber.html")  . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

$full_pagebar.=$pagebar;

if($nextpage){$full_pagebar.='<a href="' . @stdi2("view=manufacturers&pg=$nextpagenumber", "manufacturers/pg$nextpagenumber.html") . "\" rel=\"next\" class=\"PglNext\">$nextpage</a>";}

				}

$template->assign('pages_links', $full_pagebar);

return $template->out_content();
}

?>