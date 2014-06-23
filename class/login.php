<?php
/**
 * Created by PhpStorm.
 * User: colinjlacy
 * Date: 6/23/14
 * Time: 2:30 PM
 */

namespace classes;


class Login {

    public function checkToken($token) {
        if ($token != $_SESSION['token']) {
            $hacker = true;
        } else {
            $hacker = false;
        }
        return $hacker;
    }

    public function setLogin($user_id) {
        // set the session variable "user_loggedin" to the user's
        $_SESSION['user_loggedin'] = $user_id;
    }

    public function authenticate($token, $username, $password) {

        if ($this->checkToken($token) == false) {
            die;
        }

        $u = $username;
        $p = $password;

        // get user entry from database and compare password to saved password field
        // if successful, setLogin with the user's id
        if ($u == "colin" && $p == "thisthis") {
            $this -> setLogin('1');
        }
        return true;
    }

    public function checkInputLength($username, $password) {
        $inputs = [
            "Username" => $username,
            "Password" => $password
        ];

        $empty_array = [];

        foreach ($inputs as $key => $value) {

            // Make sure the $value isn't empty
            if(!(strlen($value) > 0)) {
                array_push($empty_array, $key);
            }

        }

        return $empty_array;
    }
} 