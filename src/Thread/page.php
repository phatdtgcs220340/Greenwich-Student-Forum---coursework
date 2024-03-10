<?php

namespace Src\Thread;

session_start();
require_once("thread.php");

use PDO, PDOException;

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}
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
        if (empty($threadFetch)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
        $thread = new Thread($threadFetch['thread_id'], $threadFetch['title'], $threadFetch['image'], $threadFetch['content'], $threadFetch['user_id'], $threadFetch['creation_date'], $threadFetch['category']);
    } catch (PDOException $e) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../images/favicon.jpg">
    <title>Greenwich Student Forum</title>
</head>

<body id="body">
<nav class="border border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="../index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://upload.wikimedia.org/wikipedia/vi/b/bf/Official_logo_of_Greenwich_Vietnam.png" class="h-32" alt="Flowbite Logo" />
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Greenwich Student Forum</h5>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-10 h-10 rounded-full" src="../<?php echo $_SESSION['image'] ?>" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border border-gray-100" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900"><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                        <a href="../profile/profile.php?userId=<?php echo $_SESSION['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        </li>
                        <li>
                            <a href="../auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                    <li>
                        <a href="../index.php" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">My Feedback</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="p-6 gap-2">
        <div class="flex flex-col w-2/3">
        <h5 class="mb-2 text-xl font-medium tracking-tight text-gray-700"><?php echo $thread->getTitle() ?></h5>
        <h5>Category: <?php echo $thread->getCategory() ?></h5>
        <?php if ($_SESSION['user_id'] == $thread->getUserId()) echo '
                <button class="text-gray-500 text-base font-bold self-end hover:text-gray-900" data-dropdown-toggle="thread-dropdown" data-dropdown-placement="bottom">⁝</button>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border border-gray-100" id="thread-dropdown">
                                <ul class="py-2" aria-labelledby="thread-menu-button">
                                    <li>
                                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete</button>
                                    </li>
                                    <li>
                                    <button onclick="displayForm()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                    </li>
                                </ul>
                </div>'
        ?>
        </div>
        <div class="flex flex-col p-6 w-2/3 h-auto bg-white border-t border-b border-gray-400 gap-2">
            <form id="update-form" class="hidden" action="update-thread.php" method="post" enctype="multipart/form-data">
                <input name="user_id" class="hidden" value="<?php echo $thread->getUserId()?>">
                <input name="thread_id" type="text" class="hidden" value="<?php echo $threadId?>">
                <textarea rows="4" class="block p-2.5 w-full font-lg rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" id="edit-content" name="content"></textarea>
                <h5 id="note" class="hidden text-xs font-lg italic">Leave nothing for delete</h5>
                <input disabled id="edit-image" class="hidden block w-full text-sm text-gray-900 border border-gray-300 cusor-pointer bg-white focus:outline-none" accept="image/png, image/jpeg, image/svg" placeholder="Leave nothing for delete" raria-describedby="file_input_help" id="thread-image" name="image" type="file">
                <br>
                <button type="button" onclick="changeImage()" class="py-2.5 px-5 me-2 mx-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Update Image</button>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mx-8">Save</button>
            </form>
            <p id="thread-content" class="font-lg"><?php 
            $content = $thread->getContent();
            echo substr_count($content,"<br>") == 0 ? nl2br($content) : $content ?></p>
            <img id="thread-image" class="" src="../<?php
                        if ($thread->getImage() != "")
                            echo $thread->getImage();
                        else
                            echo "";
                        ?>" alt="" />
            <div class="bg-gray-100 p-2 border boreder-gray-400 self-end">
                <h2 class="text-xs mb-2">asked <?php echo $thread->timeDifference() ?> ago</h2>
                <a href="../profile/profile.php?userId=<?php echo $thread->getUserId()?>" class="flex gap-2">
                    <img class="w-8 h-8 rounded-lg" src="<?php $user = $thread->userInfo();
                     echo "../".$user['image'] ?>" 
                    alt="user photo">
                    <h2 class="text-sm"><?php
                                        $user = $thread->userInfo();
                                        echo $user['firstName'] . " " . $user['lastName'];
                                        ?></h2>
                </a>
            </div>
            <?php
            // if the user is the owner of the thread then display delete and edit method
            if ($thread->getUserId() == $_SESSION['user_id'])
                echo '<div class="flex self-start">
                    <!-- Delete form -->
                    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                                </button>
                                <div class="p-4 md:p-5 text-center">
                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete this thread?</h3>
                                    <form action="delete-thread.php" method="post">
                                        <input class="hidden" name="user_id" value="'.$thread->getUserId().'">
                                        <input class="hidden" name="thread_id" value="'.$_GET['threadId'].'">
                                        <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                            Yes, I\'m sure
                                        </button>
                                    </form>
                                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>'
            ?>
        </div>

        <form action="../Post/create-post.php" method="post" class="w-3/4">
            <input class="hidden" id="threadId" name="threadId" value="<?php echo $thread->getThreadId() ?>">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your answer</label>
            <textarea id="content" name="content" rows="4" class="block mb-2 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Leave a comment..."></textarea>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mt-px mb-2">Answer</button>
        </form>
        <?php
        require_once("../Post/post.php");
        require_once("../Post/post-list.php");

        use Src\Post as post;

        $postList = post\postList($thread->getThreadId());
        // display thread list 
        foreach ($postList as $postNode) {
            $post = new post\Post($postNode['post_id'], $postNode['content'], $postNode['user_id'], $postNode['thread_id'], $postNode['creation_date']);
            echo $post->toCard();
        }
        ?>
    </div>
    <script>
        function displayForm() {
            var form = document.getElementById("update-form");
            var content = document.getElementById("thread-content");
            var textarea = document.getElementById("edit-content");
            if (form.classList.contains("hidden"))
            {
                form.classList.remove("hidden");
                textarea.value = content.innerHTML;
                content.classList.add("hidden");
            }
            else {
                form.classList.add("hidden");
                content.classList.remove("hidden");
            }
        }
        function changeImage() {
            var destination = document.getElementById("thread-image");
            var source = document.getElementById("edit-image");
            var note = document.getElementById("note")
            if (source.classList.contains("hidden"))
            {
                source.classList.remove("hidden");
                note.classList.remove("hidden");
                destination.classList.add("hidden");
                source.disabled = false;
            }
            else {
                source.classList.add("hidden");
                note.classList.add("hidden");
                source.disabled = true;
                destination.classList.remove("hidden");
            }
        }
    </script>
    <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>
</body>

</html>