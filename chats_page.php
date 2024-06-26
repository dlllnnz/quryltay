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

    <div class="container">
        <div class="sidebar">
            <?php if ($org_id) { ?>
                <div class="large-font" style="
                display: flex;
                justify-content: space-around;
                text-decoration: none; color: inherit;
                "><label ><b>Chats</b></label> <a style="text-decoration: none; color: inherit;" href="">+</a></div>
                <ul class="chats">
                    <?php
                        $chat_query = mysqli_query($conn, "SELECT cp.chat_id AS chat_id, chat_name FROM chatparticipants AS cp JOIN chats ON cp.chat_id = chats.chat_id WHERE user_id = $user_id AND chats.organization_id = $org_id");
                        while ($chat = mysqli_fetch_array($chat_query)) { ?>
                            <li><a href="?org_id=<?php echo $org_id; ?>&chat_id=<?php echo $chat['chat_id'];?>"><?php echo htmlspecialchars($chat['chat_name']);?></a></li>
                        <?php }
                    ?>
                </ul>
            <?php } ?>
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
            <?php if (isset($_GET['chat_id'])) { $get = http_build_query($_GET); ?>
                <form action="php/send_messages.php?<?php echo $get;?>" method="POST">
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
