<section class="order orderinfo_tbl">
<h1>{lang.order_processing}</h1>
<h2>{lang.step3} {lang.order_confirmation}</h2>

<table class="coltbl">
 <tr class="htr">
  <td>{lang.product_name}</td>
  <td>{lang.sku}</td>
  <td>{lang.price}</td>
  <td>{lang.quantity}</td>
  <td>{lang.cost}</td>
 </tr>
<!--begin:cart_products-->
 <tr class="{def_class}">
  <td><a href="{product_url}" target="_blank">{product_title}</a>
  <!--if:product_options-->
   <!--begin:product_options-->
   <div class="cartPrOpt">{product_option_name}: {product_option_value}</div>
   <!--end:product_options-->
  <!--/if:product_options-->
  </td>
  <td>{product_sku}</td>
  <td class="nowrap">{product_price} {currency_brief}</td>
  <td class="alignCenter">{product_quantity}</td>
  <td class="nowrap">{cost} {currency_brief}</td>
 </tr>
<!--end:cart_products-->
 <tr class="ftr">
  <td colspan="5" class="alignCenter">&nbsp;</td>
 </tr>
</table>

<table class="cartTotal">
 <caption>{lang.results}</caption>
 <tr>
  <td>{lang.pay_method}:</td>
  <td>{pay_method}</td>
 </tr>
 <tr>
  <td>{lang.delivery_method}:</td><td>{delivery_method}</td>
 </tr>
 <tr>
  <td>{lang.selected_currency}:</td>
  <td>{currency_title} ({currency_brief})</td>
 </tr>
 <tr>
  <td>{lang.total_cost}:</td>
  <td>{total_cost} {currency_brief}</td>
 </tr>

 <!--if:discount-->
 <tr>
  <td>{lang.discount}: {discount_percents} %</td>
  <td>{discount} {currency_brief}</td>
 </tr>
 <tr>
  <td>{lang.total_with_discount}:</td>
  <td>{total_cost_with_discount} {currency_brief}</td>
 </tr>
 <!--/if:discount-->
 
<!--if:delivery_cost-->
 <tr>
  <td>{lang.delivery_cost}:</td><td>{delivery_cost} {currency_brief}</td>
 </tr>
<!--/if:delivery_cost-->

 <tr>
  <td>{lang.final_total}:</td>
  <td>{final_total} {currency_brief}</td>
 </tr>

</table><br>

<div class="orderConfirm">
 <div class="please_confirm">{lang.please_confirm}</div>
 <form action="{relative_url}pages.php" method="POST" style="display:inline; margin-right:40px;">
 <input type="hidden" name="view" value="order">
 <input type="hidden" name="step" value="3">
 <input type="submit" value="{lang.confirm}">
 </form>
 <button onclick="document.location.href='{relative_url}cart.php';">{lang.refusal}</button>
</div><br>

</section>