<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
global $smtpset;
$smtpset=$custom->get_settings(4);
?>
<form method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="smtp">
<input type="hidden" name="savesmtpsett" value="1">
<?php
$custom->get_lang('admin_lang/smtp');
 if(! empty($_POST['savesmtpsett'])){
  if(! $_POST['new_sett']['pass']){
  $_POST['new_sett']['pass']=$smtpset['pass'];
  }
  elseif($_POST['new_sett']['pass']=='-'){
  $_POST['new_sett']['pass']='';
  }
  else{
  require_once(INC_DIR."/crypt.php");
  $crypting = new crypting;
  $_POST['new_sett']['pass'] = base64_encode($crypting->crypt_data($_POST['new_sett']['pass'], $sett['index_text']));
  }
 echo $admin_lib->save_settings(4, $_POST['new_sett']);
 $smtpset=$custom->get_settings(4);
 unset($_POST['new_sett']);
 $_POST['new_sett']['use_smtp']=$_POST['use_smtp'];
 $sett['use_smtp']=$_POST['use_smtp'];
 $admin_lib->save_settings(2, $_POST['new_sett']);
 }
?>
<h1><?php echo $lang['smtp_settings']; ?></h1>
<?php echo $lang['smtp_prompt']; ?><br><br>
<table width="100%" class="settbl">
<tr class="htr"><td><?php echo $lang['description']; ?></td><td><?php echo $lang['value']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['use_smtp'] . ' ' . custom::contextHelp($lang['use_smtp_help']); ?></td><td><input type="radio" name="use_smtp" value="1"<?php if($sett['use_smtp']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="use_smtp" value="0"<?php if(! $sett['use_smtp']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['host'] . ' ' . custom::contextHelp($lang['host_help']); ?></td><td><input type="text" name="new_sett[host]" value="<?php echo $smtpset['host']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['port'] . ' ' . custom::contextHelp($lang['port_help']); ?></td><td><input type="text" name="new_sett[port]" value="<?php echo $smtpset['port']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php
$helo_help = '';
$server_hostname = '';
 if(! empty($_SERVER['SERVER_ADDR'])){
 $server_hostname = @gethostbyaddr($_SERVER['SERVER_ADDR']);
 }
 if(! empty($_SERVER['SERVER_NAME']) || $server_hostname){
 $helo_help .= '<br>' . $lang['helo_help_example'] . ', ';
 }
 if(! empty($_SERVER['SERVER_NAME'])){
 $helo_help .= $_SERVER['SERVER_NAME'];
 }
 if($server_hostname && $server_hostname != $_SERVER['SERVER_NAME']){
 $helo_help .= ' ' . $lang['helo_help_example_or'] . ' ' . $server_hostname;
 }
echo $lang['helo'] . ' ' . custom::contextHelp($lang['helo_help'] . $helo_help);  
?></td><td><input type="text" name="new_sett[helo]" value="<?php echo $smtpset['helo']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['timeout']; ?></td><td><input type="text" name="new_sett[timeout]" value="<?php echo $smtpset['timeout']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['auth'] . ' ' . custom::contextHelp($lang['auth_help']); ?></td><td><input type="radio" name="new_sett[auth]" value="1"<?php if($smtpset['auth']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[auth]" value="0"<?php if(! $smtpset['auth']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['user'] . ' ' . custom::contextHelp($lang['user_help']); ?></td><td><input type="text" name="new_sett[user]" value="<?php echo $smtpset['user']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pass'] . ' ' . custom::contextHelp($lang['pass_help']); ?></td><td><input type="password" name="new_sett[pass]"></td></tr>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>