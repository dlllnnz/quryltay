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
        <form action="php/add_organization.php" method="post">
            <h2>Создание организации</h2>
            <input type="text" name="org_name" placeholder="Название организации" required>
            <textarea name="org_description" placeholder="Описание огранизации" required></textarea>
            <button type="submit">Отправить запрос</button>
        </form>
    </div>
</body>
</html>