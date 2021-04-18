<!DOCTYPE html><html>
<head>
<meta charset="{charset}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{title}</title>
<link id="main_css" rel="stylesheet" type="text/css" href="{design_url}styles.css">
{tunable_css_link}
<!--[if lte IE 10]>
<link rel="stylesheet" type="text/css" href="{design_url}lte-ie10.css">
<![endif]-->
<!--[if lte IE 8]>
<script type="text/javascript" src="{relative_url}ht/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="{design_url}nav.js"></script>
{metatags}
</head>
<body>
 <header class="header">
 
  <!-- Левая часть шапки -->
  <div class="hdrLeft">
   <!-- Название магазина (логотип) -->
   <a href="{shop_index}">{logo_image}</a>
  </div>
  <!-- КОНЕЦ Левая часть шапки -->

  <div class="hdrRight">
  
   <div class="hdrRightTop">
   <!-- текст в шапке -->
   {header_text}
   </div>

   <div class="hdrRightBottom">

   <div class="cart_info">{cart_info}</div>

   <!-- Поисковая форма -->
   <form action="{relative_url}search.php" method="GET" class="frmSearch">
     <!--if:any_search_type--> <!-- если в настройках тип поиска "Искать любые совпадения" -->
     <div class="searchSettings">
     <span class="searchSettingsButton" onclick="showHideBlock('searchSettingsBody');"><img src="{design_url}img/search-settings.png" alt=""></span>
      <div class="searchSettingsBody" id="searchSettingsBody">
      <input type="checkbox" id="srchFullstr" name="fullstr"{fullstr_checked}><label for="srchFullstr">{lang.only_full_string}</label>
      </div>
     </div>
     <!--/if:any_search_type-->
   <input type="search" name="srchtext" placeholder="{lang.search_products}" value="{search_text}"><input type="submit" value="&nbsp;" title="{lang.to_find}">
   </form>
   <!-- КОНЕЦ Поисковая форма -->


  
  </div><!-- закр. hdrRightBottom -->

  </div><!--закр. hdrRight-->

 </header>
 <div class="clear"></div>

 <nav class="mainNav">

  <!--Верхнее меню-->
   <div id="horizontal_menu" class="horizontal_menu">
   <div class="horMenuButton" onclick="addRemoveClass('horizontal_menu','horizontal_menuOpened');addRemoveClass('sidebar','sidebarOpened');sidebarCloseAllMenu();">
    <div></div>
    <div></div>
    <div></div>
   </div><!-- закр. horMenuButton -->
   {horizontal_menu}
   </div>

 <div id="sidebar" class="sidebar">
  {menu_categories}
  {menu_content_pages}
  {vertical_menu}
  {menu_manufacturers}
  {menu_news}
 </div><!--закр. sidebar-->
 <script type="text/javascript">
 //Активирует функции для sidebar
 sidebarInit();
 </script>
 
 </nav>

 <div class="central">

   <!--if:currency_selection-->
   <form name="frmSelCurrency" id="frmSelCurrency" action="{relative_url}pages.php" method="GET" class="frmSelCurrency">
   <input type="hidden" name="view" value="sel_currency">
   <div class="currencyButton" title="{lang.select_currency}" onclick="showHideBlock('currency_id','inline');"><img src="{design_url}img/currency.png" alt="{lang.select_currency}"></div>
    <select name="currency_id" id="currency_id" onchange="this.form.submit();">{sel_currencies_options}
    </select>
   <input type="hidden" name="independ" value="1">
   <input type="hidden" name="redir" value="{request_uri_encoded}">
   </form>
   <script type="text/javascript">
   //Скрывает выбор валюты при прокрутке сртраницы вниз
   hideSelCurrencyOnScroll();
   </script>
   <!--/if:currency_selection-->

  <main id="content" class="content">
  {content}
  </main>

    {menu_special_offers}
    {new_products}

 <!-- закр. central -->
 </div>

<div class="clear"></div>

  <footer class="footer">
   <div class="fooLeft">
   <!-- Левая часть -->
    <div class="bottomMenu">
    {horizontal_menu}
    </div>
    <div class="footerText">
    <!--Сюда можно вставить какой-нибудь текст-->
    {footer_text}
    </div>
   </div>
   <div class="fooRight">
   <!-- Правая часть -->
   Copyright &copy; {domain}<br>
   Работает на движке <a href="http://www.arwshop.ru/" target="_blank">ArwShop</a>
   </div>
  </footer>

</body>
</html>