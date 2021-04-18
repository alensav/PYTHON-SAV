<section class="order order_complete">
<h1>{lang.order_processing}</h1>
<h3>{lang.thank_you} {first_name}, {lang.order_is_sended}</h3>
<div class="order_number">{lang.order_number}: {order_number}</div>

<!--if:payment_blank-->
<div class="orderPmblank">
 <div class="orderPmblankHdr"><strong>{lang.view_payment_blank}:</strong></div>
 <ul>
  <!--begin:payment_blanks-->
  <li><a href="{blank_url}" target="_blank">{blank_title}</a></li>
  <!--end:payment_blanks-->
 </ul>
</div><br>
<!--/if:payment_blank-->

 <!--if:adv_descript-->
 <div class="orderPaymethodAdvDescript">{adv_descript}</div><br>
 <!--/if:adv_descript-->

 <div class="payment_module">
 {payment_module}
 </div>
</section>