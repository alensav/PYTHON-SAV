//возвращает объект формы в которой находится textarea
function getForm(textareaName){
var f=document.getElementsByTagName('FORM');
 for(var a=0;a<f.length;a++){
 var ta=f[a].getElementsByTagName('TEXTAREA');
  for(var t=0;t<f[a].length;t++){
   if(ta[t].name == textareaName){
   return f[a];
   }
  }
 }
return '';
}
function hideAutoBr(){
 for(var i=0;i<textareas.length;i++){
 wfrm=getForm(textareas[i]);
 wfrm['auto_br_'+textareas[i]].checked=false;
 document.getElementById('auto_br_'+textareas[i]).style.display='none';
 }
}
try{
hideAutoBr();
}catch(e){}
tinymce.init({
//нужно указывать id текстовых полей
//selector: '#description,#special',
selector: elements,
//height: 500,
language: 'ru',
//document_base_url: document_base_url,
relative_urls: false,
//проверка орфографии средствами браузера
browser_spellcheck: true,
image_list: tm_image_list,
link_list: tm_link_list,
templates: tm_templates_list,
plugins: [
//Не подключены: autolink autosave(запрос на уход со страницы) bbcode codesample contextmenu fullpage(заголовочные теги страницы) importcss(с ним не работает formats) legacyoutput(старые теги вместо CSS) directionality(dir=ltr rtl) spellchecker example example_dependency layer noneditable tabfocus textpattern
'advlist anchor autoresize charmap code colorpicker emoticons fullscreen hr image imagetools insertdatetime link lists media nonbreaking pagebreak paste preview print searchreplace table template textcolor visualblocks visualchars wordcount save brplugin'
],
toolbar: 'save insertfile | copy cut paste | undo redo searchreplace | bold italic strikethrough underline | forecolor backcolor | fontselect | fontsizeselect | formatselect | blockquote visualblocks nonbreaking brbutton | alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist removeformat | link anchor | image media template | insertdatetime emoticons | preview print fullscreen code attribs',
//меню Параграф
block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6;div=div;Quote=blockquote;Preformatted=pre',
//доп.вкладка при вставке изображения
image_advtab: true
/*
content_css:[
'//1.css',
'//2.css'
]
*/
});
