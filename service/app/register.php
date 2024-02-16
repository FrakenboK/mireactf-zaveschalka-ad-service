<?php

include "models/user.php";

session_start();
if (isset($_SESSION['user'])) {
    header('Location: /dashboard.php');
    die();
}

if (count($_POST) === 4) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['login'])){
        $err = 'Invalid username';
        header('Location: /register.php?err='.$err);
        die();
    }

    if (file_exists('./users/'.md5($_POST['login']).'.txt')){
        echo 'User exists';
        header('Location: /register.php');
        die();
    }

    $user = new User($_POST);
    echo 'User created';
    $_SESSION['user'] = $user;
    header('Location: /profile.php');
    die();
}

?>

<?php
    // if (count($_POST) !== 4 && count($_POST) !== 0) {
    //     echo 'Not all parameters were passed!';
    // }
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
                <textarea name="login" class="textarea-text" placeholder="Логин"></textarea>
                <textarea name="password" class="textarea-text" placeholder="Пароль"></textarea>
                <textarea name="email" class="textarea-text" placeholder="Email"></textarea>
                <textarea name="phone" class="textarea-text" placeholder="Телефон"></textarea>
            </div>
            <button type="submit" class="submit-button">Сохранить</button>
        </form>
    
    </div>

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
