<?php

/*
 *
 * Используем PDO ввиду требования ТЗ
 *
 * Используем try{} catch {} для обработки ошибок
 *
 */

try {
    $dbh = new PDO('mysql:dbname=php_Chernyavskaya;host=localhost', 'root', ''); //подключаемся к БД
} catch (PDOException $e) { //если возникла ошибка - выводим её, и прекращаем выполнение скрипта
    die($e->getMessage());
}

echo $_GET['id'] . "<br>"; //выводим ID который хранится в глоб. параметре $_GET

if(is_numeric($_GET['id'])) //проверяем указанный айди от сторонних символов
{
    $count = $dbh->exec("DELETE FROM `log_taking` WHERE `id` = '". $_GET['id'] ."'"); //выполняем DELETE запрос, тем самым удаляя поле с указанным ID
    echo 'Удалено ' . $count . ' строк.'; //выводим кол-во удалённых строк
}
else //если ID введён неккорректно - выводим ошибку
{
    echo 'Введён некорректный ID записи.';
    die();
}

?>