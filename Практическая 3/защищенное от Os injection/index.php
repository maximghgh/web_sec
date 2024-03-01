<?php
// Получаем имя файла из GET-параметра и экранируем его
$file_name = escapeshellarg($_GET['file']);

// Выполняем команду для открытия файла (например, в Linux)
system("cat " . $file_name);
?>