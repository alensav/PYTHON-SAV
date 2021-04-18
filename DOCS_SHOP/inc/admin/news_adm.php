<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class news_adm{

function get_all_news(){
global $lang, $db, $sett, $custom;

$news_onpage = 30 ;

if(! $news_onpage){$news_onpage=30;}

$pg = isset($_GET['pg']) ? $_GET['pg'] : 0;
$ret = '';

$tbl = DB_PREFIX.'news';

$res = $db->query("SELECT COUNT(*) FROM $tbl")or die($db->error());
$quantity_news=$db->result($res,0,0);


if($pg){$pg=preg_replace('/\D/', '', $pg);}
if(!$pg){$pg=1;}

$tstfirst_line=$pg * $news_onpage - $news_onpage;
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){ return '';}

if($first_line < 0 ){return '';}


$res=$db->query("SELECT newsid, date, title FROM $tbl ORDER BY date DESC, newsid DESC LIMIT $first_line, $news_onpage")or die($db->error());


 while($row=$db->fetch_array($res)){

 $ret .= <<<HTMLDATA
<h4 style="margin:4px;">$row[date] <a href="?view=news&act=edit&amp;nid=$row[newsid]">$row[title]</a></h4>
<img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=news&act=edit&amp;nid=$row[newsid]">$lang[edit]</a> &nbsp; &nbsp; <img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=news&act=delete&amp;nid=$row[newsid]" onclick="return q('$lang[delete_this_news]')">$lang[delete]</a><br><br><br>
HTMLDATA;
 }

$kolvopagesconst=ceil($quantity_news / $news_onpage);

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
   $pagebar.="<a href=\"?view=news\"><B>$pagenumber</B></a> &nbsp;";
   }
   else{
   $pagebar.="<a href=\"?view=news&pg=$pagenumber\"><B>$pagenumber</B></a> &nbsp;";
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
 $full_pagebar.="<a href=\"?view=news\"><B>$prevpage</B></a> &nbsp;";
 }
 elseif($prevpage){
  $full_pagebar.="<a href=\"?view=news&pg=$prevpagenumber\"><B>$prevpage</B></a> &nbsp;";
  }

$full_pagebar.=$pagebar;

if($nextpage){$full_pagebar.="<a href=\"?view=news&pg=$nextpagenumber\"><B>$nextpage</B></a><br>";}

$ret.=$full_pagebar;
				}

return $ret;
}


function get_news_detail($newsid){
global $db;
$newsid=intval($newsid);
if(! $newsid){return '';}
$tbl=DB_PREFIX.'news';
$res=$db->query("SELECT * FROM `$tbl` WHERE `newsid` = '$newsid'") or die($db->error());
$row=$db->fetch_array($res);
$date=explode('-', $row['date']);
$row['year']=$date[0];
$row['month']=$date[1];
$row['day']=$date[2];
return $row;
}


function save_news(){
global $db, $act, $lang, $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

require_once(INC_DIR.'/admin/chpu.php');

$tbl_news=DB_PREFIX.'news';

$_POST['newsid'] = intval($_POST['newsid']);

 if($act=='edit'){
  if(! $_POST['newsid']){
   return '';
  }
 }
 elseif($act=='add'){
  if(TDTC == 1){
  $res = $db->query("SELECT COUNT(*) FROM $tbl_news") or die($db->error());
   if($db->result($res,0,0) >= 10){
   return mdmogrn("$lang[130] 10 $lang[208]");
   }
  }
 }

$err_msg = '';

$_POST['title']=trim($_POST['title']);
if(! $_POST['title']){$err_msg.="$lang[no_title]<br>";}
$_POST['newsname'] = trim($_POST['newsname']);
$_POST['newsname'] = chpu::autoName($_POST['newsname'], $_POST['title'], $_POST['newsid'], false);
 if($_POST['newsname']){
 $ch_newsname=$db->secstr($_POST['newsname']);
 $res=$db->query("SELECT COUNT(*) FROM `$tbl_news` WHERE `newsname` = '$ch_newsname' AND `newsid` <> $_POST[newsid]") or die($db->error());
  if($db->result($res,0,0)>0){
  $err_msg.="$lang[link_name] \"$_POST[newsname]\" $lang[used_in_other_news]<br>";
  }
 }

$_POST['meta_title'] = $db->cutstr($_POST['meta_title'], 255);
$_POST['meta_description'] = $db->cutstr($_POST['meta_description'], 255);
$_POST['meta_keywords'] = $db->cutstr($_POST['meta_keywords'], 255);
$_POST['meta_tags'] = $db->cutstr($_POST['meta_tags'], 65535, true);

 if(! empty($_POST['auto_br_menu_text'])){
 $_POST['menu_text'] = nl2br($_POST['menu_text'], false);
 }

 if(! empty($_POST['auto_br_text'])){
 $_POST['text'] = nl2br($_POST['text'], false);
 }

$_POST['year']=$this->add_zeros($_POST['year'], 4);
$_POST['month']=$this->add_zeros($_POST['month'], 2);
$_POST['day']=$this->add_zeros($_POST['day'], 2);

$date = substr("$_POST[year]-$_POST[month]-$_POST[day]", 0, 10);
$_POST['title'] = $db->cutstr($_POST['title'], 255);
$_POST['menu_text'] = $db->cutstr($_POST['menu_text'], 65535, true);
$_POST['text'] = $db->cutstr($_POST['text'], 16777215, true);

 if($err_msg){
 return "<p class=\"red\">$err_msg</p>";
 }

 if($act=='edit'){
  if(! $_POST['newsname']){
  $_POST['newsname']="$_POST[newsid]";
  }
 $res=$db->query("UPDATE `$tbl_news` SET `newsname` = '$_POST[newsname]', `date` = '$date', `title` = '$_POST[title]', `menu_text` = '$_POST[menu_text]', `text` = '$_POST[text]', `meta_title` = '$_POST[meta_title]', `meta_description` = '$_POST[meta_description]', `meta_keywords` = '$_POST[meta_keywords]', `meta_tags` = '$_POST[meta_tags]' WHERE `newsid` = '$_POST[newsid]'") or die($db->error());
 }
 elseif($act=='add'){
 $res=$db->query("INSERT INTO `$tbl_news` (`newsid`, `newsname`, `date`, `title`, `menu_text`, `text`, `meta_title`, `meta_description`, `meta_keywords`, `meta_tags`) VALUES(NULL, '$_POST[newsname]', '$date', '$_POST[title]', '$_POST[menu_text]', '$_POST[text]', '$_POST[meta_title]', '$_POST[meta_description]', '$_POST[meta_keywords]', '$_POST[meta_tags]')") or die($db->error());
 $_POST['newsid']=$db->insert_id();
  if(! $_POST['newsname']){
  $_POST['newsname']="$_POST[newsid]";
  $db->query("UPDATE `$tbl_news` SET `newsname` = '$_POST[newsname]' WHERE `newsid` = '$_POST[newsid]'") or die($db->error());
  }
 }

if($res){return 1;}else{return '';}
}


function delete_news($newsid){
global $db, $lang, $admin_lib;
$newsid=intval($newsid);
if(! $newsid){return '';}

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$tbl=DB_PREFIX.'news';
$db->query("DELETE FROM $tbl WHERE newsid = '$newsid'") or die($db->error());
return "<h3>$lang[news_is_deleted]</h3>";
}


function add_zeros($str, $def_length){
$str=preg_replace('([^0-9])', '', $str);
$len=strlen($str);
if($len<$def_length){$str=str_repeat('0', $def_length-$len).$str;}
return $str;
}


}
?>
