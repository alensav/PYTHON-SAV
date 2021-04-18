<section class="cart">
<h1>{lang.cart}</h1>
<div class="addReport">{additional_report}</div>

 <form action="{def_action}" method="POST" class="frmCart">
 {additionally_fields}
 <input type="hidden" name="act" value="recalculate">
  <table class="coltbl">
  <tr class="htr">
   <td>{lang.product_name}</td>
   <td>{lang.price}</td>
   <td>{lang.quantity}</td>
   <td>{lang.cost}</td>
  </tr>
  <!--begin:cart_products-->
  <tr class="{def_class}">
   <td>
   <a href="{product_url}">{product_title}</a>
    <!--if:product_options-->
     <!--begin:product_options-->
     <div class="cartPrOpt">{product_option_name}: {product_option_value}</div>
     <!--end:product_options-->
    <!--/if:product_options-->
   </td>
   <td class="nowrap">{product_price} {currency_brief}</td>
   <td class="alignCenter"><input type="text" name="product_quantity[{product_id}][{variant_id}]" size="3" value="{def_product_quantity}">&nbsp;&nbsp;&nbsp;<a href="cart.php?act=del&amp;product={product_id}&amp;variant={variant_id}" onclick="return delq();"><img src="{design_url}img/del.gif" alt="{lang.delete}" class="imgst"></a></td>
   <td class="nowrap">{cost} {currency_brief}</td>
  </tr>
  <!--end:cart_products-->
  <tr class="CartFtr">
   <td colspan="4">
    <table class="CartTotal">
     <tr>
      <td>{lang.total_cost}:</td>
      <td>&nbsp;{total_cost} {currency_brief}</td>
     </tr>

     <!--if:discount-->
     <tr>
      <td>{lang.discount}: {discount_percents} %</td>
      <td>&nbsp;{discount} {currency_brief}</td>
     </tr>
     <tr>
      <td>{lang.total_with_discount}:</td>
      <td>&nbsp;{total_cost_with_discount} {currency_brief}</td>
     </tr>
     <!--/if:discount-->

    </table>

  <div class="submitBl"><input type="submit" value="{lang.recalculate}"></div>
  </td>
 </tr>
</table>
</form>

<!--if:only_cart-->
<div class="only_cart">
 <form action="pages.php" method="POST" style="display:inline; margin-right:40px;">
 <input type="hidden" name="view" value="order">
 <input type="submit" value="{lang.process_order}">
 </form>
 <button onclick="history.go(-1);">{lang.return_back}</button>
</div>
<!--/if:only_cart-->

</section>