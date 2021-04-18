// Copyright (c) Igor Anikeev
// http://www.arwshop.ru/
// Скрипт позволяет сразу визуально изменять отображаемую цену товара при выборе посетителем дополнительных опций товара с разницей в цене до добавления товара в корзину.
// Установка:
// 1. Загрузите на сайт в папку ht файл proptions.js
// 2. Добавьте в основной файл дизайна design.tpl (файл находится в папке design/имя_дизайна/tpl) после закрывающего тега </body> следующий HTML-код:
// <script type="text/javascript" src="{relative_url}ht/proptions.js"></script>
// 3. В файлах дизайна category.tpl, main.tpl, manufacturer.tpl, product_detail.tpl, search.tpl замените метку {product_price} следующим HTML-кодом:
// <span id="pprice{product_id}">{product_price}</span>

var oldoptions=new Array();
options_init();

function options_init(){
var dforms=document.getElementsByTagName('form');
 for(var fi=0;fi<dforms.length;fi++){
  if(dforms[fi].name.substring(0,6)=='addfrm'){
  var els=dforms[fi].elements;
  var productid=0;
   for(var ei=0;ei<els.length;ei++){
    if(els[ei].name=='product' && productid==0){
    productid=els[ei].value;
    //начинаем цикл сначала на тот случай если <input type="hidden" name="product" value="{product_id}"> в коде располагается ниже доп.опций товаров
    ei=-1;
    }
    else if(els[ei].name.substring(0,16)=='product_options[' && productid>0){
    oname='p'+productid+'_'+els[ei].name;
    oldoptions[oname]='... (0.00 #)';
    //присваиваем новое свойство sprid
    els[ei].sprid=productid;
    els[ei].onchange=function(){ochprice(this);}
    ochprice(els[ei]);
    oldoptions[oname]=opttext(els[ei]);
    }
   }
  }
 }
}

function ochprice(sobj){
var productid=sobj.sprid;
var newpricedif=price_from_text(opttext(sobj));
var oname='p'+productid+'_'+sobj.name;
var oldpricedif=price_from_text(oldoptions[oname]);
var pricespan=document.getElementById('pprice'+productid);
var defprice=unFormatPrice(pricespan.innerHTML);
var newprice=format_price(defprice-oldpricedif+newpricedif);
pricespan.innerHTML=newprice;
oldoptions[oname]=opttext(sobj);
}

function price_from_text(text){
var price=' '+text;
delim1=' (';
delim2=')';
var pos1=strrpos(price,delim1);
 if(pos1==-1){
 return 0.00;
 }
var pos2=price.indexOf(delim2,pos1);
 if(pos2==-1){
 return 0.00;
 }
price=price.substring(pos1+2,pos2);
pos1=strrpos(price,' ');
price=price.substring(0,pos1);
 if(price.substring(0,1)=='+'){
 price=price.substring(1);
 }
return unFormatPrice(price);
}

function opttext(sobj){
 for(var i=0;i<sobj.options.length;i++){
  if(sobj.options[i].value==sobj.value){
  return sobj.options[i].innerHTML;
  }
 }
return '';
}

function is_object(objName){
if(document.getElementById(objName)){return true;}return false;
}

function strrpos(text, srch){
return text.lastIndexOf(srch);
}

//method=1 -без учета регистра
function str_replace(str,srchstr,replstr,method){
//экранирование символов в srchstr
srchstr=srchstr.replace(/(?=.)/g,'\\');
if(method==1){modifer='gi';}else{modifer='g';}
return str.replace(new RegExp(srchstr,modifer),replstr);
}

function format_price(number){
return number_format(number, 2, '.', ' ');
}

function unFormatPrice(price){
price=str_replace(price,' ','',0);
return parseFloat(price);
}

function number_format(number, decimals, dec_point, thousands_sep) { // Format a number with grouped thousands
	    // 
	    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +     bugfix by: Michael White (http://crestidg.com)
	 
	    var i, j, kw, kd, km;
	 
	    // input sanitation & defaults
	    if( isNaN(decimals = Math.abs(decimals)) ){
	        decimals = 2;
	    }
	    if( dec_point == undefined ){
	        dec_point = ",";
	    }
	    if( thousands_sep == undefined ){
	        thousands_sep = ".";
	    }
	 
	    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
	 
	    if( (j = i.length) > 3 ){
	        j = j % 3;
	    } else{
	        j = 0;
	    }
	 
	    km = (j ? i.substr(0, j) + thousands_sep : "");
	    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
	    //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
	    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
	 
	 
	    return km + kw + kd;
	}
