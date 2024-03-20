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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cherry+Swash:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="../resource/static/images/favicon.jpg">
  <style>
    #plate {
    background-image: url('../resource/static/images/home-background-image.jpg'); /* Specify the path to your image */
    background-repeat: repeat; /* Prevent the image from repeating */
  }
  </style>
  <title>Greenwich Student Forum</title>
</head>

<body>
<nav class="border-b-2 border-white bg-green-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
              <h5 class="mb-2 text-2xl tracking-tight text-blue-400" style="font-family: 'Cherry Swash', serif; font-weight: 700; font-style: normal;">Student Forum</h5>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-9 h-9 rounded-full" src="../<?php echo $_SESSION['image'] ?>" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border border-gray-100" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900"><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></span>
                        <span class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                        <a href="./profile/?userId=<?php echo $_SESSION['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
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
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                    <li>
                        <a href="index.php" class="block py-2 px-3 text-white bg-gray-100 rounded md:bg-transparent md:text-gray-900 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">My Feedback</a>
                    </li>
                    <li>
                        <a href="admin/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <div id="plate" class="p-12 flex items-center justify-center flex-col gap-3 bg-white">
    <div class="w-1/2 mx-auto mb-8 p-6 bg-red-200 rounded-lg shadow">
      <form action="./Thread/create-thread.php" method="post" enctype="multipart/form-data">
        <div class="w-full mb-4 rounded-lg bg-red-100 dark:bg-gray-700 dark:border-gray-600">
          <div class="flex items-center justify-between px-3 py-2 border-b dark:border-gray-600">
            <div class="flex flex-col items-start">
              <div class="flex flex-wrap items-center rtl:space-x-reverse sm:ps-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300  cusor-pointer bg-white focus:outline-none" accept="image/png, image/jpeg, image/svg" raria-describedby="file_input_help" id="postImage" name="image" type="file">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG.</p>
              </div>
              <label for="module" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
              <select required id="module" name="module" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-1">
                  <?php
                    require_once("module/module-list.php");
                    use Src\Module as module;
                    $moduleList = module\moduleList();
                    foreach($moduleList as $node) { 
                        echo '<option value='.$node['module_id'].'>'.$node['module_name'].'</option>';
                   }
                  ?>
              </select>
              <div class="rtl:space-x-reverse sm:ps-4">
                <label for="title" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                <div class="flex gap-4">
                <input required oninput="countWord('title', 'title-limit')" type="text" id="title" name="title" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-white text-sm">
                <p class="text-xs">Word counts: <span id="title-limit">0/10</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="px-2 py-2 bg-white rounded-b-lg dark:bg-gray-800">
            <label for="content" class="sr-only">Publish post</label>
            <textarea required id="content" name="content" rows="8" class="w-full px-0 text-sm text-gray-800 bg-white" placeholder="Write an article..."></textarea>
          </div>
        </div>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-gray-900 bg-yellow-100 shadow hover:bg-blue-100 rounded-lg">
          Publish question
        </button>
      </form>
    </div>
    
    <div class="mb-4 w-1/2 p-4 grid grid-cols-2 bg-red-100 rounded-lg shadow">
      <div>
      <h5 class="mb-2 font-semibold">Filter By</h5>
      <select id="filter_category" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto p-1">
        <?php
          if (!isset($_GET['module']))
            echo "<option selected>Default</option>";
          else echo "<option>Default</option>";
          $moduleList = module\moduleList();
          foreach($moduleList as $node) { 
          if ($node['module_id'] == $_GET['module'])
            echo '<option selected value='.$node['module_id'].'>'.$node['module_name'].'</option>';
          else echo '<option value='.$node['module_id'].'>'.$node['module_name'].'</option>';
          }
        ?>
      </select>
      </div>
      <div>
      <h5 class="mb-2 font-semibold">Sort By</h5>
      <select id="sort" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto p-1">
        <?php
          $flag = 0;
          if (isset($_GET['orderBy'])) {
            if ($_GET['orderBy'] == 'oldest')
              echo '<option value="latest">Latest (default)</option>
              <option selected value="oldest">Oldest</option>';
            else $flag = 1;
          }
          else $flag = 1;
          if ($flag == 1) echo '<option selected value="latest">Latest (default)</option>
          <option value="oldest">Oldest</option>'
        ?>
      </select>
      </div>
      <a id="filter_link" href="#" onclick="filter()" class="mt-4 p-2 bg-yellow-100 hover:bg-blue-100 shadow rounded-lg font-semibold text-gray-700 col-span-2 text-center hover:text-gray-900">Filter</a>
      </div>
      <?php
      require_once("Thread/thread.php");
      require_once("Thread/thread-list.php");

      use Src\Thread as thread;
      $uriParam = '';
      $latest = true;
      if (isset($_GET['orderBy'])) {
        $uriParam = $uriParam.'&orderBy='.$_GET['orderBy'];
        if ($_GET['orderBy'] == 'oldest')
          $latest = false;
      }
      if (!isset($_GET['module']))
        $threadList = thread\threadListAll($latest);
      else {
        $threadList = thread\threadListCategory($latest);
        $uriParam = $uriParam.'&module='.$_GET['module'];
      }

      echo '
      <div class="w-1/2 flex flex-col items-center justify-center gap-5">';
      // display thread list 
      foreach ($threadList['thread_list'] as $threadNode) {
        $thread = new thread\Thread($threadNode['thread_id'], $threadNode['title'], $threadNode['image'], $threadNode['content'], $threadNode['user_id'], $threadNode['creation_date']);
        echo $thread->toCard(true, "Thread");
      }
      echo '</div>';
      echo '<ul class="inline-flex -space-x-px text-sm">';
      for ($i = 1; $i <= $threadList['total_pages']; $i++) {
        echo '<li>
        <a href="?page='.$i.$uriParam.'" class="mr-1 font-semibold rounded-lg flex items-center justify-center px-3 h-8 leading-tight text-gray-800 bg-yellow-100 border border-gray-300 hover:bg-yellow-200 hover:text-gray-900">'.$i.'</a>
      </li>';
      }
      ?>
  </ul>
      <h5 class="text-sm font-semibold">Page <?php 
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
      echo $page?>
      </h5>
  </div>
  
  <script src="https://flowbite.com/docs/flowbite.min.js?v=2.3.0a"></script>
  <script>
    function filter() {
      var link = document.getElementById("filter_link");
      var category = document.getElementById("filter_category").value;
      var sort = document.getElementById("sort").value;
      var destination = "index.php?orderBy="+sort;
      if (category != "Default") {
        destination+="&module="+category;
      }
      link.setAttribute("href", destination);
    }
  </script>
  <script src="../resource/static/script/word_count.js"></script>
</body>

</html>