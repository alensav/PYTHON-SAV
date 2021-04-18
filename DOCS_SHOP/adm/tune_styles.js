// Copyright (c) Igor Anikeev
// http://www.arwshop.ru/
var edDoc; //iframe.document
var cssRules; //iframe.document.styleSheets[x].cssRules
var selectedPropertiesBlock = 0; //выбранный элемент в селектбоксе selectorsTexts, он же соответствует индексу правила в массиве cssData
var selectedPropertyName; //выбранный элемент в селектбоксе  propertiesBlock_x
defBrowserRuleIndex = -1; //текущий индекс cssRules
var ifrLoadCount = 0; //поскольку window.onunload нормально работает только в IE, вместо onunload определяем по ко-ву загрузки фрейма
var winImgUrlAction = ''; //что делать после выбора изображения в диалоговом окне
var jPickerUsed = false; //По ней проверяется подключён ли jPicker
var saveDisabled = false; //В случае старого браузера будет true для запрета сохранения

function badBrowser(){
saveDisabled = true;
alert(lang['bad_browser']);
}

function setWaitInterface(){
document.getElementById('toolbar').className = 'readOnlyBlock';
document.getElementById('waitForReadOnly').className = 'wait';
}

function setLoadedInterface(){
document.getElementById('toolbar').className = 'normalBlock';
document.getElementById('waitForReadOnly').className = 'notWait';
}

//перебирает cssData и устанавливает значения в cssRules (необходимо после перехода по ссылке во фрейме, чтобы не сбросилось визуальное оформление)
function setAllCssRules(){
 for(var i = 0; i < cssData.length; i++){
  if(cssData[i].browserRuleIndex != -1){
   for(var propertyName in cssData[i].properties){
   cssRules[cssData[i].browserRuleIndex].style[propertyName] = cssData[i].properties[propertyName].toString();
   }
  }
 }
}

function tuneStylesInit(){
 try{
 setWaitInterface();
 edDoc = document.getElementById('design').contentWindow.document; //в IE8 не работает
 var cssLink = edDoc.getElementById('tunable_css');
  if(cssLink === null){
  alert(lang['css_link_error'] + ' "tunable_css"');
  return false;
  }
 //edDoc.styleSheets[1]
 cssRules = cssLink.sheet.cssRules;//IE9++ и новые браузеры
 //cssRules = cssLink.styleSheet.rules;//IE8
 }
 catch(e){
 badBrowser();
 addError(e);
 return false;
 }

 try{

  //записываем себе в массив cssData индексы cssRules соответствующие selectorText-ам
  for(var i = 0; i < cssRules.length; i++){
   if(typeof(cssRules[i].selectorText) == 'undefined'){
   continue;
   }
  //если selectorText содержит кавычки, разные браузеры могут ставить как одинарные так и двойные
  var browserSelectorText = cssRules[i].selectorText.replace(/\"/g, "'");
   for(var i2=0; i2< cssData.length; i2++){
    if(cssData[i2].selectorText == browserSelectorText){
    cssData[i2].browserRuleIndex = i;
    //не прерываем на тот случай если несколько одинаковых селекторов
    }
   }
  }

 ifrLoadCount++;
  //если фрейм загружен больше 1 раза пишем всё в cssRules из массива cssData
  if(ifrLoadCount > 1){
  setAllCssRules();
  }

/*
  //если пользователь убрал логотип но ещё не сохранил изменения (или ещё не установил логотип)
  if(document.getElementById('logo_image').value == ''){
  var ifrLogo=edDoc.getElementById('logo_image');
   if(ifrLogo !== null){
   ifrLogo.style.display='none';
   }
  }
*/

 var ifrLogo = edDoc.getElementById('logo_image');
  //если на странице есть логотип (наличие {logo_image} в design.tpl и logo_image_$sett[design] в настройках)
  if(ifrLogo !== null){
  //если пользователь убрал логотип но ещё не сохранил изменения (или ещё не установил логотип)
   if(document.getElementById('logo_image').value == ''){ //hidden поле адреса логотипа в форме сохранения редактора
   ifrLogo.style.display='none';
   }
   //если логотип видимый
   else if(ifrLogo.style.display != 'none'){
   ifrLogo.src = document.getElementById('logo_image').value;
   }
  }

 setLoadedInterface();
 }
 catch(e){
 addError(e);
 }
}

//нумерация индексов индексов массива cssData соответствует нумерации values в селектбоксе selectorsTexts
function getBrowserRuleIndex(cssDataIndex){
return cssData[cssDataIndex].browserRuleIndex;
}

function showPropertiesBlock(blIndex){
 try{
 document.getElementById('values_block').style.display = 'none';
 document.getElementById('properties_' + selectedPropertiesBlock).selectedIndex = 0;
 document.getElementById('propertiesBlocks').style.display = 'none';
 document.getElementById('propertiesBlock_' + selectedPropertiesBlock).style.display = 'none';
  if(blIndex == ''){
  return;
  }
 document.getElementById('propertiesBlocks').style.display = 'inline-block';
 document.getElementById('propertiesBlock_' + blIndex).style.display = 'block';
 selectedPropertiesBlock = blIndex;
 defBrowserRuleIndex = getBrowserRuleIndex(blIndex);
 }
 catch(e){
 addError(e);
 }
}

function resetValuesBlock(){
document.getElementById('prop_value').value = '';
document.getElementById('browser-prop-value').value = '';
var els = document.getElementById('value_tools').getElementsByTagName('div');
 for(var i = 0; i < els.length; i++){
 els[i].style.display = 'none';
 }
var els = document.getElementById('properties-values').getElementsByTagName('select');
 for(var i = 0; i < els.length; i++){
 els[i].style.display = 'none';
 }
document.getElementById('properties-values').style.display = 'none';
}

//заменяет border-top-left-radius на borderTopLeftRadius
function cssToJsPropertyName(propertyName){
 if(propertyName == 'float'){
 return 'cssFloat';
 }
return propertyName.replace(/\-([a-z]{1})/g, function(a0, a1){return a1.toUpperCase();});
}

function numToHex(c){
var hex = parseInt(c).toString(16);
return hex.length == 1 ? '0' + hex : hex;
}

function rgbToHex(r, g, b){
return '#' + numToHex(r) + numToHex(g) + numToHex(b);
}

function rgbInStrToHex(str){
//ищем в строке rgb(0, 0, 0) и заменяем на #000000
return str.replace(/rgb\s*\(\s*([0-9]{1,3})\,\s*([0-9]{1,3})\,\s*([0-9]{1,3})\s*\)/g, function(a0, a1, a2, a3){return rgbToHex(a1, a2, a3);});
}

//возвращает начальное не изменённое значение CSS свойства, кот. было взято из css файла на момент загрузки страницы редактора
function getFirstPropertyValue(propertyName, cssDataIndex){
return defDataCss[cssDataIndex].properties[propertyName];
}

//возвращает индекс правила в массиве cssData, соответствующий индексу cssRules браузера
//в случае отсутствия возвращает -1
function getcssDataIndexBybrowserRuleIndex(browserRuleIndex){
 for(var i=0; i <cssData.length; i++){
  if(cssData[i].browserRuleIndex == browserRuleIndex){
  return i;
  }
 }
return -1;
}

//возвращает значение css свойства из cssRules[x] браузера
//если в cssRules[x] свойство отсутствует, возвращает начальное не корректированное браузером значение css свойства, кот. было взято из css файла на момент загрузки страницы редактора
//Параметр cssDataIndex не обязательный, но при его отсутствии, когда в cssRules[x] свойство отсутствует, то будет работать медленно
function getBrowserPropertyValue(propertyName, browserRuleIndex, cssDataIndex, displayError){
 if(browserRuleIndex == -1){
 return 'getBrowserPropertyValue error: Unknown ruleIndex';
 }
var newValue = cssRules[browserRuleIndex].style[propertyName];
 if(typeof(newValue) == 'undefined'){
 return 'undefined ("' + propertyName + '" ' + lang['unknown_in_browser'] + ')';
 }
return rgbInStrToHex(newValue);
/*
 if(typeof(newValue) == 'undefined'){
  if(cssDataIndex == ''){
  cssDataIndex = getcssDataIndexBybrowserRuleIndex(browserRuleIndex);
  }
  if(displayError){
  document.getElementById('property_err').innerHTML = '"' + propertyName + '" ' + lang['unknown_in_browser'];
  }
 return getFirstPropertyValue(propertyName, cssDataIndex);
 }
return rgbInStrToHex(newValue);
*/
}

//Показывает кнопки инструментов, которые доступны для свойства propertyName
function showValueTools(propertyName, value){
 var toolsByProperties = {
 'background': [
     'sel_color_btn',
     'sel_img_btn',
   ],
 'background-color': [
     'sel_color_btn',
   ],
 'background-image': [
     'sel_img_btn',
   ],
   'color': [
     'sel_color_btn',
   ],
 'border': [
     'sel_color_btn',
   ],
 'border-color': [
     'sel_color_btn',
   ],
 'border-top-color': [
     'sel_color_btn',
   ],
 'border-top': [
     'sel_color_btn',
   ],
 'border-left': [
     'sel_color_btn',
   ],
 'border-left-color': [
     'sel_color_btn',
   ],
 'border-right': [
     'sel_color_btn',
   ],
 'border-right-color': [
     'sel_color_btn',
   ],
 'border-bottom': [
     'sel_color_btn',
   ],
 'border-bottom-color': [
     'sel_color_btn',
   ],
 };
 //если propertyName нет в toolsByProperties
 if(typeof(toolsByProperties[propertyName]) == 'undefined'){
 var strVal = value.toString();
 //ищем #ffffff или #fff
 var tMatch = strVal.match(/\#[a-f0-9]{3,6}/i);
  if(tMatch !== null && (tMatch[0].length == 7 || tMatch[0].length == 4) ){
  document.getElementById('sel_color_btn').style.display = '';
  }
 //ищем url(...)
 tMatch = strVal.match(/url\([\'\"]{0,1}[^\'\"]*[\'\"]{0,1}\)/);
  if(tMatch !== null){
  document.getElementById('sel_img_btn').style.display = '';
  }
 return;
 }
 for(var i=0; i < toolsByProperties[propertyName].length; i++){
 document.getElementById(toolsByProperties[propertyName][i]).style.display = '';
 }
}

function showPropertiesValues(propertyName){
var selBox = document.getElementById('propValues_'+propertyName);
 if(selBox !== null){
 selBox.style.display = 'inline';
 selBox.selectedIndex = 0;
 document.getElementById('properties-values').style.display = 'inline';
 }
}

//преобразует 3 значный hex цвет #0af в 6 значный #00aaff
function hexColor3to6(color3){
 if(! color3.match(/^\#[a-f0-9]{3}$/i)){
 return color3;
 }
var ret = '#';
 for(var i = 1; i < 4; i++){
 ret += color3[i] + color3[i];
 }
return ret;
}

//устанавливает цвет в input type=color
function setColorInput(newValue){
//newMatch[0] будет #xxxxxx или #xxx или newMatch будет null, где #xxxxxx (#xxx) первое вхождение цвета в строке
var newMatch = newValue.match(/\#[a-f0-9]{3,6}/i);
 if(newMatch === null || (newMatch[0].length != 7 && newMatch[0].length != 4) ){
 return;
 }
 if(newMatch[0].length == 4){
 newMatch[0] = hexColor3to6(newMatch[0]);
 }
document.getElementById('color_input').value = newMatch[0];
 //если подключён jPicker, устанавливаем значение цвета и ему, т.к. он не среагирует просто на изменение value input type color
 if(jPickerUsed){
 $.jPicker.List[0].color.active.val('hex', newMatch[0]);
 }
}

function showValuesBlock(propertyName){
 try{
 resetValuesBlock();
  if(propertyName == ''){
  document.getElementById('values_block').style.display = 'none';
  return;
  }
 selectedPropertyName = propertyName;
 //document.getElementById('property_err').innerHTML = '';
 document.getElementById('values_block').style.display = 'inline-block';
 showValueTools(propertyName, cssData[selectedPropertiesBlock].properties[propertyName]);
 showPropertiesValues(propertyName);
 var propVal  = document.getElementById('prop_value');
 propVal.value = cssData[selectedPropertiesBlock].properties[propertyName];
 setColorInput(propVal.value);
 var value = getBrowserPropertyValue(propertyName, defBrowserRuleIndex, selectedPropertiesBlock, true);
 document.getElementById('browser-prop-value').value = value;
  //если значение пустое, но оно не было пустым изначально в css файле
  //if(value == '' && getFirstPropertyValue(propertyName, selectedPropertiesBlock) != ''){
  //document.getElementById('property_err').innerHTML = lang['browser_cleared_value'];
  //}
 }
 catch(e){
 addError(e);
 }
}

//edDoc.styleSheets[steelsheetIndex].insertRule(selector + '{'+propertyName.replace(/([A-Z])/g,'-$1').toLowerCase() + ':' + newValue + ';}', edDoc.styleSheets[steelsheetIndex].cssRules.length);

function setPropertyValue(cssDataIndex, browserRuleIndex, propertyName, value){
 if(browserRuleIndex == -1){
 alert('setPropertyValue error: Unknown ruleIndex');
 }
cssData[cssDataIndex].properties[propertyName] = value;
cssRules[browserRuleIndex].style[propertyName] = value;
}

//Функция onchange для prop_value. Вызывать после изменения prop_value
function propValueChange(value){
 try{
  //если пользователь сбросил значение к первоначальному
  if(value == ':Reset:'){
  value = getFirstPropertyValue(selectedPropertyName, selectedPropertiesBlock).toString();
  document.getElementById('prop_value').value = value;
  }
 //setPropertyValue(defBrowserRuleIndex, selectedPropertyName, value);
 setPropertyValue(selectedPropertiesBlock, defBrowserRuleIndex, selectedPropertyName, value);
 document.getElementById('browser-prop-value').value = getBrowserPropertyValue(selectedPropertyName, defBrowserRuleIndex, selectedPropertiesBlock, true);
 setColorInput(document.getElementById('prop_value').value); //устанавливает значение в input type color если значение в #xxxxxx
 //showValuesBlock(selectedPropertyName);
 }
 catch(e){
 addError(e);
 }
}

//Устанавливает значение prop_value, при необходимости только заменяя цвет #xxxxxx или url() новым значением (все совпадения в строке), оставляя остальную часть строки нетронутой. В завершении выполняет событие onchange для prop_value
function setPropValueSpecial(newValue){
 try{
 var pv = document.getElementById('prop_value');
 var substrMatch = false;
  if( (newValue.length == 7 || newValue.length == 4) && newValue.match(/^\#[a-f0-9]{3,6}$/i) && pv.value.match(/\#[a-f0-9]{3,6}/i)){
  substrMatch = true;
  pv.value = pv.value.replace(/\#[a-f0-9]{3,6}/gi, newValue);
  }
  if(newValue.match(/^url\([\'\"]{0,1}[^\'\"]*[\'\"]{0,1}\)$/) && pv.value.match(/url\([\'\"]{0,1}[^\'\"]*[\'\"]{0,1}\)/)){
  substrMatch = true;
  pv.value = pv.value.replace(/url\([\'\"]{0,1}[^\'\"]*[\'\"]{0,1}\)/gi, newValue);
  }
  if(! substrMatch){
  pv.value = newValue;
  }
 pv.onchange();
 }
 catch(e){
 addError(e);
 }
}

function saveChanges(){
 try{
  if(saveDisabled){
  badBrowser();
  return false;
  }
  if(! confirm(lang['replace_css_file'] + ' "' + lang['css_file'] + '"')){
  return false;
  }
 var submit = document.getElementById('save_submit');
 submit.disabled = true;
 submit.style.cursor = 'wait';
 var data = '';
  for(var i = 0; i < cssData.length; i++){
   if(cssData[i].comment != ''){
   data += '/* ' + cssData[i].comment + " */\n";
   }
   //если правило поддерживается
   if(cssData[i].unsupportedRuleCssText == ''){
   data += cssData[i].selectorText.toString().replace(/\,\s/g, ",\n") + " {\n";
    for(var propertyName in cssData[i].properties){
    data += propertyName + ': ' + cssData[i].properties[propertyName] + ";\n";
    }
   data += "}\n\n";
   }
   //если правило не поддерживается
   else{
   data += "/* Unsupported rule */\n" + cssData[i].unsupportedRuleCssText + "\n\n";
   }
  }
 document.getElementById('saved_css').value = data;
 return true;
 }
 catch(e){
 addError(e);
 return false;
 }
}

//Передаёт в качестве аргумента url выбранного изображения в диалоговом окне. Функция для взаимодействия с окном выбора изображения. Вызывается диалоговым окном обзора изображений. Имя функции не менять
function winImgUrlCallback(url){
 if(url == ''){
 return false;
 }
 switch(winImgUrlAction){

  case 'prop_value':
  url = "url('" + url + "')";
  setPropValueSpecial(url);
  break;
/*
  case 'logo_image':
  document.getElementById('logo_image').value = url;
  alert(lang['view_logo_after_save']);
  break;
*/
  case 'logo_image':
  document.getElementById('logo_image').value = url;
  var ifrLogo=edDoc.getElementById('logo_image');
   //если на странице нет логотипа
   if(ifrLogo === null){
   alert(lang['view_logo_after_save']);
   }
   //если логотип присутствует и видимый
   else{
   ifrLogo.src = url;
   ifrLogo.style.display = '';
   }
  document.getElementById('del_logo').style.display = '';
  break;

 }
}

//Динамически добавляет элемент (script, link и т.д) в тег head
//АСИНХРОННО!
function appendHead(tag, attributes){
var el = document.createElement(tag);
 for(var attrName in attributes){
 el.setAttribute(attrName, attributes[attrName]);
 }
document.getElementsByTagName('head')[0].appendChild(el);
}

//Подгружает js скрипт в тег head синхронно (т.е.если несколько раз вызвать, будет соблюдена очерёдность, и следующий не загрузится пока не загрузится предыдущий). И ниже код после вызова функции выполняется только после завершения загрузки
function requireScript(url){
var aRequest, aScript, aScriptSource;
//url = window.location.protocol + '//' + window.location.host + '/' + url;
aRequest = new XMLHttpRequest();
aRequest.open('GET', url, false);
aRequest.send();
//set the returned script text while adding special comment to auto include in debugger source listing:
 aScriptSource = aRequest.responseText + '\n////# sourceURL=' + url + '\n';
 {
 //create a dom element to hold the code
 aScript = document.createElement('script');
 aScript.type = 'text/javascript';
 //set the script tag text, including the debugger id at the end!!
 aScript.text = aScriptSource;
 //append the code to the dom
 document.getElementsByTagName('head')[0].appendChild(aScript);
 }
}

//Gроверяет поддерживается ли браузером выбор цвета (input type color), и если не поддерживается, подключает jpicker
//Все последние версии браузеров поддерживают color, кроме IE, Edge и Safari
function checkColorSupport(){
var colorInput = document.getElementById('color_input');
 //если поддерживается
 //если не поддерживается, то в будет type=text вместо type=color - в IE так, однако в Safari 5.1.7 не поддерживается но возвращает type=color. Но все браузеры, в кот. поле поддерживается, когда изначально в поле задано value="" возвращают value=#000000, поэтому дополнительно проверяем value
 if(colorInput.type == 'color' && colorInput.value != ''){
 //Для браузеров, поддерживающих диалог выбора цвета будем использовать диалог браузера
 return;
 }
//Далее подключение jPicker
//прячем текстовое поле input type color, т.к. jPicker рядом справа добавит свою кнопку
document.getElementById('color_input').style.display = 'none';
//Стили можно загрузить асинхронно, и даже не страшно если с большой задержкой
appendHead('link', {'rel': ['stylesheet'], 'type': ['text/css'], 'href': ['adm/jpicker/css/jPicker-1.1.6.min.css']});
appendHead('link', {'rel': ['stylesheet'], 'type': ['text/css'], 'href': ['adm/jpicker/jPicker.css']});
//Скрипты обязательно синхронно, соблюдая очерёдность
requireScript('adm/jpicker/jquery-1.4.4.min.js');
requireScript('adm/jpicker/jpicker-1.1.6.min.js');
 //Инициализация jPicker
 $(document).ready(
 function(){
 $.fn.jPicker.defaults.images.clientPath='adm/jpicker/images/';
  $('#color_input').jPicker({
    window:{
      //expandable: true,
      title: lang['color_select'],
      position:
      {
       x: 'screenCenter', //acceptable values "left", "center", "right", "screenCenter", or relative px value
       y: 'bottom', //acceptable values "top", "bottom", "center", or relative px value
      }
    }
   },
   //callback функция, в которую возвращается значение выбранного цвета
   function(color, context){
   setPropValueSpecial('#' + color.val('hex'));
   }
   );
  }
 );
jPickerUsed = true;
}

function addError(e){
var el = document.getElementById('err_log');
var date = new Date();
el.innerHTML = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + ': ' + e.name + ': ' + e.message + '. ' + e.stack + '<hr>' + el.innerHTML;
el.style.display = 'block';
}
