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

tinyMCE.init({
//General options
mode: "exact",
elements: elements,
theme: "advanced",
language: "ru",
//document_base_url : document_base_url,
relative_urls: false,
plugins: "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",

// Theme options
theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak,template,code,restoredraft",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing: true,

//Example content CSS (should be your site CSS)
//content_css : "css/content.css",

//Drop lists for link/image/media/template dialogs
//template_external_list_url : "lists/template_list.js",
template_external_list_url : template_external_list_url,
//external_link_list_url : "lists/link_list.js",
external_link_list_url : external_link_list_url,
//external_image_list_url : "lists/image_list.js",
external_image_list_url : external_image_list_url,
//media_external_list_url : "lists/media_list.js",
media_external_list_url : media_external_list_url,

//Style formats
style_formats : [
{title : 'Bold text', inline : 'b'},
{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
//{title : 'Example 1', inline : 'span', classes : 'example1'},
//{title : 'Example 2', inline : 'span', classes : 'example2'},
{title : 'Table styles'},
{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
],

//Replace values for the template plugin
template_replace_values : {
//username : "Some User",
//staffid : "991234"
}

});
