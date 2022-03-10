<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Главная</title>
</head>
<body>
<navbar>
    <?php
    if ($userData != null) {
        if ($userData['userlogin'] != null){
            echo '<p>Добро пожаловать, '. $userData['userlogin'] .'</p>';
            echo '<p><a href="/logout">Выйти</a></p>';
            echo '<p><a href="/recipes/manage">Управление рецептами</a></p><hr>';
        } else {
            echo '<p><a href="/login">Войти</a></p>';
            echo '<p><a href="/registration">Регистрация</a></p>';
        }
    } else {
        echo '<p><a href="/login">Войти</a></p>';
        echo '<p><a href="/registration">Регистрация</a></p>';
    }
    ?>
    <p><a href="/recipes">Рецепты</a></p>
    <p><a href="/ingridients">Ингридиенты</a></p>
</navbar>
</body>
</html>