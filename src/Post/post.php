<?php 
namespace Src\Post;
use PDO, PDOException;
    class Post {
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
        public function getPostId() {
            return $this->postId;
        }

        public function getContent() {
            return $this->content;
        }

        public function getUserId() {
            return $this->userId;
        }

        public function getThreadId() {
            return $this->threadId;
        }

        public function getCreationDate() {
            return $this->creationDate;
        }

        // Setter methods
        public function setPostId($postId) {
            $this->postId = $postId;
        }

        public function setContent($content) {
            $this->content = $content;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
        }

        public function setThreadId($threadId) {
            $this->threadId = $threadId;
        }

        public function setCreationDate($creationDate) {
            $this->creationDate = $creationDate;
        }
        public function userInfo() {
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
        public function toCard() {
            $user = $this->userInfo();
            $permission = $_SESSION['user_id'] == $this->userId;
            if ($permission) { 
                $edit = '
                <div>
                <button class="text-base text-gray-500 font-bold" id="post'.$this->postId.'-menu-button" aria-expanded="false" data-dropdown-toggle="post'.$this->postId.'-dropdown" data-dropdown-placement="bottom">⁝</button>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg border border-gray-100" id="post'.$this->postId.'-dropdown">
                        <ul class="py-2" aria-labelledby="post'.$this->postId.'-menu-button">
                            <li>
                            <form action="../Post/delete-post.php" method="post">
                            <input class="hidden" name="thread_id" value="'.$this->threadId.'">
                            <input class="hidden" name="post_id" value="'.$this->postId.'">
                            <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Delete
                            </button>
                            </form>
                            </li>
                            <li>
                            <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            </li>
                        </ul>
                    </div>
                </div>';
            }
            else $edit = "";
            echo '
            <div class="flex items-start gap-2.5">
            <a href="../profile/profile.php?userId='.$this->userId.'">
            <img class="w-8 h-8 rounded-full" src="../'.$user['image'].'" alt="user image">
            </a>
            <div class="flex flex-col w-1/2 p-4 border-gray-200 bg-gray-100 rounded-lg rounded-es-xl">
               <div class="flex items-center gap-2">
                  <span class="text-sm font-semibold text-gray-900 dark:text-white">'.$user['firstName']." ".$user['lastName'].'</span>
                  <span class="text-sm font-normal text-gray-500 dark:text-gray-400">'.$this->creationDate.'</span>
               </div>
               <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">'.$this->content.'</p>
            </div>
            '.$edit.'
            </div>
            ';
        }
    }
?>
