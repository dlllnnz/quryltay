<?php require("../parts/globals.php")?>
<?php  
    // Получение идентификатора пользователя  
    $organization_id = $_POST['$searched_org_id'];
    $user_id = $_SESSION['user_id'];
    
    // Вставка данных в таблицу students для каждого выбранного предмета
    $sql_part = "INSERT INTO orgparticipants(user_id, organization_id, userinfo) VALUES(?, ?, 'user')";
    $stmt_part = mysqli_prepare($conn, $sql_part);
    mysqli_stmt_bind_param($stmt_part, 'ii', $user_id, $organization_id);
    
    if (mysqli_stmt_execute($stmt_part)) {
        echo "<script>alert('Организация успешно создана');</script>";
        header("refresh:2, url=../index.php");
        exit();
    } else {
        echo "<script>alert('Ошибка при добавлении организации');</script>";
        header("refresh:2, url=../php/add_org_form.php");
        exit();
    }
    
    mysqli_stmt_close($stmt_part);
    mysqli_close($conn);
?>