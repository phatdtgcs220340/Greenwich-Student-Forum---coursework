<?php

namespace Src\Thread;
use DateTime, Src\User\User;

class Thread
{
    private $threadId;
    private $title;
    private $content;
    private $userId;
    private $image;
    private $creationDate;
    private $moduleId;
    private $moduleName;
    private User $user;
    public function __construct($threadId, $title, $image, $content, $userId, $creationDate, $moduleId, $moduleName, User $user)
    {
        $this->threadId = $threadId;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->userId = $userId;
        $this->creationDate = $creationDate;
        $this->moduleId = $moduleId;
        $this->moduleName = $moduleName;
        $this->user = $user;
    }
    public function getThreadId()
    {
        return $this->threadId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getModuleId()
    {
        return $this->moduleId;
    }

    public function getModuleName()
    {
        return $this->moduleName;
    }

    public function getUser()
    {
        return $this->user;
    }
    public function toThreadViewUrl()
    {
        return "Thread/?threadId=" . $this->threadId;
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
            $user_card = '
            <a href="./profile?userId='.$this->user->getUserId().'" class="flex gap-3">
            <img class="rounded-lg h-8" src="../'.$this->user->getImage().'">
            <h5 class="mb-2 text-xl font-medium tracking-tight text-gray-700">' . $this->user->getFirstName() . " " . $this->user->getLastName().'</h5>
            </a>';
            }
        else $user_card = "";
        $trimmedContent = $this->content;
        if (strlen($trimmedContent) > 50) {
            $trimmedContent = substr($trimmedContent,0, 50)."...";
        }
        echo '
            <div class= "p-4 flex-initial flex flex-col w-full mb-4 bg-red-200 rounded-lg shadow">'.$user_card.'
                <a href="' .$currentPath.$this->toThreadViewUrl() . '">
                    <div class="w-full bg-yellow-100 hover:bg-blue-100 rounded-lg shadow hover:bg-gray-100">
                        <img class="rounded-t-lg" src="../' . $this->image . '" alt="" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">' . $this->title. '</h5>
                            <p class="mb-3 font-normal text-gray-700">' . $trimmedContent . '</p>
                           
                        </div>
                    </div>
                </a>
                <a class="py-1 px-2 mt-2 w-fit rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-sm font-semibold hover:text-gray-100 hover:from-cyan-600 hover:to-blue-600"
                href="'.$currentPath.'?module='.$this->moduleId.'">'.$this->moduleName.'</a>
            </div> ';
    }
}
