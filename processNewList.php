<?php

// get the information passed from the app via the POST method
$_POST = json_decode(file_get_contents("php://input"), true);

// save the post information as local variables
$items = $_POST['items'];
$title = mysql_real_escape_string($_POST['title']);
$userId =  mysql_real_escape_string($_POST['userId']);

// combine the array of items into a string, glued with a string that will unlikely ever appear in a grocery list
$breakString = "&?colin!?&";
$joined = mysql_real_escape_string(join($breakString, $items));

// retrieve the database info
include("inc/db.inc");

// if no db connection info, then you can't connect
if(!$con) {

    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the query
$sql = "INSERT INTO grocery_lists (user_id, title, content) VALUES ('$userId', '$title', '$joined')";

// execute the query and save the returned object
$retval = mysqli_query($con, $sql);

// if no returned object
if(!$retval) {

    // let somebody know
    die('Could not enter data ' . mysqli_error($con));

// if there is a returned object
} else {

    // return the ID of the inserted row
    echo mysqli_insert_id($con);

}


?>
