<section class="profile">
<h1>{lang.change_profile} {username}</h1>
{error_message}

 <div class="groupname">
 {lang.group} {groupname}
  <!--if:group_discount-->
  <span>({lang.discount_at_the_purchase} {group_discount} %)</span>
  <!--/if:group_discount-->
 </div>

 <!--if:pub_group_discounts-->
 <div class="group_discounts_url"><a href="{group_discounts_url}">{lang.about_discounts}</a></div>
 <!--/if:pub_group_discounts-->

 <div class="group_descript">{group_descript}</div>
 <div class="your_orders"><a href="{relative_url}pages.php?view=user_orders">{lang.your_orders}</a></div>

 <form action="{relative_url}pages.php" method="POST" class="frmChangeProfile">
 <input type="hidden" name="view" value="profile">
 <input type="hidden" name="save" value="1">

 {user_info}

 <table class="coltbl change_password">
  <tr class="htr">
   <td>
   {lang.change_password}
   </td>
  </tr>
  <tr class="str">
   <td>
   {lang.login}: {username}
   </td>
  </tr>
  <tr class="ttr">
   <td>
   {lang.old_password}<br>
   <input type="password" name="old_password" size="40">
   </td>
  </tr>
  <tr class="str">
   <td>
   {lang.new_password}<br>
   <input type="password" name="password1" size="40">
   </td>
  </tr>
  <tr class="ttr">
   <td>
   {lang.repeat_new_password}<br>
   <input type="password" name="password2" size="40">
   </td>
  </tr>
 </table><br>

 <input type="submit" value="{lang.save_changes}">

 </form>

</section>