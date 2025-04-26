<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";


    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_posts.php';

    function rollback() {
        header('location:'.$abort_redirect);
        unset($_POST['submit']);
        $_SESSION['post_data'] = $_POST;
    }

    function rollback_exit($connection) {
        rollback();
        $connection->close();
        exit();
    }

    if(isset($_GET['id'])) { 
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $fetch_post_info = "SELECT title,author_id,thumbnail FROM posts WHERE id=$post_id LIMIT 1";
        $result = $connection->query($fetch_post_info);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            //Check if user is the author of the post
            if($row['author_id'] !== $_SESSION['user_session']['id']) {
                //If not, check if the user is admin
                if($_SESSION['user_session']['role'] !== UserRoles::Admin->value) {
                    //Exit if user is not the owner of the post and not admin.
                    $_SESSION['dashboard_abort_msg'] = 'Invalid Permission.';
                    rollback_exit($connection);
                }
            }

            #change URL root to file root
            $img_path = str_replace(DOMAIN_NAME,ROOT_PATH,$row['thumbnail']);
            #replace URL's slash(/) with file path(DIRECTORY_SEPARATOR)
            $img_path = str_replace('/',$ds,$img_path);
            #Delete old post thumbnail
            if($img_path) unlink($img_path);

            //Delete post data in database
            $delete_post = "DELETE FROM posts WHERE id=$post_id";
            $connection->query($delete_post);

            if($connection->errno) {
                http_response_code(500);
                $abort_dashboard_op($abort_redirect,$connection,'Can\'t delete Post. Internal Server Error.');
            } else {
                http_response_code(200);
                header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_posts.php');
                $_SESSION['dashboard_success_msg'] = "Post '".trim_text($row['title'])."' has been deleted!";
            }
        } else {
            http_response_code(404);
            $_SESSION['dashboard_abort_msg'] = 'Post can\'t be deleted. Invalid Post.';
            rollback_exit($connection);
        }

        $connection->close();
    } else $abort_dashboard_op($abort_redirect);
?>