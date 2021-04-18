// Copyright (c) Igor Anikeev
// http://www.arwshop.ru/
// Если включена анимация, то в файлах дизайна category.tpl, main.tpl, manufacturer.tpl, search.tpl, product_detail.tpl
// основные изображения товаров {product_small_image} (в файле product_detail.tpl {product_image}),
// которые в форме добавления в корзину должны быть помещены в контейнер div
// с атрибутом id="primage{product_id}"

// 1 - включить анимацию, 0 - отключить
var animation = 1 ;

// количество пикселей перемещения за один цикл при анимации
var aniPixels = 2 ;

// временной промежуток анимации в миллисекундах
var aniInterval = 3 ;

// размер в пикселях, до которого уменьшать изображение (только ширина или только высота)
var minImgSize = 100 ;

function gParams(s){var t=s.split('=');if(t[0]=='cart_add'){jsCartAdd=t[1];}}
function getsEngineURL(){
var sn='/ht/jscart.js';
var s=document.getElementsByTagName('script');
 for(var i=0;i<s.length;i++){
 var pos=s[i].src.indexOf(sn);
  if(pos!=-1){
  gParams(s[i].src.substring(pos+sn.length+1));
  return s[i].src.substring(0,pos+1);
  }
 }
return '/';
}
function wpcOnload(){getCart();}
function getXmlHttp(){
var xmlhttp;
 try{
 xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 }
 catch(e){
  try{
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  catch(E){
  xmlhttp = false;
  }
 }
 if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
 xmlhttp = new XMLHttpRequest();
 }
return xmlhttp;
}
function getHttp(url, callBackFunc){
var req = getXmlHttp();
 req.onreadystatechange = function(){  
  if(req.readyState==4){
   if(req.status == 200){
   callBackFunc(req.responseText);
   }
  }
 }
 try{
 req.open('GET', url, true);  
 req.send(null);
 }
 //в случае ошибки отключаем javascript режим добавления товаров
 catch(e){
 jsCartAdd=0;
 }
}
function postHttp(url, postData, callBackFunc){
var req = getXmlHttp();
 req.onreadystatechange = function(){  
  if(req.readyState==4){
   if(req.status == 200){
   callBackFunc(req.responseText);
   }
  }
 }
req.open('POST', url, true);
req.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
req.send(postData);
}
function getCart(){
getHttp(sEngineURL+'cart.php?independ=1&scarttype=2',
  function(data){
  document.getElementById('jscart').innerHTML=data;
  updatecPrTotalQuantity();
  }
);
}
function postForm(form){
var postData='';
 for(i=0;i<form.elements.length;i++){
 postData+=form.elements[i].name+'='+form.elements[i].value+'&';
 }
document.body.style.cursor='wait';
postHttp(sEngineURL+'cart.php?independ=1&scarttype=2', postData,
  function(data){
  document.getElementById('jscart').innerHTML=data;
  updatecPrTotalQuantity();
   if(jsCartAdd==2){
    if(animation && is_object('primage'+form.name.substring(6))){
    addCartAni(form);
    jcMessage(lang['product_sended']);
    }
    else{
    jcMessage(lang['product_sended']);
    }
   }
  document.body.style.cursor='auto';
  }
);
return true;
}
function updatecPrTotalQuantity(){
var tQ=0;
var qspans=document.getElementsByTagName('span');
 for(var i=0;i<qspans.length;i++){
  if(qspans[i].id.substring(0,12)=='cPrQuantity_'){
  tQ+=Number(qspans[i].innerHTML);
  }
 }
//var newContent=document.createTextNode(tQ+' ');
//document.getElementById('cPrTotalQuantity').appendChild(newContent);
//добавляем пробел, т.к. в IE он пропадает
document.getElementById('cPrTotalQuantity').innerHTML=' '+tQ+' ';
 if(tQ>0){
 document.getElementById('emptyCartContent').style.display='none';
 document.getElementById('filledCartContent').style.display='block';
 }
 else{
 document.getElementById('emptyCartContent').style.display='block';
 document.getElementById('filledCartContent').style.display='none';
 }
}
//возвращает абсолютные координаты клика мышью
//clickEvent - object.onclick=function(clickEvent){...}
function clicKAbsolutePos(clickEvent){
 try{
 //IE6 вернет ошибку
 var pos={x:Number(clickEvent.pageX), y:Number(clickEvent.pageY)};
 }
 catch(e){
 var pos={x:-1, y:-1};
 }
 //если NaN
 if(isNaN(pos.x) || isNaN(pos.y)){
 pos={x:-1, y:-1};
 }
return pos;
}
function jsCartInit(){
if(! jsCartAdd){return;}
window.onload=function(){
var f=document.getElementsByTagName('form');
 for(var i=0;i<f.length;i++){
  if(f[i].name.substring(0,6)=='addfrm'){
   //если Во всплывающем окне
   if(jsCartAdd==1){
   f[i].action=sEngineURL+'cart.php?independ=1';
   f[i].target='wppcart';
    f[i].onsubmit=function(){
    var wwidth=560;var wheight=380;
    wpc=window.open(sEngineURL+'cart.php?independ=1', 'wppcart', 'resizable,scrollbars,width='+wwidth+',height='+wheight+',left='+(screen.width/2-wwidth/2)+',top='+(screen.height/2-wheight/2));
    };
   }
   //если Без открытия страницы
   else if(jsCartAdd==2){
   f[i].action=sEngineURL+'cart.php?independ=1&scarttype=2';
   f[i].onsubmit=function(){postForm(this);return false;};
   f[i].onclick=function(clickEvent){lastClickPos=clicKAbsolutePos(clickEvent);};
   }
  }
 }
if(onloadPrev!=null&&onloadPrev!='undefined'){onloadPrev();}
};
getCart();
}
function jcMessage(msg){
 //координаты клика могут быть 0 (или <0 в IE) если форма отправлена не кликом а клавишей Enter
 if(lastClickPos.x<1 || lastClickPos.y<1){
 alert(msg);
 return;
 }
var m=document.getElementById('jcMsg');
m.innerHTML=msg;
m.style.left=lastClickPos.x+14+'px';
m.style.top=lastClickPos.y-14+'px';
m.style.display='block';
setTimeout(function(){m.style.display='none';}, 4000);
}
//функции анимации
var aniTId=0;
var mcTbl=new Array();
function addCartAni(form){
clearTimeout(aniTId);
document.getElementById('dAni').style.display='none';
document.getElementById('dAni').innerHTML='';
var dImgDName='primage'+form.name.substring(6);
var prId=form.name.substring(6);
var images=document.getElementsByTagName('img');
var imgSize={width:0,height:0};
 for(var i=0;i<images.length;i++){
  if(isImgParent(images[i].parentNode,dImgDName)){
  var img=new Image();
  img.id='mImg';
  img.src=images[i].src;
  img.width=images[i].width;
  img.height=images[i].height;
  img.style.borderLeft='1px outset #AAAAAA';
  img.style.borderTop='1px outset #AAAAAA';
  img.style.borderRight='1px outset #AAAAAA';
  img.style.borderBottom='1px outset #AAAAAA';
  document.getElementById('dAni').appendChild(img);
  imgSize={width:img.width,height:img.height};
  break;
  }
 }
 if(! imgSize.width || ! imgSize.height){
 jcMessage(lang['product_sended']);
 return;
 }
var jscartPos=absolutePosition(document.getElementById('jscart'));
var dImgPos=absolutePosition(document.getElementById(dImgDName));
document.getElementById('dAni').style.left=dImgPos.x+'px';
document.getElementById('dAni').style.top=dImgPos.y+'px';
document.getElementById('dAni').style.display='block';
var dAniPos=absolutePosition(document.getElementById('dAni'));
var posDiff={x:jscartPos.x-dAniPos.x,y:jscartPos.y-dAniPos.y};
//расстояние по осям x и y с избавлением от минуса возведением в квадрат и извлечением кв.корня
var distanceXY={x:Math.sqrt(kv(posDiff.x)),y:Math.sqrt(kv(posDiff.y))};
var posSign={x:0,y:0};
 if(posDiff.x<0){
 posSign.x=-1;
 }
 else{
 posSign.x=1;
 }
 if(posDiff.y<0){
 posSign.y=-1;
 }
 else{
 posSign.y=1;
 }
var sizeK=imgSize.width/imgSize.height;
var distance=Math.sqrt(kv((jscartPos.x-dAniPos.x))+kv((jscartPos.y-dAniPos.y)));
var qwCycles=distance/aniPixels/aniInterval;
var xMoveCycles=distanceXY.x/aniPixels;
var yMoveCycles=distanceXY.y/aniPixels;
moveCyclesK=Math.max(xMoveCycles,yMoveCycles)/Math.min(xMoveCycles,yMoveCycles);
var mcCount=Math.ceil(Math.max(xMoveCycles,yMoveCycles));
var tmp=new Array();
var kSum=moveCyclesK;
 for(var i=0;i<mcCount;i++){
 var n='n'+Math.round(kSum);
 tmp[n]=true;
 kSum+=moveCyclesK;
 }
mcTbl=new Array();
 for(var i=0;i<mcCount;i++){
  if(tmp['n'+i]==true){
  mcTbl[i]=true;
  }
  else{
  mcTbl[i]=false;
  }
 }
tmp=null;
var minPx=(imgSize.width+imgSize.height)/2;
var minPxInCycle=Math.round(minPx/qwCycles/aniInterval/1.1);
if(minPxInCycle<1){minPxInCycle=1;}
moveD(dAniPos,jscartPos,posSign,imgSize,minPxInCycle,sizeK,distanceXY,0);
}
function kv(n){return n*n;}
function moveD(dAniPos,jscartPos,posSign,imgSize,minPxInCycle,sizeK,distanceXY,cycleNumber){
var xMove=0,yMove=0;
 if(distanceXY.x>=distanceXY.y){
  if(dAniPos.x*posSign.x<jscartPos.x*posSign.x){
  xMove=aniPixels*posSign.x;
  dAniPos.x+=xMove;
   if(mcTbl[cycleNumber]){
   yMove=aniPixels*posSign.y;
   dAniPos.y+=yMove;
   }
  }
 }
 else{
  if(dAniPos.y*posSign.y<jscartPos.y*posSign.y){
  yMove=aniPixels*posSign.y;
  dAniPos.y+=yMove;
   if(mcTbl[cycleNumber]){
   xMove=aniPixels*posSign.x;
   dAniPos.x+=xMove;
   }
  }
 }
cycleNumber++;
document.getElementById('dAni').style.left=dAniPos.x+'px';
document.getElementById('dAni').style.top=dAniPos.y+'px';
imgSize.width-=minPxInCycle;
imgSize.height=Math.round(imgSize.width/sizeK);
 if(imgSize.width>minImgSize || imgSize.height>minImgSize){
 document.getElementById('mImg').width=imgSize.width;
 document.getElementById('mImg').height=imgSize.height;
 }
 if((xMove||yMove)){
 aniTId=setTimeout(function(){moveD(dAniPos,jscartPos,posSign,imgSize,minPxInCycle,sizeK,distanceXY,cycleNumber);},aniInterval);
 }
 else{
 document.getElementById('dAni').style.display='none';
 }
}
function absolutePosition(obj){
var pos={x:obj.offsetLeft, y:obj.offsetTop};
 if(obj.offsetParent){
 var tmp=absolutePosition(obj.offsetParent);
 pos.x+=tmp.x;
 pos.y+=tmp.y;
 }
return pos;
}
function is_object(objName){
if(document.getElementById(objName)){return true;}return false;
}
function isImgParent(Obj,dImgDName){
if(Obj.parentNode==null){return false;}
 if(Obj.nodeName=='DIV'){
  if(Obj.id==dImgDName){
  return true;
  }
 }
return isImgParent(Obj.parentNode,dImgDName);
}
//END функции анимации
document.write('<div id="jscart"></div>');
//во избежание смещения из-за позиционирования элементов дизайна создаём jcMsg динамически и помещаем в начало body
var jcMsg=document.createElement('div');
jcMsg.setAttribute('id','jcMsg');
jcMsg.setAttribute('style','position:absolute;display:none;z-index:98;background-color:#ffffff;color:#000000;font-size:16px;font-weight:bold;border:2px solid #009d00;padding:5px;   border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;cursor:pointer;');
jcMsg.onclick=function(){document.location.href='#';this.style.display='none';};
//document.body.appendChild(jcMsg);
document.body.insertBefore(jcMsg,document.body.firstChild);
var jsCartAdd=0;
var sEngineURL=getsEngineURL();
var lastClickPos={x:0, y:0};
//если отсутствует lang
if(typeof lang=='undefined'){var lang=new Array();lang['product_sended']='Товар отправлен в корзину';}
 if(animation){
 //во избежание смещения из-за позиционирования элементов дизайна создаём dAni динамически и помещаем в начало body
 var dAni=document.createElement('div');
 dAni.setAttribute('id','dAni');
 dAni.setAttribute('style','position:absolute;display:none;z-index:99;');
 //document.body.appendChild(dAni);
 document.body.insertBefore(dAni,document.body.firstChild);
 }
var onloadPrev=window.onload;
jsCartInit();
