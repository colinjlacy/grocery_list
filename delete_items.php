<?php
session_start();

if(!($_SESSION['user_loggedin'])) {
    die;
} else {
    $user_id = $_SESSION['user_loggedin'];
}

// get the information passed from the app via the POST method
$items = json_decode(file_get_contents("php://input"), true);

// retrieve the database info
include("inc/db.inc");

// if no db connection info, then you can't connect
if(!$con) {

    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the item query string
$item_sql = "DELETE FROM list_items WHERE id IN (";

// set an iterator as 1 (not 0 because I want the loop to match the count - not index - of the array item)
$i = 1;

// get the count of items
$count = count($items);

$return = "";

// loop through the items, adding each to the query string
foreach($items as $item) {

    // append item info to the query, along with the relational grocery_list id
    $item_sql .= $item;

    $return .= "added ".$item.". ";

    // if the incremented value is still less than the count of the items array, add some string glue
    if ($i < $count) {
        $item_sql .= ", ";
    } else {
        $item_sql .= ")";
    }

    // increment
    $i++;

}

$return .= "and final query is ".$item_sql;

// execute the query and save the returned object
$itemval = mysqli_query($con, $item_sql);

// if no returned object
if(!$itemval) {

    // let somebody know
    die('Could not delete items: ' . mysqli_error($con));

} else {

    echo $return;

};
