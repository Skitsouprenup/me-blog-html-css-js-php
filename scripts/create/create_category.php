<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_category.php';

    if(isset($_POST['submit'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        function rollback(string $title = "") {
            header('location:'.DOMAIN_NAME.'pages/forms/dashboard/create/create_category.php?title='.$title);
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
                $_SESSION['create_category_error'] = $value[2];
                break;
            }
        }

        $title = $credentials['title'][0];

        if(isset($_SESSION['create_category_error'])) {
            rollback($title);
        }
        else {

            $create_category = "INSERT INTO categories (title, description) ".
            "VALUES ('$title', '{$credentials['description'][0]}')";
            $connection->query($create_category);

            if($connection->errno) {
                http_response_code(500);
                $_SESSION['create_category_error'] = 'Can\'t create category. Internal Server Error.';
                rollback($title);
            }
            else {
                http_response_code(200);
                header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_category.php');
                $_SESSION['dashboard_success_msg'] = "Category '".trim_text($title)."' has been created!";
            }
        }
        $connection->close();
    } else $abort_dashboard_op($abort_redirect);
?>