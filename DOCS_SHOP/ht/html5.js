//для IE версии 8 и меньше создаём элементы
var html5tags=new Array('article', 'aside', 'details', 'figcaption', 'figure', 'footer', 'header', 'hgroup', 'menu', 'nav', 'section', 'main');
 for(var i=0;i<html5tags.length;i++){
 document.createElement(html5tags[i]);
 }
html5tags=null;
