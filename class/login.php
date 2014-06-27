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

    public function setLogin($user_id, $username) {
        // set the session variable "user_loggedin" to the user's
        $_SESSION['user_loggedin'] = $user_id;
        $_SESSION['username'] = $username;
    }

    public function authenticate($token, $username, $password) {

        if ($this->checkToken($token) == true) {
            die;
        }

        $u = mysql_real_escape_string($username);
        $p = mysql_real_escape_string($password);

        // get user entry from database and compare password to saved password field
        // if successful, setLogin with the user's id

        require_once("inc/db.inc");

        // if no db connection info, then you can't connect
        if(!$con) {

            // let somebody know
            die('Could not connect ' . mysqli_error($con));

        }

        // build the list query
        $user_sql = "SELECT * FROM users WHERE username = '$u' and password = '$p'";

        // execute the query and save the returned object
        $retval = mysqli_query($con, $user_sql);

        // if no returned object
        if(!$retval) {

            // let somebody know
            die('Could not retrieve user ' . mysqli_error($con));

        // if there is a returned object
        } else {

            // return the ID of the inserted row
            $row = mysqli_fetch_assoc($retval);
            $user_id = $row['id'];

            $this->setLogin($user_id, $username);

            return true;

        }

    }

    public function checkInputLength($username, $password) {
        $inputs = array(
            "Username" => $username,
            "Password" => $password
        );

        $empty_array = array();

        foreach ($inputs as $key => $value) {

            // Make sure the $value isn't empty
            if(!(strlen($value) > 0)) {
                array_push($empty_array, $key);
            }

        }

        return $empty_array;
    }

}