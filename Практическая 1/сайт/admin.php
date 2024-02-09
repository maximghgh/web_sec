<?
    session_start();
    if(!$_SESSION['admin'])
    {
        header("Location:/dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Страничка администратора</h3>
    <a href="dashboard.php">Страничка пользователя</a>
</body>
</html>