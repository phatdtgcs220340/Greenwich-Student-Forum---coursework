<?php

namespace Src;
use PDO, PDOException;
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./auth/login.php');
    exit;
}
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    try {
        // Connect to your database
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve the thread content based on the threadId
        $stmt = $pdo->prepare("SELECT * FROM `user` WHERE user_id = ?");
        $stmt->execute([$userId]);
        $userFetch = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($userFetch)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
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
    <link rel="icon" type="image/x-icon" href="images\favicon.jpg">
    <title>Greenwich Student Forum</title>
</head>

<body>
    <nav class="border border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="home-view.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://upload.wikimedia.org/wikipedia/vi/b/bf/Official_logo_of_Greenwich_Vietnam.png" class="h-32" alt="Flowbite Logo" />
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Greenwich Student Forum</h5>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-10 h-10 rounded-full" src="./<?php echo $_SESSION['image'] ?>" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900"><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="user-setting.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        </li>
                        <li>
                            <a href="./auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
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
                        <a href="home-view.php" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">My Feedback</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="flex flex-col items-center">
        <div class="mt-8 w-2/3 grid grid-cols-2 grid-flow-col gap-4">
            
            <div class="row-span-2">
                <img class="w-64 h-64 rounded-lg mb-4" src="<?php echo $userFetch['image'] ?>" alt="">
            </div>
            <div class="">
                <h5 class="text-2xl font-semibold">Full name: <?php echo $userFetch['firstName'] . ' ' . $userFetch['lastName'] ?></h5>
                <h5 class="text-sm font-normal">Email: <?php echo $userFetch['email'] ?></h5>
            </div>
            
            <div class="">
                <h5 class="text-2xl text-gray-700 mb-4 font-semibold">Threads</h5>
                <?php

                require_once("Thread/thread-list.php");
                require_once("Thread/thread.php");

                use Src\Thread as thread;

                $threadList = thread\threadListUser($userFetch['user_id']);
                foreach ($threadList as $threadNode) {
                    $thread = new thread\Thread($threadNode['thread_id'], $threadNode['title'], "", "", $threadNode['user_id'], $threadNode['creation_date'], $threadNode['category']);
                    echo $thread->toCard(false);
                }
                ?>
            </div>
        </div>
    </div>
      <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>
</body>

</html>