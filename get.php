<?php

/*
 *
 * Согласно ТЗ задания работаем не с PDO, а с mysqli.
 * Вводим данные от нашей локальной базы данных и подключаемся к ней
 *
 */

$mysql = new mysqli('localhost', 'root', '', 'php_Chernyavskaya');
if(!$mysql->connect_error) //в случае если при подключении возникла ошибка, то просто ничего не делаем
{
    $sql = $mysql->query("SELECT * FROM `log_taking`"); //подготавливаем запрос к БД на выбор всех полей из таблицы log_taking
    $string = null;
    while(($result = $sql->fetch_array(MYSQLI_ASSOC))) //выполняем запрос и получаем ответ в ввиде ассоциативного массива
    {
        if($result['returned_at'] != NULL) //если в ответе returned_at (дата возвращения книги) == NULL (т.е ничего нет) - значит человек не вернул книгу
        {
            $string .= getReaderLastName($result['reader_id']) . " " . getReaderFirstName($result['reader_id']) . " взял книгу " . getBookName($result['book_id']) . " " . $result['taking_at'] . " и вернул её " . $result['returned_at'] . "<br>";
        }
        else //в противном случае - вернул. Дополнительно выводим дату возврашения книги
        {
            $string .= getReaderLastName($result['reader_id']) . " " . getReaderFirstName($result['reader_id']) . " взял книгу " . getBookName($result['book_id']) . " " . $result['taking_at'] . " и не вернул её " . "<br>";
        }
    }
    echo $string;
}
else
{
    echo $mysql->error;
    die();
}

/*
 *
 * Поскольку в таблице `log_taking` у нас не хранится само название книги, а только её ID
 * То мы должны по ID книги получить название этой книги из таблицы `books` поля "name"
 *
 * ----------------------------------------------------------------------------------------
 *
 * Можно было сделать и по другому, настроив связи в базе данных,
 * Но конкретно в нашем случае это будет излишне, ввиду малого количества записей
 *
 */

function getBookName(int $bookId)
{
    $mysql = new mysqli('localhost', 'root', '', 'php_Chernyavskaya'); //по новой подключаемся к БД
    if(!$mysql->connect_error) //в случае если при подключении возникла ошибка, то просто выводим Ошибка НАХУЙ
    {
        $sql = $mysql->query("SELECT * FROM `books` WHERE id = '". $bookId ."' LIMIT 1"); //сразу выполняем запрос
        return $sql->fetch_array(MYSQLI_ASSOC)['name']; //получаем ответ в виде ассоциативного массива, обращаемся к конкретному полю и возвращаем его значение
    }
    return "Ошибка!";
}

/*
 *
 * Поскольку в таблице `log_taking` у нас не хранится имена читателей, а только их ID
 * То мы должны по ID получить имя читателя из таблицы `readers`
 *
 * ----------------------------------------------------------------------------------------
 *
 * Можно было сделать и по другому, настроив связи в базе данных,
 * Но конкретно в нашем случае это будет излишне, ввиду малого количества записей
 *
 */

function getReaderFirstName(int $id)
{
    $mysql = new mysqli('localhost', 'root', '', 'php_Chernyavskaya'); //по новой подключаемся к БД
    if(!$mysql->connect_error) //в случае если при подключении возникла ошибка, то просто выводим Ошибка НАХУЙ
    {
        $sql = $mysql->query("SELECT * FROM `readers` WHERE id = '". $id ."' LIMIT 1"); //сразу выполняем запрос
        $res = $sql->fetch_array(MYSQLI_ASSOC); //получаем ответ в виде ассоциативного массива
        return $res['first_name']; //обращаемся к конкретному полю и возвращаем его значение
    }
    return "Ошибка!";
}

/*
 *
 * Поскольку в таблице `log_taking` у нас не хранится фамилии читателей, а только их ID
 * То мы должны по ID получить фамилию читателя из таблицы `readers`
 *
 * ----------------------------------------------------------------------------------------
 *
 * Можно было сделать и по другому, настроив связи в базе данных,
 * Но конкретно в нашем случае это будет излишне, ввиду малого количества записей
 *
 */

function getReaderLastName(int $id)
{
    $mysql = new mysqli('localhost', 'root', '', 'php_Chernyavskaya'); //по новой подключаемся к БД
    if(!$mysql->connect_error)
    {
        $sql = $mysql->query("SELECT * FROM `readers` WHERE id = '". $id ."' LIMIT 1"); //сразу выполняем запрос
        $res = $sql->fetch_array(MYSQLI_ASSOC); //получаем ответ в виде ассоциативного массива
        return $res['last_name']; //обращаемся к конкретному полю и возвращаем его значение
    }
    return "Ошибка!";
}

/*
 *
 * В случае, если читатель вернул книгу, нам нужно вывести дату
 *
 */

function getReturnDate(int $bookId)
{
    $mysql = new mysqli('localhost', 'root', '', 'php_Chernyavskaya'); //по новой подключаемся к БД
    if(!$mysql->connect_error)
    {
        $sql = $mysql->query("SELECT * FROM `log_taking` WHERE book_id = '". $bookId ."' AND "); //получаем ответ в виде ассоциативного массива
        return $sql->fetch_array(MYSQLI_ASSOC); //обращаемся к конкретному полю и возвращаем его значение
    }
    return "Ошибка!";
}

?>