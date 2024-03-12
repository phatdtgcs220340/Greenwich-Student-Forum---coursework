<?php

namespace Src\Post;

use PDO, PDOException;

function postList($threadId)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('SELECT * FROM `post` WHERE thread_id = ? ORDER BY creation_date DESC');
        $stmt->execute([$threadId]);
        $post_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $post_list;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
