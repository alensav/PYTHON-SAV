<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
if(! defined('SYS_LOADER')){die();}
$custom->get_lang('admin_lang/help');
?>
<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html; charset=<?php echo $sett['charset']; ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo $lang['title_help']; ?></title>
<style type="text/css">
.code{color:#0000ff;}
</style>
</head><body text="#000000" bgcolor="#FFFFFF">
<?php
switch($_GET['hpage']){

case 'payment_blanks_add_poss':
echo file_get_contents(SCRIPT_DIR."/lang/$sett[lang]/admin_lang/help/payment_blanks_add_poss.tpl");
break;

}
?><p align="center"><a href="javascript:self.close()"><?php echo $lang['close_window']; ?></a></p>
</body></html>
