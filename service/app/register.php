<?php

include "models/user.php";

session_start();
if (isset($_SESSION['user'])) {
    header('Location: /dashboard.php');
    die();
}

if (count($_POST) === 4) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['login'])){
        echo 'Invalid username';
        header('Location: /register.php');
        die();
    }

    if (file_exists('./users/'.md5($_POST['login']).'.txt')){
        echo 'User exists';
        header('Location: /register.php');
        die();
    }

    $user = new User($_POST);
    echo unserialize(serialize($user))->login;
    $_SESSION['user'] = $user;



}
?>

<form action="register.php" method="post">
    <label for="login">Your login:</label>
    <input name="login" id="login" type="text">

    <label for="password">Your password:</label>
    <input name="password" id="password" type="text">

    <label for="phone">Your phone:</label>
    <input name="phone" id="phone" type="text">

    <label for="email">Your email:</label>
    <input name="email" id="email" type="text">

    <button type="submit">Submit</button>
</form>