<?php

namespace Src\Thread;

use PDO, PDOException;

function threadListAll()
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
        $stmt = $pdo->prepare('SELECT * FROM `thread` ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
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
        echo "Error: " . $e->getMessage();
    }
}
function threadListUser($userId)
{
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
function threadListCategory($category)
{
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
