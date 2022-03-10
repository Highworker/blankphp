<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Войдите</title>
</head>
<body>
    <p><?php
        if(isset($data)){
            foreach($data as $item) {
                echo '<p>' . ($item) .'</p>';
            }
        }
        ?>
    </p>
<form action="/login/action" method="POST">
    <input name="login" value="Логин" onclick="this.value = ''">
    <input name="password" value="Пароль" onclick="this.value = ''">
    <button name="registrationSubmit">Войти</button>
</form>
</body>
</html>