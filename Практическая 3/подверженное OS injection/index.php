<?php
// Получаем имя файла из GET-параметра
$file_name = $_GET['file'];

// Выполняем команду для открытия файла (например, в Linux)
system("cat " . $file_name);
?>
