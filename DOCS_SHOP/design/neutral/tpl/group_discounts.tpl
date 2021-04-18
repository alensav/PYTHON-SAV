<section class="group_discounts">
<h1>{lang.discounts} {lang.of_user_group} &quot;{user_groupname}&quot;</h1>

<table class="coltbl">
 <tr class="htr">
  <td>{lang.order_sum}</td>
  <td>{lang.discount}</td>
 </tr>

 <!--begin:group_discounts-->
 <tr class="{def_class}">
  <td>{lang.from} {order_sum}&nbsp;{currency_brief}</td>
  <td>{discount} %</td>
 </tr>
 <!--end:group_discounts-->
 
</table>

<p>{lang.min_order_sum} &quot;{user_groupname}&quot;: {min_order_sum}&nbsp;{currency_brief}</p>
<hr>

<!--if:pub_all_discounts-->
<p><img src="{design_url}img/ls.png" alt="" class="imgst"><a href="{discounts_url}">{lang.all_discounts}</a></p>
<!--/if:pub_all_discounts-->
</section>