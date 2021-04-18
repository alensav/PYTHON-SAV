<section class="discounts">
<h1>{lang.discounts}</h1>

<p>{lang.your_groupname} <a href="{group_discounts_url}">&quot;{user_groupname}&quot;</a>.</p>

<!--begin:groups-->

<h4>{lang.groupname_discounts} &quot;{groupname}&quot;</h4>

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
<p>{lang.min_order_sum} &quot;{groupname}&quot;: {min_order_sum}&nbsp;{currency_brief}</p>
<hr style="margin-top:20px; margin-bottom:20px;">
<!--end:groups-->

</section>
