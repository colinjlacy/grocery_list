<?php
session_start();

$token = $_POST['token'];
$username = $_POST['username'];
$password = $_POST['password'];

require_once 'class/login.php';

$login = new \classes\Login();

$empty = $login->checkInputLength($username, $password);

if (count($empty) > 0) {
    echo "EMPTY!!!";
} else {
    echo "Got past the empty array";

    $isLoggedIn = $login->authenticate($token, $username, $password);

    if ($isLoggedIn == true) {
        echo "Should be logged in!";
    }

    echo $_SESSION['user_loggedin'];
}
?>
