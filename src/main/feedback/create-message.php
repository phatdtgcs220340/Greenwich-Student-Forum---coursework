<?php 
    session_start();
    if (!isset($_SESSION['user_id'])) {
      header('Location: ./auth/login.php');
      exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $userId = $_SESSION['user_id'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('INSERT INTO `message`(title, content, user_id) VALUES(?, ?, ?)');
            $stmt->execute([$title, $content, $userId]);
            header("Location: index.php");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>