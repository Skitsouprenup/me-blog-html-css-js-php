<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_users.php';

    if(isset($_GET['username'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $username = filter_var($_GET['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $fetch_users = "SELECT firstname,lastname,avatar FROM users WHERE username='$username'";
        $result = $connection->query($fetch_users);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            #change URL root to file root
            $img_path = str_replace(DOMAIN_NAME,ROOT_PATH,$row['avatar']);
            #replace URL's slash(/) with file path(DIRECTORY_SEPARATOR)
            $img_path = str_replace('/',$ds,$img_path);
            #Delete user image
            if($img_path) unlink($img_path);

            //Delete Post...

            //Delete user data in database
            $delete_user = "DELETE from users WHERE username='$username'";
            $connection->query($delete_user);

            $name = $row['firstname'][0].' '.$row['lastname'][0];
            if($connection->errno) {
                $abort_dashboard_op($abort_redirect,true,'Can\'t delete \''.$name.'\'. Contact Administrator if possible.');
            } else {
                
                header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_users.php');
                $_SESSION['dashboard_success_msg'] = "User $name has been deleted!";
            }

        } else $abort_dashboard_op($abort_redirect,true);

    } else $abort_dashboard_op($abort_redirect);
?>