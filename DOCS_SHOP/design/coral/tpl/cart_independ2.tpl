<aside class="mnuCart cart_independ2">
<div class="mnuHdr"><a href="{relative_url}cart.php">{lang.cart}</a></div>
 <div class="mnuBody">
 <div class="addReport">{additional_report}</div>
 <!--begin:cart_products-->
 <span id="cPrQuantity_{product_id}_{variant_id}" style="display:none">{def_product_quantity}</span>
 <!--end:cart_products-->
 <div id="emptyCartContent" style="display:none">{lang.empty_cart}</div>
  <div id="filledCartContent" style="display:none">
  <div class="inYourCart">{lang.in_your_cart} <span id="cPrTotalQuantity"></span> {lang.prod_units_on_the_sum} {total_cost}&nbsp;{currency_brief}</div>
  <div class="moreCart"><img src="{design_url}img/more.gif" width="8" height="5" alt="" class="imgst"><a href="{relative_url}cart.php">{lang.more_detailed}</a></div>
  <div class="orderCart"><img src="{design_url}img/vm-order.gif" width="5" height="5" alt="" class="imgst"><a href="{relative_url}pages.php?view=order">{lang.process_order}</a></div>
  </div>
 </div>
</aside>