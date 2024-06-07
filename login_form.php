<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quryltay</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <?php require("parts/globals.php")?>
    <?php require("parts/header.php")?>
    
    <div class="form-container">
        <form action='php/add_user.php' method='POST'>
            <h1 class="form-title">Регистрация</h1>
            <label for="name">Имя</label>
            <input type="text" id="username" name="username" class="form-input">
            
            <label for="name">Фамилия</label>
            <input type="text" id="usersurname" name="usersurname" class="form-input">
            
            <label for="name">Псевдоним</label>
            <input type="text" id="userlogin" name="userlogin" class="form-input"> 
            
            <label for="email">Почта</label>            
            <input type="email" id="useremail" name="useremail" class="form-input">

            <label for="password">Пароль</label>
            <input type="password" id="userpassword" name="userpassword" class="form-input">

            <button type="submit" class="form-button">Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>