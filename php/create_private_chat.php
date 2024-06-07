<?php
require('../parts/globals.php');

if (!isset($_POST['chat_name']) || !isset($_POST['org_id']) || !isset($_POST['participant_id'])) {
    header('Location: ../chats_page.php');
    exit();
}

$chat_name = $_POST['chat_name'];
$org_id = $_POST['org_id'];
$participant_id = $_POST['participant_id'];
$current_time = date('Y-m-d H:i:s');

// Создаем новый приватный чат
$stmt = $conn->prepare("INSERT INTO chats (chat_name, organization_id) VALUES (?, ?)");
$stmt->bind_param("si", $chat_name, $org_id);
$stmt->execute();
$chat_id = $stmt->insert_id;
$stmt->close();

// Добавляем создателя и участника в участники чата
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("INSERT INTO chatparticipants (chat_id, user_id, joined_at) VALUES (?, ?, ?), (?, ?, ?)");
$stmt->bind_param("iisiis", $chat_id, $user_id, $current_time, $chat_id, $participant_id, $current_time);
$stmt->execute();
$stmt->close();

header("Location: ../chats_page.php?org_id=$org_id");
exit();
?>
