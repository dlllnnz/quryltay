<?php
require('../parts/globals.php');

if (!isset($_POST['chat_name']) || !isset($_POST['org_id'])) {
    header('Location: ../chats_page.php');
    exit();
}

$chat_name = $_POST['chat_name'];
$org_id = $_POST['org_id'];
$current_time = date('Y-m-d H:i:s');

// Создаем новый групповой чат
$stmt = $conn->prepare("INSERT INTO chats (chat_name, organization_id) VALUES (?, ?)");
$stmt->bind_param("si", $chat_name, $org_id);
$stmt->execute();
$chat_id = $stmt->insert_id;
$stmt->close();

// Добавляем всех пользователей организации в участники чата
$users_query = $conn->prepare("SELECT user_id FROM orgparticipants WHERE organization_id = ?");
$users_query->bind_param("i", $org_id);
$users_query->execute();
$users_result = $users_query->get_result();
$users_query->close();

$insert_stmt = $conn->prepare("INSERT INTO chatparticipants (chat_id, user_id, joined_at) VALUES (?, ?, ?)");
while ($user = $users_result->fetch_assoc()) {
    $insert_stmt->bind_param("iis", $chat_id, $user['user_id'], $current_time);
    $insert_stmt->execute();
}
$insert_stmt->close();

header("Location: ../chats_page.php?org_id=$org_id");
exit();
?>
