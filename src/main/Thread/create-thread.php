<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $module = $_POST['module'];
    $target_dir = "resource/static/images/thread/";
    // prevent overwrite when using the same img name
    $target_file = $target_dir .$user_id. basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare('INSERT INTO `thread` (title, content, image, user_id, module_id) VALUES (?, ?, ?, ?, ?)');
        if (!empty($_FILES["image"]["name"])) {
            if (getimagesize($_FILES["image"]["tmp_name"]) !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
    
            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png"
                && $imageFileType != "svg"
            ) {
                $uploadOk = 0;
            }
            
            if ($uploadOk != 0) {
                move_uploaded_file($_FILES["image"]["tmp_name"], "../../" . $target_file);
            }
        }
        else {
            $target_file = "";
        }
        $stmt->execute([$title, $content, $target_file, $user_id, $module]);

        header("Location: ../index.php");
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
}
