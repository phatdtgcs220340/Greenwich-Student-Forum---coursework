<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id']; 
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('DELETE FROM `user` WHERE user_id = ?');
            $stmt->execute([$userId]);
            header("Location: ../admin/user-manager.php");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>