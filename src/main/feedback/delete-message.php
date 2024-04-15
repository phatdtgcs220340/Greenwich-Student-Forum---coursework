<?php 
    session_start();
    if (!isset($_SESSION['user_id'])) {
      header('Location: ./auth/login.php');
      exit;
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $messageId = $_POST['message_id'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('DELETE FROM `message` WHERE message_id = ?');
            $stmt->execute([$messageId]);
            if ($_SESSION['role'] == 'Admin')
                header("Location: ../admin/message-manager.php");
            else header("Location: ./");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>