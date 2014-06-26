<?php
session_start();
session_unset();
header('Location: http://localhost:8888/grocery_list/');
?>