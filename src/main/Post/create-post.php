<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $userId = $_SESSION['user_id'];
    $threadId = $_POST['thread_id'];
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO `post` (content, user_id, thread_id) VALUES(?, ?, ?)");
        $stmt->execute([$content, $userId, $threadId]);
        header("Location: ../Thread/index.php?threadId=" . $threadId);
    }
    catch (PDOException $e) {
        header("../error/database-connection-failed.php");
        exit;
    }
}
