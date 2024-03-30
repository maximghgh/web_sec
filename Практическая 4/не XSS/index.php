<!DOCTYPE html>
<html>
<head>
    <title>XSS Vulnerable App</title>
</head>
<body>
    <h1>Welcome to My Vulnerable App!</h1>
    <form method="post">
        Enter your name: <input type="text" name="name"><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        echo "<p>Hello, $name!</p>"; 
    }
?>