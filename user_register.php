<?php

// Get the input data from the user
$token = $_POST['token'];
$username = $_POST['username'];
$password = $_POST['password'];
$verify = $_POST['password-verify'];


// Call for the Login class
require 'class/add_user.php';

// Create a new instance of Login
$register = new \classes\addUser();

if (count($register->checkInputLength($username, $password)) > 0) {

    // Should auth fail, send them back to the index
    $_SESSION['error_message'] = "<p>You need to enter both a Username and a Password</p>";
    header('Location: /');

}

if ($register->validatePassword($password, $verify) == false) {

    // Should auth fail, send them back to the index
    $_SESSION['error_message'] = "<p>Your Password Verification doesn't match</p>";
    header('Location: /');

}

$validate = $register->validateInputs($token, $username, $password);

if (count($validate) > 0) {

    // Should auth fail, loop through items in the bad_format array, and add them as list items, then send them back to the index
    $_SESSION['error_message'] = "<p>The following entries are formatted incorrectly:</p><ul>";
    foreach ($validate as $field) {
        $_SESSION['error_message'] .= "<li>$field</li>";
    }
    $_SESSION['error_message'] .= "</ul>";
    header('Location: /');

}

include("inc/db.inc");

// if no db connection info, then you can't connect
if(!$con) {

    // let somebody know
    die('Could not connect ' . mysqli_error($con));

}

// build the list query
$user_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

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

    $register->setLogin($user_id, $username);

}
