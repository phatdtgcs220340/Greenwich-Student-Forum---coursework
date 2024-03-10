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
        header("HTTP/1.0 500 Internal Server Error");
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
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}
function threadListCategory()
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
        $category = $_GET['filterBy'];
        // Calculate the starting limit for the query
        $start_limit = ($page - 1) * $results_per_page;
        $stmt = $pdo->prepare('SELECT * FROM `thread` WHERE category = :category ORDER BY creation_date DESC LIMIT :start_limit, :results_per_page');
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':start_limit', $start_limit, PDO::PARAM_INT);
        $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $thread_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Pagination links
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `thread` WHERE category = ?");
        $stmt->execute([$category]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_pages = ceil($row["total"] / $results_per_page);
        return ["thread_list" => $thread_list, "total_pages" => $total_pages];
    } catch (PDOException $e) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}
