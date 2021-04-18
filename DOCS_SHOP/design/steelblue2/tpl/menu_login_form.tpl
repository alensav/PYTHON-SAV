<aside class="menu_login_form">
<div class="mnuHdr">{lang.enter}</div>
<div class="mnuBody">
 <form action="{relative_url}pages.php" method="POST">
 <input type="hidden" name="user_enter" value="1">
 <input type="hidden" name="view" value="login">
 {lang.user_name}<br>
 <input type="text" name="username" size="12"><br>
 {lang.password}<br>
 <input type="password" name="password" size="12"><br>
 <input type="submit" value="{lang.enter}"><br>
 <a href="{relative_url}pages.php?view=forgot_password">{lang.forgot_password}</a><br>
 <a href="{relative_url}pages.php?view=register">{lang.register}</a>
 </form>
</div>
</aside>