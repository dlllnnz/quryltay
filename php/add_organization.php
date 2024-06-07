<?php require("../parts/globals.php")?>
<?php 
    $org_name = $_POST['org_name'];
    $org_description = $_POST['org_description'];

    $checkname = mysqli_query($conn, "SELECT * FROM organizations WHERE org_name='$org_name'");
    $row = mysqli_fetch_array($checkname);
    if (!empty($row['organization_id'])){
        echo "Error. Login already exists";
        header('refresh:2, url=../adding_org_form.php');
        exit();
    }

    $sql_org = "INSERT INTO organizations(org_name, org_description) VALUES(?, ?)";
    $stmt_org = mysqli_prepare($conn, $sql_org);
    mysqli_stmt_bind_param($stmt_org, 'ss', $org_name, $org_description);

    if (mysqli_stmt_execute($stmt_org)) {   
        // Получение идентификатора пользователя  
        $organization_id = mysqli_insert_id($conn);
        $user_id = $_SESSION['user_id'];
        
        // Вставка данных в таблицу students для каждого выбранного предмета
        $sql_part = "INSERT INTO orgparticipants(user_id, organization_id, userinfo) VALUES(?, ?, 'creator')";
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
    } else {
        echo "<script>alert('Ошибка при добавлении организации');</script>";
        header("refresh:2, url=../php/add_org_form.php");
        exit();
    }
    
    mysqli_stmt_close($stmt_org);
    mysqli_close($conn);
?>