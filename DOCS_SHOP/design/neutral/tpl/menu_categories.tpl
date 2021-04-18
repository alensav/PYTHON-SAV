<div class="menu_categories">
 <div class="mnuHdr">{lang.categories}</div>
 <div class="mnuBody">
  <ul>
  <!--begin:menu_categories-->
   <li><a href="{category_url}">{menu_image}{category_title}</a>
    <!--if:subcategories_exists-->
    <ul>
     <!--begin:subcategories-->
     <li><a href="{subcategory_url}">{submenu_image}{subcategory_title}</a>
      <!--if:recursion_exists--><ul>{recursion_cycle}</ul><!--/if:recursion_exists-->
     </li>
     <!--end:subcategories-->
    </ul>
    <!--/if:subcategories_exists-->
   </li>
   <!--end:menu_categories-->
   <li class="lEmpt"></li>
  </ul>
 </div>
</div>