<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $module = $_POST['module'];
    $target_dir = "images/thread/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare('INSERT INTO `thread` (title, content, image, user_id, module_id) VALUES (?, ?, ?, ?, ?)');
        if (!empty($_FILES["image"]["name"])) {
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
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
                if (move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        else {
            $target_file = "";
        }
        $stmt->execute([$title, $content, $target_file, $user_id, $module]);

        header("Location: ../index.php");
    } catch (PDOException $e) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}
