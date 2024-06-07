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

        $user_id = $_SESSION['user_id'];
        $org_id = $_GET['org_id'] ?? null;
        $user_role = '';

        // Получение роли пользователя в организации
        if ($org_id) {
            $role_query = mysqli_query($conn, "SELECT userinfo FROM orgparticipants WHERE user_id = $user_id AND organization_id = $org_id");
            if ($role_row = mysqli_fetch_assoc($role_query)) {
                $user_role = $role_row['userinfo'];
            }
        }
    ?>
    <div class="main">
        <div class="sidebar">
            <h2>Organizations</h2>
            <ul class="organizations">
                <?php
                    $org_query = mysqli_query($conn, "SELECT o.organization_id, o.name FROM organizations AS o JOIN orgparticipants AS op ON o.organization_id = op.organization_id WHERE op.user_id = $user_id");
                    while ($org = mysqli_fetch_assoc($org_query)) { ?>
                        <li><a style="color: white" href="?org_id=<?php echo $org['organization_id'];?>"><?php echo htmlspecialchars($org['name']);?></a></li>
                    <?php }
                ?>
            </ul>

            <?php if ($org_id) { ?>
                <h2>Chats</h2>
                <ul class="chats">
                    <?php
                        $chat_query = mysqli_query($conn, "SELECT cp.chat_id AS chat_id, chat_name FROM chatparticipants AS cp JOIN chats ON cp.chat_id = chats.chat_id WHERE user_id = $user_id AND chats.organization_id = $org_id");
                        while ($chat = mysqli_fetch_array($chat_query)) { ?>
                            <li><a style="color: white" href="?org_id=<?php echo $org_id; ?>&chat_id=<?php echo $chat['chat_id'];?>"><?php echo htmlspecialchars($chat['chat_name']);?></a></li>
                        <?php }
                    ?>
                </ul>
            <?php } ?>
        </div>
        <div class="chat-area">
            <div class="chat-header">
                <h2><?php
                    if (isset($_GET['chat_id'])) {
                        $chat_id = $_GET['chat_id'];
                        $sel = mysqli_query($conn, "SELECT chat_name FROM chats WHERE chat_id = $chat_id");
                        if ($row = mysqli_fetch_array($sel)) {
                            echo htmlspecialchars($row['chat_name']);
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
                        <p><?php echo htmlspecialchars($row['userlogin']);?>: <?php echo htmlspecialchars($row['content']);?></p>
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

    <?php if ($org_id && $user_role === 'creator') { ?>
        <div>
            <h2>Create New Group Chat</h2>
            <form action="php/create_group_chat.php" method="POST">
                <input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
                <input type="text" name="chat_name" placeholder="Chat Name" required>
                <button type="submit">Create Group Chat</button>
            </form>
        </div>
    <?php } ?>

    <?php if ($org_id) { ?>
        <div>
            <h2>Create Private Chat</h2>
            <form action="php/create_private_chat.php" method="POST">
                <input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
                <input type="text" name="chat_name" placeholder="Chat Name" required>
                <select name="participant_id" required>
                    <option value="" disabled selected>Select Participant</option>
                    <?php
                        $users_query = mysqli_query($conn, "SELECT users.user_id, users.userlogin FROM users JOIN orgparticipants ON users.user_id = orgparticipants.user_id WHERE orgparticipants.organization_id = $org_id AND users.user_id != $user_id");
                        while ($user = mysqli_fetch_assoc($users_query)) {
                            echo '<option value="' . htmlspecialchars($user['user_id']) . '">' . htmlspecialchars($user['userlogin']) . '</option>';
                        }
                    ?>
                </select>
                <button type="submit">Create Private Chat</button>
            </form>
        </div>
    <?php } ?>
</body>
</html>
