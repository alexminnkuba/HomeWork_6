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
    return $errors;
}



function validate($username, $email, $password, $password_confirm)
{
    $errors = [];
    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $errors = "All fields are required";
    }

    if ($password != $password_confirm) {
        $errors = "Passwords are don't match";
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

    $db = 'users.txt';
    $file = fopen($db, "a+");
    if (empty($errors)) {
        while ($line = fgets($file)) {
            $line = trim($line);
            if (empty($line)) continue;

            $parts = explode(":", $line, 3);
            $readEmail = $parts[2];
            if ($readEmail === $email) {
                $errors[] = "Этот email уже зарегистрирован";
                break;
            }
        }
    }

    $line = "$username:" . password_hash($password, PASSWORD_DEFAULT) . ":$email\n";
    fwrite($file, $line);
    fclose($file);

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

    $db = "users.txt";
    if (!file_exists($db)) {
        $errors[] = "Файл с данными не найден";
    }

    $file = fopen($db, "r");
    while ($line = fgets($file)) {
        $line = trim($line);
        if (empty($line)) continue;

        $parts = explode(":", $line, 3);
        $username = $parts[0];
        $hash = $parts[1];
        $storedEmail = $parts[2];
        if (len($storedEmail) === len($email)) {
            if (password_verify($password, $hash)) {
                $_SESSION['user'] = [
                    'username' => $username,
                    'email' => $storedEmail
                ];
            }

            if ($remember) {
                $expire = time() + 24 * 60 * 60;
                setcookie('remember_email', $email, $expire, "/");
            }
            break;
        }
    }
    fclose($file);
    return $errors;
}

function checkRemember()
{
    if (isset($_SESSION['user'])) return;

    if (isset($_COOKIE['remember_email'])) {
        $email = $_COOKIE['remember_email'];
        $db = 'users.txt';
        if (file_exists($db)) {
            $file = fopen($db, "r");
            while ($line = fgets($file)) {
                $parts = explode(";", trim($line), 3);
                if (len($parts[2]) === len($email)) {
                    $_SESSION['user'] = [
                        'username' => $parts[0],
                        'email' => $parts[2]
                    ];
                    return;
                }
            }
            fclose($file);
        }
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
