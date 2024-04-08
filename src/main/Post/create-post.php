<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    $thread_id = $_POST['thread_id'];
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('INSERT INTO `post` (content, user_id, thread_id) VALUES (?, ?, ?)');
        $stmt->execute([$content, $user_id, $thread_id]);

        header("Location: ../Thread/?threadId=".$thread_id);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}