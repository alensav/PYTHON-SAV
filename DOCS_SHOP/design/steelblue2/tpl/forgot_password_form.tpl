<form action="{relative_url}pages.php" method="POST" class="forgot_password_form">
{error_message}
<h1>{lang.password_recovery}</h1>
<input type="hidden" name="view" value="forgot_password">
<input type="hidden" name="send_forgot_password_key" value="1">
<table>
  <tr> 
    <td>{lang.user_name} </td>
    <td><input type="text" name="username" value="{username}"></td>
  </tr>
  <tr> 
    <td>{lang.email} </td>
    <td><input type="text" name="email" value="{email}"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="{lang.continue}"></td>
  </tr>
</table>
</form>