<?php

namespace Src\Post;

use PDO, PDOException;

function postList($threadId)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('SELECT p.*, u.firstName, u.lastName, u.email, u.image AS avatar
        FROM `post` p 
        LEFT JOIN `user` u ON p.user_id = u.user_id
        WHERE thread_id = ? ORDER BY creation_date DESC');
        $stmt->execute([$threadId]);
        $post_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $post_list;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
