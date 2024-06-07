<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Организация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require('partials/globals.php');
    require('partials/header.php');

    $searched_org_id = $_GET['organization_id'] ?? 0;
    $org_query = "SELECT org_name, org_description FROM organizations WHERE organization_id = ?";
    $stmt = $conn->prepare($org_query);
    $stmt->bind_param("i", $searched_org_id);
    $stmt->execute();
    $org_result = $stmt->get_result();
    $org = $org_result->fetch_assoc();
    $org_name = $org['org_name'] ?? 'Неизвестная организация';
    $org_description = $org['org_description'] ?? 'unknown';

    echo "<h2>Информация организации: " . htmlspecialchars($org_name) . "</h2>";
    echo "<p>Описание: " . htmlspecialchars($org_description) . "</p>";

    // Кнопка "добавиться в эту организацию"
    echo "<form action='adding_to_prg.php' method='post'>";
    echo "<input type='hidden' name='organization_id' value='" . htmlspecialchars($searched_org_id) . "'>";
    echo "<button type='submit'>Добавиться в эту организацию</button>";
    echo "</form>";

    // Закрываем соединение с базой данных
    $stmt->close();


    ?>
</body>
</html>
