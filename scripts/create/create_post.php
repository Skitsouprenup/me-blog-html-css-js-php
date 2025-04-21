<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_posts.php';

    function rollback() {
        header('location: '.DOMAIN_NAME.'pages/forms/dashboard/create/create_post.php');
        unset($_POST['submit']);
        $_SESSION['post_data'] = $_POST;
    }

    function rollback_exit($connection) {
        rollback();
        $connection->close();
        exit();
    }

    if(isset($_POST['submit'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $thumb = $_FILES['thumb'];
        $credentials = [];

        /* Validation criteria */
        foreach($_POST as $key => $value) {
            if($key === 'submit') continue;
            filterCredentials($credentials, $key, $value);
        }
        /* Extra Validation Criteria */
        $credentials['thumb'] = [
            '',
            !$thumb['name'],
            "Thumbnail is required. Please upload your thumbnail."
        ];

        foreach($credentials as $key => $value) {
            if($value[1]) {
                $_SESSION['create_post_error'] = $value[2];
                break;
            }
        }

        //First Error check
        if(isset($_SESSION['create_post_error'])) {
            rollback_exit($connection);
        }

        //Check if category of this submitted post exists.
        $category_id = -1;
        $fetch_category = 
            "SELECT id from categories ".
            "WHERE title='".$credentials['category'][0]."' ";
        $result = $connection->query($fetch_category);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $category_id = $row['id'];
        } else {
            $_SESSION['create_post_error'] = 'Invalid category.';
            rollback_exit($connection);
        }
        //--//

        //Upload thumbnail to server.
        //current time in seconds.
        $time = time();
        $thumb_name = $time.'_'.$thumb['name'];
        //Temporary file name. If file is not moved to a directory after the request,
        //The temporary image file will be discarded.
        $thumb_tmp_name = $thumb['tmp_name'];

        $uploader_id = filter_var($_SESSION['user_session']['id'], FILTER_SANITIZE_NUMBER_INT);
        $thumb_dest = ROOT_PATH.'images'.$ds.'posts'.$ds.$uploader_id;
        if(!file_exists($thumb_dest)) {
            if(!mkdir($thumb_dest, 0777, true)) {
                $_SESSION['create_post_error'] = 'Can\'t create post. Internal Server Error.';
                rollback_exit($connection);
            }
        }
        $thumb_dest .= $ds.$thumb_name;

        //URL
        $thumb_dest_client = DOMAIN_NAME.'images/posts/'.$uploader_id.'/'.$thumb_name;

        //Check if file is an image
        $allowed_ext = ['png', 'jpg', 'jpeg'];
        $ext = explode('.', $thumb_name);
        $ext = end($ext);

        if(in_array($ext, $allowed_ext)) {
            //file size less than 1mb
            if($thumb['size'] < 1000000) {
                // Move temp image file to a directory to make it
                // permanent.
                move_uploaded_file($thumb_tmp_name, $thumb_dest);
            } else $_SESSION['create_post_error'] = 'File Size Too Big! Max file size is 1mb.';
        } else $_SESSION['create_post_error'] = 'Image file extension must be a .png, .jpg or .jpeg.';
        //--//

        //2nd Error check
        if(isset($_SESSION['create_post_error'])) {
            rollback_exit($connection);
        }

        //Post title
        $title = $credentials['title'][0];

        // Insert post to database
        $insert_id = -1;
        $create_post = "INSERT INTO posts (title, content, thumbnail, category_id, author_id) ".
        "VALUES ('{$credentials['title'][0]}', '{$credentials['description'][0]}', ".
        "'$thumb_dest_client', $category_id, {$_SESSION['user_session']['id']} )";
        $connection->query($create_post);

        if($connection->errno) {
            $_SESSION['create_post_error'] = 'Can\'t create post. Please try again.';
            rollback_exit($connection);
        }
        else {
            $insert_id = $connection->insert_id;
            $_SESSION['dashboard_success_msg'] = "Post '".trim_text($title)."' has been created!";
        }
        //--//

        if(isset($credentials['featured_cbox'][0])) {
            
            //featured_post table must only have one record and the id of that
            //is '1'.
            $update_featured_post = "UPDATE featured_post SET ".
            "post_title='{$credentials['title'][0]}', ".
            "post_id=$insert_id WHERE id=1";
            $connection->query($update_featured_post);

            if($connection->errno) {
                $_SESSION['dashboard_abort_msg'] = "Can't update featured blog.";
            } else {
                if(isset($_SESSION['dashboard_success_msg']))
                    $_SESSION['dashboard_success_msg'] .= "<br />Post '".trim_text($title)."' is now a featured blog!";
                else $_SESSION['dashboard_success_msg'] = "Post '".trim_text($title)."' is now a featured blog!";
            }
        }

        $connection->close();
        header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_posts.php');

    } else $abort_dashboard_op($abort_redirect);
?>