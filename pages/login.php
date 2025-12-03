<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $remember = isset($_POST['remember']);

    $errors = loginUser($email, $password, $remember);

    if (empty($errors)) {
        echo "<div class='alert alert-success'>Вы успешно вошли!</div>";
        echo "<script>setTimeout(() => location.href='index.php?page=1', 1000);</script>";
    } else {
        echo "<div class='alert alert-danger'>Неверный email или пароль</div>";
    }
}

require_once "pages/loginform.php";
