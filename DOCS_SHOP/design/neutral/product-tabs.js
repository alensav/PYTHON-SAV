/* Вкладки на странице товара */
function prodTabsInit(){
var tabMenu=document.getElementById('prodTabs').getElementsByTagName('span');
 for(var i=0;i<tabMenu.length;i++){
 tabMenu[i].onclick=function(){activateProdTab(this);};
 }
activateProdTab(tabMenu[0]);
}
function activateProdTab(obj){
obj.className='activeTab';
var actId='prod'+obj.id;
var tabMenu=document.getElementById('prodTabs').getElementsByTagName('span');
 for(var i=0;i<tabMenu.length;i++){
 var defTab=document.getElementById('prod'+tabMenu[i].id);
  //если активная вкладка
  if(defTab.id==actId){
  defTab.style.display='block';
  }
  else{
  defTab.style.display='none';
  tabMenu[i].className='noActiveTab';
  }
 }
}
