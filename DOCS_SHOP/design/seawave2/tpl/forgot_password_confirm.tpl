<form action="{relative_url}pages.php" method="POST" class="forgot_password_confirm">
{error_message}
<input type="hidden" name="view" value="forgot_password">
 <h3>{lang.enter_key}</h3>
 <input type="text" name="confirmkey" value="{confirmkey}" size="40"><br>
 <input type="submit" value="{lang.confirm_changes}">
</form>