
<?php

include("utils/auth_check.php");



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
            <a href="profile.php">Профиль</a>
            <a href="dashboard.php">Список завещаний</a>
            <a href="dashboard.php">Список пользователей</a>
            <a href="logout.php">Выйти</a>
        </div>
    </div>    
    <div class="form-wrapper">
        <div class="form-title">Завещание</div>
        <div class="form-description">Добавьте ваше завещание ниже и нажмите "Сохранить".</div>
        <form class= "hui" action="create_will.php" method="post">
            <div class="form-field">
            <label for="noteTextarea"></label>
            <textarea id="noteTextarea" name="name" class="textarea-text" placeholder="Называние завещания"></textarea>
            <textarea id="noteTextarea" name="will" class="textarea-text-big" placeholder="Завещание" rows="4"></textarea>
            </div>
            <div class="form-field access-field">
                <label for="accessText">Кому выдать доступ</label>
                
                <button type="button" class="add-button">+</button>
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
