<div class="product_comments">

 <!--if:comments_exists-->
 <h3>{lang.product_comments} <a href="{product_url}#">{product_title}</a></h3>
 
  <!--begin:comments-->
  <div class="prComment">
   <div class="pComHdr">{sender_name} <span class="cpdate">{cpdate}</span></div>
   <div class="comment">
   {scomment}
    <!--if:admin_reply-->
    <div class="admin_reply">
     <div class="pComHdr">{admin_name} <span class="cpdate">{ardate}</span></div>
     <div class="comment">
     {admin_reply}
     </div>
    </div>
    <!--/if:admin_reply-->
   </div>
  </div>
  <!--end:comments-->

 <div class="pages_links">{pages_links}</div>

 <!--/if:comments_exists-->

 <!--if:not_comments_exists-->
 <div class="no_comments">{lang.no_comments}.</div>
 <!--/if:not_comments_exists-->

 <!--if:allow_add_authorized_only-->
  <!--if:not_authorized-->
  <div class="notAuthorizedComments">{lang.not_authorized}. <a href="{relative_url}pages.php?view=login&amp;lastpage={last_page}%23acom">{lang.enter}</a>.</div>
  <!--/if:not_authorized-->
 <!--/if:allow_add_authorized_only-->

 <!--if:allow_add_this_visitor-->
 <span id="acom"></span>
 <div id="pmdiv" style="cursor:pointer;" onclick="if(document.getElementById('shfr').style.display=='none'){document.getElementById('shfr').style.display='block';document.getElementById('pmdivimg').src='{design_url}img/minus.gif';}else{document.getElementById('shfr').style.display='none';document.getElementById('pmdivimg').src='{design_url}img/plus.gif';}">
 <img id="pmdivimg" src="{design_url}img/minus.gif" alt="" class="imgst"><strong>{lang.add_comment}</strong>
 </div>
 <div id="shfr">
 {comments_form}
 </div>
 <script type="text/javascript">
  if(document.location.href.substring(document.location.href.length-5)!='#acom'){
  document.getElementById('shfr').style.display='none';
  document.getElementById('pmdivimg').src='{design_url}img/plus.gif';
  }
 </script>
 <!--/if:allow_add_this_visitor-->

</div>