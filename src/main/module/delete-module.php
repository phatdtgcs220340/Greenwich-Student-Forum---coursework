<?php 
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