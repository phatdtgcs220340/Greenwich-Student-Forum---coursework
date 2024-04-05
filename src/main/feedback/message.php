<?php 
    namespace Src\Message;
    use UnexpectedValueException, DateTime;
    class Message {
        private $title;
        private $content;
        private $userId;
        private $messageId;
        private $creationDate; 
        public function __construct($messageId, $title, $content, $userId, $creationDate)
        {   
            $this->messageId = $messageId;
            $this->title = $title;
            $this->content = $content;
            $this->userId = $userId;
            $this->creationDate = $creationDate;
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
        public function setMessageId($messageId)
        {
            if (!is_int($messageId)) {
                throw new UnexpectedValueException();
            } else {
                $this->messageId = $messageId;
            }
        }
        public function getMessageId()
        {
            return $this->messageId;
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
        public function toModal() {
            return '
            <button data-modal-target="message'.$this->messageId.'-modal" data-modal-toggle="message'.$this->messageId.'-modal" class="w-full mb-1 text-gray-900 bg-blue-300 hover:bg-blue-400 px-5 py-2.5 text-start" type="button">
              '.$this->title.'<span class="text-start"> '.$this->timeDifference().'</span>
            </button>
            
            <div id="message'.$this->messageId.'-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                User feedback
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="message'.$this->messageId.'-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <p class="text-base leading-relaxed text-gray-500">
                                <span class="font-semibold">Title:</span><br>'.$this->title.'
                            </p>
                            <p class="text-base leading-relaxed text-gray-500">
                                <span class="font-semibold">Content:</span><br>'.nl2br($this->content).'
                            </p>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button data-modal-hide="message'.$this->messageId.'-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                            <button data-modal-hide="message'.$this->messageId.'-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    }
?>