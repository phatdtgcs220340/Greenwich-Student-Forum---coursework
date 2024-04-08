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
        $moduleId = $_POST['module_id']; 
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('DELETE FROM `module` WHERE module_id = ?');
            $stmt->execute([$moduleId]);
            header("Location: ../admin/module-manager.php");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>