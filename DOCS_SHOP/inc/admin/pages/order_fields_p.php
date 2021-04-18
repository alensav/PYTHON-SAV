<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/order_fields');
$custom->get_lang('register');
require_once(INC_DIR."/admin/order_fields.php");
$order_fields=new order_fields;
require_once(INC_DIR."/register.php");
$register=new register;

 if(! empty($_POST['save'])){
 $admin_lib->save_settings(2, $_POST['new_sett']);
 $sett=$custom->get_settings(2);
 echo $order_fields->save_order_fields();
 $fields=$_POST['new_fields'];
 }
 else{
 $fields=$order_fields->of_get_orderfields();
 }

?>
<form method="POST" action="?">
<input type="hidden" name="view" value="settings">
<input type="hidden" name="settype" value="order_fields">
<input type="hidden" name="save" value="1">

<br><table class="settbl" border="0">
<tr class="htr">
<td colspan="2"><?php echo $lang['reg_form']; ?></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['def_country']; ?></td><td><select name="new_sett[def_country]"><?php
echo "<option value=\"\">$lang[not_selected]</option>" . $register->get_countries_list($sett['def_country']);
?>
</select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['reg_def_group']; ?></td><td><select name="new_sett[reg_def_group]"><?php echo $order_fields->of_get_grouplist(); ?>
</select></td></tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['reg_allow_groups']; ?></td><td><?php
$regallowgroups=$register->reg_allowed_groups();
$ragsize=sizeof($regallowgroups);
 if($ragsize){
 echo "$lang[allowed_groups_count] $ragsize $lang[of_groups]";
 }
 else{
 echo $lang['no'];
 }
?> <a href="javascript:window.open('?view=settings&settype=reg_allow_groups&independ=1','','status,scrollbars,resizable,width=360,height=300');void(0);">(<?php echo $lang['change']; ?>)</a></td></tr>

<?php if(extension_loaded('gd')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['antibot_register']; ?></td><td class="nowrap"><input type="radio" name="new_sett[antibot_register]" value="1"<?php if($sett['antibot_register']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[antibot_register]" value="0"<?php if(! $sett['antibot_register']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>
<?php } ?>

</table><br>

<table class="settbl" border="0">
<tr class="htr">
<td colspan="2"><?php echo $lang['order_form']; ?></td>
</tr>

<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['order_without_register']; ?></td><td class="nowrap"><input type="radio" name="new_sett[order_without_register]" value="1"<?php if($sett['order_without_register']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[order_without_register]" value="0"<?php if(! $sett['order_without_register']){echo ' checked';} ?>> <?php echo $lang['no']; ?>
</td></tr>

<?php if(extension_loaded('gd')){ ?>
<tr class="<?php echo $admin_lib->sett_class(); ?>"><td><?php echo $lang['antibot_order']; ?></td><td class="nowrap"><input type="radio" name="new_sett[antibot_order]" value="1"<?php if($sett['antibot_order']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_sett[antibot_order]" value="0"<?php if(! $sett['antibot_order']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td></tr>
<?php } ?>

</table>

<h3><?php echo $lang['order_fields']; ?></h3>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[email]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[email][enabled]" value="1"<?php if($fields['email']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[email][enabled]" value="0"<?php if(! $fields['email']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[email][required]" value="1"<?php if($fields['email']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[email][required]" value="0"<?php if(! $fields['email']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[email][sortid]" size="5" value="<?php echo $fields['email']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[email][placeholder]" value="<?php echo $fields['email']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[email][contexthelp]" cols="29" rows="4"><?php echo $fields['email']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>


<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[last_name]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[last_name][enabled]" value="1"<?php if($fields['last_name']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[last_name][enabled]" value="0"<?php if(! $fields['last_name']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[last_name][required]" value="1"<?php if($fields['last_name']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[last_name][required]" value="0"<?php if(! $fields['last_name']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[last_name][sortid]" size="5" value="<?php echo $fields['last_name']['sortid']; ?>"></td>
</tr>


<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[last_name][placeholder]" value="<?php echo $fields['last_name']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[last_name][contexthelp]" cols="29" rows="4"><?php echo $fields['last_name']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>


<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[first_name]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[first_name][enabled]" value="1"<?php if($fields['first_name']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[first_name][enabled]" value="0"<?php if(! $fields['first_name']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[first_name][required]" value="1"<?php if($fields['first_name']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[first_name][required]" value="0"<?php if(! $fields['first_name']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[first_name][sortid]" size="5" value="<?php echo $fields['first_name']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[first_name][placeholder]" value="<?php echo $fields['first_name']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[first_name][contexthelp]" cols="29" rows="4"><?php echo $fields['first_name']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>


<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[patronymic]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[patronymic][enabled]" value="1"<?php if($fields['patronymic']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[patronymic][enabled]" value="0"<?php if(! $fields['patronymic']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[patronymic][required]" value="1"<?php if($fields['patronymic']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[patronymic][required]" value="0"<?php if(! $fields['patronymic']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[patronymic][sortid]" size="5" value="<?php echo $fields['patronymic']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[patronymic][placeholder]" value="<?php echo $fields['patronymic']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[patronymic][contexthelp]" cols="29" rows="4"><?php echo $fields['patronymic']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[company]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[company][enabled]" value="1"<?php if($fields['company']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[company][enabled]" value="0"<?php if(! $fields['company']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[company][required]" value="1"<?php if($fields['company']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[company][required]" value="0"<?php if(! $fields['company']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[company][sortid]" size="5" value="<?php echo $fields['company']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[company][placeholder]" value="<?php echo $fields['company']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[company][contexthelp]" cols="29" rows="4"><?php echo $fields['company']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[country]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[country][enabled]" value="1"<?php if($fields['country']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[country][enabled]" value="0"<?php if(! $fields['country']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[country][required]" value="1"<?php if($fields['country']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[country][required]" value="0"<?php if(! $fields['country']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[country][sortid]" size="5" value="<?php echo $fields['country']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[country][contexthelp]" cols="29" rows="4"><?php echo $fields['country']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[city]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[city][enabled]" value="1"<?php if($fields['city']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[city][enabled]" value="0"<?php if(! $fields['city']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[city][required]" value="1"<?php if($fields['city']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[city][required]" value="0"<?php if(! $fields['city']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[city][sortid]" size="5" value="<?php echo $fields['city']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[city][placeholder]" value="<?php echo $fields['city']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[city][contexthelp]" cols="29" rows="4"><?php echo $fields['city']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[address]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[address][enabled]" value="1"<?php if($fields['address']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[address][enabled]" value="0"<?php if(! $fields['address']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[address][required]" value="1"<?php if($fields['address']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[address][required]" value="0"<?php if(! $fields['address']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[address][sortid]" size="5" value="<?php echo $fields['address']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><textarea name="new_fields[address][placeholder]" cols="29" rows="4"><?php echo $fields['address']['placeholder']; ?></textarea></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[address][contexthelp]" cols="29" rows="4"><?php echo $fields['address']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[zip_code]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[zip_code][enabled]" value="1"<?php if($fields['zip_code']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[zip_code][enabled]" value="0"<?php if(! $fields['zip_code']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[zip_code][required]" value="1"<?php if($fields['zip_code']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[zip_code][required]" value="0"<?php if(! $fields['zip_code']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[zip_code][sortid]" size="5" value="<?php echo $fields['zip_code']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[zip_code][placeholder]" value="<?php echo $fields['zip_code']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[zip_code][contexthelp]" cols="29" rows="4"><?php echo $fields['zip_code']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[phone]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[phone][enabled]" value="1"<?php if($fields['phone']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[phone][enabled]" value="0"<?php if(! $fields['phone']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[phone][required]" value="1"<?php if($fields['phone']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[phone][required]" value="0"<?php if(! $fields['phone']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['sort_index']; ?></td>
<td><input type="text" name="new_fields[phone][sortid]" size="5" value="<?php echo $fields['phone']['sortid']; ?>"></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['placeholder']; ?></td>
<td><input type="text" name="new_fields[phone][placeholder]" value="<?php echo $fields['phone']['placeholder']; ?>"></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[phone][contexthelp]" cols="29" rows="4"><?php echo $fields['phone']['contexthelp']; ?></textarea></td>
</tr>

</table>

<br>

<table class="settbl" border="0">

<tr class="htr">
<td colspan="2"><?php echo "$lang[field] \"$lang[agreement]\""; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['show_field_in_orderform']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[agreement][enabled]" value="1"<?php if($fields['agreement']['enabled']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[agreement][enabled]" value="0"<?php if(! $fields['agreement']['enabled']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="ttr">
<td><?php echo $lang['required_field']; ?></td>
<td class="nowrap"><input type="radio" name="new_fields[agreement][required]" value="1"<?php if($fields['agreement']['required']){echo ' checked';} ?>> <?php echo $lang['yes']; ?> &nbsp; <input type="radio" name="new_fields[agreement][required]" value="0"<?php if(! $fields['agreement']['required']){echo ' checked';} ?>> <?php echo $lang['no']; ?></td>
</tr>

<tr class="str">
<td><?php echo $lang['contexthelp']; ?></td>
<td><textarea name="new_fields[agreement][contexthelp]" cols="29" rows="4"><?php echo $fields['agreement']['contexthelp']; ?></textarea></td>
</tr>

</table>

<?php
echo <<<HTMLDATA
<br><input type="submit" value="$lang[submit]" class="button1">
</form>
HTMLDATA;
?>
