//Скрипт устанавливает для опций дополнительного свойства "Цвет" соответствующий цвет фона, если в названии цвета присутствует его HEX цвет, например, название цвета должно быть: Красный #ff0000 (регистр не важен)
//Установка: в конец файла дизайна design.tpl перед закрывающим тегом </body> вставьте тег: <script type="text/javascript" src="{relative_url}ht/set-options-color.js"></script>

function setOptionsColor(){
var reg=/\#[0-9a-fA-F]{6}/;
var allSelBoxes=document.getElementsByTagName('select');
 for(var i=0;i<allSelBoxes.length;i++){
  if(allSelBoxes[i].name=='product_options[1]'){
  var allOptions=allSelBoxes[i].getElementsByTagName('option');
   for(var i2=0;i2<allOptions.length;i2++){
   var color=allOptions[i2].text.match(reg);
    if(color){
    allOptions[i2].style.backgroundColor=color.toString();
    }
   }
  }
 }
}
setOptionsColor();
