<?php 
    namespace Src\Thread;
    use UnexpectedValueException, PDO, PDOException;
    class Thread {
        private $threadId;
        private $title; 
        private $content;
        private $userId;
        private $image;
        private $creationDate;

        public function __construct($threadId, $title, $image, $content, $userId) {
            $this->threadId = $threadId;
            $this->title = $title;
            $this->content = $content;
            $this->image = $image;
            $this->userId = $userId;
        }
        public function toThreadViewUrl() {
            return "http://localhost/comp1841/coursework/src/Thread/page.php?threadId=".$this->threadId;
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
        public function setTitle($title) {
            if (!is_string($title)) {
                echo "Invalid setTitle() param";
            }
            else {
                $this->title = $title;
            }
        }
        public function getTitle() {
            return $this->title;
        }
        public function setContent($content) {
            if (!is_string($content)) {
                throw new UnexpectedValueException();
            }
            else {
                $this->content = $content;
            }
        }
        public function getContent() {
            return $this->content;
        }
        public function setUserId($userId) {
            if (!is_int($userId)) {
                throw new UnexpectedValueException();
            }
            else {
                $this->userId = $userId;
            }
        }
        public function getUserId() {
            return $this->userId;
        }
        
        public function setThreadId($id) {
            if (!is_int($id)) {
                throw new UnexpectedValueException();
            }
            else {
                $this->threadId = $id;
            }
        }
        public function getThreadId() {
            return $this->threadId;
        }
        public function toCard() {
            $userInfo = $this->userInfo();
            $trimmedContent = $this->content;
            if (str_word_count($trimmedContent) > 10) {
                $trimmedContent = implode(' ', array_slice(explode(' ', $trimmedContent), 0, 10))." ...";
            }
            echo '
            <div class= "flex-initial w-96">
                <div class="flex gap-3">
                <img class="rounded-lg h-8" src="https://p16-tm-sg.tiktokmusic.me/img/tos-alisg-v-2102/oEP71hZqEwA72YkANvBsrV4gAiAAXBciIEIAr~c5_500x500.image">
                <h5 class="mb-2 text-xl font-medium tracking-tight text-gray-700">'.$userInfo['firstName']." ".$userInfo['lastName'].'</h5>
                </div>
                <a href="'.$this->toThreadViewUrl().'">
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                        <img class="rounded-t-lg" src="./thread/'.$this->image.'" alt="" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">'.$this->title.'</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">'.$trimmedContent.'</p>
                        </div>
                    </div>
                </a>
            </div>
            ';
        }
    }
?>