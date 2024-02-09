<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form method="POST">
        <input type="text" name="login" placeholder="Логин"><br>
        <input type="password" name="password" placeholder="пароль"><br>
        <input type="submit" value="авторизироваться" name="button">
   </form> 
<?php
    $connect = mysqli_connect("localhost","root","","testty");
    error_reporting(0);
    session_start();

    $login = $_POST['login'];
    $password = $_POST['password'];
    $button = $_POST['button'];

    $out = "SELECT * FROM `user` where `login` = $login AND `password` = $password";
    $out_ad = "SELECT * FROM `user` where `login` = $login AND `password` = $password and `status`='1'";

    if($button)
    {

        $out_r_a=mysqli_query($connect, $out_ad);
        $user = mysqli_num_rows($out_r_a);
        if($user != 0)
        {
            $_SESSION['admin'] = 1;
            header("Location:/admin.php");
        }
        else 
        {
            $out_r_u=mysqli_query($connect, $out);
            $users = mysqli_num_rows($out_r_u);
            if($users != 0)
            {
                header("Location:/dashboard.php");
            }
        }

    }


?>
</body>
</html>
