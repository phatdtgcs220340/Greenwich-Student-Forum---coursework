<?php

namespace Src;
use Src\Module as module, Src\User\User;
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ./auth/login.php');
  exit;
}
require_once("module/module-list.php");
$moduleList = module\moduleList();
$flag = 1;
if (isset($_GET['module'])) {
  $flag = 0;
  foreach($moduleList as $module) 
    if ($module['module_id'] == $_GET['module']) {
      $flag = 1;
      break;
  }
  }
if (isset($_GET['orderBy']))
  if ($_GET['orderBy'] != 'latest' && $_GET['orderBy'] != 'oldest')
    $flag = 0;
if (isset($_GET['page'])) {
  if (!is_numeric($_GET['page'])) {
    $flag = 0;
  }
}
if ($flag == 0) {
  header("Location: error/404.php");
  exit(404);
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
  <link rel="icon" type="image/x-icon" href="../resource/static/images/favicon.jpg">
  <style>
    #plate {
    background-image: url('../resource/static/images/home-background-image.jpg'); /* Specify the path to your image */
    background-repeat: repeat; /* Prevent the image from repeating */
    }
    textarea:focus, input:focus, select:focus{
    outline: none;
    }
  </style>
  <title>Greenwich Student Forum</title>
</head>

<body>
<nav class="border-b-2 fixed z-20 w-full top-0 start-0 border-white bg-green-50">
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
                        <a href="./profile?userId=<?php echo $_SESSION['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
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
                <ul class="flex flex-col items-center font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                    <li>
                        <a href="index.php" class="block py-2 px-3 text-white bg-gray-100 rounded md:bg-transparent md:text-gray-900 md:p-0" aria-current="page">Home</a>
                    </li>
                    <?php if ($_SESSION['role'] == 'Student') 
                          echo '
                          <li>
                              <a href="feedback/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">My Feedback</a>
                          </li>';
                          else echo '<li>
                          <a href="admin/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-600 md:p-0">Admin</a>
                      </li>'?>
                    
                </ul>
            </div>
        </div>
    </nav>

  <div id="plate" class="px-12 py-24 flex items-center justify-center flex-col gap-3 bg-white">

    <div class="w-3/5 h-1/2 mx-auto mb-8 <?php if ($_SESSION['role'] == 'Admin') echo "hidden";?>">
      <button id="question-button" onclick="displayForm()" 
        class="bg-cyan-200 mb-2 p-2 rounded-lg font-semibold text-sm">Ask someth...</button>
      <form id="question-form" class="p-6 bg-red-200 rounded-lg shadow hidden" action="./Thread/create-thread.php" method="post" enctype="multipart/form-data">
        <div class="w-full mb-4 rounded-lg bg-red-100">
          <div class="flex items-center justify-between px-3 py-2 border-b">
            <div class="flex flex-col items-start">
              <div class="flex flex-wrap items-center rtl:space-x-reverse">
                <label class="block text-sm font-medium text-gray-900" for="file_input">Upload file</label>
                <input class="block w-full bg-white mt-1 rounded-full text-sm text-slate-500 
                  file:py-2 file:px-4
                  file:rounded-full file:border-0
                  file:text-sm file:font-semibold
                  file:bg-violet-50 file:text-blue-400
                  hover:file:bg-violet-100 focus:outline-none" 
                  accept="image/png, image/jpeg, image/svg" raria-describedby="file_input_help" id="postImage" name="image" type="file">
              </div>
              <label for="module" class="block text-sm font-medium text-gray-900">Select an option</label>
              <select required id="module" name="module" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-1">
                  <?php
                    $moduleList = module\moduleList();
                    foreach($moduleList as $node) { 
                        echo '<option value='.$node['module_id'].'>'.$node['module_name'].'</option>';
                   }
                  ?>
              </select>
              <div class="rtl:space-x-reverse">
                <label for="title" class="block mt-2 text-sm font-medium text-gray-900">Title</label>
                <div class="flex gap-4">
                <input required oninput="countWord('title', 'title-limit')" type="text" id="title" name="title" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-white text-sm">
                <p class="text-xs">Word counts: <span id="title-limit">0/20</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="px-2 py-2 bg-white rounded-b-lg">
            <label for="content" class="sr-only">Publish post</label>
            <textarea required id="content" name="content" rows="5" class="w-full px-0 text-sm text-gray-800 bg-white" placeholder="Write an article..."></textarea>
          </div>
        </div>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-gray-900 bg-yellow-100 shadow hover:bg-blue-100 rounded-lg">
          Publish question
        </button>
      </form>
    </div>
    
    <div class="mb-4 w-auto sm:w-1/2 p-4 sm:grid sm:grid-cols-2 bg-red-100 rounded-lg shadow">
      <div class="mb-2">
      <h5 class="font-semibold">Filter By</h5>
      <select id="filter_category" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-auto p-1">
        <?php
          if (!isset($_GET['module']))
            echo "<option selected>Default</option>";
          else echo "<option>Default</option>";
          foreach($moduleList as $node) { 
          if ($node['module_id'] == $_GET['module'])
            echo '<option selected value='.$node['module_id'].'>'.$node['module_name'].'</option>';
          else echo '<option value='.$node['module_id'].'>'.$node['module_name'].'</option>';
          }
        ?>
      </select>
      </div>
      <div class="mb-2">
      <h5 class="font-semibold">Sort By</h5>
      <select id="sort" class="mb-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-auto p-1">
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
      require_once("profile/user.php");
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
      <div class="w-auto sm:w-1/2 flex flex-col items-center justify-center gap-5">';
      // display thread list 
      foreach ($threadList['thread_list'] as $threadNode) {
        $thread = new thread\Thread($threadNode['thread_id'], $threadNode['title'], $threadNode['image'], $threadNode['content'], $threadNode['user_id'], $threadNode['creation_date'], $threadNode['module_id'], $threadNode['module_name'],
      new User($threadNode['user_id'],$threadNode['firstName'],$threadNode['lastName'],$threadNode['email'],$threadNode['avatar']));
        echo $thread->toCard(true, "");
      }
      echo '</div>';
      if (!isset($_GET['page']))
        $page = 1;
      else $page = $_GET['page'];
      $nextPage = $page == $threadList['total_pages']? 1 : $page + 1;
      $prevPage = $page == 1 ? $threadList['total_pages'] : $page - 1;
      ?>
  </ul>
  <div class="<?php if ($threadList['total_pages'] == 0) echo "hidden"?>  flex flex-col items-center gap-2">
    <div class="inline-flex mt-2 xs:mt-0">
      <form action="index.php" method="get"> 
          <?php 
            if (isset($_GET['module']))
              echo '<input type="hidden" name="module" value="'.$_GET['module'].'">';
              if (isset($_GET['orderBy']))
              echo '<input type="hidden" name="orderBy" value="'.$_GET['orderBy'].'">'
          ?>
          <input type="hidden" name="page" value="<?php echo $prevPage?>">
          <button class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-800 bg-gray-50 rounded-l-lg hover:bg-gray-200 mr-0.5">
            Prev
          </button>
        </form>
        <form action="index.php" method="get"> 
          <?php 
            if (isset($_GET['module']))
              echo '<input type="hidden" name="module" value="'.$_GET['module'].'">';
              if (isset($_GET['orderBy']))
              echo '<input type="hidden" name="orderBy" value="'.$_GET['orderBy'].'">'
          ?>
          <input type="hidden" name="page" value="<?php echo $nextPage?>">
          <button class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-800 bg-gray-50 rounded-r-lg hover:bg-gray-200">
            Next
          </button>
        </form>
      </div>
      <h5 class="text-sm font-semibold">Page <?php 
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
      echo $page ."/". $threadList['total_pages']?>
      </h5>
    </div>
    <div class="h-48"></div>
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
  <script>
    function displayForm() {
            const form = document.getElementById("question-form");
            const button = document.getElementById("question-button");
            if (form.classList.contains("hidden"))
            {
                form.classList.remove("hidden");
                button.innerHTML = "Cancel"
            }
            else {
                form.classList.add("hidden");
                button.innerHTML = "Ask someth..."
            }
        }
  </script>
  <script src="../resource/static/script/word_count.js"></script>
</body>

</html>