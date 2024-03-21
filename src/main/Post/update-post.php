<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
      header('Location: ./auth/login.php');
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $post_id = $_POST['post_id'];
        $content = $_POST['content'];
        $thread_id = $_POST['thread_id'];
        try {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('UPDATE `post` SET content = ?, creation_date = ? WHERE post_id = ?');
            $stmt->execute([$content, date('Y-m-d H:i:s'), $post_id]);
    
            header("Location: ../Thread/?threadId=".$thread_id);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>