<?php
session_start();

if(!($_SESSION['user_loggedin'])) {
    die;
} else {
    $user_id = $_SESSION['user_loggedin'];
}

// get the information passed from the app via the POST method
$_POST = json_decode(file_get_contents("php://input"), true);

echo $_POST;

$id = $_POST;

// retrieve the database info
include("inc/db.inc");

// if no db connection info, then you can't connect
if(!$con) {

    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the query
$sql = "DELETE FROM grocery_lists WHERE id = '$id' AND user_id = '$user_id'";

// execute the query and save the returned object
$retval = mysqli_query($con, $sql);

// if no returned object
if(!$retval) {

    // let somebody know
    die('Could not enter data ' . mysqli_error($con));

// if there is a returned object
} else {

    // return the ID of the inserted row
    echo "Yep, that worked!";

}
