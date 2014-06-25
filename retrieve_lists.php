<?php
session_start();

// get the user ID from the session vars
$user_id = $_SESSION['user_loggedin'];

// retrieve the database info
include("inc/db.inc");

// if no db connection info, then you can't connect
if(!$con) {

    // let somebody know
    die('Could not connect: ' . mysqli_error($con));

}

// build the query
$sql = "SELECT * FROM grocery_lists WHERE user_id = '$user_id'";

// execute the query and save the returned object
$retval = mysqli_query($con, $sql);

// if no returned object
if(!$retval) {

    // let somebody know
    die('Could not retrieve data ' . mysqli_error($con));

// if there is a returned object
} else {

    // create a blank array
    $dataToBeEncoded = array();

    // loop through each row in the returned object
    while($row = $retval -> fetch_assoc()) {

        // and insert it into the blank array
        $dataToBeEncoded[] = $row;

    }

    // then return a json_encoded version of the data to the app
    echo json_encode($dataToBeEncoded);
}

?>