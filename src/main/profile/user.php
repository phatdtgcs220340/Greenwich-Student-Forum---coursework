<?php 
    namespace Src\User;
    
    class User {
        private $userId; 
        private $firstName;
        private $lastName;
        private $email;
        private $image;
        
        public function __construct($userId, $firstName, $lastName, $email, $image) 
        {
            $this->userId = $userId;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->image = $image;
        }
        
        public function getUserId()
        {
            return $this->userId;
        }
        
        public function getFirstName()
        {
            return $this->firstName;
        }
        
        public function getLastName()
        {
            return $this->lastName;
        }
        
        public function getEmail()
        {
            return $this->email;
        }
        
        public function getImage()
        {
            return $this->image;
        }
    }
    
?>