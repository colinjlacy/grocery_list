<?php
/**
 * Created by PhpStorm.
 * User: colinjlacy
 * Date: 6/23/14
 * Time: 3:04 PM
 */

namespace classes;


class addUser extends Login {

    function validatePassword($password, $password_validation) {
        if ($password != $password_validation) {
            return false;
        } else {
            return true;
        }
    }

    function databaseInsert($username, $password) {
        // do stuff
    }

    function validateInputs($token, $username, $password) {

        if ($this->checkToken($token) == false) {
            die;
        }

        $inputs = [
            "Username" => $username,
            "Password" => $password
        ];

        $bad_format = [];

        foreach ($inputs as $key => $value) {
            switch($key) {
                case "Username":
                    if(!preg_match("/^[A-Za-z0-9]{1,20}$/", $value) )
                    {
                        $bad_format[] = $key;
                    }
                    break;
                case "Password":
                    if(!preg_match("/^[A-Za-z0-9]{6,20}$/", $value) )
                    {
                        $bad_format[] = $key;
                    }
            }
        }

        return $bad_format;
    }
} 