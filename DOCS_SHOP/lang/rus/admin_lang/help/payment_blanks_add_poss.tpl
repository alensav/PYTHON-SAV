<h4>Замены в шаблонах платежных бланков</h4>
{orderid} - уникальный номер заказа<br>
{date} - дата заказа (число.месяц.год)<br>
{time} - время заказа (часы:минуты:секунды)<br>
{paymethod} - название способа оплаты<br>
{currency} - полное название валюты, выбранной покупателем<br>
{currency_brief} - краткое обозначение валюты, выбранной покупателем (валюта платежа)<br>
{currency_course} - курс валюты, выбранной покупателем по отношению к валюте, используемой по умолчанию (т.е. к валюте базы данных)<br>
{def_currency} - полное название валюты магазина, используемой по умолчанию<br>
{def_currency_brief} - краткое обозначение валюты магазина, используемой по умолчанию<br>
{total_pc} - суммарная стоимость заказа в валюте платежа<br>
{discount_percents} - скидка в процентах<br>
{discount_pc} - скидка в валюте платежа<br>
{total_with_discount_pc} - итого с учётом скидки в валюте платежа<br>
{delivery_cost_pc} стоимость доставки в валюте платежа<br>
{final_total_pc} - окончательная сумма к оплате в валюте платежа<br>
{deliverymethod} - Название способа доставки<br>
{userid} - уникальный ID пользователя в системе<br>
{username} - логин пользователя в системе<br>
{first_name} - имя покупателя<br>
{last_name} - фамилия покупателя<br>
{patronymic} - отчество покупателя<br>
{company} - название компании покупателя<br>
{country} - страна покупателя<br>
{city} - город покупателя<br>
{address} - адрес покупателя<br>
{zip_code} - почтовый индекс покупателя<br>
{phone} - номер телефона покупателя<br>
{email} - заменяется e-mail адрес покупателя<br>
{comment} - комментарий покупателя к заказу<br>
{adm_pub_comment} - доступный покупателю комментарий администратора к заказу<br>
{final_total_pc_integer} - целая часть окончательной суммы к оплате в валюте платежа<br>
{final_total_pc_fractional} - дробная часть окончательной суммы к оплате в валюте платежа<br>
{final_total_pc_words_integer} - прописью целая часть окончательной суммы к оплате в валюте платежа, например, если сумма 547.84 руб, то выведет &quot;пятьсот сорок семь&quot;<br>
{final_total_pc_words_int_symbol} - прописью &quot;рубль&quot;, &quot;рубля&quot;, &quot;рублей&quot; в зависимости от суммы<br>
{final_total_pc_words_fractional} - прописью дробная часть окончательной суммы к оплате в валюте платежа, например, если сумма 547.84 руб, то выведет &quot;восемьдесят четыре&quot;<br>
{final_total_pc_words_fract_symbol} - прописью &quot;копейка&quot;, &quot;копейки&quot;, &quot;копеек&quot; в зависимости от суммы<br>

<br><hr><br>

Кроме этого можно включить в бланк значения дополнительных полей формы оформления заказа, при условии, что этим полям были присвоены уникальные имена.<br>
Для включения в бланк дополнительных полей следует использовать метки {add.field_name} где вместо field_name уникальное имя поля.<br>

<br><hr><br>

Есть возможность включить в платежный бланк отчёт по каждому товару, например, в виде таблицы. Тогда HTML-код таблицы товаров в бланке должен выглядеть примерно так:<br><br>

<span class="code">
&lt;table width=&quot;500&quot; border=&quot;1&quot;&gt;<br>
&nbsp;&lt;tr&gt;<br>
&nbsp;&nbsp;&lt;td&gt;Товар&lt;/td&gt;<br>
&nbsp;&nbsp;&lt;td&gt;Кол-во&lt;/td&gt;<br>
&nbsp;&nbsp;&lt;td&gt;Цена&lt;/td&gt;<br>
&nbsp;&nbsp;&lt;td&gt;Стоимость&lt;/td&gt;<br>
&nbsp;&lt;/tr&gt;<br>
&nbsp;&lt;!--begin:products--&gt;<br>
&nbsp;&lt;tr&gt;<br>
&nbsp;&nbsp;&lt;td&gt;{product_title}&lt;br&gt;{product_options}&lt;/td&gt;<br>
&nbsp;&nbsp;&lt;td&gt;{product_quantity}&lt;/td&gt;<br>
&nbsp;&nbsp;&lt;td&gt;{product_price_pc} &lt;/td&gt;<br>
&nbsp;&nbsp;&lt;td&gt;{product_sum_pc}&lt;/td&gt;<br>
&nbsp;&lt;/tr&gt;<br>
&nbsp;&lt;!--end:products--&gt;<br>
&lt;/table&gt;<br><br>
</span>

В этом случае комментарии &lt;!--begin:products--&gt; и &lt;!--end:products--&gt;  являются метками начала и конца цикла при выборке товаров из базы данных, и являются обязательными.