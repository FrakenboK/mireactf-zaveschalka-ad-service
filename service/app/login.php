<?php

include "models/user.php";
?>

<form action="login.php" method="post">
    <label for="login">Your login:</label>
    <input name="login" id="login" type="text">

    <label for="password">Your password:</label>
    <input name="password" id="password" type="text">

    <button type="submit">Submit</button>
</form>