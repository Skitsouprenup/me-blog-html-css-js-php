<?php 
/* Database */

define('DB_HOST', 'localhost');
define('DB_USER', 'Me_blog');
define('DB_PASS', '1234');
define('DB_NAME', 'me_blog');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($connection->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
?>