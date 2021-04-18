<form action="{relative_url}pages.php" method="POST" class="login_form">
<input type="hidden" name="view" value="login">
<input type="hidden" name="user_enter" value="1">
<input type="hidden" name="lastpage" value="{last_page}">
  <table>
    <tr> 
      <td>{lang.user_name}</td>
      <td><input type="text" name="username" value="" tabindex="1" required="required" class="authText"></td>
    </tr>
    <tr> 
      <td>{lang.password}</td>
      <td><input type="password" name="password" tabindex="2" required="required" class="authText"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input type="submit" value="{lang.enter}" tabindex="3"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><a href="{relative_url}pages.php?view=forgot_password" tabindex="4">{lang.forgot_password}</a><br><a href="{relative_url}pages.php?view=register&amp;lastpage={last_page}" tabindex="5">{lang.register}</a></td>
    </tr>
  </table>
</form>