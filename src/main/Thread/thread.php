<?php

namespace Src\Thread;

use UnexpectedValueException, PDO, PDOException, DateTime;

class Thread
{
    private $threadId;
    private $title;
    private $content;
    private $userId;
    private $image;
    private $creationDate;

    public function __construct($threadId, $title, $image, $content, $userId, $creationDate)
    {
        $this->threadId = $threadId;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->userId = $userId;
        $this->creationDate = $creationDate;
    }
    public function toThreadViewUrl()
    {
        return "/page.php?threadId=" . $this->threadId;
    }
    public function extraInfo()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM `user` WHERE user_id = ?');
            $stmt->execute([$this->userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $pdo->prepare('SELECT COUNT(*) AS comments FROM `post` WHERE thread_id = ?');
            $stmt->execute([$this->threadId]);
            $totalComment = $stmt->fetch(PDO::FETCH_ASSOC)['comments'];
            return ["user" => $user, "comment" => $totalComment];
        } catch (PDOException $e) {
            header("Location: ../error/database-connection-failed.php");
            exit;
        }
    }
    public function setTitle($title)
    {
        if (!is_string($title)) {
            echo "Invalid setTitle() param";
        } else {
            $this->title = $title;
        }
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new UnexpectedValueException();
        } else {
            $this->content = $content;
        }
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setUserId($userId)
    {
        if (!is_int($userId)) {
            throw new UnexpectedValueException();
        } else {
            $this->userId = $userId;
        }
    }
    public function getUserId()
    {
        return $this->userId;
    }

    public function setThreadId($id)
    {
        if (!is_int($id)) {
            throw new UnexpectedValueException();
        } else {
            $this->threadId = $id;
        }
    }
    public function getThreadId()
    {
        return $this->threadId;
    }
    public function setImage($path)
    {
        $this->image = $path;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getCreationDate()
    {
        return $this->creationDate;
    }   
    public function timeDifference()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Create DateTime objects for the current time and the creation datetime
        $currentDatetime = new DateTime();
        $creationDatetimeObj = new DateTime($this->creationDate);

        // Calculate the difference between the current time and the creation datetime
        $difference = $currentDatetime->diff($creationDatetimeObj);

        // Format the difference as desired (for example, in years, months, days, hours, minutes, seconds)
        // Format the difference
        $formattedDifference = '';

        // Check each time unit starting from years down to seconds
        if ($difference->y > 0) {
            $formattedDifference = $difference->y . ' years';
        } elseif ($difference->m > 0) {
            $formattedDifference = $difference->m . ' months';
        } elseif ($difference->d > 0) {
            $formattedDifference = $difference->d . ' days';
        } elseif ($difference->h > 0) {
            $formattedDifference = $difference->h . ' hours';
        } elseif ($difference->i > 0) {
            $formattedDifference = $difference->i . ' minutes';
        } elseif ($difference->s > 0) {
            $formattedDifference = $difference->s . ' seconds';
        }

        // Display the formatted difference
        return $formattedDifference;
    }
    public function toCard($displayUser="true", $currentPath)
    {   
        if ($displayUser == true) {
        $extraInfo = $this->extraInfo();
        $user_card = '
        <a href="./profile/profile.php?userId='.$this->userId.'" class="flex gap-3">
        <img class="rounded-lg h-8" src="../'.$extraInfo['user']['image'].'">
        <h5 class="mb-2 text-xl font-medium tracking-tight text-gray-700">' . $extraInfo['user']['firstName'] . " " . $extraInfo['user']['lastName'].'</h5>
        </a>';
        }
        else $user_card = "";
        $trimmedContent = $this->content;
        if (str_word_count($trimmedContent) > 10) {
            $trimmedContent = implode(' ', array_slice(explode(' ', $trimmedContent), 0, 10)) . " ...";
        }
        echo '
            <div class= "p-4 flex-initial w-full mb-4 bg-red-200 rounded-lg shadow">'.$user_card.'
                <a href="' .$currentPath.$this->toThreadViewUrl() . '">
                    <div class="w-full bg-yellow-100 hover:bg-blue-100 rounded-lg shadow hover:bg-gray-100">
                        <img class="rounded-t-lg" src="../' . $this->image . '" alt="" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">' . $this->title. '</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">' . $trimmedContent . '</p>
                        </div>
                    </div>
                </a>';
            if ($displayUser)
                echo '
                <div class="flex items-end mt-2 gap-2">
                    <button data-modal-target="fast-answer-modal-'.$this->threadId.'" data-modal-toggle="fast-answer-modal-'.$this->threadId.'">
                    <img class="h-6 p-1 bg-yellow-200 rounded-md border border-gray-700 hover:bg-yellow-300 hover:border-gray-800" src="../resource/static/images/icon/comment.png">
                    <button>
                    <h5 class="text-sm font-medium">'.$extraInfo['comment'].'</h5>
                    
                </div>
                <!-- Main modal -->
                <div id="fast-answer-modal-'.$this->threadId.'" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-blue-100 rounded-lg shadow">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b-2 border-yellow-100 rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Fast answer
                                </h3>
                                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="fast-answer-modal-'.$this->threadId.'">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5">
                                <form class="space-y-4" action="Post/create-post.php" method="post">
                                    <div>
                                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900">Your answer</label>
                                        <textarea name="content" id="content" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
                                        <input name="user_id" value="'.$_SESSION['user_id'].'" class="hidden">
                                        <input name="thread_id" value="'.$this->threadId.'" class="hidden">
                                        </div>
                                    <button type="submit" class="w-full text-gray-700 bg-red-100 hover:bg-red-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
            </div> ';
            echo '</div>';
    }
}
