<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/currencies');
require_once(INC_DIR."/admin/adm_currencies.php");
$adm_currencies=new adm_currencies;
 if( (isset($_GET['add_newcurrency']) && $_GET['add_newcurrency'] == '1') || (isset($_POST['add_newcurrency']) && $_POST['add_newcurrency'] == 'save') ){
  if(! empty($_POST['add_newcurrency']) && $_POST['add_newcurrency'] == 'save'){
  echo $adm_currencies->add_currency();
  }
 include(INC_DIR."/admin/pages/newcurrency_p.php");
 }
 if(! empty($_GET['act']) && $_GET['act'] == 'del_currency'){
 echo $adm_currencies->delete_currency($_GET['curr_id']);
 }
?>
<h1><?php echo $lang['currencies']; ?></h1>
<form name="curfrm" method="POST" action="?">
<input type="hidden" name="view" value="currencies">
<input type="hidden" name="savecurrencies" value="1">
<?php if(! empty($_POST['savecurrencies'])){echo $adm_currencies->save_currencies();} ?>
<table width="100%" class="settbl">
<tr class="htr"><td align="center"><?php echo $lang['currency_name']; ?></td><td align="center"><?php echo $lang['short_denotation']; ?></td><td align="center"><?php echo $lang['currency_course']; ?></td><td align="center">ISO 3166 alpha</td><td align="center">ISO 4217 numeric</td><td align="center"><?php echo $lang['def_currency']; ?></td><td align="center"><?php echo $lang['enabled']; ?></td><td align="center"><?php echo $lang['delete']; ?></td></tr>
<?php echo $adm_currencies->currencies_form(); ?>
<tr class="ftr"><td colspan="8"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=currencies&add_newcurrency=1"><?php echo $lang['add_currency']; ?></a></p>
