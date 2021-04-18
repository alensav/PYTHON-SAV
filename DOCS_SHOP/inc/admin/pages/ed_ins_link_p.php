<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/editor');
?>
<!DOCTYPE html><html>
<head>
<meta http-equiv="Content-type" CONTENT="text/html; charset=<?php echo $sett['charset']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $lang['ilink']; ?></title>
<script type="text/javascript">
function inparams(){
linkurl.value=window.dialogArguments[0];
linktext.value=window.dialogArguments[1];
}
</script>
<script type="text/javascript" for="Ok" event="onclick">
window.returnValue=Array(linkurl.value,linktext.value,linktarget.value);
window.close();
</script>
</head>
<body bgcolor=menu onload="inparams();"><center><table>
<tr><td><?php echo $lang['link_url']; ?></td><td><input type="text" id="linkurl" size="30"></td></tr>
<tr><td><?php echo $lang['link_text']; ?></td><td><textarea id="linktext" cols="23" rows="3"></textarea></td></tr>
<tr><td><?php echo $lang['link_target']; ?></td><td><select id="linktarget"><option value=""><?php echo $lang['target_self']; ?>
<script type="text/javascript">
if(window.dialogArguments[2]=='_blank'){document.write('<option value="_blank" selected><?php echo $lang['target_blank']; ?></select>');}else{document.write('<option value="_blank"><?php echo $lang['target_blank']; ?></select>');}
</script>
</td></tr>
</table>
<br><button id="Ok" onclick="insert_link();"><?php echo $lang['apply']; ?></button> &nbsp; &nbsp; <button onclick="window.close();"><?php echo $lang['cancel']; ?></button></center>
</body></html>