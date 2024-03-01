<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="login" placeholder="логин"><br>
        <input type="password" name="password" placeholder="пароль"><br>
        <input type="submit" value="авторизоваться" name="button">
    </form>
</body>
</html>
<?php
    $connect = mysqli_connect("localhost","root","","testty");
    error_reporting(0);
    session_start();

    // Получение данных из POST запроса
    $login = $_POST['login'];
    $password = $_POST['password'];
    $button = $_POST['button'];

    // Подготовленный запрос для избежания SQL инъекций
    $stmt = $connect->prepare("SELECT * FROM `user` where `login` = ? AND `password` = ?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['login'] = $login; 
        header("Location: /dashboard.php");
        exit; 
    } else {
        
        echo "Ошибка: Неправильный логин или пароль.";
    }
?>
