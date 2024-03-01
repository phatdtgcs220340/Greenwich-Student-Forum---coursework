<?php
    namespace Src\Thread;
    require_once("./thread.php");
    use PDO, PDOException;

    if (isset($_GET['threadId'])) {
        $threadId = $_GET['threadId'];
        try {
        // Connect to your database
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve the thread content based on the threadId
        $stmt = $pdo->prepare("SELECT * FROM `thread` WHERE thread_id = ?");
        $stmt->execute([$threadId]);
        $threadFetch = $stmt->fetch(PDO::FETCH_ASSOC);
        $thread = new Thread($threadFetch['thread_id'], $threadFetch['title'], $threadFetch['image'], $threadFetch['content'], $threadFetch['user_id']);
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <title><?php echo $threadFetch['title'] ?></title>
</head>
<body>
    
</body>
</html>
