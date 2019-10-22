<?php 
    
    class FormValidator {
        
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
        
        //Not empty, 10 chars, and only numbers 
        public function validatePhone($phone) {
            $pass = true;
            if (empty($phone)) {
                $pass = false;
            } else if (strlen($phone) != 10) {
                $pass = false;
            } else if (!preg_match('/[0-9]/', $phone)) {
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