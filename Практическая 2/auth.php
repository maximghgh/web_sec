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

    $login = $_POST['login'];
    $password = $_POST['password'];
    $button = $_POST['button'];

    $out = "SELECT * FROM `user` where `login` = '$login' AND `password` = '$password'";
    echo $out;
    
    if($button)
    {
        $run=mysqli_query($connect, $out);
        $user= mysqli_num_rows($run);
        if($user !=0)
        {
            header("Location:/dashboard.php");
        }

    }

?>