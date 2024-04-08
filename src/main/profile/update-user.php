<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}
// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $targetDir = "resource/static/images/user/";
    $uploadOk = 1;
    $updateImage = true;
    if (isset($_FILES["image"])) {
        $file = $_FILES["image"];
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $uploadOk = 1;
        $targetFile = $targetDir . basename("user".$userId."_"."avatar".".".$imageFileType);
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
                if (move_uploaded_file($file["tmp_name"], "../../" . $targetFile)) {
                    echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else $targetFile = "resource/static/images/user/default_avatar.jpg";
    } else $updateImage = false;

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($updateImage) {
            $stmt = $pdo->prepare('UPDATE `user` SET firstName = ?, lastName = ?, image = ?  WHERE user_id = ?  ');
            $stmt->execute([$firstName, $lastName, $targetFile, $userId]);
            $_SESSION['image'] = $targetFile;
        } else {
            $stmt = $pdo->prepare('UPDATE `user` SET firstName = ?, lastName = ? WHERE user_id = ?  ');
            $stmt->execute([$firstName, $lastName, $userId]);
        }
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        header("Location: index.php");
    } catch (PDOException $e) {
        header("Location: ../error/database-connection-failed.php");
        exit;
    }
}
?>
