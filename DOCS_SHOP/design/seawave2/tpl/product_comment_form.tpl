 <!--if:independ_form-->
 <div class="addCommIndepend"><span id="acom"></span><strong>{lang.add_comment} {lang.to} <a href="{product_url}">{product_title}</a></strong></div>
 {error_message}
 <!--/if:independ_form-->

 <form action="{relative_url}pages.php?" method="POST" class="frmAddComment">
 <input type="hidden" name="product" value="{product_id}">
 <input type="hidden" name="add_product_comment" value="1">
 <input type="hidden" name="lastpage" value="{last_page}">
 <table>
  <tr>
   <td>{lang.sender_name} {required_name}</td>
   <td><input type="text" name="sender_name" value="{sender_name}"></td>
  </tr>
  <tr>
   <td>{lang.sender_email} {required_email}</td>
   <td><input type="text" name="sender_email" value="{sender_email}"></td>
  </tr>
  <tr>
   <td>{lang.scomment} <span class="req">*</span></td>
   <td><textarea name="scomment" cols="40" rows="9">{scomment}</textarea></td>
  </tr>
  <!--if:antibot-->
  <tr>
   <td>{lang.protect_code} <span class="req">*</span></td>
   <td><input type="text" name="protect_code" size="10"><img src="{random_image_url}" alt="{lang.imgcode}" class="protectImg"></td>
  </tr>
  <!--/if:antibot-->
  <tr>
   <td>&nbsp;</td>
   <td><input type="submit" value="{lang.send}"></td>
  </tr>
 </table>
 <div><span class="req">*</span> - {lang.required_fields}</div>
</form>