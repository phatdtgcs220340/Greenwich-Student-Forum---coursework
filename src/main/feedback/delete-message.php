<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $messageId = $_POST['message_id'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('DELETE FROM `message` WHERE message_id = ?');
            $stmt->execute([$messageId]);
            header("Location: ../");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>