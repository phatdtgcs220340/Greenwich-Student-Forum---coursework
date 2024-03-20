<?php 
    namespace Src\User;
    use PDO, PDOException; 
    function userList() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `user` WHERE role=\'Student\'');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>