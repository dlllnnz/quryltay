<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <!-- Linking to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Importing Fira Sans font -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Importing Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Добро пожаловать в Quryltay</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<div class="container">
    <?php require("parts/globals.php")?>
    <?php require("parts/header.php")?>
    <h1>Добро пожаловать!</h1>
    <p>Выберите действие:</p>
    <a href="adding_org_form.php" class="btn">Создать организацию</a>
    <a href="displaying_orgs.php" class="btn">Вступить в организацию</a>
</div>
</body>
</html>