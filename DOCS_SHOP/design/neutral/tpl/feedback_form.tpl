<form action="{relative_url}pages.php" method="POST" class="feedback_form">
<input type="hidden" name="view" value="content">
<input type="hidden" name="pname" value="contacts">
<input type="hidden" name="send" value="1">
<h3>{lang.send_mail}</h3>
 <p><span class="req">*</span> - {lang.required_fields}</p>
 <table class="coltbl" style="border:0px;">
  <tr> 
   <td>{lang.your_email} <span class="req">*</span><br>
   <input type="email" name="email" value="{email}" placeholder="example@example.com" maxlength="128" size="40">
   </td>
  </tr>
  <tr> 
   <td>{lang.first_name} <span class="req">*</span><br>
   <input name="first_name" value="{first_name}" type="text" size="40" maxlength="128">
   </td>
  </tr>
  <tr> 
   <td>{lang.subject} <span class="req">*</span><br>
   <input name="subject" value="{subject}" type="text" size="40" maxlength="128">
   </td>
  </tr>
  <!--begin:additional_fields-->
  <tr> 
   <td>{field_description} {required}<br>
   {field}
   </td>
  </tr>
  <!--end:additional_fields-->
  <tr> 
   <td>{lang.mail_text} <span class="req">*</span><br>
   <textarea name="mailtext" cols="48" rows="10">{mailtext}</textarea>
   </td>
  </tr>
  <tr> 
   <td>
    <!--if:antibot_feedback-->
    <span class="req">*</span> {lang.protect_code}<br><input type="text" name="protect_code" size="10" maxlength="6"><img src="{random_image_url}" alt="{lang.protect_code}" class="protectImg"><br><br>
    <!--/if:antibot_feedback-->
    <input type="submit" value="{lang.submit}">
   </td>
  </tr>
 </table>
</form>