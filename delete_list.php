<?php
session_start();

if(!($_SESSION['user_loggedin'])) {
    header('Location: /');
} else {
    $user_id = $_SESSION['user_loggedin'];
}

// get the information passed from the app via the POST method
$_POST = json_decode(file_get_contents("php://input"), true);

$id = $_POST;

// retrieve the database info
include("inc/db.inc");


// if no db connection info, then you can't connect
if(!$con) {


    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the query
$list_sql = "DELETE FROM grocery_lists WHERE id = '$id' AND user_id = '$user_id'";

// execute the query and save the returned object
$retval = mysqli_query($con, $list_sql);

// if no returned object
if(!$retval) {


    // let somebody know
    die('Could not delete list: ' . mysqli_error($con));

};

// build the item query string
$item_sql = "DELETE FROM list_items WHERE list_id = '$id'";

// execute the query and save the returned object
$itemval = mysqli_query($con, $item_sql);

// if no returned object
if(!$itemval) {

    // let somebody know
    die('Could not delete items: ' . mysqli_error($con));

} else {

    echo "That worked!";

};
