<?php

namespace Src\Thread;

use PDO, PDOException;

function threadListAll($latest = true)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $results_per_page = 5;
        // Determine the current page
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        // Calculate the starting limit for the query
        $start_limit = ($page - 1) * $results_per_page;
        if ($latest)
            $stmt = $pdo->prepare('SELECT * FROM `thread` ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
        else
            $stmt = $pdo->prepare('SELECT * FROM `thread` ORDER BY creation_date ASC LIMIT :start_limit, :results_per_page');
        $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
        $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Pagination links
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM `thread`");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_pages = ceil($row["total"] / $results_per_page);
        return ["thread_list" => $thread_list, "total_pages" => $total_pages];
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
}
function threadListByUser($userId)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $results_per_page = 4;
        // Determine the current page
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        // Calculate the starting limit for the query
        $start_limit = ($page - 1) * $results_per_page;
        $stmt = $pdo->prepare('SELECT * FROM `thread` WHERE user_id = :user_id ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
        $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Pagination links
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `thread` WHERE user_id= ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_pages = ceil($row["total"] / $results_per_page);
        return ["thread_list" => $thread_list, "total_pages" => $total_pages];
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
}
function threadListCategory($latest = true)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $results_per_page = 5;
        // Determine the current page
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $module_id = $_GET['filterBy'];
        // Calculate the starting limit for the query
        $start_limit = ($page - 1) * $results_per_page;
        if ($latest)
            $stmt = $pdo->prepare('SELECT m.module_name, t.* FROM `module` m RIGHT JOIN `thread` t ON t.module_id = m.module_id WHERE m.module_id = :module_id ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
        else 
            $stmt = $pdo->prepare('SELECT m.module_name, t.* FROM `module` m RIGHT JOIN `thread` t ON t.module_id = m.module_id WHERE m.module_id = :module_id  ORDER BY creation_date ASC LIMIT :start_limit, :results_per_page');
        $stmt->bindParam(':module_id', $module_id, PDO::PARAM_STR);
        $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
        $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Pagination links
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `module` WHERE module_id = ?");
        $stmt->execute([$module_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_pages = ceil($row["total"] / $results_per_page);
        return ["thread_list" => $thread_list, "total_pages" => $total_pages];
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
}
