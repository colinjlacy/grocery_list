<?php
/**
 * Created by PhpStorm.
 * User: colinjlacy
 * Date: 6/23/14
 * Time: 3:04 PM
 */

namespace classes;

require_once 'login.php';

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

        if ($this->checkToken($token) == true) {
            die;
        };

        $inputs = array(
            "Username" => $username,
            "Password" => $password
        );

        $bad_format = array();

        foreach ($inputs as $key => $value) {
            switch($key) {
                case "Username":
                    if(!preg_match("/^[A-Za-z0-9]{0,20}$/", $value) )
                    {
                        $bad_format[] = $key;
                    }
                    break;
                case "Password":
                    if(!preg_match("/^[A-Za-z0-9]{0,20}$/", $value) )
                    {
                        $bad_format[] = $key;
                    }
            }
        }

        return $bad_format;
    }

    public function register($username, $password) {

        include("../inc/db.inc");

        // if no db connection info, then you can't connect
        if(!$con) {

            // let somebody know
            die('Could not connect ' . mysqli_error($con));

        }

        $u = mysql_real_escape_string($username);
        $p = mysql_real_escape_string($password);

        // build the list query
        $user_sql = "INSERT INTO users (username, password) VALUES ('$u', '$p')";

        // execute the query and save the returned object
        $retval = mysqli_query($con, $user_sql);

        // if no returned object
        if(!$retval) {

            // let somebody know
            die('Could not enter user ' . mysqli_error($con));

        // if there is a returned object
        } else {

            // return the ID of the inserted row
            $user_id = mysqli_insert_id($con);

            $this->setLogin($user_id, $username);

        }

    }
}