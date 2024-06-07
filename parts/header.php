<?php if (!empty($_SESSION['userlogin'])):?>
    <ul class="navbar_link navbar_left std-font">
        <li><a href="choosing_form.php" >организацию</a></li>
        <li><a href="chats_page.php" >чат</a></li>
        <li><a href="php/exit.php">Выход</a></li>
        <?php 
        $user_id = $_SESSION['user_id'];
        $org_id = $_GET['org_id'] ?? null;
        $user_role = '';

        // Получение роли пользователя в организации
        if ($org_id) {
            $role_query = mysqli_query($conn, "SELECT userinfo FROM orgparticipants WHERE user_id = $user_id AND organization_id = $org_id");
            if ($role_row = mysqli_fetch_assoc($role_query)) {
                $user_role = $role_row['userinfo'];
            }
        }?>
        <?php
        $org_query = mysqli_query($conn, "SELECT o.organization_id, o.org_name FROM organizations AS o JOIN orgparticipants AS op ON o.organization_id = op.organization_id WHERE op.user_id = $user_id");
        while ($org = mysqli_fetch_assoc($org_query)) { ?>
            <li><a href="?org_id=<?php echo $org['organization_id'];?>"><?php echo htmlspecialchars($org['org_name']);?></a></li>
        <?php }
    ?>
            
    </ul>
    
    
<?php else: ?>
    <ul class="navbar_link navbar_top std-font">
        <li><a href="/">Main</a></li>
        <li><a href="chats_page.php">чат</a></li>
        <li><a href="signin_form.php">Вход</a></li>
    </ul>
<?php endif; ?>
