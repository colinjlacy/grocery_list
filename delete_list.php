<?php
session_start();

if(!($_SESSION['user_loggedin'])) {
    die;
} else {
    $user_id = $_SESSION['user_loggedin'];
}

// get the information passed from the app via the POST method
$_POST = json_decode(file_get_contents("php://input"), true);

$id = $_POST;

// retrieve the database info
include("inc/db.inc");

file_put_contents('log.log', "got past the include", FILE_APPEND);

// if no db connection info, then you can't connect
if(!$con) {

    file_put_contents('log.log', "no connection", FILE_APPEND);

    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the query
$list_sql = "DELETE FROM grocery_lists WHERE id = '$id' AND user_id = '$user_id'";

// execute the query and save the returned object
$retval = mysqli_query($con, $list_sql);

// if no returned object
if(!$retval) {

    file_put_contents('log.log', "list sql query returned negative", FILE_APPEND);

    // let somebody know
    die('Could not delete list: ' . mysqli_error($con));

};

// build the item query string
$item_sql = "DELETE FROM list_items WHERE list_id = '$id'";

// execute the query and save the returned object
$itemval = mysqli_query($con, $item_sql);

// if no returned object
if(!$itemval) {

    file_put_contents('log.log', "item sql query returned negative", FILE_APPEND);
    // let somebody know
    die('Could not delete items: ' . mysqli_error($con));

} else {

    file_put_contents('log.log', "item sql query returned positive", FILE_APPEND);

};
