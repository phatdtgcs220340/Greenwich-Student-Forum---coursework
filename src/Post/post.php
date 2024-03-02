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
            echo '
            <div class="flex flex-col gap-2">
            <div class="flex items-start gap-2.5">
            <img class="w-8 h-8 rounded-full" src="'.$user['image'].'" alt="user image">
            <div class="flex flex-col w-1/2 p-4 border-gray-200 bg-gray-100 rounded-lg rounded-es-xl">
               <div class="flex items-center gap-2">
                  <span class="text-sm font-semibold text-gray-900 dark:text-white">'.$user['firstName']." ".$user['lastName'].'</span>
                  <span class="text-sm font-normal text-gray-500 dark:text-gray-400">'.$this->creationDate.'</span>
               </div>
               <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">'.$this->content.'</p>
            </div>
            </div>
            ';
        }
    }
?>
