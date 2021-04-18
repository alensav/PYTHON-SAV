<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/tools');

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $tname = isset($_GET['tname']) ? $_GET['tname'] : '';
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
 $tname=$_POST['tname'];
 }

 if($tname){

  switch($tname){

  case 'phpinfo':
  phpinfo();
  break;

  case 'dbcopy':
  include(INC_DIR."/admin/pages/db_copy_p.php");
  break;

  case 'export_csv':
  include(INC_DIR."/admin/pages/export_csv_p.php");
  break;

  case 'import_csv':
  include(INC_DIR."/admin/pages/import_csv_p.php");
  break;

  case 'import':
  include(INC_DIR."/admin/pages/import_p.php");
  break;

  case 'db_restore':
  include(INC_DIR."/admin/pages/db_restore_p.php");
  break;

  case 'change_prices':
  include(INC_DIR."/admin/pages/change_prices_p.php");
  break;

  }

 }
 else{
 echo <<<HTMLDATA
<br><table class="settbl">
 <tr class="htr">
  <td colspan="2">$lang[tools]</td>
 </tr>

 <tr class="str">
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=dbcopy">$lang[db_copy]</a><br><br></td>
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=db_restore">$lang[db_restore]</a><br><br></td>
 </tr>

 <tr class="ttr">
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=export_csv">$lang[export_csv]</a><br><br></td>
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=import_csv">$lang[import_csv]</a><br><br></td>
 </tr>

 <tr class="str">
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=import&from=light">$lang[import_light]</a><br><br></td>
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=import&from=catalog">$lang[import_catalog]</a><br><br></td>
 </tr>

 <tr class="ttr">
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=import&from=trade">$lang[import_trade]</a><br><br></td>
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=tools&tname=change_prices">$lang[change_prices]</a><br><br></td>
 </tr>

 <tr class="str">
  <td><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=phpinfo&independ=1" target="_blank">$lang[phpinfo]</a><br><br></td>
  <td>&nbsp;</td>
 </tr>

</table>
HTMLDATA;
 }
?>
