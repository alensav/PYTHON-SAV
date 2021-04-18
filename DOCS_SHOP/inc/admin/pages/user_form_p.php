<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $user_info=$users->get_user_info($_GET['userid']);
 }
 elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  if($_POST['save']){
   $save_code=$users->update_user_info();
   if($save_code==1){
   echo "<h3>$lang[changes_success]</h3>";
   $user_info=$users->get_user_info($_POST['userid']);
   }
   else{
   echo "<table><tr><td><font class=\"red\">$save_code</font></td></tr></table>";
   $user_info=$custom->stripslashes_array($_POST);
   }
  }
 }



if($user_info['userid']){



if($user_info['groupid']){$act='edit';}
?>
<br><form name="userform" METHOD="POST" action="?">
<input type="hidden" name="view" value="users">
<input type="hidden" name="act" value="<?php echo $act; ?>">
<input type="hidden" name="userid" value="<?php echo $user_info['userid']; ?>">
<input type="hidden" name="save" value="<?php if($act=='edit'){echo 'edit';}else{echo 'add';} ?>">

<table class="settbl" border="0">
 <tr class="htr"><td colspan="2"><?php echo $lang['user_info']; ?></td></tr>

<?php
$text_size = 30 ;

require_once(INC_DIR."/register.php");
$register=new register;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[login]&nbsp;</td><td><input type="text" name="username" size="$text_size" maxlength="50" value="$user_info[username]">&nbsp;</td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[new_password]&nbsp;</td><td><input type="password" name="new_password1" size="$text_size" maxlength="128"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[repeat_password]&nbsp;</td><td><input type="password" name="new_password2" size="$text_size" maxlength="128"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();
$groups=$users->get_users_groups_in_array();

echo "<tr class=\"$def_class\"><td align=\"right\">$lang[group]&nbsp;</td><td><select name=\"groupid\">";

 foreach($groups as $group_id => $group_name){
 if($group_id==$user_info['groupid']){$selected=' selected';}else{$selected='';}
 echo "<option value=\"$group_id\"$selected>$group_name</option>";
 }

echo "</select></td></tr>";

$def_class=$admin_lib->sett_class();

 if($_SERVER['REQUEST_METHOD'] == 'GET'){
 $chgroup_mailnotify_checked = ' checked';
 }
 elseif($_POST['chgroup_mailnotify']){
 $chgroup_mailnotify_checked = ' checked';
 }
 else{
 $chgroup_mailnotify_checked = '';
 }

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">&nbsp;</td><td><input type="checkbox" name="chgroup_mailnotify"$chgroup_mailnotify_checked>$lang[change_group_mail_notify]
<input type="hidden" name="old_groupid" value="$user_info[groupid]">
</td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[email]&nbsp;</td><td><input type="text" name="email" size="$text_size" maxlength="128" value="$user_info[email]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[first_name]&nbsp;</td><td><input type="text" name="first_name" size="$text_size" maxlength="128" value="$user_info[first_name]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[last_name]&nbsp;</td><td><input type="text" name="last_name" size="$text_size" maxlength="128" value="$user_info[last_name]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[patronymic]&nbsp;</td><td><input type="text" name="patronymic" size="$text_size" maxlength="128" value="$user_info[patronymic]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[company]&nbsp;</td><td><input type="text" name="company" size="$text_size" maxlength="64" value="$user_info[company]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

$user_info['country']=intval($user_info['country']);

echo "<tr class=\"$def_class\"><td align=\"right\">$lang[country]&nbsp;</td><td><select name=\"country\"><option value=\"\">$lang[not_selected]</option>" . $register->get_countries_list($user_info['country']) . "</select></td></tr>";

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[city]&nbsp;</td><td><input type="text" name="city" size="$text_size" maxlength="128" value="$user_info[city]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[address]&nbsp;</td><td><textarea name="address" cols="30" rows="5">$user_info[address]</textarea></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[zip_code]&nbsp;</td><td><input type="text" name="zip_code" size="$text_size" maxlength="64" value="$user_info[zip_code]"></td></tr>
HTMLDATA;

$def_class=$admin_lib->sett_class();

echo <<<HTMLDATA
<tr class="$def_class"><td align="right">$lang[phone]&nbsp;</td><td><input type="text" name="phone" size="$text_size" maxlength="64" value="$user_info[phone]"></td></tr>
HTMLDATA;

echo <<<HTMLDATA
<tr class="ftr"><td colspan="2" align="center"><br><input type="submit" value="$lang[submit]" class="button1"> <input type="reset" value="$lang[reset]" class="button1"></td></tr>
</table><br><img src="adm/img/st.gif" class="stimg">&nbsp;<a href="?view=users">$lang[to_users_list]</a>
</form>
HTMLDATA;



}
else{
echo "<table><tr><td><b>$lang[cant_find_user]</b></td></tr></table>";
}
?>
