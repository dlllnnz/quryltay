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
        <form>
            <h1 class="form-title">Регистрация</h1>
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" class="form-input">
            
            <label for="name">Фамилия</label>
            <input type="text" id="name" name="name" class="form-input">
            
            <label for="name">Псевдоним</label>
            <input type="text" id="name" name="name" class="form-input"> 
            
            <label for="email">Почта</label>            
            <input type="email" id="email" name="email" class="form-input">

            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" class="form-input">

            <button type="submit" class="form-button">Зарегестрироваться</button>
        </form>
    </div>
</body>
</html>