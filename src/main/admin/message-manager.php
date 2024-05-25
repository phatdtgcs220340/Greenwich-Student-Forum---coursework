<?php
    namespace Src\Message;
    use Src\Message;
    use Src\Message\Message as MessageMessage;
    require_once("../feedback/message-list.php");
    require_once("../feedback/message.php");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../auth/login.php');
        exit;
    }
    if($_SESSION['role'] != 'Admin') {
        header('Location: ../error/access-denied.php');
        exit;
    }
    if (isset($_GET['page'])) {
        if (!is_numeric($_GET['page'])) {
          header("Location: ../error/404.php");
          exit;
        }
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
<nav class="border-b-2 fixed z-20 w-full top-0 start-0 border-white bg-green-50">
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
    <div class="w-full py-20 flex flex-wrap items-center justify-center mt-4">
        <div class="flex flex-col w-full bg-blue-200 shadow mx-4">
        <h1 class="self-center m-2 bg-blue-100 px-3 py-1 shadow rounded-lg text-white text-3xl font-semibold font-sans">Feedback</h1>                
        <div class="m-4">
            <?php 
                $messageMap = findAll($_SESSION['user_id']);
                foreach($messageMap['message_list'] as $message) {
                    $messageObject = new MessageMessage($message['message_id'], $message['title'], $message['content'], $message['user_id'], $message['creation_date']);
                    echo $messageObject->toModal("../feedback/");
                }
            ?>
        </div>
        <div class="<?php if ($messageMap['total_pages'] == 0) echo "hidden"?> flex flex-col items-center mb-1">
            <span class="text-sm text-gray-700">
                
                Page <?php  
                    if (!isset($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }
                    $nextPage = $page == $messageMap['total_pages']? 1 : $page + 1;
                    $prevPage = $page == 1 ? $messageMap['total_pages'] : $page - 1;
                    echo $page.'/'.$messageMap['total_pages'];
                ?>
            </span>
            <div class="inline-flex mt-2 xs:mt-0">
                <form action="index.php" method="get"> 
                    <input type="hidden" name="page" value="<?php echo $prevPage?>">
                    <button class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-800 bg-gray-50 rounded-l-lg hover:bg-gray-200 mr-0.5">
                    Prev
                    </button>
                </form>
                <form action="index.php" method="get"> 
                    <input type="hidden" name="page" value="<?php echo $nextPage?>">
                    <button class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-800 bg-gray-50 rounded-r-lg hover:bg-gray-200">
                    Next
                    </button>
                </form>
            </div>
        </div>
    </div> 
    <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>

</body>
</html>