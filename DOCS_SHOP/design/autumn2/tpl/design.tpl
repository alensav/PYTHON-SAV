<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-type" content="text/html; charset={charset}">
<title>{title}</title>
<link rel="stylesheet" type="text/css" href="{design_url}styles.css">
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="{design_url}lte_ie7.css">
<script type="text/javascript" src="{design_url}lte_ie7.js"></script>
<![endif]-->
<!--[if lte IE 8]>
<script type="text/javascript" src="{relative_url}ht/html5.js"></script>
<![endif]-->
{metatags}
</head>
<body>
 <header class="header">
 <!-- Левая часть шапки -->
  <div class="hdrLeft">
   <div class="logo">
   <!-- Логотип -->
   </div>
   <div class="underLogo">
   <!-- Текст под логотипом -->
   </div>
  </div>
  <div class="hdrWideRight">
  <!-- Правая часть шапки на всю ширину -->
   <div class="hdrRight">
   <!--Правая часть шапки-->
    <!-- Поисковая форма -->
    <div class="frmSearch">
     <form action="{relative_url}search.php" method="GET">
     <input type="search" name="srchtext" size="17" placeholder="{lang.search_products}" value="{search_text}"><input type="submit" value="{lang.to_find}">
     <!--if:any_search_type--><br><input type="checkbox" name="fullstr"{fullstr_checked}>{lang.only_full_string}<!--/if:any_search_type-->
     </form>
    </div>
    <!-- КОНЕЦ Поисковая форма -->
   </div>
   <div class="hdrCenter">
   <!-- Центральная часть шапки -->
   {header_text}
   </div>
  </div>
 </header>

  <!-- Верхнее меню -->
  {horizontal_menu}

 <div id="wrapper">

  <div id="wrap1">

    <div id="wrap2">

     <div id="wrap3">

      <div id="central">

       <!--if:currency_selection-->
       <form name="frmSelCurrency" action="{relative_url}pages.php" method="GET" class="frmSelCurrency">
       <input type="hidden" name="view" value="sel_currency">
       <span class="nowrap">{lang.select_currency}&nbsp;</span><select name="currency_id" onchange="this.form.submit();">{sel_currencies_options}</select>
       <input type="hidden" name="independ" value="1">
       <input type="hidden" name="redir" value="{request_uri_encoded}">
       <noscript><input type="submit" value="{lang.select_currency}"></noscript>
       </form>
       <!--/if:currency_selection-->

      <main id="content" class="content">
      {content}
      </main>

     <!-- закр. central -->
     </div>

    <!-- закр. wrap3 -->
    </div>

   <div id="leftMenu" class="sidebar">
   <!-- Левое меню -->
   {menu_categories}
   {menu_content_pages}
   {menu_news}
   {menu_special_offers}
   {login_form}
   <!-- КОНЕЦ Левое меню -->
   </div>

   <!-- закр. wrap2 -->
   </div>

  <!-- закр. wrap1 -->
  </div>

  <div id="rightMenu" class="sidebar">
  <!-- Правое меню -->
  {cart_info}
  {vertical_menu}
  {menu_manufacturers}
  {new_products}
  <!-- КОНЕЦ Правое меню -->
  </div>

 <!-- закр. wrapper -->
 </div>

 <aside class="bottomMenu">
  <div class="bottomLine"></div>
  {horizontal_menu}
  <div class="bottomLine"></div>
 </aside>

  <footer class="footer">
   <div class="fooLeft">
   <!-- Левая часть -->
   Copyright &copy; {domain}
   </div>
   <div class="fooRight">
   <!-- Правая часть -->
   Работает на движке <a href="http://www.arwshop.ru/" target="_blank">ArwShop</a>
   </div>
   <div class="fooCenter">
   <!-- Центр. часть -->
   {footer_text}
   </div>
  <div class="bottomLine"></div>
  </footer>

</body>
</html>