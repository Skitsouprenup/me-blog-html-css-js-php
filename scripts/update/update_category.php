<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_category.php';

    if(isset($_POST['submit'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        function rollback(string $title = "") {
            header(
                'location:'.DOMAIN_NAME.
                'pages/forms/dashboard/update/update_category.php?title='.$title);
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
                $_SESSION['update_category_error'] = $value[2];
                break;
            }
        }

        #Remove the '/' added by <hidden> tag?
        $prev_title = str_replace("/", "", $credentials['prev_title'][0]);

        if(isset($_SESSION['update_category_error'])) {
            rollback($prev_title);
            exit();
        }

        #'LIMIT 1' means, only update one record. Optional.
        $update_query = "UPDATE categories SET ".
        "title='".$credentials['title'][0]."', ".
        "description='".$credentials['description'][0]."' ".
        "WHERE title='".$prev_title."' LIMIT 1"; 
        $connection->query($update_query);

        if($connection->errno) {
            $_SESSION['update_category_error'] = 'Can\'t update category. Please try again.';
            rollback($prev_title);
        } else {
            header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_category.php');
            $_SESSION['dashboard_success_msg'] = "Category '".trim_text($credentials['title'][0])."' has been updated!";
        }

    }else $abort_dashboard_op($abort_redirect);

?>