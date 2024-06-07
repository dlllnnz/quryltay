<?php if (!empty($_SESSION['userlogin'])):?>
    <div class="navbar_container">
        <ul class="navbar_link navbar_left std-font">
            <li><a href="/" >Main</a></li>
            <li><a href="chats_page.php" >чат</a></li>
            <li><a href="php/exit.php">Выход</a></li>
        </ul>
    </div>
    
<?php else: ?>
    <div class="navbar_container">
        <ul class="navbar_link navbar_top std-font">
            <li><a href="/">Main</a></li>
            <li><a href="chats_page.php">чат</a></li>
            <li><a href="signin_form.php">Вход</a></li>
        </ul>
    </div>
<?php endif; ?>