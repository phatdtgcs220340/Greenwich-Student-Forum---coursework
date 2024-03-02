<?php
    namespace Src\Register;
    use PDO, PDOException;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Check if the email already exists
        $stmt = $pdo->prepare('SELECT * FROM `user` WHERE email = ?');
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();
        if ($existingUser) {
            echo "Error: Email address already exists.";
        } else {
            // Insert the new user
            $stmt = $pdo->prepare('INSERT INTO `user` (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, \'Student\')');
            $stmt->execute([$firstName, $lastName, $email, $password]);
            header("Location at: ./login.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
