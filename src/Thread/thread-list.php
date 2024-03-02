<?php
    namespace Src\Thread;
    use PDO, PDOException;
    function threadListAll() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('SELECT * FROM `thread` ORDER BY creation_date DESC');
        $stmt->execute();
        $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $thread_list;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
    function threadListUser($userId) {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `thread` WHERE user_id = ? ORDER BY creation_date DESC');
            $stmt->execute([$userId]);
            $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $thread_list;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function threadListCategory($category) {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `thread` WHERE category = ? ORDER BY creation_date DESC');
            $stmt->execute([$category]);
            $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $thread_list;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>