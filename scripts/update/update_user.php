<?php
require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";
require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";

require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
apiAccessControl(__FILE__);

$abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_users.php';

if(isset($_POST['submit'])) {
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    
    function rollback(string $username = "") {
        header('location:'.DOMAIN_NAME.'pages/forms/dashboard/update/update_user.php?username='.$username);
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

    #Remove the '/' added by <hidden> tag?
    $username = str_replace("/", "", $credentials['username'][0]);

    if(isset($_SESSION['update_user_error'])) {
        http_response_code(400);
        rollback($username);
        exit();
    }

    #'LIMIT 1' means, only update one record. Optional.
    $update_query = "UPDATE users SET ".
    "firstname='".$credentials['firstname'][0]."', ".
    "lastname='".$credentials['lastname'][0]."', ".
    "role='".$credentials['role'][0]."' ".
    "WHERE username='".$username."' LIMIT 1"; 
    $connection->query($update_query);

    if($connection->errno) {
        http_response_code(500);
        $_SESSION['update_user_error'] = 'Can\'t update user. Contact Administrator if possible.';
        rollback($username);
    } else {
        http_response_code(200);
        $name = $credentials['firstname'][0].' '.$credentials['lastname'][0];
        header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_users.php');
        $_SESSION['dashboard_success_msg'] = "User '$name' has been updated!";
    }
    $connection->close();
} else {
    http_response_code(400);
    $abort_dashboard_op($abort_redirect);
}
?>