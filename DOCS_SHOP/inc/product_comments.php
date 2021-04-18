<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php

class prcomm{

function __construct(){
global $db, $pcomset, $custom;
$pcomset = $custom->get_settings(6);
$custom->get_lang('product_comments');
}

function get_comments($itemid, $itemname, $item_row){
global $db, $sett, $pcomset, $custom, $pg, $lang, $shop;
$itemid = intval($itemid);
$pg=intval($pg);
if($pg < 1){$pg=1;}

 if($pcomset['pubreg_only']){
  if(empty($_SESSION['arwshop_mk']['user']['userid'])){
  return array('content' => $lang['not_authorized_view'], 'quantity' => $lang['view_info']);
  }
 }

 if($itemid){
 $where="`itemid` = $itemid";
 }
 else{
 $item_row['itemname']=$itemname;
 $where="`itemname` = '".$db->secstr($itemname)."'";
 }

 if(empty($item_row['itemname']) || empty($item_row['catid']) || empty($item_row['title'])){
 $tbl=DB_PREFIX.'items';
 $res = $db->query("SELECT `itemid`, `itemname`, `catid`, `title` FROM `$tbl` WHERE $where") or die($db->error());
 $item_row = $db->fetch_array($res);
 $itemid=intval($item_row['itemid']);
 }

 if($pg>1){
 global $page_tags;
 $page_tags['meta_title'] = "$lang[product_comments] &quot;$item_row[title]&quot; ($lang[page] $pg)";
 }

 if(! $itemid){
 return array('content' => header404(), 'quantity' => '');
 }

$fcatname=$shop->categories["$item_row[catid]"]['fcat'];
$tbl_item_comments=DB_PREFIX.'item_comments';

$template = new template('product_comments.tpl');
$template->get_cycle('comments');

 if($pcomset['reverse_sort']){
 $desc = ' DESC';
 }
 else{
 $desc = '';
 }

$res = $db->query("SELECT COUNT(*) FROM $tbl_item_comments WHERE itemid = $itemid AND visible = 1") or die($db->error());
$q_comments = $db->result($res, 0, 0);

$pcomset['qpcomm'] = intval($pcomset['qpcomm']);
if($pcomset['qpcomm'] < 1){$pcomset['qpcomm'] = 40;}
$tstfirst_line=$pg * $pcomset['qpcomm'] - $pcomset['qpcomm'];
$first_line=intval($tstfirst_line);
if($first_line != $tstfirst_line){return array('content' => header404(), 'quantity' => '');}
if($first_line < 0 ){return array('content' => header404(), 'quantity' => '');}

$limit='';
 if(empty($_GET['show_all'])){
 $limit=" LIMIT $first_line, $pcomset[qpcomm]";
 }

 if($q_comments){
 $res = $db->query("SELECT `comid`, `sender_email`, `sender_name`, `cpdate`, `ardate`, `scomment`, `admin_reply` FROM `$tbl_item_comments` WHERE `itemid` = $itemid AND `visible` = 1 ORDER BY `sortid`, `cpdate`$desc$limit") or die($db->error());
 }

$def_class='ttr';
 while($q_comments && $row = $db->fetch_array($res)){
 if($def_class=='str'){$def_class='ttr';}else{$def_class='str';}
  if(! $row['sender_name']){
  $row['sender_name'] = $pcomset['name_empty'];
  }
 $template->assign_cycle('def_class', $def_class);
 $template->assign_cycle('comid', $row['comid']);
 $template->assign_cycle('sender_email', $row['sender_email']);
 $template->assign_cycle('cpdate', date("d.m.Y H:i", $row['cpdate'] + $sett['time_diff'] * 3600));
 $template->assign_cycle('scomment', $row['scomment']);
 $template->assign_cycle('ardate', date("d.m.Y H:i", $row['ardate'] + $sett['time_diff'] * 3600));
 $template->assign_cycle('admin_reply', $row['admin_reply']);
 $template->assign_cycle('admin_name', $pcomset['admin_name']);

  if($pcomset['pub_email'] && $row['sender_email']){
  $template->assign_cycle('sender_name', "<a href=\"mailto:$row[sender_email]\">$row[sender_name]</a>");
  }
  else{
  $template->assign_cycle('sender_name', $row['sender_name']);
  }

  if($row['admin_reply']){
  $template->condition_cycle('admin_reply');
  }
  else{
  $template->not_condition_cycle('admin_reply');
  }

 $template->next_loop();
 }

$template->assign('product_id', $itemid);
$template->assign('product_title', $item_row['title']);
$template->assign('last_page', generate_lastpage());
$template->assign('product_url', @stdi2("product=$itemid", $custom->statlink($fcatname, "$item_row[itemname].html", "product$itemid.html", 'p')));
mt_srand((double) microtime() * 1000000);
$rnd=mt_rand(0,999999).mt_rand(0, 999999);
$template->assign('random_image_url', "$sett[relative_url]img.php?v=$rnd");

 if($q_comments){
 $template->condition('comments_exists');
 $template->not_condition('not_comments_exists');
 }
 else{
 $template->not_condition('comments_exists');
 $template->condition('not_comments_exists');
 }

 if(! empty($_SESSION['arwshop_mk']['user']['userid'])){
 $template->not_condition('not_authorized');
 }
 else{
 $template->condition('not_authorized');
 }

 if($pcomset['add_comm']==='all'){
 $template->condition('allow_add_this_visitor');
 $template->assign('comments_form', $this->addcomform($itemid, $item_row, '', 0));
 $template->not_condition('allow_add_authorized_only');
 }
 elseif($pcomset['add_comm']==='reg'){
 $template->condition('allow_add_authorized_only');
  if(! empty($_SESSION['arwshop_mk']['user']['userid'])){
  $template->condition('allow_add_this_visitor');
  $template->assign('comments_form', $this->addcomform($itemid, $item_row, '', 0));
  }
  else{
  $template->not_condition('allow_add_this_visitor');
  }
 }
 else{
 $template->not_condition('allow_add_this_visitor');
 $template->not_condition('allow_add_authorized_only');
 }
 
$template->out_cycle();


$kolvopagesconst=ceil($q_comments / $pcomset['qpcomm']);

 if($pg>1 && $pg>$kolvopagesconst){
 return array('content' => header404(), 'quantity' => '');
 }

$full_pagebar='';

 if($kolvopagesconst>1 && empty($_GET['show_all'])){

 $kolvopages = $kolvopagesconst;
 $pagenumber = 1;
 $pagebar = '';

  while($kolvopages>0){
   if($pagenumber == $pg){
   $pagebar.="<span class=\"PgOpen\">$pagenumber</span> &nbsp;";
   }
   else{
    if($pagenumber==1){
    $pagebar.='<a href="' . @stdi2("product=$itemid", $custom->statlink($fcatname, "$item_row[itemname].html", "product$itemid.html", 'p')) . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
    }
    else{
    $pagebar.='<a href="' . @stdi2("product=$itemid&sub=product_comments&pg=$pagenumber", $custom->statlink('product_comments', "$item_row[itemname]/pg$pagenumber.html", "product_comments$itemid/pg$pagenumber.html", 'pc')) . "\" class=\"PglA\">$pagenumber</a> &nbsp;";
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
 $full_pagebar.='<a href="' . @stdi2("product=$itemid", $custom->statlink($fcatname, "$item_row[itemname].html", "product$itemid.html", 'p')) . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }
  elseif($prevpage){
  $full_pagebar.='<a href="' . @stdi2("product=$itemid&sub=product_comments&pg=$prevpagenumber", $custom->statlink('product_comments', "$item_row[itemname]/pg$prevpagenumber.html", "product_comments$itemid/pg$prevpagenumber.html", 'pc'))  . "\" rel=\"prev\" class=\"PglPrev\">$prevpage</a> &nbsp;";
  }

 $full_pagebar.=$pagebar;

 if($nextpage){$full_pagebar.='<a href="' . @stdi2("product=$itemid&sub=product_comments&pg=$nextpagenumber", $custom->statlink('product_comments', "$item_row[itemname]/pg$nextpagenumber.html", "product_comments$itemid/pg$nextpagenumber.html", 'pc')) . "\" rel=\"next\" class=\"PglNext\">$nextpage</a>";}

 }



$template->assign('pages_links', $full_pagebar);
return array('content' => $template->out_content(), 'quantity' => $q_comments);
}


function addcomform($itemid, $item_row, $err, $is_independ_form){
global $sett, $user_data, $pcomset, $lang, $lastpage, $custom;

 if($is_independ_form){
 global $page_tags;
 $page_tags['meta_title'] = "$lang[add_comment] $lang[to] $item_row[title]";
 }

 if(! empty($_POST['add_product_comment'])){
 $sender_name = stripslashes($_POST['sender_name']);
 $sender_email = stripslashes($_POST['sender_email']);
 $_POST['scomment'] = stripslashes($_POST['scomment']);
 }
 else{
 $sender_name = $user_data['first_name'];
 $sender_email = $user_data['email'];
 }

$template = new template('product_comment_form.tpl');
 if($err){
 require_once(INC_DIR."/msg.php");
 $template->assign('error_message', msg::error($err, $lang['error_found']));
 }
 else{
 $template->assign('error_message', '');
 }

 if($_SERVER['REQUEST_METHOD'] === 'GET'){
 $template->assign('last_page', generate_lastpage());
 }
 else{
 $template->assign('last_page', $lastpage);
 }

$template->assign('product_id', $itemid);
$template->assign('product_title', $item_row['title']);
 if(! isset($item_row['fcatname'])){
 $item_row['fcatname'] = '';
 }
$template->assign('product_url', @stdi2("product=$itemid", $custom->statlink($item_row['fcatname'], "$item_row[itemname].html", "product$itemid.html", 'p')));
$template->assign('sender_name', $sender_name);
$template->assign('sender_email', $sender_email);
$scomment = isset($_POST['scomment']) ? $custom->replace_tags_and_quotes($_POST['scomment']) : '';
$template->assign('scomment', $scomment);
mt_srand((double) microtime() * 1000000);
$rnd=mt_rand(0,999999).mt_rand(0, 999999);
$template->assign('random_image_url', "$sett[relative_url]img.php?v=$rnd");

 if($pcomset['name_req']){
 $template->assign('required_name', '<span class="red">*</span>');
 }
 else{
 $template->assign('required_name', '');
 }

 if($pcomset['email_req']){
 $template->assign('required_email', '<span class="red">*</span>');
 }
 else{
 $template->assign('required_email', '');
 }

 if($is_independ_form){
 $template->condition('independ_form');
 }
 else{
 $template->not_condition('independ_form');
 }

 if($pcomset['antibot']){
 $template->condition('antibot');
 }
 else{
 $template->not_condition('antibot');
 }

return $template->out_content();
}



function add_comment($itemid){
global $db, $pcomset, $custom, $lang, $user_data, $sett, $shop;

$pc_access = $this->add_form_access();
 if($pc_access !== '1'){
 return $pc_access;
 }

$itemid = intval($itemid);
$tbl=DB_PREFIX.'items';
$res = $db->query("SELECT `itemid`, `itemname`, `catid`, `title` FROM `$tbl` WHERE `itemid` = $itemid AND visible = 1") or die($db->error());
$item_row = $db->fetch_array($res);
 if(! $item_row['itemid']){
 return 'Invalid product id';
 }

$item_row['fcatname']=$shop->categories["$item_row[catid]"]['fcat'];

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 return $this->addcomform($itemid, $item_row, '', 1);
 }

$_POST = $custom->trim_array($_POST);
$_POST = $custom->replace_tags_and_quotes_array($_POST);
$err = '';

require_once(INC_DIR."/mailer.php");
$mailer = new mailer;

$stop_words = explode("\x0A", $custom->get_txtsettings('pr_comm_stop_words'));

 if($pcomset['name_req'] && ! $_POST['sender_name']){
 $err .= "$lang[empty_name]<br>";
 }

 if($this->stop_words_exists($stop_words, $_POST['sender_name'])){
 $err .= "$lang[stop_words_exists]<br>";
 }

 if($pcomset['email_req']){
  if(! $_POST['sender_email']){
  $err .= "$lang[empty_email]<br>";
  }
  elseif(! $mailer->valid_email($_POST['sender_email'])){
  $err .= "$lang[invalid_email]<br>";
  }
 }
 elseif($_POST['sender_email']){
  if(! $mailer->valid_email($_POST['sender_email'])){
  $err .= "$lang[invalid_email]<br>";
  }
 }

 if(! $_POST['scomment']){
 $err .= "$lang[empty_scomment]<br>";
 }

$pcomset['com_minlen'] = intval($pcomset['com_minlen']);
if($pcomset['com_minlen'] < 0){$pcomset['com_minlen'] = 0;}
 if(mb_strlen($_POST['scomment']) < $pcomset['com_minlen']){
 $err .= "$lang[short_comment] $pcomset[com_minlen] $lang[simbols].<br>";
 }

$pcomset['com_maxlen'] = intval($pcomset['com_maxlen']);
if($pcomset['com_maxlen'] > 65535){$pcomset['com_maxlen'] = 65535;}
 if(mb_strlen($_POST['scomment']) > $pcomset['com_maxlen']){
  if($pcomset['cut_com']){
  $_POST['scomment'] = mb_substr($_POST['scomment'], 0, $pcomset['com_maxlen']);
  }
  else{
  $err .= "$lang[long_comment] $pcomset[com_maxlen] $lang[simbols].<br>";
  }
 }

 if($this->stop_words_exists($stop_words, $_POST['scomment'])){
 $err .= "$lang[stop_words_exists]<br>";
 }

 if($pcomset['antibot']){
 $_POST['protect_code']=trim($_POST['protect_code']);
  if(! $_POST['protect_code']){
  $err.="$lang[not_protect_code]<br>";
  }
  elseif($_POST['protect_code'] != $_SESSION['arwshop_mk']['rnd_botcode']){
  $err.="$lang[invalid_protect_code]<br>";
  }
  else{
  unset($_SESSION['arwshop_mk']['rnd_botcode']);
  }
 }

 if($err){
 return $this->addcomform($itemid, $item_row, $err, 1);
 }

$_POST['sender_name'] = $db->secstr($_POST['sender_name']);
$_POST['sender_name'] = $db->cutstr($_POST['sender_name'], 255);
$_POST['sender_email'] = $db->secstr($_POST['sender_email']);
$_POST['sender_email'] = $db->cutstr($_POST['sender_email'], 255);
$_POST['scomment'] = $custom->rn_to_n($_POST['scomment']);
$_POST['scomment'] = str_replace("\n", "<br>\n", $_POST['scomment']);
$_POST['scomment'] = $db->secstr($_POST['scomment']);
$_POST['scomment'] = $db->cutstr($_POST['scomment'], 65535, true);
$_POST['scomment'] = $this->check_cuted_tag($_POST['scomment'], '<br>');
$userid = intval($user_data['userid']);
$date=intval(time());

 if($pcomset['premoderate']){
 $visible = 0;
 }
 else{
 $visible = 1;
 }

 if($this->is_comment_exists($itemid, $userid, $_POST['sender_email'], $_POST['sender_name'], $_POST['scomment'])){
 require_once(INC_DIR."/msg.php");
 return msg::error($lang['comment_exists']);
 }

$tbl=DB_PREFIX.'item_comments';
$db->query("INSERT INTO `$tbl` (`comid`, `itemid`, `userid`, `sender_email`, `sender_name`, `cpdate`, `scomment`, `ardate`, `admin_reply`, `visible`, `sortid`) VALUES (NULL, $itemid, $userid, '$_POST[sender_email]', '$_POST[sender_name]', $date, '$_POST[scomment]', 0, '', $visible, 0)") or die($db->error());
$comid=$db->insert_id();

$tbl=DB_PREFIX.'item_comments_new';
$db->query("INSERT INTO `$tbl` (comid, itemid) VALUES ($comid, $itemid)") or die($db->error());

$product_relative_url = @stdi2("product=$item_row[itemid]", $custom->statlink($item_row['fcatname'], "$item_row[itemname].html", "product$item_row[itemid].html", 'p'));
$pos=strrpos(' '.$product_relative_url, '/');
$product_url = substr($sett['url'], 0, strlen($sett['url']) - strlen($sett['relative_url'])) . $product_relative_url;

 if($user_data['username']){
 $username = $user_data['username'];
 }
 else{
 $username = $lang['not_auth'];
 }

 if($visible){
 $status = $lang['visible'];
 }
 else{
 $status = $lang['invisible'];
 }

 if($pcomset['notifi_admin']){
 $mailtext = $mailer->get_tplfile('product_comment_added');
 $mailtext = str_replace('{comment_id}', $comid, $mailtext);
 $mailtext = str_replace('{product_id}', $itemid, $mailtext);
 $mailtext = str_replace('{product_title}', $item_row['title'], $mailtext);
 $mailtext = str_replace('{product_url}', $product_url, $mailtext);
 $mailtext = str_replace('{username}', $username, $mailtext);
 $mailtext = str_replace('{cpdate}', date("d.m.Y H:i:s", $date + $sett['time_diff'] * 3600), $mailtext);
 $mailtext = str_replace('{comment_visible}', $status, $mailtext);
 $mailtext = str_replace('{sender_name}', $_POST['sender_name'], $mailtext);
 $mailtext = str_replace('{sender_email}', $_POST['sender_email'], $mailtext);
 $mailtext = str_replace('{scomment}', str_replace('<br>', "\n", $_POST['scomment']), $mailtext);
  if($_POST['sender_email']){
  $from_email = $_POST['sender_email'];
  $from_name = $_POST['sender_name'];
  }
  else{
  $from_email = $sett['email'];
  $from_name = $sett['shop_name'];
  }
 $mailer->sendemail($from_name, $from_email, $sett['shop_name'], $sett['email'], "$lang[added_comment] (product id $itemid)", $mailtext);
 }

$msg = '';
 if($pcomset['premoderate']){
 $msg .= $lang['premoderate'].'<br>';
 }
$msg.="<a href=\"$product_relative_url\">$lang[on_product_page]</a>";
require_once(INC_DIR."/msg.php");
return msg::success($msg, "$lang[thanks] $lang[com_added_success]");
}



function add_form_access(){
global $sett, $pcomset, $lang;
 if(! $pcomset['add_comm']){
 return "<p>$lang[not_must_add].</p>";
 }
 elseif($pcomset['add_comm']==='reg'){
  if($_SESSION['arwshop_mk']['user']['userid']){
  return '1';
  }
  else{
  return "<p>$lang[not_authorized]. <a href=\"$sett[relative_url]pages.php?view=login&lastpage=" . generate_lastpage() . "%23acom\">$lang[enter]</a>.</p>";
  }
 }
 elseif($pcomset['add_comm']==='all'){
 return '1';
 }
return 'Access not allowed.';
}


function stop_words_exists($stop_words, $text){
$text=' '.mb_strtolower($text);
 foreach($stop_words as $word){
  if($word){
   if(mb_strpos($text, $word)){
   return true;
   }
  }
 }
return false;
}


function is_comment_exists($itemid, $userid, $sender_email, $sender_name, $scomment){
global $db;
$tbl=DB_PREFIX.'item_comments';
$res = $db->query("SELECT COUNT(*) FROM `$tbl` WHERE `itemid` = $itemid AND `userid` = '$userid' AND  `sender_email` = '$sender_email' AND `sender_name` = '$sender_name' AND `scomment` = '$scomment'") or die($db->error());
 if($db->result($res,0,0)>0){
 return true;
 }
return false;
}


function check_cuted_tag($text, $tag){
$ctag_len=strlen($tag)-1;
$last=' '.substr($text, strlen($text)-$ctag_len);
$pos=strpos($last, '<');
 if($pos){
 return substr($text, 0, strlen($text)-$ctag_len-1+$pos);
 }
return $text;
}


}
?>