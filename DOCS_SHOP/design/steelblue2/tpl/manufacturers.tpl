<section class="manufacturers">
<h1>{lang.manufacturers}</h1>
 <!--begin:manufacturers-->
 <div class="mnfRow">
  <!--if:manufacturer_image-->
  <div class="mnfRowImg">
  <a href="{manufacturer_local_url}"><img src="{relative_url}img/small/{manufacturer_image}" alt="{manufacturer_name}"></a>
  </div>
  <!--/if:manufacturer_image-->
  <div class="mnfRowDescr">
  <h3><a href="{manufacturer_local_url}">{manufacturer_name}</a></h3>
  {manufacturer_description}
  </div>
 </div>
 <div class="mnfRowSep"></div>
 <!--end:manufacturers-->
 <div class="pages_links">{pages_links}</div>
</section>