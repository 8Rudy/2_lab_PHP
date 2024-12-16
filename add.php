<?php

/*
 *
 * Используем PDO ввиду требования ТЗ
 *
 * Используем try{} catch {} для обработки ошибок
 *
 */

try {
    $dbh = new PDO('mysql:dbname=php_Chernyavskaya;host=localhost', 'root', '');
} catch (PDOException $e) {
    die($e->getMessage());
}

/*
 *
 * Подготавливаем запрос к БД с указанными параметрами
 *
 */

$sth = $dbh->prepare("INSERT INTO `log_taking` SET `reader_id` = :reader_id, `book_id` = :book_id, `taking_at` = :taking_at, `returned_at` = :returned_at");
try {
    if(rand(1,2) == 1) //генерируем случайное число от 1 до 2, если число 1, то вставляем запись, где читатель не вернул книгу
    {
        $sth->execute(array('reader_id' => rand(1, 5), 'book_id' => rand(1, 5), 'taking_at' => date("Y-m-d H:i:s"), 'returned_at' => NULL));
        echo "ID: " . $dbh->lastInsertId();
    }
    else //если число 2, то вставляем запись, где читатель вернул книгу спустя 7 дней
    {
        $returned = strtotime("+7 day");
        $date = date("Y-m-d H:i:s", $returned);
        $sth->execute(array('reader_id' => rand(1, 5), 'book_id' => rand(1, 5), 'taking_at' => date("Y-m-d H:i:s"), 'returned_at' => $date));
        echo "ID: " . $dbh->lastInsertId();
    }
}catch (Exception $e)
{
    echo $e->getMessage();
}

?>
