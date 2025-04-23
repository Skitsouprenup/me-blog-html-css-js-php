<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_category.php';

    if(isset($_GET['title'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $title = filter_var($_GET['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //Delete category in database
        $delete_user = "DELETE from categories WHERE title='$title'";
        $connection->query($delete_user);

        if($connection->errno) {
            http_response_code(500);
            $abort_dashboard_op($abort_redirect,true,'Can\'t delete \''.$title.'\'. Internal Server Error.');
        } else {
            http_response_code(200);
            header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_category.php');
            $_SESSION['dashboard_success_msg'] = "Category '$title' has been deleted!";
        }
        $connection->close();
    } else $abort_dashboard_op($abort_redirect);

?>