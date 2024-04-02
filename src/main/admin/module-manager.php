<?php
    namespace Src\Admin;
    use Src\Module as module;

    use function Src\Module\moduleList;

    session_start();
    if ($_SESSION['role'] != 'Admin') {
        header("Location: ../error/access-denied.php");
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
                        <a href="../profile?userId=<?php echo $_SESSION['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
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
                              <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">My Feedback</a>
                          </li>';
                          else echo '<li>
                          <a href="./" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">Admin</a>
                      </li>'?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="w-full flex flex-wrap items-center justify-center mt-4">
        <div class="flex flex-col w-full bg-blue-200 shadow mx-4">
        <h1 class="self-center m-2 bg-blue-100 px-3 py-1 shadow rounded-lg text-white text-3xl font-semibold font-sans">Module Manager</h1>
        <button class="self-end border-2 border-white  mr-2 my-2 flex items-center gap-2 bg-green-200 p-2 rounded-lg hover:bg-green-300" data-modal-target="create-module-modal" data-modal-toggle="create-module-modal">
            <img class="h-6" src="../../resource/static/images/icon/add.png" alt="">
            <p class="text-sm text-white font-semibold">New module</p>
        </button>
        <p class="self-end text-sm text-red-700 mr-4"><?php if(isset($_GET['error'])) echo "Module existed";?></p>
        <div id="create-module-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-blue-100 rounded-lg shadow">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b-2 border-yellow-100 rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    New Module
                                </h3>
                                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-module-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5">
                                <form class="space-y-4" action="../module/create-module.php" method="post">
                                        <label for="module_name" class="block mb-2 text-sm font-medium text-gray-900">Module name</label>
                                        <input type="text" name="module_name" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1" required>
                                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                        <textarea name="description" id="content" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
                                        <button type="submit" class="w-full text-gray-700 bg-red-100 hover:bg-red-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div> 
        <h4 class="text-red-600 font-semibold ml-2">Caution: Remove module lead to removing all related threads and posts</h4>
        <div class="m-4">
            <?php 
                require_once("../module/module-list.php");
                foreach(moduleList() as $module) {
                    echo '<div class="w-full flex flex-col my-2 p-2 bg-blue-300 rounded-lg">
                        <h4 class="font-semibold">Module: <span class="font-normal">'.$module['module_name'].'</span></h4>
                        <h4 class="font-semibold">Description: <span class="text-sm font-normal">'.$module['description'].'</span></h4>
                        <div class="flex items-start mt-2 gap-2">
                            <a class="bg-indigo-500 p-0.5 rounded-sm hover:bg-indigo-700" href="../?module='.$module['module_id'].'">
                                <img class="h-5" src="../../resource/static/images/icon/join.png">
                            </a>
                            <form action="../module/delete-module.php" method="POST">
                                <input class="hidden" name="module_id" value="'.$module['module_id'].'">
                                <button class="bg-red-400 p-0.5 rounded-sm hover:bg-red-600" type="submit">
                                    <img class="h-5" src="../../resource/static/images/icon/remove.png">
                                </button>
                            </form>
                        </div>               
                        </div>';
                }
            ?>
        </div>
        </div>
    </div>
    <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>

</body>
</html>