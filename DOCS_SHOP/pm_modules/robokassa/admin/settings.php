<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }

global $language, $engineconf;
?>
<form method="POST" action="?">
<input type="hidden" name="pmmod" value="robokassa">
<input type="hidden" name="act" value="settings">
<input type="hidden" name="save_sett" value="1">
<?php

 if(! empty($_POST['save_sett'])){
 $err_code=$rcadmin->updateconfig();
  if($err_code != 1){
  echo "<font class=\"red\">$err_code</font>";
  }
  else{
  echo "<h3>$language[changes_success]</h3>";
  }
 }

$cssclass = 'ttr';
?>
<h3><?php echo $language['robokassa_settings']; ?></h3>

<table width="100%" class="settbl">
<tr class="htr"><td colspan="2"><?php echo $language['paysys_settings']; ?></td></tr>
<tr class="htr"><td><?php echo $language['name']; ?></td><td><?php echo $language['value']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['pass1']; ?></td><td><?php echo $language['pass1_desc']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['pass2']; ?></td><td><?php echo $language['pass2_desc']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Result URL</td><td style="white-space:nowrap;"><?php echo "$engineconf[url]pmmod.php?pmmod=robokassa&act=result&independ=1"; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['result_method']; ?></td><td>POST</td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Success URL</td><td style="white-space:nowrap;"><?php echo "$engineconf[url]pmmod.php?pmmod=robokassa&act=success"; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['success_method']; ?></td><td>POST</td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Fail URL</td><td style="white-space:nowrap;"><?php echo "$engineconf[url]pmmod.php?pmmod=robokassa&act=fail"; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['fail_method']; ?></td><td>POST</td></tr>

</table><br>



<table width="100%" class="settbl">
<tr class="htr"><td colspan="2"><?php echo $language['general_settings']; ?></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['login']; ?></td><td><input type="text" name="conf[login]" value="<?php echo $rcconf['login']; ?>"size="34"></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['pass1']; ?></td><td><input type="password" name="conf[pass1]" value="<?php echo $robokassa->getedd(base64_decode($rcconf['pass1']), 'robokassa') ?>" size="34"></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['pass2']; ?></td><td><input type="password" name="conf[pass2]" value="<?php echo $robokassa->getedd(base64_decode($rcconf['pass2']), 'robokassa') ?>" size="34"></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['lang']; ?></td><td><input type="text" name="conf[lang]" value="<?php echo $rcconf['lang']; ?>" size="2" maxlength="2"></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['server']; ?></td><td><select name="conf[test_srv]"><option value="1"<?php if($rcconf['test_srv']){echo ' selected="selected"';} ?>><?php echo $language['test_server']; ?></option><option value="0"<?php if(! $rcconf['test_srv']){echo ' selected="selected"';} ?>><?php echo $language['work_server']; ?></option></select></td></tr>

</table><br>

<br><input type="submit" value="<?php echo $language['submit']; ?>" class="button1">
</form>
<p><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=pay_methods"><?php echo $language['all_pay_methods']; ?></a></p>