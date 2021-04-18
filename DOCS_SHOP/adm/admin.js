// Copyright (c) Igor Anikeev
// http://www.arwshop.ru/
function q(text){if(! confirm(lng_do_you_want+' '+text+'?')){return false;}else{return true;}}
function additem(){window.open('?view=product&act=additem&independ=1','','status,scrollbars,resizable,width=730,height=600');}
function editem(itemid){window.open('?view=product&act=editem&itemid='+itemid+'&independ=1','','status,scrollbars,resizable,width=730,height=600');}
//Показывает элемент если он скрыт, прячет если он не скрыт
//objId - id объекта
//newDisplay (не обязательный параметр) - значение CSS свойства display в видимом состоянии: block, inline и т.д. (по умолчанию block)
//js onclick нужно т.к. в IE и в Edge с планшета без мыши не срабатывает css hover по одному клику, а при имитации двойного клика открывается меню браузера. Позволяет фиксировать открытое меню в IE и в Edge
function showHideBlock(objId,newDisplay){
newDisplay = typeof newDisplay !== 'undefined' ?  newDisplay : 'block';
var obj=document.getElementById(objId);
 if(obj.style.display==newDisplay){
 obj.style.display='none';
 }
 else{
 obj.style.display=newDisplay;
 }
}
function getClientWidth(){
return  document.documentElement.clientWidth;
}
function menuOnresizeInit(){
 window.onresize=function(){
  if(getClientWidth() > 1000){
  document.getElementById('leftMenu').style.display='block';
  }
  else{
  document.getElementById('leftMenu').style.display='none';
  }
  if(onresizePrev!=null&&onresizePrev!='undefined'){
  onresizePrev();
  }
 };
}
var onresizePrev=window.onresize;
menuOnresizeInit();
