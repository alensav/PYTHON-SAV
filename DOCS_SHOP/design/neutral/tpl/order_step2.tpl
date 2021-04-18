<section class="order order_step2">
<h1>{lang.order_processing}</h1>
{error_message}
<h2>{lang.step2} {lang.fill_form}</h2>
<span class="req">*</span> {lang.required_fields}
<form id="frmOrderStep2" action="{relative_url}pages.php" method="POST" class="frmOrderStep2">
<input type="hidden" name="view" value="order">
<input type="hidden" name="step" value="2">

<table class="coltbl selCurrency">
 <tr class="htr">
  <td>{lang.selection_currency}</td>
 </tr>
 <tr class="str">
  <td>{lang.selected_paymethod}: {selected_pay_method}<br>
  <a href="{relative_url}pages.php?view=order">{lang.choose_other_paymethod}</a>
  </td>
 </tr>
 <tr class="ttr">
  <td><span class="req">*</span>&nbsp;{lang.currency}<br>
  <select name="order_currency" required="required">
   <option value="">{lang.select_currency}</option>
   <!--begin:paymethod_currencies-->
   <option value="{currency_id}"{selected}>{currency_name} ({currency_brief})</option>
   <!--end:paymethod_currencies-->
   </select>
  </td>
 </tr>
</table>
<br>
<table class="coltbl selDeliveryMethod">
 <tr class="htr">
  <td colspan="2"><span class="req">*</span>&nbsp;{lang.delivery_method}</td>
 </tr>

 <!--begin:delivery_methods-->
 <tr class="{def_class}"> 
  <td style="vertical-align:top;"><input type="radio" id="dmLbl{delivery_method_id}" name="delivery_method" value="{delivery_method_id}" required="required"{checked}></td>
  <td>
  <label for="dmLbl{delivery_method_id}" class="optLabel" title="{lang.choose}">{delivery_method_name}</label>
   <div>{short_descript}</div>
   <div><img src="{design_url}img/ls.png" alt="" class="imgst"><a href="{delivery_method_url}" target="_blank">{lang.details_descript}</a></div>
  </td>
 </tr>
 <!--end:delivery_methods-->

</table>
<br>

{user_information}

<table class="coltbl orderAddFields">
 <!--begin:additional_fields-->
 <tr class="{def_class}">
  <td>
  {required} {field_description}&nbsp;<br>
  {field}
  </td>
 </tr>
 <!--end:additional_fields-->
</table>

<div class="orderComment">
{lang.your_comment}<br>
<textarea name="comment" cols="40" rows="8">{user_comment}</textarea>
</div>

<!--if:antibot_order-->
<div class="antiBotOrder">
<span class="req">*</span> {lang.protect_code}<br>
<input type="text" name="protect_code" size="10"><img src="{random_image_url}" alt="{lang.protect_code}" class="protectImg">
</div>
<!--/if:antibot_order-->

 <!--if:agreement-->
 <div class="orderAgreement">{agreement}</div>
 <!--/if:agreement-->
 
<div class="submitBl"><input type="submit" value="{lang.continue}"></div>

</form>
</section>