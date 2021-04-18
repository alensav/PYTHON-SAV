<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<form method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="changepass">
<input type="hidden" name="savenewlogin" value="1">
<?php
$custom->get_lang('admin_lang/changepass');
if(! empty($_POST['savenewlogin'])){echo $admin_lib->save_newlogin();} ?>
<h3><?php echo $lang['changepass']; ?></h3>
<table width="100%" class="settbl">
<tr class="htr"><td><?php echo $lang['description']; ?></td><td><?php echo $lang['value']; ?></td></tr>
<tr class="ttr"><td><?php echo $lang['new_name']; ?></td><td><input type="text" name="new_admin_name" value="<?php echo isset($_POST['new_admin_name']) ? $_POST['new_admin_name'] : ''; ?>"></td></tr>
<tr class="str"><td><?php echo $lang['old_pass']; ?></td><td><input type="password" name="old_admin_password" value=""></td></tr>
<tr class="ttr"><td><?php echo $lang['new_pass']; ?></td><td><input type="password" name="new_admin_password1" value=""></td></tr>
<tr class="str"><td><?php echo $lang['new_pass_confirm']; ?></td><td><input type="password" name="new_admin_password2" value=""></td></tr>
<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>
<p><?php echo $lang['again_auth']; ?></p>
