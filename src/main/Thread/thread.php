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
        return "/?threadId=" . $this->threadId;
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
        <a href="./profile/?userId='.$this->userId.'" class="flex gap-3">
        <img class="rounded-lg h-8" src="../'.$extraInfo['user']['image'].'">
        <h5 class="mb-2 text-xl font-medium tracking-tight text-gray-700">' . $extraInfo['user']['firstName'] . " " . $extraInfo['user']['lastName'].'</h5>
        </a>';
        }
        else $user_card = "";
        $trimmedContent = $this->content;
        if (strlen($trimmedContent) > 50) {
            $trimmedContent = substr($trimmedContent,0, 50)."...";
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
                if ($extraInfo['comment'] > 0)
                    echo '
                    <div class="flex rounded-lg items-center justify-center p-1 mt-2 gap-2 bg-green-300 w-1/5">
                        <img class="h-4" src="../resource/static/images/icon/checked.png">
                        <h5 class="text-sm text-white font-medium">'.$extraInfo['comment'].' answers</h5>
                    </div>';
                else 
                    echo '
                    <div class="flex items-center justify-center rounded-lg p-1 mt-2 gap-2 bg-gray-400 w-1/5">
                        <h5 class="text-sm text-white font-medium">Unsolved</h5>
                    </div>';
            echo '</div> ';
    }
}
