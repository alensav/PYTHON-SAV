<!--Получили данные-->
<?php
//Получение данныч из форм-->
$login = $_POST["login"];
$pass = $_POST["password"];
$login = $_POST["email"];
$login = $_POST["tel"];
$login = $_POST["login"];
//Обработка полученных данных
$login = htmlspecialchars($login);
$pass = htmlspecialchars($password);
$email = htmlspecialchars($email);
$tel = htmlspecialchars($tel);

$login = urldecode($login);
$pass = urldecode($password);
$email = urldecode($email);
$tel = urldecode($tel);

$login = trim($login);
$pass = trim($password);
$email = trim($email);
$tel = trim($tel);

//Отправка данных до адрессата
if (mail(
    "docs_shop@arhiv-proekt.ru",
    "Логин: " . $login . "\n" .
        "Пароль: " . $pass . "\n" .
        "Email: " . $email . "\n" .
        "Телефон:",
    $tel,
    "From no-reply@mydomain.ru \r\n"
)) {
    echo ("Письмо успешно отправлено");
} else {
    echo ("Есть ошибка! Проверьте данные ...");
}









?>