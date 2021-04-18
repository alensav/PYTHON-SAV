Здравствуйте {first_name}!
Подтверждаем, что поступил платеж.
Номер заказа: {order_number} 
Способ оплаты: {payment_method} 
Оплаченная сумма: {final_total_pc} {currency_brief} 
<?php
global $db, $order_id;
$table = DB_PREFIX . 'orders_items';
$result = $db->query("SELECT `itemid` FROM `$table` WHERE `orderid` = '$order_id'") or die($db->error());
$itemsids = '';
 while($row = $db->fetch_assoc($result)){
 $itemsids .= $row['itemid'] . ',';
 }
$itemsids = substr($itemsids, 0, strlen($itemsids) - 1);
$table = DB_PREFIX . 'items';
$result = $db->query("SELECT * FROM `$table` WHERE `itemid` IN($itemsids)") or die($db->error());
 while($row = $db->fetch_assoc($result)){
 echo "Ссылка для скачивания \"$row[title]\": $row[quantity_txt]\n";
 }
?>
С уважением, 
{shop_name} 
{shop_url} 

                        {shop_email}