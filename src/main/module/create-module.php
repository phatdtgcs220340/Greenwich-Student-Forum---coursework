<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $moduleName = $_POST['module_name'];
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('INSERT INTO `module`(module_name) VALUES(?)');
            $stmt->execute([$moduleName]);
            echo "successful add module";
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>