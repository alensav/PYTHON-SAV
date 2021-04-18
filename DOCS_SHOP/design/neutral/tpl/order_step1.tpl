<section class="order order_step1">
<h1>{lang.order_processing}</h1>
{error_message}

<!--if:not_authorized-->
<div class="orderLoginShowHide" onclick="if(document.getElementById('frmOrderLogin').style.display=='none'){document.getElementById('frmOrderLogin').style.display='block';}else{document.getElementById('frmOrderLogin').style.display='none';}"><b>&#8691;  {lang.enter} / {lang.register}</b></div>
<form id="frmOrderLogin" action="{relative_url}pages.php" method="POST" class="frmOrderLogin">
<div class="please_authorized">{lang.please_authorized}</div>
<input type="hidden" name="view" value="login">
<input type="hidden" name="user_enter" value="1">
<input type="hidden" name="lastpage" value="{last_page}">
 <table class="frmOrderLogin">
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
<div class="notRegisterMsg">{lang.if_not_register} <a href="{relative_url}pages.php?view=register&amp;lastpage={last_page}"> {lang.this_link}</a>. {lang.for_permanent_discounts} {register_not_mandatory_message}</div>
</form>
<script type="text/javascript">
document.getElementById('frmOrderLogin').style.display='none';
</script>
<!--/if:not_authorized-->

<!--if:authorized_or_order_without_register-->
<form id="frmOrderStep1" action="{relative_url}pages.php" method="POST" class="frmOrderStep1">
<h2>{lang.step1} {lang.select_pay_method}</h2>
<input type="hidden" name="view" value="order">
<input type="hidden" name="step" value="1">

<table class="coltbl selPayMethod">
 <tr class="htr">
  <td colspan="2">{lang.pay_method}</td>
 </tr>
 <!--begin:pay_methods-->
 <tr class="{def_class}">
  <td style="vertical-align:top;"><input type="radio" id="pmLbl{def_pmid}" name="pay_method" value="{def_pmid}" onchange="this.form.submit();" required="required"{checked}></td>
  <td><label for="pmLbl{def_pmid}" class="optLabel" title="{lang.choose}">{paymethod_title}</label>
   <div>{short_descript}</div>
   <div><img src="{design_url}img/ls.png" alt="" class="imgst"><a href="{paymethod_url}">{lang.details_descript}</a></div></td>
 </tr>
 <!--end:pay_methods-->
</table>
<div class="submitBl"><input type="submit" value="{lang.continue}"></div>
</form>
<!--/if:authorized_or_order_without_register-->

<hr>

<div class="orderCartInfo">{cart_info}</div>

</section>