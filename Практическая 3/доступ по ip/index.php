<?php

// Задаем список разрешенных IP-адресов
$allowedIPs = array(
    '127.0.0.1', // пример IP-адреса 1
    '192.168.1.101'  // пример IP-адреса 2
);

// Получаем IP-адрес клиента
$clientIP = $_SERVER['REMOTE_ADDR'];

// Проверяем, разрешен ли доступ для данного IP-адреса
if (!in_array($clientIP, $allowedIPs)) {
    // Далее можно вывести пользователю сообщение об ошибке или просто завершить выполнение скрипта
    die("Доступ запрещен. Ваш IP-адрес: $clientIP");
}
else{
    header("Location:/main.php");
}

?>
