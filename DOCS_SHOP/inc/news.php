<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class news{

function get_all_news(){
global $lang, $db, $sett, $custom, $pg, $page_tags;

$news_onpage = 30 ;
$short_length = 255 ;

if(! $news_onpage){$news_onpage=30;}

$page_tags['meta_title']="$lang[news] - $sett[pages_title]";

$tbl=DB_PREFIX.'news';

$res=$db->query("SELECT COUNT(*) FROM $tbl")or die($db->error());
$quantity_news=$db->result($res,0,0);


if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(!$pg){$pg=1;}

$tstfirst_line=$pg * $news_onpage - $news_onpage;
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){echo header404();}

if($first_line < 0 ){return '';}

$res=$db->query("SELECT newsid, newsname, date, title, menu_text, LEFT(text, $short_length) AS text FROM $tbl ORDER BY date DESC, newsid DESC LIMIT $first_line, $news_onpage")or die($db->error());

$template = new template('news.tpl');
$template->get_cycle('news');

 while($row=$db->fetch_array($res)){
 $news_url=@stdi2("view=news&amp;nid=$row[newsid]", "news/$row[newsname].html");
 $template->assign_cycle('news_date', $row['date']);
 $template->assign_cycle('news_url', $news_url);
 $template->assign_cycle('news_title', $row['title']);
 $template->assign_cycle('menu_text', $row['menu_text']);
 $template->assign_cycle('news_text', strip_tags($row['text']));
 $template->next_loop();
 }

$template->out_cycle();

$full_pagebar='';
$kolvopagesconst=ceil($quantity_news / $news_onpage);

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
   $pagebar.='<a href="' . @stdi2("view=news", "news/") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
   }
   else{
   $pagebar.='<a href="' . @stdi2("view=news&pg=$pagenumber", "news/pg$pagenumber.html") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
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
 $full_pagebar.='<a href="' . @stdi2("view=news", "news/") . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
 }
 elseif($prevpage){
  $full_pagebar.='<a href="' . @stdi2("view=news&pg=$prevpagenumber", "news/pg$prevpagenumber.html")  . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

$full_pagebar.=$pagebar;

if($nextpage){$full_pagebar.='<a href="' . @stdi2("view=news&pg=$nextpagenumber", "news/pg$nextpagenumber.html") . "\" rel=\"next\" class=\"PglNext\">$nextpage</a>";}

				}

$template->assign('pages_links', $full_pagebar);
return $template->out_content();
}


function news_detail(){
global $sett, $page_tags;
$nid = isset($_GET['nid']) ? intval($_GET['nid']) : 0;
$row = $this->get_news_detail($nid, $_GET['newsname']);
if(! $row['title']){return header404();}

 if($row['meta_title']){
 $page_tags['meta_title'] = $row['meta_title'];
 }
 else{
  if(mb_strlen($row['title'])>70){
  $page_tags['meta_title']=mb_substr($row['title'], 0, 100) . "... - $sett[pages_title]";
  }
  else{
  $page_tags['meta_title']="$row[title] - $sett[pages_title]";
  }
 }

 if($row['meta_description']){
 $page_tags['metatags'] .= "<meta name=\"description\" content=\"$row[meta_description]\">\n";
 }

 if($row['meta_keywords']){
 $page_tags['metatags'] .= "<meta name=\"keywords\" content=\"$row[meta_keywords]\">\n";
 }

$page_tags['metatags'] .= $row['meta_tags'];

$template = new template('news_detail.tpl');
$template->assign('date', $row['date']);
$template->assign('news_title', $row['title']);
$template->assign('news_text', $row['text']);
$template->assign('menu_text', $row['menu_text']);
$template->assign('all_news_url', @stdi2("view=news", "news/"));
return $template->out_content();
}


function get_news_detail($newsid, $newsname){
global $db;
$newsid=intval($newsid);
$newsname=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $newsname);
 if($newsid){
 $where="newsid = $newsid";
 }
 elseif($newsname){
 $where="newsname = '$newsname'";
 }
 else{
 return '';
 }
$tbl=DB_PREFIX.'news';
$res=$db->query("SELECT * FROM $tbl WHERE $where")or die($db->error());
return $db->fetch_array($res);
}


}
?>