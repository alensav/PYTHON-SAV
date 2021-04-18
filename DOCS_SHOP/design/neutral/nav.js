// Copyright (c) Igor Anikeev
// http://www.arwshop.ru/
//Навигация в адаптивном дизайне
//js onclick нужно т.к. в IE и в Edge с планшета без мыши не срабатывает css hover по одному клику, а при имитации двойного клика открывается меню браузера. Позволяет фиксировать открытое меню в IE и в Edge
var lastZIndex=999;

//В IE ниже 9 нет функции getElementsByClassName, здесь она добавляется
function getByClassInit(){
 //если функция getElementsByClassName существует
 if(document.getElementsByClassName){
 getByClassInited=true;
 return;
 }
var els=document.body.getElementsByTagName('*');
 for(var i=0;i<els.length;i++){
 //Проверено для IE 6 и выше и должно работать в других старых браузерах
 els[i].getElementsByClassName=function(class_name){

  var elements=this.getElementsByTagName("*"),length=elements.length,out=[],i2;
   for (i2 = 0; i2 < length; i2 += 1) {
   //Поместим в массив элементы, содержащие требуемый класс
    if (elements[i2].className.indexOf(class_name) !== -1){
    out.push(elements[i2]);
    }        
   }
  return out;

  };
 }
getByClassInited=true;
}
var getByClassInited=false;

function nav_is_ie(){
if(navigator.userAgent.toLowerCase().indexOf('msie')==-1 && navigator.userAgent.toLowerCase().indexOf('trident/')==-1){return false;}
if(navigator.appName.toLowerCase().indexOf('internet explorer')==-1 && navigator.appName.toLowerCase().indexOf('netscape')==-1){return false;}
if(navigator.userAgent.toLowerCase().indexOf('opera')!=-1){return false;}
return true;
}

function nav_is_edge(){
 if(navigator.userAgent.indexOf(' Edge/')!=-1){
 return true;
 }
return false;
}

function sidebarInit(){
 //Если не IE и не Edge
 if(! nav_is_ie() && ! nav_is_edge()){
 return;
 }
 if(! getByClassInited){
 getByClassInit();
 }
var sidebar=document.getElementById('sidebar');
var menusHdr=sidebar.getElementsByClassName('mnuHdr');
 for(var i=0;i<menusHdr.length;i++){
  menusHdr[i].onclick=function(){
  mnuBody=this.parentNode.getElementsByClassName('mnuBody');
  addRemoveClass(mnuBody[0],'mnuBodyOpened');
  };
 }
}

//Показывает элемент если он скрыт, прячет если он не скрыт
//objId - id объекта
//newDisplay (не обязательный параметр) - значение CSS свойства display в видимом состоянии: block, inline и т.д. (по умолчанию block)
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

//Добавляет элементу дополнительный CSS класс (например, было class="qwe" стало class="qwe asd"), убирает добавленный, если уже добавлен
//obj - объект или id объекта
//addClass - добавляемый CSS класс
function addRemoveClass(obj,addClass){
 //если не объект а id
 if(typeof obj !== 'object'){
 var obj=document.getElementById(obj);
 }
var pos=obj.className.indexOf(' '+addClass);
 if(pos!=-1){
 obj.className=obj.className.substring(0,pos);
 }
 else{
 obj.className+=' '+addClass;
 lastZIndex++;
 obj.style.zIndex=lastZIndex;
 }
}

//Закрывает все подменю объекта sidebar
function sidebarCloseAllMenu(){
 if(! getByClassInited){
 getByClassInit();
 }
var sidebar=document.getElementById('sidebar');
 //если закрыт
 //if(sidebar.className=='sidebar'){
 var menus=sidebar.getElementsByClassName('mnuBody');
  for(var i=0;i<menus.length;i++){
  menus[i].className='mnuBody';
  }
 //}
}

//скрывает выбор валюты при прокрутке сртраницы вниз
function hideSelCurrencyOnScroll(){
onscrollPrev=window.onscroll;
window.onscroll=function(){
 var s=window.pageYOffset;
 var f=document.getElementById('frmSelCurrency');
  if(s>400){
  f.style.display='none';
  }
  else{
  f.style.display='block';
  }
  if(onscrollPrev != null && onscrollPrev != 'undefined'){
  onscrollPrev();
  }
 };
}
var onscrollPrev;
