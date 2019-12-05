<?php 
    
    class Validator {
        
        function __Validator(){
            
        }
        
        //Will validate no special chars or empty.
        public function validateName($name) {
            $string_exp = "/^[A-Za-z .'-]+$/";
            $pass = true;
            if (empty($name)) { 
                $pass = false;
            } else if (!preg_match($string_exp, $name)){
                $pass = false;
            }
            return $pass;
        }
        
        //Not empty, proper length and numbers only
        public function validateISBN($isbn) {
            $pass = true;
            $mathPass = self::isbnMath($isbn);
            if (empty($isbn)) {
                $pass = false;
            } else if (strlen($isbn) != 13) {
                $pass = false;
            } else if (!preg_match('/[0-9]/', $isbn)) {
                $pass = false;
            } else if (!$mathPass) {
                $pass = false;
            }
            return $pass;
        }
        
        //Sees if isbn follows the correct format
        private static function isbnMath($isbn) {
            $pass = true;
            $sum = 0;
            settype($sum, "integer");
            for($i = 0; $i < 12; $i++) { //Add first 12 digits together but multiply by 3 on every other digit
                if ($i % 2 == 1) {
                    $sum += (3 * intval(substr($isbn, $i, 1))); 
                } else {
                    $sum += intval(substr($isbn, $i, 1)); 
                }
            }
            $sum += intval($isbn.substr(12, 12));
            if ($sum % 10 != 0) { //If the sum is not divisible by 10 then it's invalid.
                $pass = false;
            }
            return $pass;
        }
        
        
        
        //Not empty, match the email format
        public function validateEmail($email) {
            $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
            $pass = true;
            if (empty($email)) {
                $pass = false;
            } else if (!preg_match($email_exp, $email)) {
                $pass = false;
            }
            return $pass;
        }  
        
        //Does not exceed max length, no special chars
        public function validateTextArea($text, $maxLength) {
            $string_exp = "/^[A-Za-z0-9 .'-]+$/";
            $pass = true;
            if(strlen($text) > $maxLength) {
                $pass = false;
            } else if (!preg_match($string_exp, $text)){
                if(!empty($text)) { //can be empty, if not then it didn't match expression.
                    $pass = false; 
                }
            }
            return $pass;
        }
    }
?>