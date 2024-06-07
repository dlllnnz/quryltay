<?php
require("../parts/globals.php");

$user_id = $_SESSION['user_id'];
if (!isset($_GET['chat_id'])) {
	header('Location: ../chats_page.php');
	die();
}
$chat_id = $_GET['chat_id'];
if (!isset($_POST['message'])) {
	header("Location: ../chats_page.php?chat_id=$chat_id");
	die();
}
$message = $_POST['message'];

$stmt = $conn->prepare('INSERT INTO messages(chat_id, sender_id, content) VALUES(?, ?, ?)');
$stmt->bind_param('iis', $chat_id, $user_id, $message);
$stmt->execute();

header("Location: ../chats_page.php?chat_id=$chat_id");
