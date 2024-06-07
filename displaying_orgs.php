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

    <form action="search_org.php" method="GET">
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
        <button type="submit">Загрузите организации</button>
    </form>
    </section>

    <?php require('parts/footer.php') ?>
</body>
</html>