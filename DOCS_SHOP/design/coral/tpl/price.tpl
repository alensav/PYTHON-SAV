<!DOCTYPE html>
<html class="priceList"><head>
<meta http-equiv="Content-type" content="text/html; charset={charset}">
<title>{lang.price_list} - {pages_title}</title>
<link rel="stylesheet" type="text/css" href="{design_url}styles.css">
</head>
<body>
<header class="priceHeader">
 <div class="plhLeft"><h1>{lang.price_list}</h1></div>
 <div class="plhRight">
 <img src="{design_url}img/home.gif" alt="" class="imgst"><a href="{shop_index}">{lang.on_main_page}</a> &nbsp;  &nbsp; <img src="{design_url}img/print.gif" alt="" class="imgst"><a href="#" onclick="print();return false;">{lang.print}</a>&nbsp;
 </div>
 <div class="plhCenter">
  <!--if:currency_selection-->
   <form name="frmSelCurrency" action="{relative_url}pages.php" method="GET" class="frmSelCurrency">
    <input type="hidden" name="view" value="sel_currency">
    <span class="nowrap">{lang.select_currency}&nbsp;</span><select name="currency_id" onchange="this.form.submit();">{sel_currencies_options}</select>
    <input type="hidden" name="independ" value="1">
    <input type="hidden" name="redir" value="{request_uri_encoded}">
    <noscript><input type="submit" value="{lang.select_currency}"></noscript>
   </form>
  <!--/if:currency_selection-->
 </div>
 <div class="clear"></div>
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
 <tr class="priceCat">
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