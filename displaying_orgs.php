<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quryltay</title>
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <?php require('parts/globals.php') ?>

    <?php require('parts/header.php') ?>

    <section class="contact-section spad">
    <form action="" method="POST">
        <input type="text" name="searchInput" placeholder="Введите название организации" value="<?php echo isset($_POST['searchInput']) ? $_POST['searchInput'] : ''; ?>">
        <button type="submit">Поиск</button>
    </form>

    <form action="" method="post">
    <?php
    if (isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
        $searchInput = $_POST['searchInput'];

        $sql = "SELECT organization_id, org_name FROM organizations WHERE org_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchParam = "%" . $searchInput . "%";
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<select name='organization_id'>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['organization_id'] . "'>" . htmlspecialchars($row['org_name']) . "</option>";
            }
            echo "</select>";
        } else {
            echo "Нет совпадений.";
        }
        $stmt->close();
    }
    ?>
    <button type="submit">Загрузить организацию</button>
    </form>

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
    </section>

    <?php require('parts/footer.php') ?>
</body>
</html>