<section class="delivery_methods">
<h1>{lang.delivery_methods}</h1>
<table class="coltbl">
 <tr class="htr">
  <td>{lang.delivery_method}</td>
  <td>{lang.short_descript}</td>
 </tr>

 <!--begin:delivery_methods-->
 <tr class="{def_class}"> 
  <td><a href="{delivery_method_url}">{delivery_method_name}</a></td>
  <td>
   <!--if:delivery_cost-->
   <div class="delivery_cost">{lang.delivery_cost} {delivery_cost} {currency_brief}</div>
    <!--/if:delivery_cost-->
   <div class="dmShortDescript">{short_descript}</div>
   <div class="dmMore"><a href="{delivery_method_url}"><img src="{design_url}img/ls.png" alt="" class="imgst">{lang.details_descript}</a></div>
  </td>
 </tr>
 <!--end:delivery_methods-->

</table>
</section>
