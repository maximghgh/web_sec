<!DOCTYPE html>
<html>
<head>
    <title>XSS Protected App</title>
</head>
<body>
    <h1>Welcome to My XSS Protected App!</h1>
    <form method="post">
        Enter your name: <input type="text" name="name"><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST["name"]);
        echo "<p>Hello, $name!</p>"; 
    }
?>