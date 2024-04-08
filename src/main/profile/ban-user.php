<?php 
    session_start();
    if (!isset($_SESSION['user_id'])) {
      if($_SESSION['role'] != 'Admin')
        header('Location: ../error/access-denied.php');
      else 
        header('Location: ../auth/login.php');
      exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id']; 
        $banned = $_POST['banned'] == 1 ? 0 : 1;
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('UPDATE `user` SET is_enabled = ? WHERE user_id = ?');
            $stmt->execute([$banned, $userId]);
            header("Location: ../admin/user-manager.php");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>