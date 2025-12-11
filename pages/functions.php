<?php
session_start();

function regUser($username, $email, $password, $password_confirm): array
{
    $errors = [];

    $username = trim(htmlspecialchars($username));
    $email = trim(htmlspecialchars($email));
    $password = trim($password);
    $password_confirm = trim($password_confirm);

    $errors = validate($username, $email, $password, $password_confirm);
    if (empty($errors)) {
        global $conn;
        try {
            $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
            if ($stmt->rowCount()) {
                return $errors;
            }
        } catch (PDOException $e) {
            echo "SMTH GOES WRONG";
        }
    }
    return $errors;
}

function validate($username, $email, $password, $password_confirm)
{
    $errors = [];
    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $errors[] = "All fields are required";
    }

    if ($password != $password_confirm) {
        $errors[] = "Passwords are don't match";
    }

    if (len($username) < 3 || len($username) > 15) {
        $errors[] = "Login name must be more than 3 characters and less than 15";
    }

    if (len($password) < 3 || len($password) > 30) {
        $errors[] = "Login name must be more than 3 characters and less than 30";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email";
    }

    global $conn;
    $sql = "SELECT * FROM `users` WHERE `name`=? OR `email`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $email]);
    $result = $stmt->fetchAll();
    if ($stmt->rowCount()) {
        $errors[] = "Login or email is already exists";
    }

    return $errors;
}

function loginUser($email, $password, $remember = false): array
{
    $errors = [];

    $email = trim(htmlspecialchars($email));
    $password = trim($password);

    $errors = authValidate($email, $password, $remember);
    return $errors;
}

function authValidate($email, $password, $remember)
{
    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email";
    }

    if (len($password) < 3 || len($password) > 30) {
        $errors[] = "Login name must be more than 3 characters and less than 30";
    }

    if (!empty($errors)) return $errors;

    $user = getUserByEmail($email);
    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = "Неверный email или пароль";
        return $errors;
    }
    setUserSession($user);

    if ($remember) {
        setcookie('remember_email', $email, time() + 24 * 60 * 60, "/");
    }

    return [];
}

function checkRemember()
{
    if (isset($_SESSION['user'])) return;

    if (!isset($_COOKIE['remember_email'])) return;

    $email = $_COOKIE['remember_email'];

    $user = getUserByEmail($email);

    if ($user) {
        setUserSession($user);
        setcookie('remember_email', $email, time() + 24 * 60 * 60, "/");
    } else {
        setcookie('remember_email', '', time() - 3600, "/");
    }
}


function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function uploadFile($name)
{
    $result = '';
    if ($_FILES[$name]['error'] != 0) {
        $result = "Error: " . $_FILES[$name]['error'];
        return $result;
    }

    if (is_uploaded_file($_FILES[$name]['tmp_name']) && move_uploaded_file($_FILES[$name]['tmp_name'], 'images/' . $_FILES[$name]['name'])) {
        $result = "File uploaded successfully";
    } else {
        $result = "File not uploaded";
    }

    return $result;
}

function len(string $str)
{
    return mb_strlen($str,);
}

function dump($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function dd($data)
{
    dump($data);
    die;
}

function getCurrentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function logout()
{
    unset($_SESSION['user']);
    if (isset($_COOKIE['remember_email'])) {
        setcookie('remember_email', '', time() - 3600, "/");
        setcookie('remember_token', '', time() - 3600, "/");
    }
}

function setUserSession($user)
{
    $_SESSION['user'] = [
        'id' => $user['users_id'],
        'username' => $user['name'],
        'email' => $user['email']
    ];
}

function getUserByEmail($email)
{
    global $conn;

    try {
        $sql = "SELECT `users_id`, `name`, `email`, `password` FROM `users` WHERE `email` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "SMTH GOES WRONG";
        return false;
    }
}
