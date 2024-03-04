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
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200&family=Nunito:wght@300;400&family=Open+Sans&display=swap" rel="stylesheet" />
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
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border border-gray-100" id="user-dropdown">
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

  <div class="p-12 flex items-center justify-center flex-col gap-3 bg-white">
    <div class="mx-auto mb-8 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
      <form action="./Thread/create-thread.php" method="post" enctype="multipart/form-data">
        <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
          <div class="flex items-center justify-between px-3 py-2 border-b dark:border-gray-600">
            <div class="flex flex-col items-start">
              <div class="flex flex-wrap items-center rtl:space-x-reverse sm:ps-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300  cusor-pointer bg-white focus:outline-none" raria-describedby="file_input_help" id="postImage" name="image" type="file">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
              </div>
              <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
              <select required id="category" name="category" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-1">
                <option selected>Choose a category</option>
                <option value="Algorithm">Algorithm</option>
                <option value="Data Science">Data Science</option>
                <option value="Front-end">Front-end</option>
                <option value="Back-end">Back-end</option>
                <option value="Database">Database</option>
                <option value="Network">Network</option>
                <option value="Blockchain">Blockchain</option>
              </select>
              <div class="flex flex-wrap items-center rtl:space-x-reverse sm:ps-4">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                <input required type="text" id="title" name="title" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-white text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600">
              </div>
            </div>
          </div>
          <div class="px-2 py-2 bg-white rounded-b-lg dark:bg-gray-800">
            <label for="content" class="sr-only">Publish post</label>
            <textarea required id="content" name="content" rows="8" class="w-full px-0 text-sm text-gray-800 bg-white" placeholder="Write an article..."></textarea>
          </div>
        </div>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
          Publish post
        </button>
      </form>
    </div>
      <?php
      require_once("Thread/thread.php");
      require_once("Thread/thread-list.php");

      use Src\Thread as thread;
      
      $threadListAll = thread\threadListAll();

      echo '
      <div class="w-1/2 flex flex-col items-center justify-center gap-5">';
      // display thread list 
      foreach ($threadListAll['thread_list'] as $threadNode) {
        $thread = new thread\Thread($threadNode['thread_id'], $threadNode['title'], $threadNode['image'], $threadNode['content'], $threadNode['user_id'], $threadNode['creation_date'], $threadNode['category']);
        echo $thread->toCard();
      }
      echo '</div>';
      echo '<ul class="inline-flex -space-x-px text-sm">';
      for ($i = 1; $i <= $threadListAll['total_pages']; $i++) {
        echo '<li>
        <a href="?page='.$i.'" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">'.$i.'</a>
      </li>';
      }
      ?>
  </ul>
  </div>
  <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>
</body>

</html>