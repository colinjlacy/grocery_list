<?php

// if no form values have been submitted
if(!(isset($_POST['username']) && isset($_POST['password']))) {

    // send the user back to the index
    header('Location: /');

// if form values have been submitted...
} else {

    // Get the input data from the user
    $token = $_POST['token'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call for the Login class
    require_once 'class/login.php';

    // Create a new instance of Login
    $login = new \classes\Login();

    // Check to see if either of the inputs are empty
    if (count($login->checkInputLength($username, $password)) > 0) {

        // Should auth fail, send them back to the index
        header('Location: /');

    } else {

        // If their neither of them empty, authenticate!
        if (!($login->authenticate($token, $username, $password))) {

            // Should auth fail, send them back to the index
            header('Location: /');
        }

    }

}

?>