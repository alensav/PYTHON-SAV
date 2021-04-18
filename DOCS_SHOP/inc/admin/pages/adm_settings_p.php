<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<form name="frm" method="POST" action="?" enctype="multipart/form-data">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="adminconfig">
<input type="hidden" name="saveadminconfigsett" value="1">
<?php
$custom->get_lang('admin_lang/adm_settings');
 if(! empty($_POST['saveadminconfigsett'])){
 echo uploadWatermark();
 echo $admin_lib->save_settings(1, $_POST['new_sett']);
 $admset = $custom->get_settings(1);
 }

function uploadWatermark(){
global $lang, $admset;
$err = '';
 if(! isset($admset['watermark_format']) || ! preg_match('/^(gif|jpg|jpeg|jfif|png)$/i', $admset['watermark_format'])){
 $admset['watermark_format'] = '';
 }
 if(! empty($_POST['delete_watermark'])){
 $err .= deleteWatermark();
 }
require_once(INC_DIR."/upload.php");
$upload = new upload;
 if($upload->is_upload_file('watermark_file')){
  require_once(INC_DIR."/img_types.php");
  if(! $upload->is_allowed_filetype('watermark_file', $allow_imgtypes)){
  $err .= "$lang[allow_imgtypes] " .implode(' ', $allow_imgtypes). '<br>';
  }
  if(! $upload->is_allowed_expansion('watermark_file', $allow_imgexpansions)){
  $err .= "$lang[allow_expansions] " .implode(' ', $allow_imgexpansions). '<br>';
  }
  if($err){
  return msg::error($err);
  }
  deleteWatermark();
  if(! $upload->upload_file('watermark_file', SCRIPTCHF_DIR.'/img', 'watermark'.strtolower($upload->get_expansion($upload->user_filename('watermark_file'))))){
  $err .= "$lang[cannot_upload_file] &quot;".$upload->user_filename('watermark_file')."&quot;. $lang[error_descript] ($upload->error_code): $upload->error_descript.<br>";
  }
 $_POST['new_sett']['watermark_format'] = substr(strtolower($upload->get_expansion($upload->user_filename('watermark_file'))), 1);
 }
 if($err){
 return msg::error($err);
 }
}

function deleteWatermark(){
global $admset, $lang;
 if(empty($admset['watermark_format'])){
 return false;
 }
$_POST['new_sett']['watermark_format'] = '';
 if(file_exists(SCRIPTCHF_DIR."/img/watermark.$admset[watermark_format]")){
  if(! @unlink(SCRIPTCHF_DIR."/img/watermark.$admset[watermark_format]")){
  return "$lang[cant_delete_file] \"" . SCRIPTCHF_DIR."/img/watermark.$admset[watermark_format]" .'"<br>';
  }
 }
}
?>
<h1><?php echo $lang['admin_config']; ?></h1>
<table width="100%" class="settbl">
<tr class="htr"><td><?php echo $lang['description']; ?></td><td><?php echo $lang['value']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['orders_recordsonpage']; ?></td><td><input type="text" name="new_sett[orders_recordsonpage]" value="<?php echo $admset['orders_recordsonpage']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['stat_ordersonpage']; ?></td><td><input type="text" name="new_sett[stat_ordersonpage]" value="<?php echo $admset['stat_ordersonpage']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['users_recordsonpage']; ?></td><td><input type="text" name="new_sett[users_recordsonpage]" value="<?php echo $admset['users_recordsonpage']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['qpnewpcom']; ?></td><td><input type="text" name="new_sett[qpnewpcom]" value="<?php echo isset($admset['qpnewpcom']) ? $admset['qpnewpcom'] : ''; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['visitlog_recordsonpage']; ?></td><td><input type="text" name="new_sett[visitlog_recordsonpage]" value="<?php echo $admset['visitlog_recordsonpage']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['notify_ch_status']; ?></td><td><input type="radio" name="new_sett[notify_ch_status]" value="1"<?php if($admset['notify_ch_status']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[notify_ch_status]" value="0"<?php if(! $admset['notify_ch_status']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<?php
 if(! empty($admset['wysiwyg']) && $admset['wysiwyg'] != 'tinymce' && $admset['wysiwyg'] != 'tinymce3'){
 $admset['wysiwyg'] = 'tinymce';
 }
?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['use_wysiwyg'];  ?></td><td>
<select name="new_sett[wysiwyg]">
<option value=""><?php echo $lang['disable_wysiwyg']; ?></option>
<option value="tinymce"<?php if($admset['wysiwyg']=='tinymce'){echo ' selected="selected"';} ?>><?php echo $lang['tinymce']; ?></option>
<option value="tinymce3"<?php if($admset['wysiwyg']=='tinymce3'){echo ' selected="selected"';} ?>><?php echo $lang['tinymce3']; ?></option>
</select>
</td></tr>

<?php

?>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['gen_smimg_width'];  ?></td><td><input type="text" name="new_sett[gen_smimg_width]" value="<?php echo $admset['gen_smimg_width']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['gen_smimg_height'];  ?></td><td><input type="text" name="new_sett[gen_smimg_height]" value="<?php echo isset($admset['gen_smimg_height']) ? $admset['gen_smimg_height'] : ''; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['gen_smimg_width_gal'];  ?></td><td><input type="text" name="new_sett[gen_smimg_width_gal]" value="<?php echo $admset['gen_smimg_width_gal']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['gen_smimg_height_gal'];  ?></td><td><input type="text" name="new_sett[gen_smimg_height_gal]" value="<?php echo isset($admset['gen_smimg_height_gal']) ? $admset['gen_smimg_height_gal'] : ''; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['simg_smoothing']; ?></td><td><input type="radio" name="new_sett[simg_smoothing]" value="1"<?php if(! empty($admset['simg_smoothing'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[simg_smoothing]" value="0"<?php if(empty($admset['simg_smoothing'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pre_delete_img']; ?></td><td><input type="radio" name="new_sett[pre_delete_img]" value="1"<?php if($admset['pre_delete_img']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pre_delete_img]" value="0"<?php if(! $admset['pre_delete_img']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['set_img_chmod']; ?></td><td><input type="text" name="new_sett[img_chmod]" value="<?php echo $admset['img_chmod']; ?>" size="5" maxlength="4"<?php if(! $admset['set_img_chmod']){echo ' disabled';} ?>> <input type="radio" name="new_sett[set_img_chmod]" value="1"<?php if($admset['set_img_chmod']){echo ' checked';} ?> onclick="if(this.checked){document['frm']['new_sett[img_chmod]'].disabled=false;}"> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[set_img_chmod]" value="0"<?php if(! $admset['set_img_chmod']){echo ' checked';} ?> onclick="if(this.checked){document['frm']['new_sett[img_chmod]'].disabled=true;}"> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['set_rfiles_chmod']; ?></td><td><input type="text" name="new_sett[rfiles_chmod]" value="<?php echo $admset['rfiles_chmod']; ?>" size="5" maxlength="4"<?php if(! $admset['set_rfiles_chmod']){echo ' disabled';} ?>> <input type="radio" name="new_sett[set_rfiles_chmod]" value="1"<?php if($admset['set_rfiles_chmod']){echo ' checked';} ?> onclick="if(this.checked){document['frm']['new_sett[rfiles_chmod]'].disabled=false;}"> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[set_rfiles_chmod]" value="0"<?php if(! $admset['set_rfiles_chmod']){echo ' checked';} ?> onclick="if(this.checked){document['frm']['new_sett[rfiles_chmod]'].disabled=true;}"> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['show_inv_pr']; ?></td><td><input type="radio" name="new_sett[show_inv_pr]" value="1"<?php if(! empty($admset['show_inv_pr'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[show_inv_pr]" value="0"<?php if(empty($admset['show_inv_pr'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['sess_ip'] . ' '.custom::contextHelp($lang['sess_ip_help']); ?></td><td><input type="radio" name="new_sett[sess_ip]" value="1"<?php if(! empty($admset['sess_ip'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[sess_ip]" value="0"<?php if(empty($admset['sess_ip'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<?php if(extension_loaded('gd')){ ?>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['watermark']; ?><br><span style="font-size:11px;"><?php echo $lang['watermark_info']; ?></span><?php if(! empty($admset['watermark_format'])){echo "<br><img src=\"img/watermark.$admset[watermark_format]\" alt=\"watermark\"><br><input type=\"checkbox\" name=\"delete_watermark\"> $lang[delete_file]";} ?></td><td><input type="file" name="watermark_file" class="InputFile"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['watermark_position'];  ?></td><td>
<select name="new_sett[watermark_position]">
<option value="center"<?php if(empty($admset['watermark_position']) || $admset['watermark_position'] == 'center'){echo ' selected="selected"';} ?>><?php echo $lang['center']; ?></option>
<option value="down_right"<?php if(isset($admset['watermark_position']) && $admset['watermark_position'] == 'down_right'){echo ' selected="selected"';} ?>><?php echo $lang['down_right']; ?></option>
</select>
</td></tr>

<?php } ?>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['chpu_auto_translit'] . ' ' . custom::contextHelp($lang['chpu_auto_translit_help']); ?></td><td><input type="radio" name="new_sett[chpu_auto_translit]" value="1"<?php if(! empty($admset['chpu_auto_translit'])){echo ' checked="checked"';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[chpu_auto_translit]" value="0"<?php if(empty($admset['chpu_auto_translit'])){echo ' checked="checked"';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>