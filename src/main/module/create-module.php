<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $moduleName = $_POST['module_name'];
        $description = $_POST['description'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT ) VALUES(?, ?)');
            $stmt->execute([$moduleName, $description]);
            $stmt = $pdo->prepare('INSERT INTO `module`(module_name, description) VALUES(?, ?)');
            $stmt->execute([$moduleName, $description]);
            echo "successful add module";
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>