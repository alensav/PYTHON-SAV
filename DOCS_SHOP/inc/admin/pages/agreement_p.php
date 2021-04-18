<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/agreement');
 if(! empty($_POST['save'])){
  if(! empty($_POST['auto_br_agreement'])){
  $_POST['agreement'] = nl2br($_POST['agreement'], false);
  }
 $err_code=$admin_lib->save_txtsettings(array('agreement' => $_POST['agreement']));
  if($err_code==1){
  echo "<h3>$lang[changes_success]</h3>";
  }
  else{
  echo "<h3>$err_code</h3>";
  }
 }
?>
<form name="frm" METHOD="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="agreement">
<input type="hidden" name="save" value="1">
<?php

echo <<<HTMLDATA
<center>
<br><table class="settbl" border="0">

<tr class="htr">
<td>$lang[agreement]</td>
</tr>

<tr class="ttr">
<td>$lang[this_agreement_in_orderform]</td>
</tr>

<tr class="str">
<td align="center">
<textarea id="agreement" name="agreement" cols="70" rows="22">
HTMLDATA;
echo $custom->get_txtsettings('agreement');
echo <<<HTMLDATA
</textarea><div id="auto_br_agreement"><input type="checkbox" name="auto_br_agreement">$lang[auto_br]</div>
</tr>

<tr class="ftr"><td align="center"><br><input type="submit" value="$lang[submit]" class="button1"> <input type="reset" value="$lang[reset]" class="button1"></td></tr>
</table>
</center>
</form>
HTMLDATA;
if($admset['wysiwyg']){echo $editor->init_js(array('agreement'));}
?>
