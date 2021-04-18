<!DOCTYPE html>
<html class="priceList"><head>
<meta charset="{charset}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{lang.price_list} - {pages_title}</title>
<link id="main_css" rel="stylesheet" type="text/css" href="{design_url}styles.css">
{tunable_css_link}
</head>
<body>

 <header class="priceHeader">
 <h1>{lang.price_list}</h1>
 
  <div class="priceMenu">

  <div class="priceHdrMenuItem"><img src="{design_url}img/home.gif" alt="" class="imgst"><a href="{shop_index}">{lang.on_main_page}</a></div>

  <div class="priceHdrMenuItem"><img src="{design_url}img/print.gif" alt="" class="imgst"><a href="#" onclick="print();return false;">{lang.print}</a></div>

  <!--if:currency_selection-->
   <form name="frmSelCurrency" action="{relative_url}pages.php" method="GET" class="priceHdrMenuItem">
    <input type="hidden" name="view" value="sel_currency">
    <span class="nowrap">{lang.select_currency}&nbsp;</span><select name="currency_id" onchange="this.form.submit();">{sel_currencies_options}</select>
    <input type="hidden" name="independ" value="1">
    <input type="hidden" name="redir" value="{request_uri_encoded}">
    <noscript><input type="submit" value="{lang.select_currency}"></noscript>
   </form>
  <!--/if:currency_selection-->
  
  </div><!--закр.priceMenu-->

 </header>

<main class="priceContent">
<table class="coltbl priceTbl">
<tr class="htr">
 <td><a href="{relative_url}sort.php?view=price&amp;sort=title&amp;independ=1">{lang.product_title}</a></td>
 <td><a href="{relative_url}sort.php?view=price&amp;sort=sku&amp;independ=1">{lang.product_sku}</a></td>
 <td><a href="{relative_url}sort.php?view=price&amp;sort=price&amp;independ=1">{lang.product_price}</a></td>
 <td><a href="{relative_url}sort.php?view=price&amp;sort=quantity&amp;independ=1">{lang.product_quantity}</a></td>
</tr>
<!--begin:products-->
 <!--if:next_category-->
 <tr class="priceCategory">
  <td colspan="4">{lang.category}: <a href="{category_url}">{category_title}</a></td>
 </tr>
 <!--/if:next_category-->
<tr class="{def_class}">
 <td><a href="{product_url}">{product_title}</a></td>
 <td>{product_sku}</td>
 <td>{product_price}&nbsp;{currency_brief}</td>
 <td>{product_quantity}</td>
</tr>
<!--end:products-->
</table>
</main>

<footer class="priceFooter">
<img src="{design_url}img/home.gif" alt="" class="imgst"><a href="{shop_index}">{lang.on_main_page}</a> &nbsp;  &nbsp; <img src="{design_url}img/print.gif" alt="" class="imgst"><a href="#" onclick="print();return false;">{lang.print}</a>
</footer>
</body>
</html>