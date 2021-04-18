<section class="register">
<h1>{lang.reg_new_user}</h1>
{error_message}
<span class="req">*</span> {lang.required_fields}
 <form action="{relative_url}pages.php" method="POST" class="frmRegister">
 <input type="hidden" name="view" value="register">
 <input type="hidden" name="adduser" value="1">
 <input type="hidden" name="lastpage" value="{last_page}">

 <table class="coltbl register_data">
  <tr class="htr">
   <td>{lang.register_data}</td>
  </tr>
  <tr class="str">
   <td>
   <span class="req">*</span> {lang.user_name}&nbsp;<br>
   <input type="text" name="username" size="40" maxlength="50" value="{username}" required="required">
   </td>
  </tr>
  <tr class="ttr">
   <td>
   <span class="req">*</span> {lang.password}&nbsp;<br>
   <input type="password" name="password1" value="{password1}" size="40" maxlength="255" required="required">
   </td>
  </tr>
  <tr class="str">
   <td><span class="req">*</span> {lang.repeat_password}&nbsp;<br>
   <input type="password" name="password2" value="{password2}" size="40" maxlength="255" required="required">
   </td>
  </tr>
 </table><br>

 {profile_fields}

 <!--if:reg_allow_groups-->
 <table class="coltbl regUserGroup">
  <tr class="htr">
   <td colspan="2">{lang.user_group}</td>
  </tr>
  <!--begin:user_groups-->
  <tr class="{def_class}">
   <td style="vertical-align:top;"><input type="radio" id="userGroupLbl{def_groupid}" name="user_group" value="{def_groupid}"{group_checked}></td>
   <td><label for="userGroupLbl{def_groupid}" class="optLabel" title="{lang.choose}">{groupname}</label><br>
   {group_description}
   </td>
  </tr>
  <!--end:user_groups-->
 </table><br>
 <!--/if:reg_allow_groups-->

 <!--if:antibot_register-->
 <div class="antiBotRegister">
 <span class="req">*</span> {lang.protect_code}<br>
 <input type="text" name="protect_code" size="10"><img src="{random_image_url}" alt="{lang.protect_code}" class="protectImg">
 </div>
 <!--/if:antibot_register-->

 <div class="submitBl"><input type="submit" value="{lang.register}"></div>

 </form>
</section>
