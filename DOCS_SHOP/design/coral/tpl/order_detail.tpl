<section class="order_detail">
<h1>{lang.order_info}</h1>

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

<!--if:payment_link-->
<div class="payment_link"><a href="{payment_link}">{lang.pay_this_order}</a></div><br>
<!--/if:payment_link-->

 <!--if:adv_descript-->
 <div class="orderPaymethodAdvDescript">{adv_descript}</div><br>
 <!--/if:adv_descript-->

<table class="coltbl">
 <tr class="htr">
  <td colspan="2">{lang.order_info}</td>
 </tr>
 <tr class="str">
  <td>{lang.order_number}</td>
  <td>&#8470; {order_number}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.order_date}</td>
  <td>{order_date}</td>
 </tr>
 <tr class="str">
  <td>{lang.status}</td>
  <td>{order_status}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.pay_method}</td>
  <td>{pay_method}</td>
 </tr>
 <tr class="str">
  <td>{lang.delivery_method}</td>
  <td>{delivery_method}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.order_comment}</td>
  <td>{order_comment}</td>
 </tr>
</table><br>


<table class="coltbl">

 <tr class="htr">
  <td colspan="5">{lang.products_info}</td>
 </tr>

 <tr class="htr2">
  <td>{lang.product_name}</td>
  <td>{lang.sku}</td>
  <td>{lang.price}</td>
  <td>{lang.quantity}</td>
  <td>{lang.cost}</td>
 </tr>

 <!--begin:products-->
 <tr class="{def_class}">
  <td><a href="{product_url}" target="_blank">{product_title}</a><br>{product_options}</td>
  <td>{product_sku}</td>
  <td>{product_price} {currency_brief}</td>
  <td>{product_quantity}</td>
  <td>{product_cost} {currency_brief}</td>
 </tr>
 <!--end:products-->

 <tr class="str">
  <td colspan="5"><hr></td>
 </tr>

 <tr>
  <td colspan="5">

   <table class="CartTotal">
    <tr>
     <td>{lang.total_cost}:</td>
     <td>&nbsp;&nbsp;&nbsp;{total} {currency_brief}</td>
    </tr>

    <!--if:discount-->
    <tr>
     <td>{lang.discount}: {discount_percents} %</td>
     <td>&nbsp;&nbsp;&nbsp;{discount} {currency_brief}</td>
    </tr>
    <tr>
     <td>{lang.total_with_discount}:</td>
     <td>&nbsp;&nbsp;&nbsp;{total_with_discount} {currency_brief}</td>
    </tr>
    <!--/if:discount-->

    <!--if:delivery_cost-->
    <tr>
     <td>{lang.delivery_cost}:</td>
     <td>&nbsp;&nbsp;&nbsp;{delivery_cost} {currency_brief}</td>
    </tr>
    <!--/if:delivery_cost-->

    <tr>
     <td>{lang.selected_currency}:</td>
     <td>&nbsp;&nbsp;&nbsp;{currency} ({currency_brief})</td>
    </tr>

    <tr>
     <td><b>{lang.final_total}:</b></td>
     <td>&nbsp;&nbsp;&nbsp;<b>{final_total} {currency_brief}</b></td>
    </tr>
   </table><br>

  </td>
 </tr>
</table><br>



<table class="coltbl">
 <tr class="htr">
  <td colspan="2">{lang.shopper_info}</td>
 </tr>
 <tr class="str">
  <td>{lang.username}</td>
  <td>{username}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.first_name}</td>
  <td>{first_name}</td>
 </tr>
 <tr class="str">
  <td>{lang.last_name}</td>
  <td>{last_name}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.patronymic}</td>
  <td>{patronymic}</td>
 </tr>
 <tr class="str">
  <td>{lang.company}</td>
  <td>{company}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.country}</td>
  <td>{country}</td>
 </tr>
 <tr class="str">
  <td>{lang.city}</td>
  <td>{city}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.address}</td>
  <td>{address}</td>
 </tr>
 <tr class="str">
  <td>{lang.zip_code}</td>
  <td>{zip_code}</td>
 </tr>
 <tr class="ttr">
  <td>{lang.phone}</td>
  <td>{phone}</td>
 </tr>
 <tr class="str">
  <td>{lang.email}</td>
  <td>{email}</td>
 </tr>
</table><br>

<!--if:admin_comment-->
<table class="coltbl">
 <tr class="htr">
  <td>{lang.admin_comment}</td>
 </tr>
 <tr class="str">
  <td>{admin_comment}</td>
 </tr>
</table><br>
<!--/if:admin_comment-->

<p><img src="{design_url}img/ls.gif" alt="" class="imgst"><a href="{relative_url}pages.php?view=user_orders">{lang.back_to_orders_list}</a><br></p>

</section>