<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <?php
        require("parts/globals.php");
        require("parts/header.php");
        if (!isset($_SESSION['user_id'])) {
            header('Location: signin_form.php');
            exit();
        }
    ?>
    <div class="container">
        <div class="sidebar">
            <h2>Chats</h2>
            <ul class="chats">
                <?php
                    $user_id = $_SESSION['user_id'];
                    $sel = mysqli_query($conn, "SELECT cp.chat_id AS chat_id, chat_name FROM chatparticipants AS cp JOIN chats ON cp.chat_id = chats.chat_id WHERE user_id = $user_id");
                    while ($row = mysqli_fetch_array($sel)) { ?>
                        <li><a style="color: white" href="?chat_id=<?php echo $row['chat_id'];?>"><?php echo $row['chat_name'];?></a></li>
                    <?php }
                ?>
            </ul>
        </div>
        <div class="chat-area">
            <div class="chat-header">
                <h2><?php
                    if (isset($_GET['chat_id'])) {
                        $chat_id = $_GET['chat_id'];
                        $sel = mysqli_query($conn, "SELECT chat_name FROM chats WHERE chat_id = $chat_id");
                        if ($row = mysqli_fetch_array($sel)) {
                            echo $row['chat_name'];
                        } else {
                            echo 'Chat does not exist';
                        }
                    } else {
                        echo 'No chat selected';
                    }
                ?></h2>
            </div>
            <div class="chat-messages"><?php
                if (isset($_GET['chat_id'])) {
                    $chat_id = $_GET['chat_id'];
                    $sel = mysqli_query($conn, "SELECT userlogin, content FROM messages JOIN users ON sender_id = user_id WHERE chat_id = $chat_id ORDER BY `timestamp` ASC");
                    while ($row = mysqli_fetch_array($sel)) { ?>
                        <p><?php echo $row['userlogin'];?>: <?php echo $row['content'];?></p>
                    <?php }
                }
            ?></div>
            <?php if (isset($_GET['chat_id'])) { ?>
                <form action="php/send_messages.php?chat_id=<?php echo $_GET['chat_id'];?>" method="POST">
            <?php } ?>
                <div class="chat-input">
                    <textarea name="message" placeholder="Type your message..."></textarea>
                    <button type="submit">Send</button>
                </div>
            <?php if (isset($_GET['chat_id'])) { ?>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
