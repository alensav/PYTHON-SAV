<section class="product_detail">
<script type="text/javascript" src="{relative_url}ht/showimg/showimg.js"></script>
<script type="text/javascript" src="{design_url}product-tabs.js"></script>

<div class="prDtSpecial">{special_text}</div>

<div class="prDtChainLnk">{lang.category} <a href="{shop_index}">{lang.main}</a> / {category_chain_link}</div>

<div class="prDetail">
<h1>{product_title}</h1>



 <div id="prodTabs"><span id="TabDescript">{lang.product_descript}</span><span id="TabGallery">{lang.gallery}</span><span id="TabComments">{lang.comments} ({quantity_comments})</span></div>

 <div id="prodTabDescript">

  <div class="prDtMainInfo">
   <!--if:sku--><div class="prDtSku">{lang.sku}: {product_sku}</div><!--/if:sku-->
   <!--if:manufacturer--><div class="prDtMnf">{lang.manufacturer}: <a href="{manufacturer_url}">{manufacturer_title}</a></div><!--/if:manufacturer-->
   <!--if:old_price--><div class="old_price">{lang.old_price} <span>{old_price} {currency_brief}</span></div><!--/if:old_price-->
   <div class="price">{lang.price}: {product_price} {currency_brief}</div>
  </div>

  <!--if:in_stock-->
   <form name="addfrm{product_id}" action="{relative_url}cart.php" method="POST" class="frmPrDetail">
   <input type="hidden" name="act" value="add">
   <input type="hidden" name="product" value="{product_id}">
    <!--if:product_options-->
     <!--begin:product_options-->
     <div class="prOption">{option_name}: <select name="product_options[{option_id}]">{product_option_values}</select></div>
     <!--end:product_options-->
    <!--/if:product_options-->
    <div class="fpdSubmit"><input type="submit" value="{lang.add_to_cart}"><input type="text" name="product_quantity" value="1" size="4"></div>
   </form>
  <!--/if:in_stock-->

  <!--if:product_image-->
  <div id="primage{product_id}" class="prDtImg">{product_image}</div>
  <!--/if:product_image-->

  <div class="prDtDescript">{product_descript}</div>

  <div class="clear"></div>

  <div class="prDtQuantity">
  <!--if:not_quantity_txt-->{product_quantity}<!--/if:not_quantity_txt-->
  <!--if:quantity_txt--><!--/if:quantity_txt-->
  </div>

 </div><!-- закр. prodTabDescript -->



<div id="prodTabGallery">
 <!--if:product_gallery-->
  <div class="product_gallery">
   <!--begin:product_gallery-->
   <div class="prGalImg">
   {gallery_image}
   <!--if:cycle={gallery_quantity_columns}--><!--/if:cycle={gallery_quantity_columns}-->
   </div>
   <!--end:product_gallery-->
  </div>
 <!--/if:product_gallery-->
</div><!-- закр. prodTabGallery -->

<div id="prodTabComments">
{product_comments}
</div>



</div><!-- закр. prDetail -->

<!--if:similar_products-->
<div class="similar_products">
<h2>{lang.similar_products}</h2>
 <!--begin:similar_products-->
  <div class="similarProduct">
   <!--if:similar_small_image-->
   <div class="similarImg">{similar_small_image}</div>
   <!--/if:similar_small_image-->
  <div class="similarLink"><a href="{similar_url}">{similar_title}</a></div>
  <div class="price">{lang.price}: {similar_price} {currency_brief}</div>
  <!--if:cycle=100--><!--/if:cycle=100-->
  </div>
 <!--end:similar_products-->
</div>
<!--/if:similar_products-->

</section>

<script type="text/javascript">
prodTabsInit();
</script>