<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("mysql", "sail", "password", "shop");

echo '<br>Задание №3<br>';
//тест 1
$query1 =
    "SELECT name
     FROM `users`
     INNER JOIN `orders` ON (`orders`.`user_id` = `users`.`id`)
     GROUP BY name
     HAVING COUNT(orders.id) > 0;";

echo '<br>';
echo 'Пользователи, которые осуществили хотя бы один заказ orders в интернет магазине: ';
echo '<br>';
if ($result = $mysqli->query($query1)) {
    while($obj = $result->fetch_object()){
        print_r($obj->name);
        echo '<br>';
    }
}
echo '<br>';
echo 'Cписок товаров products и разделов catalogs, который соответствует товару:<br>';
//тест 2
$query2 =
    "SELECT products.name AS pn,products.price,catalogs.name AS cn FROM products
     INNER JOIN catalogs ON (catalogs.id = products.catalog_id);";

if ($result = $mysqli->query($query2)) {
    while($obj = $result->fetch_object()){
        echo 'Продукт: ';
        echo($obj->pn);
        echo ' Цена: ';
        echo($obj->price);
        echo ' Каталог: ';
        echo($obj->cn);
        echo '<br>';
    }
}
//тест 3
$query3 =
    "INSERT INTO sample.users (name, birthday_at)

     SELECT shop.users.name, shop.users.birthday_at
     FROM shop.users
     WHERE shop.users.id = 1;";

$query3_users =
    "SELECT sample.users.id,sample.users.name FROM sample.users;";

$mysqli->autocommit(false);
$mysqli->begin_transaction();
$result3 = $mysqli->query($query3);
$mysqli->commit();

echo '<br>';
if($result3)
{
    echo 'Транзакция выполнена успешно <br>';
}
echo '<br>';

echo 'Список пользователей в sample users:<br>';
$mysqli->query('USE sample;');
if ($result = $mysqli->query($query3_users)) {
    while($obj = $result->fetch_object()){
        print_r($obj->id.':{'.$obj->name.'} ');
    }
}
//тест 4
$query4 =
    "SELECT name
     FROM users
     INNER JOIN orders ON (orders.user_id = users.id)
     WHERE (TIMESTAMPDIFF(YEAR,users.birthday_at,CURDATE()) > 30) AND (orders.created_at < (NOW() - INTERVAL 6 MONTH))
     GROUP BY users.name HAVING COUNT(orders.id) >= 3
     ORDER BY RAND() LIMIT 1";

$mysqli->query('USE shop;');

echo '<br>';
echo '<br>';
echo 'Случайный пользователь из таблицы shop.users, старше 30 лет, сделавший минимум 3 заказа за последние полгода:<br>';
if ($result = $mysqli->query($query4)) {
    while($obj = $result->fetch_object()){
        print_r($obj->name);
    }
}
echo '<br>';

?>
