<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<form name="frm" method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="product_comments">
<input type="hidden" name="save" value="1">
<?php
$custom->get_lang('admin_lang/product_comments_sett');
 if(! empty($_POST['save'])){
 $on_pcomm = $_POST['new_sett']['on_pcomm'];
 unset($_POST['new_sett']['on_pcomm']);
 if($_POST['new_sett']['com_maxlen'] > 32767){$_POST['new_sett']['com_maxlen'] = 32767;}
 echo $admin_lib->save_settings(6, $_POST['new_sett']);
 pcs_save_stop_words();
 $pcomset = $custom->get_settings(6);
 unset($_POST['new_sett']);
 $_POST['new_sett']['on_pcomm'] = $on_pcomm;
 $admin_lib->save_settings(2, $_POST['new_sett']);
 $sett['on_pcomm'] = $_POST['new_sett']['on_pcomm'];
 }
 else{
 $pcomset=$custom->get_settings(6);
 }
?>
<h3><?php echo $lang['product_comments']; ?></h3>
<table width="100%" class="settbl">
<tr class="htr"><td><?php echo $lang['description']; ?></td><td><?php echo $lang['value']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['on_pcomm']; ?></td><td><input type="radio" name="new_sett[on_pcomm]" value="1"<?php if(! empty($sett['on_pcomm'])){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[on_pcomm]" value="0"<?php if(empty($sett['on_pcomm'])){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo "$lang[pubreg_only]<br><span style=\"font-size:12px\">($lang[pubreg_only_info])</span>"; ?></td><td><input type="radio" name="new_sett[pubreg_only]" value="1"<?php if($pcomset['pubreg_only']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pubreg_only]" value="0"<?php if(! $pcomset['pubreg_only']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['reverse_sort']; ?></td><td><input type="radio" name="new_sett[reverse_sort]" value="1"<?php if($pcomset['reverse_sort']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[reverse_sort]" value="0"<?php if(! $pcomset['reverse_sort']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pub_email']; ?></td><td><input type="radio" name="new_sett[pub_email]" value="1"<?php if($pcomset['pub_email']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[pub_email]" value="0"<?php if(! $pcomset['pub_email']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['name_empty']; ?></td><td><input type="text" name="new_sett[name_empty]" value="<?php echo $pcomset['name_empty']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['admin_name']; ?></td><td><input type="text" name="new_sett[admin_name]" value="<?php echo $pcomset['admin_name']; ?>"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['qpcomm']; ?></td><td><input type="text" name="new_sett[qpcomm]" value="<?php echo $pcomset['qpcomm']; ?>" size="4"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['productonpg']; ?></td><td><input type="radio" name="new_sett[productonpg]" value="1"<?php if($pcomset['productonpg']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[productonpg]" value="0"<?php if(! $pcomset['productonpg']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['add_comm'];  ?></td><td>
<select name="new_sett[add_comm]">
<option value=""<?php if(! $pcomset['add_comm']){echo ' selected="selected"';} ?>><?php echo $lang['nobody']; ?></option>
<option value="all"<?php if($pcomset['add_comm']==='all'){echo ' selected="selected"';} ?>><?php echo $lang['all_visitors']; ?></option>
<option value="reg"<?php if($pcomset['add_comm']==='reg'){echo ' selected="selected"';} ?>><?php echo $lang['registered_users']; ?></option>
</select>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['name_req']; ?></td><td><input type="radio" name="new_sett[name_req]" value="1"<?php if($pcomset['name_req']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[name_req]" value="0"<?php if(! $pcomset['name_req']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['email_req']; ?></td><td><input type="radio" name="new_sett[email_req]" value="1"<?php if($pcomset['email_req']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[email_req]" value="0"<?php if(! $pcomset['email_req']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['com_minlen']; ?></td><td><input type="text" name="new_sett[com_minlen]" value="<?php echo $pcomset['com_minlen']; ?>" size="6"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['com_maxlen']; ?></td><td><input type="text" name="new_sett[com_maxlen]" value="<?php echo $pcomset['com_maxlen']; ?>" size="6"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['cut_com']; ?></td><td><input type="radio" name="new_sett[cut_com]" value="1"<?php if($pcomset['cut_com']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[cut_com]" value="0"<?php if(! $pcomset['cut_com']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['premoderate']; ?></td><td><input type="radio" name="new_sett[premoderate]" value="1"<?php if($pcomset['premoderate']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[premoderate]" value="0"<?php if(! $pcomset['premoderate']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['notifi_admin']; ?></td><td><input type="radio" name="new_sett[notifi_admin]" value="1"<?php if($pcomset['notifi_admin']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[notifi_admin]" value="0"<?php if(! $pcomset['notifi_admin']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>

<?php if(extension_loaded('gd')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['antibot']; ?></td><td><input type="radio" name="new_sett[antibot]" value="1"<?php if($pcomset['antibot']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[antibot]" value="0"<?php if(! $pcomset['antibot']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>
<?php } ?>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['pr_comm_stop_words']; ?></td><td><textarea name="pr_comm_stop_words" cols="30" rows="6"><?php echo $custom->get_txtsettings('pr_comm_stop_words'); ?></textarea></td></tr>

<tr class="ftr"><td colspan="2"><br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1"></td></tr>
</table>
</form>

<p><img src="adm/img/st.gif" class="stimg">&nbsp;<?php echo $lang['manage_comments']; ?>.<br><img src="adm/img/st.gif" class="stimg">&nbsp;<?php echo $lang['manage_new_comments']." <a href=\"?view=product&act=comments&pcsub=new\">$lang[this_link]</a>."; ?></p>

<?php
function pcs_save_stop_words(){
global $admin_lib;

if(! $admin_lib->check_admin_perms()){return $admin_lib->nosave_perms_msg();}

$_POST['pr_comm_stop_words'] = mb_strtolower($_POST['pr_comm_stop_words']);
$_POST['pr_comm_stop_words'] = custom::rn_to_n($_POST['pr_comm_stop_words']);
$words_arr = explode("\n", $_POST['pr_comm_stop_words']);
unset($_POST['pr_comm_stop_words']);
$Words_str = '';
 if(sizeof($words_arr)){
  foreach($words_arr as $value){
  $value = trim($value);
   if($value){
   $Words_str.=$value."\x0A";
   }
  }
 }
$admin_lib->save_txtsettings(array('pr_comm_stop_words' => $Words_str));
}
?>