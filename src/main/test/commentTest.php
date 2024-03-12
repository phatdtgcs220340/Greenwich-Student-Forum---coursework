<?php 
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('SELECT COUNT(*) AS comments, thread_id  FROM `post` GROUP BY thread_id');
        $stmt->execute();
        $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($comment as $node) {
            echo $node['comments'].'<br>';
        }
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
?>