<?php 
    namespace Src\Message;
    use PDO, PDOException; 
    function findAll() {
        try {
            $results_per_page = 8;
            // Determine the current page
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $start_limit = ($page - 1) * $results_per_page;
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `message` ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
            $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
            $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
            $stmt->execute();
            $messageList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `message`");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_pages = ceil($row["total"] / $results_per_page);
            return ["message_list" => $messageList, "total_pages" => $total_pages];
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
    function messageByUser($userId) {
        try {
            $results_per_page = 8;
            // Determine the current page
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $start_limit = ($page - 1) * $results_per_page;
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `message` WHERE user_id = :user_id ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
            $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
            $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $messageList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `message` WHERE user_id = ?");
            $stmt->execute([$userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_pages = ceil($row["total"] / $results_per_page);
            return ["message_list" => $messageList, "total_pages" => $total_pages];
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
?>