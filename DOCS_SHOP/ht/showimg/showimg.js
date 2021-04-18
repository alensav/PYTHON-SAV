//Copyright (c) Igor Anikeev
//http://www.arwshop.ru/
//Скрипт для увеличения изображений
//Подключение: в начало  файла дизайна product_detail.tpl вставить код <script type="text/javascript" src="{relative_url}ht/showimg/showimg.js"></script>
//Вызов: showimg('URL большого изображения');
//Перелисывание изображений стрелками влево-вправо возможно, если {product_image} и {gallery_image}
//в файле дизайна product_detail.tpl заданы в виде
//<div id="primage{product_id}" class="prDtImg">{product_image}</div>
//<div class="prGalImg">{gallery_image}</div>

//transpBackgr серый полупрозрачный фон: 0 - нет, 1 - да
//отображается на всю высоту со скроллингом только еслив стилях для элемента body свойство position имеет значение relative или absolute (пример: body{position:relative;})

transpBackgr = 1 ;


function getClientWidth(){  
return  document.documentElement.clientWidth;
}

function getClientHeight(){
 try{
  if(document.doctype==null){
   if(typeof(window.innerHeight)!='undefined'){
   return parseInt(window.innerHeight);
   }
  return document.documentElement.clientHeight;
  }
 }
 catch(e){}
return document.documentElement.clientHeight;
}

function getBodyScrollTop(){
return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);  
}

function getBodyScrollLeft(){
return self.pageXOffset || (document.documentElement && document.documentElement.scrollLeft) || (document.body && document.body.scrollLeft);  
}

function getClientCenterX(){
return parseInt(getClientWidth()/2)+getBodyScrollLeft();  
}

function getClientCenterY(){
return parseInt(getClientHeight()/2)+getBodyScrollTop();  
}

function setWinPosition(){
var winLeft=getClientCenterX()-sImgSize['width']/2-5;
 if(winLeft<0){
 winLeft=0;
 }
var winTop=getClientCenterY()-sImgSize['height']/2;
 if(winTop<0){
 winTop=0;
 }
document.getElementById('imgwin').style.left=winLeft+'px';
document.getElementById('imgwin').style.top=winTop+'px';
}

//перелистывает изображение
function siListImg(route){
 if(route=='prev'){
 imgListDefIndex--;
 }
 else if(route=='next'){
 imgListDefIndex++;
 }
 if(imgListDefIndex>=sImgList.length){
 imgListDefIndex=0;
 }
 else if(imgListDefIndex<0){
 imgListDefIndex=sImgList.length-1;
 }
showimg(sImgList[imgListDefIndex]);
}

//получает список всех изображений товара по именам классов prDtImg и prGalImg у div
function siGetImgList(){
 if(sImgList.length>0){
 return;
 }
var divs=document.getElementsByTagName('div');
 for(var i=0;i<divs.length;i++){
  if(divs[i].className=='prDtImg' || divs[i].className=='prGalImg'){
  var img=divs[i].getElementsByTagName('img');
   if(img.length==1){
   var onCl=img[0].onclick.toString();
   //ищем URL (\s\S - любые смиволы, включая новую строку)
   var reg=/[\s\S]*showimg\([\'\"]{1,1}([^\'\"]*)[\'\"]{1,1}\)[\s\S]*/;
    if(onCl.match(reg)){
    var showUrl=onCl.replace(new RegExp(reg),'$1');
     if(showUrl){
     sImgList.push(showUrl);
     sImgAlts.push(img[0].alt);
     }
    }
   }
  }
 }
}

function simgIndexBySrc(src){
 for(var i=0;i<sImgList.length;i++){
  if(sImgList[i]==src){
  return i;
  }
 }
return -1;
}

function showimg(img){
sHideImg();
siGetImgList();
imgListDefIndex=simgIndexBySrc(img);
 //если у товара болше 1 изображения
 if(sImgList.length>1){
 document.getElementById('PrevNext').style.visibility='visible';
 }
 else{
 document.getElementById('PrevNext').style.visibility='hidden';
 }
//размеры imgwin (по умолчанию loading.gif)
sImgSize['width']=220;
sImgSize['height']=196+closeBtnHeight;
 if(transpBackgr){
  //если не IE или если версия IE>=8
  if(! si_is_ie() || si_ie_version()>=8){
  document.getElementById('imgbg').style.visibility='visible';
  }
 }
document.getElementById('imgwin').style.width=sImgSize['width']+'px';
document.getElementById('imgwin').style.height=sImgSize['height']+'px';
setWinPosition();
window.onresize=function(){setWinPosition();};
//window.onscroll=function(){setWinPosition();};//изображения больше окна браузера будет невозможно прокрутить
document.getElementById('loadingImg').style.visibility='visible';
document.getElementById('loadingImg').style.display='inline';
document.getElementById('imgwin').style.visibility='visible';
var sBImg=document.getElementById('sBigImg');
//onerror лучше не использовать, т.к. нек.браузеры могут вызывать это события когда вздумают,
//напр. Opera 12 после второго клика
//sBImg.onerror=function(){setTimeout(function(){sBImg.src=showimgDir+'error.gif';}, 1000);};
sBImg.onload=function(){sDisplayImg(sBImg);};
sBImg.src=img;
//sBImg.src=img+'?rnd='+rnd;//тест с запертом кэширования (см.также IMG-TORMOZ.php)
sBImg.title=sImgAlts[imgListDefIndex];
document.getElementById('imgwin').onclick=function(){sHideImg();};
window.onkeyup=function(winEvent){if(winEvent.keyCode==27){sHideImg();}else if(winEvent.keyCode==37){siListImg('prev');}else if(winEvent.keyCode==39){siListImg('next');}};
}

function sDisplayImg(imgObj){
sImgSize['width']=imgObj.width;
sImgSize['height']=imgObj.height+closeBtnHeight;
document.getElementById('imgwin').style.width=sImgSize['width']+'px';
document.getElementById('imgwin').style.height=sImgSize['height']+'px';
document.getElementById('sLBImages').style.overflow='auto';
document.getElementById('loadingImg').style.visibility='hidden';
document.getElementById('loadingImg').style.display='none';
document.getElementById('sBigImg').style.visibility='visible';
setWinPosition();
}

function sHideImg(){
document.getElementById('sBigImg').style.visibility='hidden';
document.getElementById('PrevNext').style.visibility='hidden';
//src не должно быть пустым, должен быть существующий файл, т.к. IE11 вызовет событие onerror; это же относится и к начальному изображению в div
document.getElementById('sBigImg').src='loading.gif';
document.getElementById('sBigImg').onload=function(){};//отменяем sDisplayImg в случае закрытия до загрузки изображения
document.getElementById('sBigImg').onerror=function(){};
document.getElementById('loadingImg').style.visibility='hidden';
document.getElementById('sLBImages').style.overflow='hidden';
document.getElementById('imgwin').style.visibility='hidden';
document.getElementById('imgbg').style.visibility='hidden';
window.onkeyup=null;
}

//возвр. url директории в которой скрипт (IE6 возвращает без http и домена)
//вызывать только при загрузке скрипта, т.к. url берется scripts[scripts.length-1].src
function getScriptDir(){
var scripts=document.getElementsByTagName('script');
var href=scripts[scripts.length-1].src || location.href;//последний из списка. Если SRC нет, значит, внедренный, и берем адрес самой страницы
href=href.replace(/[#\?].*/g, '');//удаляем из URL query string
return href.replace(/[^\/]*$/, '');//удаляем все после последнего слеша
}

function si_is_ie(){
if(navigator.userAgent.toLowerCase().indexOf('msie')==-1 && navigator.userAgent.toLowerCase().indexOf('trident/')==-1){return false;}
if(navigator.appName.toLowerCase().indexOf('internet explorer')==-1 && navigator.appName.toLowerCase().indexOf('netscape')==-1){return false;}
if(navigator.userAgent.toLowerCase().indexOf('opera')!=-1){return false;}
return true;
}

//Возвращает версию IE. Если не удалось определить версию, возвращает -1 (перед вызовом надо проверять IE или нет)
function si_ie_version(){
 try{
 //ищем MSIE
 var reg=/\x20\x4D\x53\x49\x45\x20([1-9]{1,2}\.[0-9]{1,})\;/;
 var match=reg.exec(navigator.userAgent);
  if(match != null) {
  return match[1];
  }
 //если не нашли MSIE ищем rv: (начиная с версии 11)
 reg=/\x20\x72\x76\:([1-9]{1,2}\.[0-9]{1,})/;
 match=reg.exec(navigator.userAgent);
  if(match != null) {
  return match[1];
  }
 return -1;
 }
 catch(e){return -1;}
}

var showimgDir=getScriptDir();
document.write('<style>#imgwin a{color:#ffffff;}</style><div id="imgbg" style="visibility:hidden;position:absolute;left:0px;top:0px;width:100%;height:100%;background-color:#333333;opacity:0.8;z-index:1;" onclick="sHideImg();"></div><div id="imgwin" style="border:ridge 6px #777777;visibility:hidden;position:absolute;z-index:2;background-color:#3A3A3A;min-width:100px;min-height:40px;max-width:100%;margin:0px;padding:0px 0px 5px 0px;"><div id="sCloseImgBl" style="float:right;margin:0px;padding:0px;font-size:20px;" onclick="sHideImg();"><img src="'+showimgDir+'close.gif" alt="" title="(Escape)" style="vertical-align:middle;margin:0px;padding:0px;"></div><div id="PrevNext" style="text-align:center;">&nbsp;<a href="javascript:siListImg(\'prev\');">&larr;</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:siListImg(\'next\');">&rarr;</a>&nbsp;</div><div style="clear:both;"></div><div id="sLBImages" style="margin:0px;padding:0px;"><img id="loadingImg" src="'+showimgDir+'loading.gif" style="visibility:hidden;margin:0px;padding:0px;"><img id="sBigImg" src="'+showimgDir+'loading.gif" style="visibility:hidden;margin:0px;padding:0px;max-width:'+(getClientWidth()-31)+'px;"></div></div>');
var closeBtnHeight=24;//24 высота div с кнопкой закрытия
//размеры imgwin (по умолчанию loading.gif)
var sImgSize=new Array();
var sImgList=new Array();
var sImgAlts=new Array();
var imgListDefIndex=0;
var rnd=Math.random();
