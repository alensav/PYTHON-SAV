<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}

$custom->get_lang('admin_lang/import');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $from=$_GET['from'];
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $from=$_POST['from'];
 }

$from = preg_replace("([^a-zA-Z0-9\_])", '', $from);

global $from_options;
$from_options = array();

 switch($from){

 case 'light':
 $from_options['title'] = 'Light';
 $from_options['def_db_prefix'] = 'aslt_';
 break;

 case 'trade':
 $from_options['title'] = 'Trade';
 $from_options['def_db_prefix'] = 'arwt_';
 break;

 case 'catalog':
 $from_options['title'] = 'Catalog';
 $from_options['def_db_prefix'] = 'arwc_';
 break;

 default: exit;
 }


 if(isset($_POST['act']) && $_POST['act'] == 'do_import'){
 echo do_import($from);
 }

function do_import($from){
global $db, $admin_lib, $lang, $from_options, $custom, $sett;

 if(empty($db->handler) || empty($db->dbname)){
 die('Invalid db handler or db name (1)!'); 
 }

$_POST['sql_host']=trim($_POST['sql_host']);
$_POST['sql_username']=trim($_POST['sql_username']);
$_POST['sql_password']=trim($_POST['sql_password']);
$_POST['sql_db_name']=trim($_POST['sql_db_name']);
$_POST['sql_db_prefix']=preg_replace("([^a-zA-Z0-9\_])", '', $_POST['sql_db_prefix']);

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$d2b_from = new db;
$from_db_conn = array();

 if(! empty($_POST['use_this_db'])){

 $d2b_from->handler = $db->handler;
 $d2b_from->dbname = $db->dbname;

 }
 else{

 $from_db_conn['host'] = $_POST['sql_host'];
 $from_db_conn['user'] = $_POST['sql_username'];
 $from_db_conn['psw'] = $_POST['sql_password'];
 $from_db_conn['dbname'] = $_POST['sql_db_name'];
 $from_db_conn['mysql_charset'] = $_POST['database_charset'];

 @$d2b_from->connect($from_db_conn);

  if(empty($d2b_from->handler)){
  return "<font class=\"red\">$lang[cannot_conn_to_sqlserver] \"$_POST[sql_host]\" $lang[with_the_use_username] \"$_POST[sql_username]\" $lang[and_password] \"$_POST[sql_password]\". $lang[check_sqlservername]</font><br>";
  }

  if(! $d2b_from->select_db($from_db_conn['dbname'])){
  return "<span class=\"red\">$lang[cannot_conn_to_db] \"$from_db_conn[dbname]\". $lang[check_sqldbname]</span><br>";
  }


 }





 if($from==='light'){

 $from_tbl_sections = $_POST['sql_db_prefix'].'sections';
 $from_tbl_sections_exists = 0;
 $from_tbl_goods = $_POST['sql_db_prefix'].'goods';
 $from_tbl_goods_exists = 0;
 $res = $d2b_from->query("SHOW TABLES FROM `$d2b_from->dbname`", $d2b_from->handler) or die($d2b_from->error());

  while($row=$d2b_from->fetch_array($res)){
  if($row[0] === $from_tbl_sections){$from_tbl_sections_exists = 1;}
  if($row[0] === $from_tbl_goods){$from_tbl_goods_exists = 1;}
  }

 $err_tbl_exists = '';
 if(! $from_tbl_sections_exists){$err_tbl_exists.="$from_tbl_sections";}
 if(! $from_tbl_goods_exists){$err_tbl_exists.="<br>$from_tbl_goods";}
  if($err_tbl_exists){
  return "<font class=\"red\">$lang[cant_find_tables] \"$d2b_from->dbname\":<br>$err_tbl_exists<br>$lang[check_prefix] &quot;$from_options[title]&quot;</font><br>";
  }

 }
 elseif($from==='trade' || $from==='catalog'){

 $from_tbl_categories = $_POST['sql_db_prefix'].'categories';
 $from_tbl_categories_exists = 0;
 $from_tbl_items = $_POST['sql_db_prefix'].'items';
 $from_tbl_items_exists = 0;
 $from_tbl_news = $_POST['sql_db_prefix'].'news';
 $from_tbl_news_exists = 0;
 $res = $d2b_from->query("SHOW TABLES FROM `$d2b_from->dbname`", $d2b_from->handler) or die($d2b_from->error());

  while($row=$d2b_from->fetch_array($res)){
  if($row[0] === $from_tbl_categories){$from_tbl_categories_exists = 1;}
  if($row[0] === $from_tbl_items){$from_tbl_items_exists = 1;}
  if($row[0] === $from_tbl_news){$from_tbl_news_exists = 1;}
  }

 $err_tbl_exists = '';
 if(! $from_tbl_categories_exists){$err_tbl_exists.="$from_tbl_categories";}
 if(! $from_tbl_items_exists){$err_tbl_exists.="<br>$from_tbl_items";}
 if(! $from_tbl_news_exists){$err_tbl_exists.="<br>$from_tbl_news";}
  if($err_tbl_exists){
  return "<font class=\"red\">$lang[cant_find_tables] \"$d2b_from->dbname\":<br>$err_tbl_exists<br>$lang[check_prefix] &quot;$from_options[title]&quot;</font><br>";
  }

 }







require_once(INC_DIR."/admin/ed_cat.php");
$ed_category = new ed_category;
$ed_category->delete_all_categories_and_items();







 if($from==='trade' || $from==='catalog'){


  if($from==='trade'){

  require_once(INC_DIR."/admin/users.php");
  $users = new users;
  $tbl_users=DB_PREFIX.'users';
  $res = $db->query("SELECT userid FROM `$db->dbname`.$tbl_users", $db->handler) or die($db->error($db->handler));
   while($row=$db->fetch_array($res)){
   $users->delete_user($row['userid']);
   }

  $tbl_users_groups=DB_PREFIX.'users_groups';
  $db->query("DELETE FROM `$db->dbname`.$tbl_users_groups", $db->handler) or die($db->error($db->handler));
 
 
  $tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';
  $db->query("DELETE FROM `$db->dbname`.$tbl_users_groups_discounts", $db->handler) or die($db->error($db->handler));
 

  require_once(INC_DIR."/admin/orders.php");
  $orders = new orders(0);
  $tbl_orders=DB_PREFIX.'orders';
  $res = $db->query("SELECT orderid FROM `$db->dbname`.$tbl_orders", $db->handler) or die($db->error($db->handler));
   while($row=$db->fetch_array($res)){
   $orders->delete_order($row['orderid']);
   }


  $from_tbl_users=$_POST['sql_db_prefix'].'users';
  $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$from_tbl_users", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
   while($row=$d2b_from->fetch_array($res)){
   $row = $custom->addslashes_array($row);
   $db->query("INSERT INTO `$db->dbname`.$tbl_users (userid, username, pwd, groupid, email, regdate, first_name, last_name, patronymic, company, country, city, address, zip_code, phone) VALUES($row[userid], '$row[username]', '$row[pwd]', $row[groupid], '$row[email]', $row[regdate], '$row[first_name]', '$row[last_name]', '$row[patronymic]', '$row[company]', '$row[country]', '$row[city]', '$row[address]', '$row[zip_code]', '$row[phone]')", $db->handler) or die($db->error($db->handler));
   }





  $from_tbl_settings=$_POST['sql_db_prefix'].'settings';
  $res = $d2b_from->query("SELECT setvalue FROM `$d2b_from->dbname`.$from_tbl_settings WHERE type = 2 AND setname = 'minimum_order_sum'", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  $row=$db->fetch_array($res);
  $from_min_order_sum=pricef($row['setvalue']);
 
  $from_tbl_users_groups=$_POST['sql_db_prefix'].'users_groups';
  $tbl_users_groups=DB_PREFIX.'users_groups';
  $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$from_tbl_users_groups", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
   while($row=$d2b_from->fetch_array($res)){
   $row = $custom->addslashes_array($row);
   $row['autochgroup'] = intval($row['autochgroup']);
   if(! $row['autochgroup_sum']){$row['autochgroup_sum']='9999999999999.99';}
   $db->query("INSERT INTO `$db->dbname`.$tbl_users_groups (groupid, groupname, min_order_sum, descript, autochgroup, autochgroup_sum, sortid) VALUES($row[groupid], '$row[groupname]', '$from_min_order_sum', '$row[descript]', $row[autochgroup], '$row[autochgroup_sum]', 0)", $db->handler) or die($db->error($db->handler));
   }





  $tbl_users_groups=$_POST['sql_db_prefix'].'users_groups';
  $tbl_users_groups_discounts=DB_PREFIX.'users_groups_discounts';
  $res = $d2b_from->query("SELECT groupid, discount FROM `$d2b_from->dbname`.$tbl_users_groups", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
   while($row=$d2b_from->fetch_array($res)){
    if($row['discount'] > 0){
    $db->query("INSERT INTO `$db->dbname`.$tbl_users_groups_discounts (did, groupid, order_sum, discount) VALUES (NULL, $row[groupid], '0.00', '$row[discount]')", $db->handler) or die($db->error($db->handler));
    }
   }


  require_once(INC_DIR."/shop.php");
  $shop=new shop;
  $from_tbl_orders=$_POST['sql_db_prefix'].'orders';
  $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$from_tbl_orders", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
   while($row=$d2b_from->fetch_array($res)){
   $row['total_pc'] = calc_pcprice($row['total'], $row['currency_course']);
   $row['discount_pc'] = calc_pcprice($row['discount'], $row['currency_course']);
   $row['total_with_discount_pc'] = calc_pcprice($row['total_with_discount'], $row['currency_course']);
   $row['delivery_cost_pc'] = calc_pcprice($row['delivery_cost'], $row['currency_course']);
   $row['final_total_pc'] = $row['final_total'];
   $row['final_total'] = $row['total_with_delivery'];
   $row = $custom->addslashes_array($row);
   $row['pmid'] = isset($row['pmid']) ? intval($row['pmid']) : 0;
   $row['dmid'] = isset($row['dmid']) ? intval($row['dmid']) : 0;
   $row['def_currency_id'] = isset($row['def_currency_id']) ? intval($row['def_currency_id']) : 0;
   $row['country_id'] = isset($row['country_id']) ? intval($row['country_id']) : 0;
   $db->query("INSERT INTO `$db->dbname`.$tbl_orders (orderid, date, status, pmid, paymethod_advname, paymethod, currency_id, currency, currency_brief, currency_course, def_currency_id, def_currency, def_currency_brief, total, total_pc, discount_percents, discount, discount_pc, total_with_discount, total_with_discount_pc, delivery_cost, delivery_cost_pc, final_total, final_total_pc, dmid, deliverymethod, userid, username, first_name, last_name, patronymic, company, country_id, country, city, address, zip_code, phone, email, comment, adm_pub_comment, admin_comment) VALUES('$row[orderid]', '$row[date]', '$row[status]', '$row[pmid]', '$row[paymethod_advname]', '$row[paymethod]', '$row[currency_id]', '$row[currency]', '$row[currency_brief]', '$row[currency_course]', '$row[def_currency_id]', '$row[def_currency]', '$row[def_currency_brief]', '$row[total]', '$row[total_pc]', '$row[discount_percents]', '$row[discount]', '$row[discount_pc]', '$row[total_with_discount]', '$row[total_with_discount_pc]', '$row[delivery_cost]', '$row[delivery_cost_pc]', '$row[final_total]', '$row[final_total_pc]', '$row[dmid]', '$row[deliverymethod]', '$row[userid]', '$row[username]', '$row[first_name]', '$row[last_name]', '$row[patronymic]', '$row[company]', '$row[country_id]', '$row[country]', '$row[city]', '$row[address]', '$row[zip_code]', '$row[phone]', '$row[email]', '$row[comment]', '$row[adm_pub_comment]', '$row[admin_comment]')", $db->handler) or die($db->error($db->handler));
  
    $from_tbl_orders_items=$_POST['sql_db_prefix'].'orders_items';
    $tbl_orders_items=DB_PREFIX.'orders_items';
    $res2 = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$from_tbl_orders_items WHERE orderid = $row[orderid]", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
     while($row2=$d2b_from->fetch_array($res2)){
     $row2['price_pc'] = calc_pcprice($row2['price'], $row['currency_course']);
     $row2 = $custom->addslashes_array($row2);
     $db->query("INSERT INTO `$db->dbname`.$tbl_orders_items (orderid, itemid, sku, title, price, price_pc, quantity, options) VALUES($row2[orderid], $row2[itemid], '$row2[sku]', '$row2[title]', '$row2[price]', '$row2[price_pc]', $row2[quantity], '')", $db->handler) or die($db->error($db->handler));
     }
  
   }

  }




 $tbl_content=DB_PREFIX.'content';
 $db->query("DELETE FROM `$db->dbname`.$tbl_content", $db->handler) or die($db->error($db->handler));


  $tbl_news=DB_PREFIX.'news';
  $db->query("DELETE FROM `$db->dbname`.`$tbl_news`", $db->handler) or die($db->error($db->handler));


 $from_tbl_content=$_POST['sql_db_prefix'].'content';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$from_tbl_content", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);
  $db->query("INSERT INTO `$db->dbname`.$tbl_content (pname, menutitle, title, description, keywords, metatags, special, text, sortid) VALUES('$row[pname]', '$row[menutitle]', '$row[title]', '$row[description]', '$row[keywords]', '$row[metatags]', '$row[special]', '$row[text]', $row[sortid])", $db->handler) or die($db->error($db->handler));
  }



 $from_tbl_mainitems=$_POST['sql_db_prefix'].'mainitems';
 $tbl_mainitems=DB_PREFIX.'mainitems';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$from_tbl_mainitems", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);
  $db->query("INSERT INTO `$db->dbname`.$tbl_mainitems (main_itemid, main_sortid) VALUES($row[main_itemid], $row[main_sortid])", $db->handler) or die($db->error($db->handler));
  }



 $from_tbl_news=$_POST['sql_db_prefix'].'news';
 $tbl_news=DB_PREFIX.'news';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.`$from_tbl_news`", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);
   if(! isset($row['menu_text'])){
   $row['menu_text'] = '';
   }
  $db->query("INSERT INTO `$db->dbname`.`$tbl_news` (`newsid`, `newsname`, `date`, `title`, `menu_text`, `text`, `meta_title`, `meta_description`, `meta_keywords`, `meta_tags`) VALUES($row[newsid], 'nid$row[newsid]', '$row[date]', '$row[title]', '$row[menu_text]', '$row[text]', '', '', '', '')", $db->handler) or die($db->error($db->handler));
  }




 }










$tbl=DB_PREFIX.'categories';

 if($from==='light'){

 $tbl_from = $_POST['sql_db_prefix'].'sections';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$tbl_from WHERE sectionuid <> 0", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);
  $db->query("INSERT INTO `$db->dbname`.$tbl (catid, fcatname, parent, title, description, image, menu_img, main_img, count, meta_title, meta_description, keywords, metatags, special, fulltitle, sortid) VALUES ($row[sectionuid], '$row[sectionuid]', 0, '$row[title]', '', '', '','', 0, '', '', '', '', '', '$row[title]', 0)", $db->handler) or die($db->error($db->handler));
  }

 }
 elseif($from==='trade' || $from==='catalog'){

 $tbl_from = $_POST['sql_db_prefix'].'categories';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$tbl_from", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);


   if($row['catid'] == 0){
   $db->query("UPDATE `$db->dbname`.$tbl SET title = '$row[title]', description = '$row[special]', meta_title = '$row[meta_title]', meta_description = '$row[description]', keywords = '$row[keywords]', metatags = '$row[metatags]' WHERE catid = 0", $db->handler) or die($db->error($db->handler));
   }
   else{
   $db->query("INSERT INTO `$db->dbname`.$tbl (catid, fcatname, parent, title, description, image, menu_img, main_img, count, meta_title, meta_description, keywords, metatags, special, fulltitle, sortid) VALUES ($row[catid], '$row[catid]', $row[parent], '$row[title]', '$row[special]', '', '', '', 0, '$row[meta_title]', '$row[description]', '$row[keywords]', '$row[metatags]', '', '$row[fulltitle]', $row[sortid])", $db->handler) or die($db->error($db->handler));
   }

  }

 }



upd2_2_cat_names();



$tbl_items=DB_PREFIX.'items';
$tbl_item_categories=DB_PREFIX.'item_categories';

 if($from==='light'){

 $tbl_from = $_POST['sql_db_prefix'].'goods';
 $res=$d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$tbl_from", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);

  $db->query("INSERT INTO `$db->dbname`.$tbl_items (itemid, itemname, catid, mnf_id, sku, title, price, old_price, quantity, quantity_txt, short_descript, long_descript, small_img, big_img, add_date, upd_date, meta_title, description, keywords, metatags, special, visible) VALUES($row[productuid], '$row[productuid]', $row[sectionuid], 0, '', '$row[title]', '$row[pr_price]', '0.00', 4294967295, '', '$row[pr_descript]', '$row[pr_descript]', '$row[little_image]', '$row[large_image]', '" .time(). "', '" .time(). "', '', '', '', '', '', 1)", $db->handler) or die($db->error($db->handler));

  $db->query("INSERT INTO `$db->dbname`.$tbl_item_categories (catid, itemid, sortid) VALUES ($row[sectionuid], $row[productuid], 0)", $db->handler) or die($db->error($db->handler));

  }

 }
 elseif($from==='trade' || $from==='catalog'){

 $tbl_from = $_POST['sql_db_prefix'].'items';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$tbl_from", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);

  $db->query("INSERT INTO `$db->dbname`.$tbl_items (itemid, itemname, catid, mnf_id, sku, title, price, old_price, quantity, quantity_txt, short_descript, long_descript, small_img, big_img, add_date, upd_date, meta_title, description, keywords, metatags, special, visible) VALUES($row[itemid], '$row[itemid]', $row[catid], 0, '$row[sku]', '$row[title]', '$row[price]', '$row[old_price]', $row[quantity], '', '$row[short_descript]', '$row[long_descript]', '$row[small_img]', '$row[big_img]', '$row[add_date]', '$row[upd_date]', '', '$row[description]', '$row[keywords]', '$row[metatags]', '$row[special]', $row[visible])", $db->handler) or die($db->error($db->handler));

  $db->query("INSERT INTO `$db->dbname`.$tbl_item_categories (catid, itemid, sortid) VALUES ($row[catid], $row[itemid], $row[sortid])", $db->handler) or die($db->error($db->handler));

  }

 }








 if($from==='trade' || $from==='catalog'){
 $tbl_gallery=DB_PREFIX.'gallery';
 $tbl_from = $_POST['sql_db_prefix'].'gallery';
 $res = $d2b_from->query("SELECT * FROM `$d2b_from->dbname`.$tbl_from", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
  while($row=$d2b_from->fetch_array($res)){
  $row = $custom->addslashes_array($row);
  $db->query("INSERT INTO `$db->dbname`.$tbl_gallery(imgid, itemid, small_img, big_img, alt) VALUES($row[imgid], $row[itemid], '$row[small_img]', '$row[big_img]', '$row[alt]')", $db->handler) or die($db->error($db->handler));
  }
 }






 if($from==='trade' || $from==='catalog'){
 $tbl_from = $_POST['sql_db_prefix'].'settings';
 $res = $d2b_from->query("SELECT `setvalue` FROM `$d2b_from->dbname`.`$tbl_from` WHERE `type` = 2 AND `setname` = 'static_urls'", $d2b_from->handler) or die($d2b_from->error($d2b_from->handler));
 $row = $d2b_from->fetch_array($res);
  if($row['setvalue'] && ! isset($sett['old_static'])){
  $tbl_settings=DB_PREFIX.'settings';
  $db->query("INSERT INTO `$db->dbname`.`$tbl_settings`(`type`, `setname`, `setvalue`) VALUES(2, 'old_static', '1')", $db->handler) or die($db->error($db->handler));
  }
 }









$ed_category->update_totalitemcount(0);


 if($d2b_from->handler !== $db->handler){
 $d2b_from->close_connection();
 }

return "<h3>$lang[import_completed]</h3>";
}




function calc_pcprice($price, $currency_course){
$new_price = pricef($price / $currency_course);
 if($price > 0 && $new_price < 0.01){
 $new_price = '0.01';
 }
return $new_price;
}



function upd2_2_cat_names(){
global $db;
$tbl=DB_PREFIX.'categories';
$categories=array();
upd2_2_get_categories_arr($categories);
 if(sizeof($categories)){
  foreach($categories as $catid => $cat_arr){
  $fullcatname=upd2_2_gen_fullcatname($catid, $categories);
  $db->query("UPDATE `$db->dbname`.`$tbl` SET `fcatname` = '$fullcatname' WHERE `catid` = $catid ", $db->handler) or die($db->error($db->handler));
  }
 }
unset($categories);
}


function upd2_2_get_categories_arr(&$categories){
global $db;
$tbl=DB_PREFIX.'categories';
$res = $db->query("SELECT catid, fcatname, parent FROM `$db->dbname`.`$tbl` WHERE catid <> 0 ORDER BY sortid, title", $db->handler) or die($db->error($db->handler));
 while($row=$db->fetch_array($res)){
 $categories["$row[catid]"]['parent']=$row['parent'];
 }
}


function upd2_2_gen_fullcatname($catid, $categories){
$parents_arr=array();
upd2_2_get_all_parents($catid, $parents_arr, $categories);
$ret='';
 if(sizeof($parents_arr)){
  foreach($parents_arr as $parent){
  $ret="$parent/".$ret;
  }
 }
$ret.="$catid";
return $ret;
}


function upd2_2_get_all_parents($cat, &$parents_arr, $categories){
$def_parent=0;
$row=array();
$row['parent']=$cat;

 while($row['parent']> 0){
 $row=$categories["$row[parent]"];

  if($row['parent'] > 0){
  array_push($parents_arr, $row['parent']);
  $def_parent=$row['parent'];
  $row['parent']=upd2_2_get_all_parents($row['parent'], $parents_arr, $categories);
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


?>
<h3><?php echo "$lang[import_from] &quot;$from_options[title]&quot;"; ?></h3><form name="frm" action="?" method="POST" onsubmit="document.frm.submit.disabled=true;">
<input type="hidden" name="view" value="tools">
<input type="hidden" name="tname" value="import">
<input type="hidden" name="from" value="<?php echo $from; ?>">
<input type="hidden" name="act" value="do_import">
<input type="hidden" name="database_charset" value="utf8">

<p><?php $import_info = $from.'_import_info'; echo $lang["$import_info"]; ?></p>

<table width="100%" class="settbl">
 <tr class="htr">
  <td colspan="2"><?php echo "$lang[fill_conndata] &quot;$from_options[title]&quot;"; ?></td>
 </tr>

 <tr class="str">
  <td colspan="2"><input type="checkbox" name="use_this_db"<?php if(! empty($_POST['use_this_db'])){echo ' checked';} ?> onclick="if(this.checked){document.frm.sql_host.disabled=true;document.frm.sql_username.disabled=true;document.frm.sql_password.disabled=true;document.frm.sql_db_name.disabled=true;}else{document.frm.sql_host.disabled=false;document.frm.sql_username.disabled=false;document.frm.sql_password.disabled=false;document.frm.sql_db_name.disabled=false;}"><?php echo "$lang[by_version] &quot;$from_options[title]&quot; $lang[use_this_db]"; ?></td>
 </tr>

 <tr class="ttr">
  <td><?php echo $lang['sql_host']; ?></td>
  <td><input type="text" name="sql_host" value="<?php echo isset($_POST['sql_host']) ? $_POST['sql_host'] : ''; ?>"></td>
 </tr>

 <tr class="str">
  <td><?php echo $lang['sql_username']; ?></td>
  <td><input type="text" name="sql_username" value="<?php echo isset($_POST['sql_username']) ? $_POST['sql_username'] : ''; ?>"></td>
 </tr>

 <tr class="ttr">
  <td><?php echo $lang['sql_password']; ?></td>
  <td><input type="text" name="sql_password" value="<?php echo isset($_POST['sql_password']) ? $_POST['sql_password'] : ''; ?>"></td>
 </tr>

 <tr class="str">
  <td><?php echo $lang['sql_db_name']; ?></td>
  <td><input type="text" name="sql_db_name" value="<?php echo isset($_POST['sql_db_name']) ? $_POST['sql_db_name'] : ''; ?>"></td>
 </tr>

 <tr class="ttr">
  <td><?php echo $lang['sql_db_prefix']; ?></td>
  <td><input type="text" name="sql_db_prefix" value="<?php if(! empty($_POST['sql_db_prefix'])){echo $_POST['sql_db_prefix'];}elseif($_SERVER['REQUEST_METHOD'] === 'GET'){echo $from_options['def_db_prefix'];} ?>"></td>
 </tr>

<?php

?>

 <tr class="ftr">
  <td colspan="2"><br><input type="submit" name="submit" value="<?php echo $lang['do_import']; ?>" class="button1"></td>
 </tr>

</table></form>