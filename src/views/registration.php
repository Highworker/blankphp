<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Регистрация</title>
</head>
<body>
    <form action="/registration/action" method="POST">
        <p><?php
                foreach($data as $item) {
                    echo '<p>' . ($item) .'</p>';
                }
            ?>
        </p>
        <input name="login" value="Логин" onclick="this.value = ''">
        <input name="password" value="Пароль" onclick="this.value = ''">
        <button name="registrationSubmit">Зарегистрироваться</button>
    </form>
</body>
</html>