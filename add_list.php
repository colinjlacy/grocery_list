<?php

// get the information passed from the app via the POST method
$_POST = json_decode(file_get_contents("php://input"), true);

// save the post information as local variables
$items = $_POST['items'];
$title = mysql_real_escape_string($_POST['title']);
$userId =  mysql_real_escape_string($_POST['userId']);

// retrieve the database info
include("inc/db.inc");

// if no db connection info, then you can't connect
if(!$con) {

    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the list query
$list_sql = "INSERT INTO grocery_lists (user_id, title) VALUES ('$userId', '$title')";

// execute the query and save the returned object
$retval = mysqli_query($con, $list_sql);

// if no returned object
if(!$retval) {

    // let somebody know
    die('Could not enter data ' . mysqli_error($con));

// if there is a returned object
} else {

    // return the ID of the inserted row
    $list = mysqli_insert_id($con);

}

// create the initial query string that we'll build off of
$item_sql = "INSERT INTO list_items (list_id, name) VALUES ";

// set an iterator as 1 (not 0 because I want the loop to match the count - not index - of the array item)
$i = 1;

// get the count of items
$count = count($items);

// loop through the items, adding each to the query string
foreach($items as $item) {

    // escape any gamebreaking characters
    $item = mysql_real_escape_string($item);

    // append item info to the query, along with the relational grocery_list id
    $item_sql .= "('$list', '$item')";

    // if the incremented value is still less than the count of the items array, add some string glue
    if ($i < $count) {
        $item_sql .= ", ";
    }

    // increment
    $i++;

}

// execute the query and save the returned object
$itemval = mysqli_query($con, $item_sql);

if(!$itemval) {

    // let somebody know
    die('Could not enter items ' . mysqli_error($con));

// if there is a returned object
} else {

    // return the ID of the inserted row
    echo $list;

}

?>
