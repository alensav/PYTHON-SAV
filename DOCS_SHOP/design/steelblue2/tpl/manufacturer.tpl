<div class="manufacturer">

 <section class="mnfInfo">

  <!--if:manufacturer_image-->
  <div class="mnfImg">
   <!--if:manufacturer_url-->
   <a href="{manufacturer_url}" target="_blank">
   <!--/if:manufacturer_url-->
  <img src="{relative_url}img/small/{manufacturer_image}" alt="{manufacturer_name}">
   <!--if:manufacturer_url-->
   </a>
   <!--/if:manufacturer_url-->
  </div>
 <!--/if:manufacturer_image-->

  <div class="mnfName">
  <h1>{manufacturer_name}</h1>
   <!--if:manufacturer_url-->
   <a href="{manufacturer_url}" target="_blank">{lang.visit_site} {manufacturer_name}</a>
   <!--/if:manufacturer_url-->
  </div>

  <div class="mnfDescript">{manufacturer_description}</div>
  <div class="clear"></div>

 </section>

 <!--if:products-->

 <form action="{relative_url}sort.php" method="GET" class="frmSort">
 <input type="hidden" name ="view" value="manufacturers">
 <input type="hidden" name ="mnf" value="{manufacturer_id}">
  <div class="sortOrderBy">{lang.order_by} <select name="sort">{sort_options}</select> <select name="desc">{desc_options}</select> <input type="submit" value="OK"></div>
 </form>

 <section class="mnfProducts">
  <!--begin:products-->
   <div class="lstProduct">
   <h3 class="pTitle"><a href="{product_url}">{product_title}</a></h3>
    <!--if:product_small_image-->
    <div id="primage{product_id}" class="prSmallImg">{product_small_image}</div>
    <!--/if:product_small_image-->
   <div class="price">{lang.price}: {product_price} {currency_brief}<!--if:old_price--> <span class="old_price2">({old_price} {currency_brief})</span><!--/if:old_price--></div>
   <div class="prCatLnk">{lang.category} <a href="{category_url}">{category_title}</a></div>
     <!--if:in_stock-->
     <form name="addfrm{product_id}" action="{relative_url}cart.php" method="POST" class="frmAddProd">
      <!--if:product_options-->
       <!--begin:product_options-->
       <div class="prOption">{option_name}: <select name="product_options[{option_id}]">{product_option_values}</select></div>
       <!--end:product_options-->
      <!--/if:product_options-->
     <input type="hidden" name="act" value="add">
     <input type="hidden" name="product" value="{product_id}">
     <input type="submit" value="{lang.add_to_cart}">
     <input type="text" name="product_quantity" value="1" size="4">
     </form>
     <!--/if:in_stock-->
    <div class="short_descript">{short_descript}</div>
   </div><!--закр.lstProduct-->
   <!--if:cycle=100--><!--/if:cycle=100-->
  <!--end:products-->
 </section>

 <div class="pages_links">{pages_links}</div>

 <!--/if:products-->

 <section class="mnfSpecial">{special_text}</section>

</div>