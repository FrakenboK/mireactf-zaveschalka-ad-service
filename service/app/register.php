<?php

include "models/user.php";

session_start();
if (isset($_SESSION['user'])) {
    header('Location: /profile.php');
    die();
}

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['email'])) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['login']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])){
        $err = 'Ацаца, никакого тебе завещения за такие креды!';
        header('Location: /register.php?err='.urlencode($err));
        die();
    }

    if (!preg_match('/^[0-9]+$/', $_POST['phone'])){
        $err = 'Ацаца, никакого тебе завещения за такой номер телефона!';
        header('Location: /register.php?err='.urlencode($err));
        die();
    }

    if (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i', $_POST['email'])){
        $err = 'Ацаца, никакого тебе завещения за такую почту!';
        echo $err;
        header('Location: /register.php?err='.urlencode($err));
        die();
    }
    if (file_exists('./users/'.md5($_POST['login'].getenv('SECRET')).'.txt')){
        $err = 'Такой пользователь уже заполнил завещание';
        header('Location: /register.php?err='.urlencode($err));
        die();
    }
 


    $user = new User($_POST);
    echo 'User created';
    $_SESSION['user'] = $user;
    header('Location: /profile.php');
    die();
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="static/css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<title>Zaveshyatelnitsa</title>
</head>
<body>

<div class="content-wrap">
    <div class="navbar">
        <span class="navbar-brand">Zaveshyatelnitsa</span>
        <div>
            <a href="login.php">Вход в аккаунт</a>
            <a href="register.php">Регистрация</a>
        </div>
    </div>    
    <div class="form-login">
        <div class="form-title">Создайте пользователя</div>
        <form action="register.php" method="post">
            <div class="form-field">
                <input name="login" class="textarea-text" placeholder="Логин"></textarea>
                <input type="password" name="password" class="textarea-text" placeholder="Пароль"></textarea>
                <input name="email" class="textarea-text" placeholder="Email"></textarea>
                <input name="phone" class="textarea-text" placeholder="Телефон"></textarea>
            </div>
            <button type="submit" class="submit-button">Сохранить</button>
        </form>
    
    </div>
    <?php
    if (isset($_GET['err'])){
        echo '<div class="message message-error">
        '.htmlspecialchars($_GET['err'], ENT_QUOTES, 'UTF-8').'
        </div>';
    }
    ?>
</div>
<!-- about -->
<div class="footer">
Сервис завещаний - с нами надежнее! | 8-800-5555-35-35
</div>

<script>
let count = 1;
document.querySelector('.add-button').addEventListener('click', function() {    
    var newDiv = document.createElement('div');
    newDiv.innerHTML = '<textarea id="noteTextarea" name="user'+count+'" class="textarea-text" placeholder="Логин получателя доступа" rows="4"></textarea>';
    document.querySelector('.form-field').appendChild(newDiv);
    count += 1;
});
</script>
</body>
</html>
