<?php if (!empty($_SESSION['userlogin'])):?>
    <ul class="navbar_link navbar_left std-font">
        <li><a href="choosing_form.php" >организацию</a></li>
        <li><a href="chats_page.php" >чат</a></li>
        <li><a href="php/exit.php">Выход</a></li>
        <?php 
        $query = "SELECT organization_id, org_name FROM organizations";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <li><a href="choosing_form.php?org_id=<?= $row['organization_id'] ?>"><?= htmlspecialchars($row['org_name']) ?></a></li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No organizations found</li>
            <?php endif; ?>
    </ul>
    
    
<?php else: ?>
    <ul class="navbar_link navbar_top std-font">
        <li><a href="/">Main</a></li>
        <li><a href="chats_page.php">чат</a></li>
        <li><a href="signin_form.php">Вход</a></li>
    </ul>
<?php endif; ?>