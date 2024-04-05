<?php

namespace Src\Post;

use PDO, PDOException;

class Post
{
    private $postId;
    private $content;
    private $userId;
    private $threadId;
    private $creationDate;
    
    public function __construct($postId, $content, $userId, $threadId, $creationDate)
    {
        $this->postId = $postId;
        $this->content = $content;
        $this->userId = $userId;
        $this->threadId = $threadId;
        $this->creationDate = $creationDate;
    }
    // Getter methods
    public function getPostId()
    {
        return $this->postId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getThreadId()
    {
        return $this->threadId;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    // Setter methods
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setThreadId($threadId)
    {
        $this->threadId = $threadId;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
    public function userInfo()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `user` WHERE user_id = ?');
            $stmt->execute([$this->userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function threadInfo()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `thread` WHERE thread_id = ?');
            $stmt->execute([$this->threadId]);
            $thread = $stmt->fetch(PDO::FETCH_ASSOC);
            return $thread;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function toCard()
    {
        $user = $this->userInfo();
        $thread = $this->threadInfo();
        $edit = '
        <button class="text-base text-gray-500 font-bold hover:text-gray-900" id="post' . $this->postId . '-menu-button" aria-expanded="false" data-dropdown-toggle="post' . $this->postId . '-dropdown" data-dropdown-placement="bottom">...</button>
        <div class="z-50 hidden my-4 text-base list-none bg-white rounded-lg border border-gray-100" id="post' . $this->postId . '-dropdown">
                <ul class="py-2" aria-labelledby="post' . $this->postId . '-menu-button">
                    <li>
                    <form action="../Post/delete-post.php" method="post">
                    <input class="hidden" name="thread_id" value="' . $this->threadId . '">
                    <input class="hidden" name="post_id" value="' . $this->postId . '">
                    <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Delete
                    </button>
                    </form>
                    </li>';
        if ($_SESSION['user_id'] == $this->userId) {
            $edit = $edit.'<li>
                            <button onclick="toggleUpdateForm(\'content-' . $this->postId . '\',\'edit-form-' . $this->postId . '\',\'edit-content-' . $this->postId . '\')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            </li>
                            </ul>
                </div>';
        }
        else if ($_SESSION['user_id'] == $thread['user_id'] || $_SESSION['role'] == 'Admin') 
                    $edit = $edit.'</ul>
                </div>';
        else $edit = "";
        echo '
            <div class="my-2">
            <div class="flex items-start gap-2.5">
            <a href="../profile/?userId=' . $this->userId . '">
            <img class="w-8 h-8 rounded-full" src="../../' . $user['image'] . '" alt="user image">
            </a>
            <div class="flex flex-col w-2/3 p-4 border-gray-200 bg-gray-100 rounded-lg rounded-es-xl shadow">
               <div class="flex items-center gap-2 w-full">
                  <span class="text-sm font-semibold text-gray-900">' . $user['firstName'] . " " . $user['lastName'] . '</span>
                  <span class="text-sm font-normal text-gray-500">' . $this->creationDate . '</span>
                  
                </div>
               <p id="content-' . $this->postId . '" class="text-sm font-normal py-2.5 text-gray-900">' . nl2br($this->content) . '</p>
               <form id="edit-form-' . $this->postId . '" class="hidden" action="../Post/update-post.php" method="post"> 
               <input name="post_id" class="hidden" value="' . $this->postId . '">
               <input name="thread_id" class="hidden" value="' . $this->threadId . '">
               <textarea name="content" id="edit-content-' . $this->postId . '" class="block mb-2 p-2.5 w-full text-sm font-lg rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
               <button type="submit" class="focus:outline-none w-full text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2">Save</button>
               </form>
            </div>
            '.$edit.'
            </div>
            </div>';
    }
}
?>