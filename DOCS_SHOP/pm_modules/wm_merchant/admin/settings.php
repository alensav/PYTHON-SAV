<?php
// Copyright (c) Igor Anikeev http://www.arwshop.ru/ 

 // Если файл загружен не из движка - завершаем программу
 if(! defined('SYS_LOADER')){
 die();
 }

global $language, $engineconf;
?>
<form method="POST" action="?">
<input type="hidden" name="pmmod" value="wm_merchant">
<input type="hidden" name="act" value="settings">
<input type="hidden" name="savewmmerchantsett" value="1">
<?php

 if(! empty($_POST['savewmmerchantsett'])){
 $err_code=$wmmadmin->updateconfig();
  if($err_code != 1){
  echo "<font class=\"red\">$err_code</font>";
  }
  else{
  echo "<h3>$language[changes_success]</h3>";
  }
 }
?>
<h1><?php echo $language['wm_merchant_settings']; ?></h1>

<?php
//функция hash доступна с версии PHP 5.1.2
$required_php_version = '5.1.2';
 if(version_compare(phpversion(), $required_php_version) < 0){
 $language['php_version_info'] = str_replace('%version%', $required_php_version, $language['php_version_info']);
 echo "<p class=\"red\">$language[php_version_info] " . phpversion() . '.</p>';
 }
$cssclass = 'ttr';
?>

<p><?php echo $language['wm_merchant_info']; ?></p>

<table width="100%" class="settbl">
<tr class="htr"><td colspan="2"><?php echo $language['purses_settings']; ?></td></tr>
<tr class="htr"><td><?php echo $language['name']; ?></td><td><?php echo $language['value']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['auction_name']; ?></td><td><?php echo $language['your_auction_name']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Secret Key</td><td><?php echo $language['key_is_recommended']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['send_secret_key']; ?></td><td><?php echo $language['no']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Result URL</td><td style="white-space:nowrap;"><?php echo "$engineconf[url]pmmod.php?pmmod=wm_merchant&act=result&independ=1"; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['params_in_preliminary_query']; ?></td><td><?php echo $language['yes']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Success URL</td><td style="white-space:nowrap;"><?php echo "$engineconf[url]pmmod.php?pmmod=wm_merchant&act=success"; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['success_method']; ?></td><td>POST</td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td>Fail URL</td><td style="white-space:nowrap;"><?php echo "$engineconf[url]pmmod.php?pmmod=wm_merchant&act=fail"; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['fail_method']; ?></td><td>POST</td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['use_form_urls']; ?></td><td><?php echo $language['no']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['err_notification_to_keeper']; ?></td><td><?php echo $language['at_pleasure']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['signature_method']; ?></td><td>SHA256</td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['test_working_mode']; ?></td><td><?php echo $language['working_mode']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['activity']; ?></td><td><?php echo $language['on']; ?></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td colspan="2" align="center"><br><?php echo $language['other_settings_default']; ?><br><br></td></tr>

</table><br>



<table width="100%" class="settbl">
<tr class="htr"><td colspan="2"><?php echo $language['general_settings']; ?></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['secret_key']; ?></td><td><?php if($wmconf['msk']){echo $language['secret_key_is_set'];}else{echo "<font class=\"red\">$language[secret_key_is_not_set]</font>";}echo '<br>'; ?><input type="password" name="secret_key" size="34"></td></tr>

<tr class="<?php if($cssclass=='str'){$cssclass='ttr';}else{$cssclass='str';} echo $cssclass; ?>"><td><?php echo $language['test_mode']; ?></td><td><input type="radio" name="new_conf[test_mode]" value="1"<?php if($wmconf['test_mode']){echo ' checked';} ?>> <?php echo $language['yes']; ?> &nbsp; <input type="radio" name="new_conf[test_mode]" value="0"<?php if(! $wmconf['test_mode']){echo ' checked';} ?>> <?php echo $language['no']; ?></td></tr>

</table><br>

<?php echo $wmmadmin->pursesconf(); ?>

<p><?php echo $language['purses_info']; ?></p>

<br><input type="submit" value="<?php echo $language['submit']; ?>" class="button1">
</form>
<p><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=settings&settype=pay_methods"><?php echo $language['all_pay_methods']; ?></a></p>