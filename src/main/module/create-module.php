<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $moduleName = $_POST['module_name'];
        $description = $_POST['description'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `module` WHERE module_name = ?');
            $stmt->execute([$moduleName]);
            $existingModule = $stmt->fetch();
            if ($existingModule) {
                header("Location: ../admin/module-manager.php?error=true");
                exit;
            }
            $stmt = $pdo->prepare('INSERT INTO `module`(module_name, description) VALUES(?, ?)');
            $stmt->execute([$moduleName, $description]);
            header("Location: ../admin/module-manager.php");
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>