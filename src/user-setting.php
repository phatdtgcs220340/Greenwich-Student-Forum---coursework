<?php

namespace Src;

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./auth/login.php');
    exit;
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
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Greenwich Student Forum</h5>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-10 h-10 rounded-full" src="./<?php echo $_SESSION['image'] ?>" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white"><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></span>
                        <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        </li>
                        <li>
                            <a href="user-setting.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Earnings</a>
                        </li>
                        <li>
                            <a href="./auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Pricing</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="flex flex-col items-center">
        <div class="mt-8 w-2/3 grid grid-cols-2 grid-flow-col gap-4">
            
            <div class="row-span-2">
                <img class="w-64 h-64 rounded-lg mb-4" src="<?php echo $_SESSION['image'] ?>" alt="">
                <button onclick="displayForm()" type="button" class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg text-sm px-1.5 py-1.5 text-center me-2 mb-2">Change avatar</button>
                <form id="update-avatar" action="update-user.php" method="post" class="hidden" enctype="multipart/form-data">
                    <input class="text-sm border border-gray-50 rounded" id="user_image" name="user_image" type="file">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-1.5 py-1.5 me-2 mb-2">Submit</button>
                </form>
            </div>
            <div class="">
                <h5 class="text-2xl font-semibold">Full name: <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] ?></h5>
                <h5 class="text-sm font-normal">Email: <?php echo $_SESSION['email'] ?></h5>
            </div>
            
            <div class="">
                <?php

                require_once("Thread/thread-list.php");
                require_once("Thread/thread.php");

                use Src\Thread as thread;

                $threadList = thread\threadListUser($_SESSION['user_id']);
                foreach ($threadList as $threadNode) {
                    $thread = new thread\Thread($threadNode['thread_id'], $threadNode['title'], "", "", $threadNode['user_id'], $threadNode['creation_date'], $threadNode['category']);
                    echo $thread->toCard();
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        function displayForm() {
            var form = document.getElementById("update-avatar");
            if (form.classList.contains("hidden"))
                form.classList.remove("hidden");
            else 
                form.classList.add("hidden");
        }
    </script>
      <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>
</body>

</html>