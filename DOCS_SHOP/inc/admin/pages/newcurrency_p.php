<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<h3><?php echo $lang['add_currency']; ?></h3>
<form method="POST" action="?">
<input type="hidden" name="view" value="currencies">
<input type="hidden" name="add_newcurrency" value="save">
<table width="100%" class="settbl">
<tr class="htr"><td align="center"><?php echo $lang['currency_name']; ?></td><td align="center"><?php echo $lang['short_denotation']; ?></td><td align="center"><?php echo $lang['currency_course']; ?></td><td align="center">ISO 3166 alpha</td><td align="center">ISO 4217 numeric</td></tr>

<tr class="ttr">

<td align="center"><input type="text" name="new_currency_title" size="20"></td>

<td align="center"><input type="text" name="new_currency_brief" size="12" maxlength="10"></td>

<td align="center"><input type="text" name="new_currency_course"></td>

<td align="center"><input type="text" name="new_currency_iso_alpha" size="5" maxlength="3"></td>

<td align="center"><input type="text" name="new_currency_iso_numeric" size="5" maxlength="3"></td>

</tr>

<tr class="ftr"><td colspan="5" align="center"><br><input type="submit" value="<?php echo $lang['add_currency']; ?>" class="button1"></td></tr>
</table>
</form>
