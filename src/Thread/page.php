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
        $thread = new Thread($threadFetch['thread_id'], $threadFetch['title'], $threadFetch['image'], $threadFetch['content'], $threadFetch['user_id'], $threadFetch['creation_date'], $threadFetch['category']);
    } catch (PDOException $e) {
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
    <title><?php echo $thread->getTitle() ?></title>
</head>

<body>
    <div class="flex flex-col flex-start p-6 gap-2 ">
        <h5 class="mb-2 text-xl font-medium tracking-tight text-gray-700"><?php echo $thread->getTitle()?></h5>
        <h5>Category: <?php echo $thread->getCategory()?></h5>
        <div class="flex flex-col p-6 w-2/3 h-auto bg-white border-t border-b border-gray-400 gap-2">
            <p><?php echo nl2br($thread->getContent()) ?></p>
            <img src="
            <?php 
            if ($thread->getImage() != "")
                echo "../".$thread->getImage();
            else 
                echo "";
            ?>" alt=""/>
            <div class="bg-gray-100 p-2 border boreder-gray-400 self-end flex flex-col gap-2">
                <h2 class="text-xs">asked <?php echo $thread->timeDifference()?> ago</h2>
                <div class="flex gap-2">
                    <img class="w-8 h-8 rounded-lg" src="https://p16-tm-sg.tiktokmusic.me/img/tos-alisg-v-2102/oEP71hZqEwA72YkANvBsrV4gAiAAXBciIEIAr~c5_500x500.image" alt="user photo">
                    <h2 class="text-sm"><?php 
                    $user = $thread->userInfo();
                    echo $user['firstName']." ".$user['lastName'];
                    ?></h2>
                </div>
            </div>
        </div>

        <form class="w-3/4">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your answer</label>
            <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
        </form>

    </div>
</body>

</html>