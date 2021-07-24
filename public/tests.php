<?php

require('interval.php');
require('delivery.php');

echo 'Задание №1<br>';
$intervals = [
    '00:00-09:00',
    '00:01-01:09',//valid false
    '09:00-11:00',//valid true
    '00000000000',//invalid
    '0001-2120'  ,//invalid
    '14:00-14:30',//valid true
    '23:59-21:00',//invalid false
    '16:00-17:00',//valid true
    '20:00-20:30',//valid true
    '21:30-22:30',//valid false
    '22:30-23:59',
];

echo('<br>Добавление интервалов и валидация:<br><br>');

foreach ($intervals as $interval)
{
    if(check_new_interval($interval))
    {
        echo('{'.$interval.'} будет добавлен в массив<br>');
    }
}

echo '<br>Задание №2<br>';
echo '<br>';
echo 'Стоимость доставки:<br>';
echo '<br>';
$russian_post = new RussianPost;
$dhl = new Dhl;

$weights = [ 2.5,9.9,10.5,25 ];
foreach ($weights as $weight)
{
        echo 'Вес: '.$weight.'кг. ';
        echo 'Стоимость: ';
        echo ' Почта России: '.$russian_post->get_delivery_cost($weight);
        echo ' DHL: '.$dhl->get_delivery_cost($weight);
        echo '<br>';
}

include('mysql.php');

?>
