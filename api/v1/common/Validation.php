<?php
class Validation 
{
    public function checkEmpty($data, $fields)
    {
        $msg = null;
        foreach ($fields as $value) {
            if (empty($data[$value])) {
                $msg .= "$value field empty <br />";
            }
        } 
        return $msg;
    }
    
    public function isAgeValid($age)
    {
        //if (is_numeric($age)) {
        if (preg_match("/^[0-9]+$/", $age)) {    
            return true;
        } 
        return false;
    }
    
    public function isEmailValid($email)
    {
        //if (preg_match("/^[_a-z0-9-+]+(\.[_a-z0-9-+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {    
            return true;  
        }
        return false;
    }

    public function isNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }
}
?>