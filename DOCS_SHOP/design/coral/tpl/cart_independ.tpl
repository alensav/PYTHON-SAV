<!DOCTYPE html>
<html class="cart_independ">
<head>
<title>{lang.cart}</title>
<meta http-equiv="Content-Type" content="text/html; charset={charset}">
<link href="{design_url}styles.css" rel="stylesheet" type="text/css">
{metatags}
</head>
<body onload="opener.wpcOnload();">
<h1>{lang.cart}</h1>
<div class="addReport">{additional_report}</div>
<form action="{def_action}" method="POST">
{additionally_fields}
<input type="hidden" name="act" value="recalculate">
<input type="hidden" name="independ" value="1">
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
 <a href="{product_url}" target="_blank">{product_title}</a>
  <!--if:product_options-->
   <!--begin:product_options-->
   <div class="cartPrOpt">{product_option_name}: {product_option_value}</div>
   <!--end:product_options-->
  <!--/if:product_options-->
 </td>
 <td class="nowrap">{product_price} {currency_brief}</td>
 <td class="alignCenter"><input type="text" name="product_quantity[{product_id}][{variant_id}]" size="3" value="{def_product_quantity}">&nbsp;&nbsp;&nbsp;<a href="cart.php?act=del&amp;product={product_id}&amp;variant={variant_id}&amp;independ=1" onclick="return delq();"><img src="{design_url}img/del.gif" alt="{lang.delete}" class="imgst"></a></td>
 <td class="nowrap">{cost} {currency_brief}</td>
</tr>
<!--end:cart_products-->
 <tr class="CartFtr">
  <td colspan="4">
   <table class="CartTotal">
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

   </table>
  <div class="submitBl"><input type="submit" value="{lang.recalculate}"></div>
  </td>
 </tr>
</table>
</form>

 <!--if:only_cart-->
 <div style="margin-left:10px;"><a href="#" onclick="opener.location='{relative_url}pages.php?view=order';setTimeout('self.close();',100);">{lang.process_order}</a></div>
 <!--/if:only_cart-->

</body>
</html>