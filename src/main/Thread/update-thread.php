<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['user_id'] != $_POST['user_id']) {
        header("Location: ../error/access-denied.php");
        exit;
    }
        
    $thread_id = $_POST['thread_id'];
    $content = $_POST['content'];
    $target_dir = "resource/static/images/thread/";
    $updateImage = true;
    if (isset($_FILES["image"])) {
        $file = $_FILES["image"];
        // prevent overwrite when using the same img name
        $target_file = $target_dir .$_SESSION['user_id']. basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!empty($file["name"])) {
            if ($file["name"] !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if (
                $imageFileType != "jpg" && $imageFileType != "png"
                && $imageFileType != "svg"
            ) {
                $uploadOk = 0;
            }

            if ($uploadOk == 1) move_uploaded_file($file["tmp_name"], "../../" . $target_file);
        }
        else $target_file = "";
    } else $updateImage = false;

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($updateImage) {
            $stmt = $pdo->prepare('UPDATE `thread` SET content = ?, image = ?  WHERE thread_id = ?  ');
            $stmt->execute([$content, $target_file, $thread_id]);
        } else {
            $stmt = $pdo->prepare('UPDATE `thread` SET content = ? WHERE thread_id = ?  ');
            $stmt->execute([$content, $thread_id]);
        }
        header("Location: ./?threadId=" . $thread_id);
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
}
