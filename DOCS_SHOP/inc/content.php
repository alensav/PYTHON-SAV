<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class content{

function get_page($pagename){
global $db, $page_tags, $sett;
$pagename=preg_replace("([^0-9a-zA-Z\x80-\xFF\x20\_\-])", '', $pagename);
if(! $pagename){return '';}
$tbl=DB_PREFIX.'content';
$res=$db->query("SELECT * FROM $tbl WHERE pname = '$pagename'") or die($db->error());
return $db->fetch_array($res);
}


function get_all_content(){
global $lang, $db, $sett, $custom, $pg;

$items_onpage = 50 ;

if(! $items_onpage){$items_onpage=50;}

$tbl=DB_PREFIX.'content';

$res=$db->query("SELECT COUNT(*) FROM $tbl")or die($db->error());
$quantity_items=$db->result($res,0,0);


if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(!$pg){$pg=1;}

$tstfirst_line=$pg * $items_onpage - $items_onpage;
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){echo header404();}

if($first_line < 0 ){return '';}

$res=$db->query("SELECT pname, title FROM $tbl ORDER BY sortid LIMIT $first_line, $items_onpage")or die($db->error());

$template = new template('content.tpl');
$template->get_cycle('content');

 while($row=$db->fetch_array($res)){

 $page_url=@stdi2("view=content&amp;pname=$row[pname]", "content/$row[pname].html");

 $template->assign_cycle('page_url', $page_url);
 $template->assign_cycle('page_title', $row['title']);
 $template->next_loop();
 }

$template->out_cycle();

$kolvopagesconst=ceil($quantity_items / $items_onpage);

 if($pg>1 && $pg>$kolvopagesconst){
 return header404();
 }

$full_pagebar = '';

if($kolvopagesconst > 1){

$pagebar = '';
$kolvopages = $kolvopagesconst;
$pagenumber = 1;

 while($kolvopages>0){
  if($pagenumber == $pg){
  $pagebar.="<span class=\"PgOpen\">$pagenumber</span> &nbsp;";
  }
  else{
   if($pagenumber==1){
   $pagebar.='<a href="' . @stdi2("view=content", "content/") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
   }
   else{
   $pagebar.='<a href="' . @stdi2("view=content&amp;pg=$pagenumber", "content/pg$pagenumber.html") . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
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
 $full_pagebar.='<a href="' . @stdi2("view=content", "content/") . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
 }
 elseif($prevpage){
 $full_pagebar.='<a href="' . @stdi2("view=content&amp;pg=$prevpagenumber", "content/pg$prevpagenumber.html")  . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

$full_pagebar.=$pagebar;

if($nextpage){$full_pagebar.='<a href="' . @stdi2("view=content&amp;pg=$nextpagenumber", "content/pg$nextpagenumber.html") . "\" rel=\"next\" class=\"PglNext\">$nextpage</a>";}

}

$template->assign('pages_links', $full_pagebar);

return $template->out_content();
}


}
?>