<?php
session_start();
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
            // Check if image file is a actual image or fake image
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png"
                && $imageFileType != "svg"
            ) {
                echo "Sorry, only JPG, PNG & SVG files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($file["tmp_name"], "../../" . $target_file)) {
                    echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else $target_file = "";
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
