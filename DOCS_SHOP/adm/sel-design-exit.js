//Скрипт используется когда в основной конфигурации выбран другой дизайн, но не сохранены изменения

function sde_is_ie(){
if(navigator.userAgent.toLowerCase().indexOf('msie')==-1 && navigator.userAgent.toLowerCase().indexOf('trident/')==-1){return false;}
if(navigator.appName.toLowerCase().indexOf('internet explorer')==-1 && navigator.appName.toLowerCase().indexOf('netscape')==-1){return false;}
if(navigator.userAgent.toLowerCase().indexOf('opera')!=-1){return false;}
return true;
}
//Возвращает версию IE. Если не удалось определить версию, возвращает -1 (перед вызовом надо проверять IE или нет)
function sde_ie_version(){
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
function formChanged(){
 if(sde_is_ie() && sde_ie_version() < 11){
 return;
 }
 window.onbeforeunload=function(evt){
  if(typeof evt=='undefined'){
  evt=window.event;
  }
  if(evt){
  evt.returnValue=sdeMsg;
  }
 return sdeMsg;
 };
}
