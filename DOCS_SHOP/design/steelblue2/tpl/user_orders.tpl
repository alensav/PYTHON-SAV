<section class="user_orders">
<h1>{lang.your_orders}</h1>
 <table class="coltbl">
  <tr class="htr">
   <td>{lang.order_number}</td>
   <td>{lang.sum}</td>
   <td>{lang.status}</td>
  </tr>
  <!--begin:orders-->
  <tr class="{def_class}">
   <td><a href="{relative_url}pages.php?view=order_detail&amp;orderid={order_number}">&#8470; {order_number}<br>{order_date}</a></td>
   <td>{sum} {currency_brief}</td>
   <td>{order_status}</td>
  </tr>
  <!--end:orders-->
 </table>
</section>