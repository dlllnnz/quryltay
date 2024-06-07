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
        <form action='php/log_in.php' method='POST'>
            <h1 class="form-title">Войти</h1>            
            <label for="name">Псевдоним</label>
            <input type="text" id="userlogin" name="userlogin" class="form-input"> 

            <label for="password">Пароль</label>
            <input type="password" id="userpassword" name="userpassword" class="form-input">

            <button type="submit" class="form-button">Войти</button>
        </form>
    </div>
</body>
</html>