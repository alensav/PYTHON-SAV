<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();} ?>
<form method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="vertical_blocks">
<input type="hidden" name="savesettings" value="1">
<?php
$custom->get_lang('admin_lang/vertical_blocks');
 if(! empty($_POST['savesettings'])){
 echo $admin_lib->save_settings(2, $_POST['new_sett']);
 $sett=$custom->get_settings(2);
 }
?>
<h1><?php echo $lang['vertical_blocks']; ?></h1>
<table width="100%" class="settbl">




<tr class="htr"><td colspan="2"><?php echo $lang['catalog']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mCat]"><option value=""<?php if(empty($sett['s_mCat'])){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if(isset($sett['s_mCat']) && $sett['s_mCat']=='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if(isset($sett['s_mCat']) && $sett['s_mCat']=='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if(isset($sett['s_mCat']) && $sett['s_mCat']=='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['q_mcat']; ?></td><td><input type="text" name="new_sett[q_mcat]" value="<?php echo $sett['q_mcat']; ?>" size="13"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['show_all_subcategories']; ?></td><td class="nowrap"><input type="radio" name="new_sett[show_all_subcategories]" value="1"<?php if(! empty($sett['show_all_subcategories'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[show_all_subcategories]" value="0"<?php if(empty($sett['show_all_subcategories'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['submenu_level']; ?></td><td><input type="text" name="new_sett[submenu_level]" value="<?php echo $sett['submenu_level']; ?>" size="13"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>




<tr class="htr"><td colspan="2"><?php echo $lang['manufacturers']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo "$lang[where_show_block]<br>$lang[disable_mnf_info]"; ?></td><td><select name="new_sett[s_mMnf]"><option value=""<?php if(empty($sett['s_mMnf'])){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if(isset($sett['s_mMnf']) && $sett['s_mMnf']=='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if(isset($sett['s_mMnf']) && $sett['s_mMnf']=='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if(isset($sett['s_mMnf']) && $sett['s_mMnf']=='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['q_mmnf']; ?></td><td><input type="text" name="new_sett[q_mmnf]" value="<?php echo $sett['q_mmnf']; ?>" size="13" maxlength="5"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['mnu_onlycatmnf']; ?></td><td class="nowrap"><input type="radio" name="new_sett[mnu_onlycatmnf]" value="1"<?php if(! empty($sett['mnu_onlycatmnf'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[mnu_onlycatmnf]" value="0"<?php if(empty($sett['mnu_onlycatmnf'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>




<tr class="htr"><td colspan="2"><?php echo $lang['news']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mNews]"><option value=""<?php if(empty($sett['s_mNews'])){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if(isset($sett['s_mNews']) && $sett['s_mNews']=='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if(isset($sett['s_mNews']) && $sett['s_mNews']=='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if(isset($sett['s_mNews']) && $sett['s_mNews']=='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['q_new_news']; ?></td><td><input type="text" name="new_sett[q_new_news]" value="<?php echo $sett['q_new_news']; ?>" size="13" maxlength="2"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['nmtext_om']; ?></td><td class="nowrap"><input type="radio" name="new_sett[nmtext_om]" value="1"<?php if(! empty($sett['nmtext_om'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[nmtext_om]" value="0"<?php if(empty($sett['nmtext_om'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>





<tr class="htr"><td colspan="2"><?php echo $lang['content']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mContent]"><option value=""<?php if(empty($sett['s_mContent'])){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if(isset($sett['s_mContent']) && $sett['s_mContent']=='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if(isset($sett['s_mContent']) && $sett['s_mContent']=='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if(isset($sett['s_mContent']) && $sett['s_mContent']=='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['max_contentmenuitems']; ?></td><td><input type="text" name="new_sett[max_contentmenuitems]" value="<?php echo $sett['max_contentmenuitems']; ?>" size="13" maxlength="3"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>




<tr class="htr"><td colspan="2"><?php echo $lang['new_products']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mNewProd]"><option value=""<?php if(empty($sett['s_mNewProd'])){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if(isset($sett['s_mNewProd']) && $sett['s_mNewProd']=='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if(isset($sett['s_mNewProd']) && $sett['s_mNewProd']=='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if(isset($sett['s_mNewProd']) && $sett['s_mNewProd']=='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['q_new_products']; ?></td><td><input type="text" name="new_sett[q_new_products]" value="<?php echo $sett['q_new_products']; ?>" size="13" maxlength="3"></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['imgin_newpr']; ?></td><td class="nowrap"><input type="radio" name="new_sett[imgin_newpr]" value="1"<?php if(! empty($sett['imgin_newpr'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[imgin_newpr]" value="0"<?php if(empty($sett['imgin_newpr'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>





<tr class="htr"><td colspan="2"><?php echo $lang['special_offers']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mSpecOff]"><option value=""<?php if($sett['s_mSpecOff']===''){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if($sett['s_mSpecOff']==='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if($sett['s_mSpecOff']==='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if($sett['s_mSpecOff']==='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['imgin_special']; ?></td><td class="nowrap"><input type="radio" name="new_sett[imgin_special]" value="1"<?php if(! empty($sett['imgin_special'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[imgin_special]" value="0"<?php if(empty($sett['imgin_special'])){echo ' checked';} ?>>&nbsp;<?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>





<tr class="htr"><td colspan="2"><?php echo $lang['cart']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['on_mcart']; ?></td><td class="nowrap"><input type="radio" name="new_sett[on_mcart]" value="1"<?php if($sett['on_mcart']){echo ' checked';} ?>>&nbsp;<?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[on_mcart]" value="0"<?php if(! $sett['on_mcart']){echo ' checked';} ?>>&nbsp;<?php echo $lang['no']; ?>
</td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>





<tr class="htr"><td colspan="2"><?php echo $lang['login_form']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mLoginFrm]"><option value=""<?php if($sett['s_mLoginFrm']===''){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if($sett['s_mLoginFrm']==='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if($sett['s_mLoginFrm']==='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if($sett['s_mLoginFrm']==='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>




<tr class="htr"><td colspan="2"><?php echo $lang['vertical_menu']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['where_show_block']; ?></td><td><select name="new_sett[s_mVertAdv]"><option value=""<?php if($sett['s_mVertAdv']===''){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all']; ?></option><option value="main"<?php if($sett['s_mVertAdv']==='main'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_on_main']; ?></option><option value="noMain"<?php if($sett['s_mVertAdv']==='noMain'){echo ' selected="selected"';} ?>><?php echo $lang['b_show_all_except_main']; ?></option><option value="no"<?php if($sett['s_mVertAdv']==='no'){echo ' selected="selected"';} ?>><?php echo $lang['b_disabled']; ?></option></select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td colspan="2"><hr></td></tr>




<tr class="htr"><td colspan="2"><?php echo $lang['common']; ?></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['mnu_smimg_width'] . ' ' . custom::contextHelp($lang['mnu_smimg_width_help']); ?></td><td><input type="text" name="new_sett[mnu_smimg_width]" value="<?php echo $sett['mnu_smimg_width']; ?>" size="13"></td></tr>





</table>
<br><input type="submit" value="<?php echo $lang['submit']; ?>" class="button1">
</form>