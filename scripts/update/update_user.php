<?php
require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";

$abort = function() {
    header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_users.php');
    exit();
};

if(isset($_POST['submit'])) {
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    
    function rollback() {
        header('location:'.DOMAIN_NAME.'pages/blog_forms/update/update_users.php?username='.$username);
        unset($_POST['submit']);
        $_SESSION['post_data'] = $_POST;
    }

    $credentials = [];

    /* Validation criteria */
    foreach($_POST as $key => $value) {
        if($key === 'submit') continue;
        filterCredentials($credentials, $key, $value);
    }

    foreach($credentials as $key => $value) {
        if($value[1]) {
            $_SESSION['update_user_error'] = $value[2];
            break;
        }
    }

    if(isset($_SESSION['update_user_error'])) {
        rollback();
        exit();
    }

    #Remove the '/' added by <hidden> tag?
    $username = str_replace("/", "", $credentials['username'][0]);

    #'LIMIT 1' means, only update one record. Optional.
    $update_query = "UPDATE users SET ".
    "firstname='".$credentials['firstname'][0]."', ".
    "lastname='".$credentials['lastname'][0]."', ".
    "role='".$credentials['role'][0]."' ".
    "WHERE username='".$username."' LIMIT 1"; 
    $connection->query($update_query);

    if($connection->errno) {
        $_SESSION['signin_error'] = 'Can\'t update user. Contact Administrator if possible.';
        rollback();
    } else header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_users.php');

} else $abort();
?>