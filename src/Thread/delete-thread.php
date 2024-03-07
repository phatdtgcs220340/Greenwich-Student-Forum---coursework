<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['user_id'] != $_POST['user_id']) {
        header("HTTP/1.0 401 Unauthorized");
        exit;
    }
    $thread_id = $_POST['thread_id'];
    
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('SELECT * FROM `thread` WHERE thread_id = ?');
        $stmt->execute([$thread_id]);
        $fileToDelete = '../'.$stmt->fetch(PDO::FETCH_ASSOC)['image'];
        $stmt = $pdo->prepare('DELETE FROM `thread` WHERE thread_id = ?');
        $stmt->execute([$thread_id]);

        // Check if the file exists before attempting to delete it
        if (file_exists($fileToDelete)) {
            // Attempt to delete the file
            if (unlink($fileToDelete)) {
                echo "File $fileToDelete has been successfully deleted.";
            } else {
                echo "Error: Unable to delete $fileToDelete.";
            }
        } else {
            echo "File $fileToDelete does not exist.";
        }
        header("Location: ../home-view.php");

    } catch (PDOException $e) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}