<?php

namespace Src;

use PDO, PDOException;

session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}
if (!isset($_GET['userId'])) $_GET['userId'] = $_SESSION['user_id'];
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
        http_response_code(404);
        header("Location: ../error/404.php");
        exit;
    }
} catch (PDOException $e) {
    header("Location: ../error/database-connection-failed.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cherry+Swash:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../../resource/static/images/favicon.jpg">
    <style>
        #plate {
            background-image: url('../../resource/static/images/profile-background-image.jpg');
            /* Specify the path to your image */
            background-repeat: repeat;
            /* Prevent the image from repeating */
        }
    </style>
    <title>Greenwich Student Forum</title>
</head>

<body>
    <nav class="border-b-2 border-white bg-green-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="../index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                <h5 class="mb-2 text-2xl tracking-tight text-blue-400" style="font-family: 'Cherry Swash', serif; font-weight: 700; font-style: normal;">Student Forum</h5>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-9 h-9 rounded-full" src="../../<?php echo $_SESSION['image'] ?>" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border border-gray-100" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900"><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="../profile?userId=<?php echo $_SESSION['user_id'] ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
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
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                    <li>
                        <a href="../index.php" class="block py-2 px-3 text-white bg-gray-100 rounded md:bg-transparent md:text-gray-900 md:p-0" aria-current="page">Home</a>
                    </li>
                    <?php if ($_SESSION['role'] == 'Student')
                        echo '
                          <li>
                              <a href="../feedback/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">My Feedback</a>
                          </li>';
                    else echo '<li>
                          <a href="../admin/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">Admin</a>
                      </li>' ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="plate" class="flex flex-col items-center">
        <div class="mt-8 w-2/3 grid grid-cols-2 grid-flow-col gap-4">

            <div class="row-span-2">
                <img class="w-64 h-64 rounded-lg mb-4 bg-white p-1" src="../../<?php echo $userFetch['image'] ?>" alt="">
                <?php
                if ($userId == $_SESSION['user_id']) {
                    echo
                    '
                        <button data-modal-target="update-info-modal" data-modal-toggle="update-info-modal" type="button" class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:outline-none rounded-lg text-sm px-1.5 py-1.5 text-center me-2 mb-2">Edit details</button>';
                }
                echo '<h5 class="text-sm font-lg text-gray-900">(' . $userFetch['role'] . ')</h5>';
                if ($userFetch['role'] == 'Admin') {
                    echo nl2br('<h5 class="text-gray-900">Social profile</h5><a href="https://github.com/phatdtgcs220340" class="text-base font-light text-gray-800">Github</a>
                            <a href="https://www.linkedin.com/in/dotanphat/" class="text-base font-light text-indigo-400">Linkedin</a>
                        ');
                }
                ?>
            </div>
            <div class="">
                <h5 class="text-2xl font-semibold">Full name: <?php echo $userFetch['firstName'] . ' ' . $userFetch['lastName'] ?></h5>
                <h5 class="text-sm font-normal">Email: <?php echo $userFetch['email'] ?></h5>
            </div>

            <div>
                <h5 class="self-start text-2xl mb-4 font-semibold">Threads</h5>
                <?php

                require_once("../Thread/thread-list.php");
                require_once("../Thread/thread.php");

                use Src\Thread as thread;

                $threadList = thread\threadListByUser($userId);
                foreach ($threadList["thread_list"] as $threadNode) {
                    $thread = new thread\Thread($threadNode['thread_id'], $threadNode['title'], "", "", $threadNode['user_id'], $threadNode['creation_date'], $threadNode['module_id'], $threadNode['module_name']);
                    echo $thread->toCard(false, "../");
                }
                echo '<ul class="inline-flex -space-x-px text-sm">';
                for ($i = 1; $i <= $threadList['total_pages']; $i++) {
                    echo '<li>
                        <a href="?userId=' . $userId . '&page=' . $i . '" class="mr-1 rounded-lg flex items-center justify-center px-3 h-8 leading-tight text-gray-800 bg-yellow-100 border border-gray-300 hover:bg-yellow-200 hover:text-gray-900">' . $i . '</a>
                    </li>';
                }
                echo '</ul>'
                ?>
            </div>
        </div>
        <div class="h-64"></div>
    </div>
    <div id="update-info-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Update user info
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="update-info-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="update-user.php" method="post" enctype="multipart/form-data" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-1">
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First name</label>
                            <input type="text" name="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5" placeholder="Johny" required="" value="<?php echo $_SESSION['firstName']?>">
                        </div>
                        <div class="col-span-1">
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last name</label>
                            <input type="text" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5" placeholder="Sin" required="" value="<?php echo $_SESSION['lastName']?>">
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm text-blue-700"><button type="button" onclick="displayForm()">Update avatar</button></label>
                            <input disabled class="hidden block w-full border border-gray-100 bg-white mt-1 rounded-full text-sm text-slate-500 
                            file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-blue-400
                            hover:file:bg-violet-100 focus:outline-none" 
                            accept="image/png, image/jpeg, image/svg" raria-describedby="file_input_help" id="update-avatar" name="image" type="file">
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-400 hover:bg-blue-500 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function displayForm() {
            var image = document.getElementById("update-avatar");
            if (image.classList.contains("hidden")) {
                image.classList.remove("hidden");
                image.disabled = false;
            }
            else {
                image.classList.add("hidden");
                image.disabled = true;
            }
        }
    </script>
    <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>
</body>

</html>