<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = regUser($_POST['username'], $_POST['email'],$_POST['password'],$_POST['password_confirm']);
    if(!empty($errors)) {
        $list = '<ul class="col-6" style="color: red;">';
        foreach ($errors as $err) {
            $list.="<li>$err</li>";
        }
        $list .= "</ul>";
        echo $list;
    } else {
        echo "<p class='mt-3 col-6' style='color:green;'> User registered successfully</p>";
    }
}

require_once "pages/regform.php";
?>
