<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <style>
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create User</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Ваше имя" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" pattern="[+][0-9]+" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Пример:email@mail.ru" required>
            </div>
            <div class="form-group">
                <label for="dob">Дата рождения:</label>
                <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d', strtotime('-111 years')); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Пол:</label>
                <select id="gender" name="gender" required>
                    <option value="1">Мужчина</option>
                    <option value="0">woman</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Картинка:</label>
                <input type="file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Не менее 8 символов" required>
            </div>
            <button type="submit">Create User</button>
        </form>

        <?php
// Подключение к базе данных
$servername = "localhost"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль пользователя базы данных
$dbname = "tyty"; // Имя базы данных

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Установка режима ошибок PDO на исключение
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Функция для генерации пароля
        function generatePassword() {
            $specialChars = '!@#$%^&*()-_+=';
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $currentMonth = date('F'); // Получаем текущее название месяца на английском языке

            // Генерация пароля
            $password = $_POST['password'];

            if (strlen($password) >= 8) {
                while (true) {
                    $password = $_POST['password'];
                    // Добавляем 4 случайных символа, избегая повторяющихся символов
                    $password .= substr(str_shuffle('abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789'), 0, 4);
                    // Добавляем название текущего месяца
                    $password .= $currentMonth;
                    // Добавляем 2 специальных символа, избегая их повторения подряд
                    $password .= $specialChars[rand(0, strlen($specialChars) - 1)];
                    $password .= $specialChars[rand(0, strlen($specialChars) - 1)];

                    // Проверяем, чтобы пароль содержал хотя бы 8 символов и не повторяющихся комбинаций
                    if (strlen($password) >= 8 && !preg_match('/(.)\1{1,}/', $password)) {
                        return $password;
                    }
                }
            } else {
                echo "Введите не менее 8 символов<br>";
                return false;
            }
        }

        // Функция для проверки формата номера телефона
        function validatePhoneNumber($phone) {
            // Проверка наличия кода страны в номере телефона
            if (preg_match('/^\+\d{1,3}\d{10}$/', $phone)) {
                return true;
            } else {
                echo "Некорректный формат номера телефона. Введите в формате: +код_страныномер\n";
                return false;
            }
        }

        // Проверка наличия данных в запросе POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Получение данных из формы
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = generatePassword(); // Генерируем пароль
            $phone = $_POST['phone'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];

            // Валидация данных
            if (!empty($username) && !empty($email) && !empty($password) && !empty($phone) && !empty($dob) && !empty($gender)) {
                // Проверка формата email
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Проверка длины пароля
                    if (strlen($password) >= 8) {
                        // Проверка номера телефона
                        if (validatePhoneNumber($phone)) {
                            // Проверка существования email в базе данных
                            $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = :email");
                            $stmt->bindParam(':email', $email);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $userCount = $row['count'];

                            // Проверка уникальности username в базе данных
                            $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE username = :username");
                            $stmt->bindParam(':username', $username);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $usernameCount = $row['count'];

                            if ($userCount == 0 && $usernameCount == 0 && !preg_match('/\d/', $username)) {
                                // Все данные введены корректно, и email не существует в базе данных, можно создать пользователя
                                // Хэширование пароля (рекомендуется для безопасности)
                                $hashed_password = $password;

                                // Загрузка изображения
                                $target_dir = "uploads/";
                                $target_file = $target_dir . $_FILES["image"]["name"];
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                // Проверка размера файла
                                if ($_FILES["image"]["size"] > 5000000) {
                                    echo "Извините, ваш файл слишком большой.";
                                    $uploadOk = 0;
                                }
                                // Проверка расширения файла
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                                    echo "Извините, только JPG, JPEG, PNG файлы могут быть загружены.";
                                    $uploadOk = 0;
                                }
                                // Загрузка файла
                                if ($uploadOk == 0) {
                                    echo "Извините, ваш файл не был загружен.";
                                } else {
                                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                        echo "Файл ". htmlspecialchars( basename( $_FILES["image"]["name"])). " был загружен.";
                                    } else {
                                        echo "Извините, произошла ошибка при загрузке вашего файла.";
                                    }
                                }

                                // SQL запрос для вставки новой записи в таблицу пользователей
                                $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone, dob, gender, image_path) VALUES (:username, :email, :password, :phone, :dob, :gender, :image_path)");
                                $stmt->bindParam(':username', $username);
                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':password', $hashed_password);
                                $stmt->bindParam(':phone', $phone);
                                $stmt->bindParam(':dob', $dob);
                                $stmt->bindParam(':gender', $gender);
                                $stmt->bindParam(':image_path', $target_file); // Имя файла картинки
                                $stmt->execute();

                                // Переадресация на страницу opa.php
                                header("Location: opa.php");
                                exit(); // Завершение выполнения текущего скрипта
                            } else {
                                if ($usernameCount > 0) {
                                    echo "Пользователь с таким именем пользователя уже существует.";
                                } elseif ($userCount > 0) {
                                    echo "Пользователь с таким email уже существует.";
                                } elseif (preg_match('/\d/', $username)) {
                                    echo "Имя пользователя не должно содержать цифр.";
                                }
                            }
                        }
                    } else {
                        echo "Password should be at least 8 characters long.";
                    }
                } else {
                    echo "Invalid email format.";
                }
            } else {
                echo "Пожалуйста, заполните все поля";
            }
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null; // Закрытие соединения с базой данных
    ?>



    </div>
</body>
</html>
