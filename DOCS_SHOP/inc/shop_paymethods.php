<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class shop_paymethods{

function get_paymethods(){
global $db, $lang, $sett, $custom, $template;

$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT pmid, pmtitle, short_descript FROM $tbl WHERE enabled = 1 ORDER BY sortid, pmtitle")or die($db->error());
$num_rows=$db->num_rows($res);

if(! $num_rows){return header404();}

$def_class='ttr';

$template = new template('pay_methods.tpl');
$template->get_cycle('pay_methods');

 while($row=$db->fetch_array($res)){

 if($def_class=='ttr'){$def_class='str';}else{$def_class='ttr';}

 $template->assign_cycle('def_class', $def_class);
 $template->assign_cycle('def_pmid', $row['pmid']);
 $template->assign_cycle('paymethod_url', @stdi2("view=pay_methods&pm=$row[pmid]", "pay_methods/pm$row[pmid].html"));
 $template->assign_cycle('paymethod_title', $row['pmtitle']);
 $template->assign_cycle('short_descript', $row['short_descript']);
 $template->next_loop();
 }

$template->out_cycle();

return $template->out_content();
}


function get_method_details($pmid){
global $db, $lang, $sett, $page_tags, $custom, $template;
$pmid=intval($pmid);

$template = new template('paymethod_detail.tpl');
$template->get_cycle('currencies');

$tbl=DB_PREFIX.'paymethods';
$res=$db->query("SELECT pmtitle, long_descript FROM $tbl WHERE pmid = '$pmid' AND enabled = 1") or die($db->error());
$row=$db->fetch_array($res);

 if(! $row['pmtitle']){
 global $template;
 return header404();
 }

$tbl_paymethods_currencies=DB_PREFIX.'paymethods_currencies';
$tbl_currencies=DB_PREFIX.'currencies';
$res=$db->query("SELECT $tbl_paymethods_currencies.currency_id, $tbl_currencies.brief, $tbl_currencies.title FROM $tbl_paymethods_currencies, $tbl_currencies WHERE $tbl_paymethods_currencies.pmid = '$pmid' AND $tbl_currencies.currency_id = $tbl_paymethods_currencies.currency_id AND $tbl_currencies.enabled = 1") or die($db->error());

$page_tags['meta_title']="$lang[pay_method] $row[pmtitle] - $sett[pages_title]";

 while($row2=$db->fetch_array($res)){
 $template->assign_cycle('currency_title', $row2['title']);
 $template->assign_cycle('currency_brief', $row2['brief']);
 $template->next_loop();
 }

$template->out_cycle();

$template->assign('paymethod_title', $row['pmtitle']);
$template->assign('paymethod_long_descript', $row['long_descript']);
$template->assign('paymethods_url', @stdi2("view=pay_methods", "pay_methods/"));

return $template->out_content();
}


}
?>