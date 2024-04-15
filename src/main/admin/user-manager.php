<?php
    namespace Src\Admin;
    use function Src\User\userList;

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../auth/login.php');
        exit;
    }

    if($_SESSION['role'] != 'Admin') {
        header('Location: ../error/access-denied.php');
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
                        <a href="../profile?userId=<?php echo $_SESSION['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
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
        <h1 class="self-center m-2 bg-blue-100 px-3 py-1 shadow rounded-lg text-white text-3xl font-semibold font-sans">I'm god</h1>
        <div class="m-4">
            <?php 
                require_once("../profile/user-list.php");
                foreach(userList() as $user) {
                    echo '<div class="w-full flex flex-col my-2 p-2 bg-blue-300 rounded-lg">
                        <img class="h-10 w-10" src="../../'.$user['image'].'">';
                    if (!$user['is_enabled'])
                    echo '<h4 class="text-sm">(Global ban)</h4>';
                    echo '
                        <h4 class="font-semibold">Fullname: <span class="font-normal">'.$user['firstName'].' '.$user['lastName'].'</span></h4>
                        <h4 class="font-semibold">Email: <span class="text-sm font-normal">'.$user['email'].'</span></h4>
                        <div class="flex items-start mt-2 gap-2">
                            <a class="flex items-center gap-1 border-2 border-white shadow bg-yellow-300 p-0.5 rounded-sm hover:bg-yellow-500" href="../profile/?userId='.$user['user_id'].'">
                                <img class="h-4" src="../../resource/static/images/icon/look.png">
                                <h4 class="text-sm font-semibold">View profile</h4>
                            </a>
                            <form action="../profile/ban-user.php" method="POST">
                                <input class="hidden" name="user_id" value="'.$user['user_id'].'">
                                <input class="hidden" name="banned" value="'.$user['is_enabled'].'">';
                                if ($user['is_enabled'])
                                    echo '
                                    <button class="flex items-center gap-1 border-2 border-white bg-red-400 p-0.5 rounded-sm hover:bg-red-600" type="submit">
                                        <img class="h-4" src="../../resource/static/images/icon/lock.png">
                                        <h4 class="text-sm font-semibold">Ban</h4>
                                    </button>';
                                else echo '
                                    <button class="flex items-center gap-1 border-2 border-white bg-green-400 p-0.5 rounded-sm hover:bg-green-600" type="submit">
                                        <img class="h-4" src="../../resource/static/images/icon/unlock.png">
                                        <h4 class="text-sm font-semibold">Unban</h4>
                                    </button>';
                                echo '
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