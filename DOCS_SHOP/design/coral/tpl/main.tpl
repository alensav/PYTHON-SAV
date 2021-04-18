<div class="main">

<section class="main_description">{main_description}</section>

<!--if:main_categories-->
<section class="main_categories">
  <!--begin:categories-->
  <div class="mainCatCell">
  <div class="mcRoot"><a href="{category_url}">{main_image}{category_title}</a></div>
   <!--if:subcategories-->
   <span class="mcSub">
    <!--begin:subcategories-->
    <a href="{subcategory_url}">{submain_image}{subcategory_title}</a>,
    <!--end:subcategories-->
   <a href="{category_url}">...</a>
   </span>
   <!--/if:subcategories-->
  </div><!--if:cycle={maincat_qcolumns}--><!--/if:cycle={maincat_qcolumns}-->
  <!--end:categories-->
</section>
<!--/if:main_categories-->

 <!--if:products-->
 <section class="mainProducts">
  <!--begin:products-->
   <div class="lstProduct">
   <h3 class="pTitle"><a href="{product_url}">{product_title}</a></h3>
    <!--if:product_small_image-->
    <div id="primage{product_id}" class="prSmallImg">{product_small_image}</div>
    <!--/if:product_small_image-->
   <div class="price">{lang.price}: {product_price} {currency_brief}<!--if:old_price--> <span class="old_price2">({old_price} {currency_brief})</span><!--/if:old_price--></div>
   <div class="prCatLnk">{lang.category} <a href="{category_url}">{category_title}</a></div>
    <!--if:manufacturer-->
    <div class="prMnf">{lang.manufacturer}: <a href="{manufacturer_url}">{manufacturer_title}</a></div>
    <!--/if:manufacturer-->
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
 <!--/if:products-->

 <section class="main_special">{special_text}</section>

</div>