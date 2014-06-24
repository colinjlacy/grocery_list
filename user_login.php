<?php

// if no form values have been submitted
if(!(isset($_POST))) {

    // send the user back to the index
    header('Location: /grocery_list/index.php');

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

        // TODO: Handle empty input errors

    } else {

        // If their neither of them empty, authenticate!
        if (!($login->authenticate($token, $username, $password))) {

            // Should auth fail, send them back to the index
            header('Location: /grocery_list/index.php');
        }

    }

    // at this point, the user has been authenticated, their ID saved in the session.
}

?>