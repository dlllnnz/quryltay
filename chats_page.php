<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger</title>
    <link rel="stylesheet" href="styles/main.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .main {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
            flex: 1;
            overflow: hidden;
        }
        .sidebar {
            width: 25%;
            background-color: #2c3e50;
            color: white;
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #34495e;
        }
        .chats {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .chats li {
            padding: 15px;
            border-bottom: 1px solid #34495e;
            cursor: pointer;
        }
        .chats li:hover {
            background-color: #34495e;
        }
        .chat-area {
            width: 75%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .chat-header {
            background-color: #ecf0f1;
            padding: 15px;
            border-bottom: 1px solid #bdc3c7;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
        }
        .chat-input {
            display: flex;
            border-top: 1px solid #bdc3c7;
        }
        .chat-input textarea {
            flex-grow: 1;
            padding: 10px;
            border: none;
            resize: none;
            font-size: 14px;
        }
        .chat-input button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        .chat-input button:hover {
            background-color: #2980b9;
        }
    </style>
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
    <div class="main">
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
