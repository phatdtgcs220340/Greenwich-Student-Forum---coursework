<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
      header('Location: ./auth/login.php');
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $post_id = $_POST['post_id'];
        $thread_id = $_POST['thread_id'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('DELETE FROM `post` WHERE post_id = ?');
            $stmt->execute([$post_id]);
    
            header("Location: ../Thread/page.php?threadId=".$thread_id);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>