<div class="category">

<h1 class="catChainLnk">{lang.category} <a href="{shop_index}">{lang.main}</a> / {category_chain_link}</h1>

 <!--if:subcategories_exists-->
 <section class="subcategories">
 <h3 class="SubcatTitle">{lang.subcategories}</h3>
  <!--begin:subcategories-->
  <div class="SubCats">
  <a href="{category_url}">{category_title}<!--if:show_quantity-->&nbsp;({category_products_count})<!--/if:show_quantity--></a>
  <!--if:cycle={quantitycat_incolumn}--><!--/if:cycle={quantitycat_incolumn}-->
  </div>
  <!--end:subcategories-->
 </section>
 <!--/if:subcategories_exists-->

 <section class="catInfo">
  <!--if:category_image--><div class="category_image">{category_image}</div><!--/if:category_image-->
  <div class="category_description">{category_description}</div>
  <div class="clear"></div>
 </section>

<!--if:products-->

 <form action="{relative_url}sort.php" method="GET" class="frmSort">
  <input type="hidden" name ="cat" value="{category_id}">
  <div class="sortOrderBy">{lang.order_by} <select name="sort">{sort_options}</select> <select name="desc">{desc_options}</select></div>
  <div class="sortOnlyMnf">{lang.only_manufacturer} <select name="only_mnf">{manufacturer_options}</select><input type="submit" value="&gt;&gt;"></div>
 </form>

 <section class="catProducts">
  <!--begin:products-->
   <div class="lstProduct">
   <h3 class="pTitle"><a href="{product_url}">{product_title}</a></h3>
    <!--if:product_small_image-->
    <div id="primage{product_id}" class="prSmallImg">{product_small_image}</div>
    <!--/if:product_small_image-->
   <div class="price">{lang.price}: {product_price} {currency_brief}<!--if:old_price--> <span class="old_price2">({old_price} {currency_brief})</span><!--/if:old_price--></div>
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

 <div class="pages_links">{pages_links}</div>

 <!--/if:products-->

 <section class="cat_special">{special_text}</section>

</div>