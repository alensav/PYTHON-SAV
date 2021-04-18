// Copyright (c) Igor Anikeev
// http://www.arwshop.ru/
function printpage(lang){
var pwin=window.open();
pwin.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'+lang['title']+'</title><link href="adm/print-order.css" rel="stylesheet" type="text/css"></head><body><div id="printLink" align="right"><img src="adm/img/print.gif" border="0">&nbsp;<a href="#" onclick="printLink.style.display=\'none\';print();return false;">'+lang['print']+'</a></div>'+document.getElementById('dPrint').innerHTML+'</body></html>');
pwin.document.close();
pwin.document.getElementById('editPrLnk').style.display='none';
var el=pwin.document.getElementsByTagName('td');
 for(var i=0;i<el.length;i++){
 if(el[i].innerHTML==''){el[i].innerHTML='&nbsp;';}
 }
var el=pwin.document.getElementsByTagName('A');
 for(var i=0;i<el.length;i++){
 el[i].href='#';
 }
}
