<?php 
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_posts.php';

    function rollback(string $post_id) {
        header(
            'location:'.DOMAIN_NAME.
            'pages/forms/dashboard/update/update_post.php?id='.$post_id
        );
        unset($_POST['submit']);
        $_SESSION['post_data'] = $_POST;
    }

    function rollback_exit($connection, string $post_id) {
        rollback($post_id);
        $connection->close();
        exit();
    }

    function write_featured_post_msg($connection, $title, $remove) {
        if($connection->errno) {
            $_SESSION['dashboard_abort_msg'] = "Can't update featured blog.";
        } else {
            $success_msg = NULL;

            if($remove) 
                $success_msg = "Post '".trim_text($title)."' 'featured' status is removed!";
            else
                $success_msg = "Post '".trim_text($title)."' is now a featured blog!";

            if(isset($_SESSION['dashboard_success_msg']))
                $_SESSION['dashboard_success_msg'] .= "<br />".$success_msg;
            else $_SESSION['dashboard_success_msg'] = $success_msg;
        }
    }

    function unset_featured_post($connection, $title) {
        //featured_post table must only have one record and the id of that
        //is '1'.
        $update_featured_post = "UPDATE featured_post SET ".
        "post_id=NULL WHERE id=1";
        $connection->query($update_featured_post);

        write_featured_post_msg($connection, $title, true);
    }

    function update_featured_post(&$post_info, $connection, $post_id, $title) {
        //featured_post table must only have one record and the id of that
        //is '1'.
        $update_featured_post = "UPDATE featured_post SET ".
        "post_id=$post_id WHERE id=1";
        $connection->query($update_featured_post);

        write_featured_post_msg($connection, $title, false);
    }

    if(isset($_POST['submit']) && isset($_GET['id'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $thumb = $_FILES['thumb'];
        $post_info = [];

        //old thumbnail
        $thumb_old = NULL;

        /* 
            Verify if the user that want to update the post is the owner of the post 
            or the user is an admin.
        */
        $fetch_post_info = "SELECT author_id, thumbnail FROM posts WHERE id=$post_id LIMIT 1";
        $result = $connection->query($fetch_post_info);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //Check if user is the author of the post
            if($row['author_id'] !== $_SESSION['user_session']['id']) {
                //If not, check if the user is admin
                if($_SESSION['user_session']['role'] !== UserRoles::Admin->value) {
                    //Exit if user is not the owner of the post and not admin.
                    $_SESSION['update_post_error'] = 'Invalid Permission.';
                    rollback_exit($connection, $post_id);
                }
            }

            $thumb_old = $row['thumbnail'];
        } else {
            http_response_code(404);
            $_SESSION['update_post_error'] = 'Invalid Post.';
            rollback_exit($connection, $post_id);
        }
        /* ### */

        /* Validation criteria */
        foreach($_POST as $key => $value) {
            if($key === 'submit') continue;
            filterCredentials($post_info, $key, $value);
        }

        foreach($post_info as $key => $value) {
            if($value[1]) {
                $_SESSION['update_post_error'] = $value[2];
                $verified = false;
                break;
            }
        }

        if(isset($_SESSION['update_post_error'])) {
            http_response_code(400);
            rollback_exit($connection, $post_id);
        }

        //Check if category of this submitted post exists.
        $category_id = -1;
        # Remove &nbsp; This &nbsp; comes from select html field because
        # I put &nbsp; to longest category name in select in order for
        # the select item to not overlap the custom red arrow that I put
        # in the select.
        $category_no_nbsp = str_replace("&nbsp;","",$post_info['category'][0]);
        $fetch_category = 
            "SELECT id from categories ".
            "WHERE title='".$category_no_nbsp."' ";
        $result = $connection->query($fetch_category);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $category_id = $row['id'];
        } else {
            http_response_code(404);
            $_SESSION['update_post_error'] = 'Invalid category.';
            rollback_exit($connection, $post_id);
        }

        $thumb_dest_client = NULL;
        if(isset($thumb['name']) && !empty($thumb['name'])) {
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
                    http_response_code(500);
                    $_SESSION['update_post_error'] = 'Can\'t update post. Internal Server Error.';
                    rollback_exit($connection, $post_id);
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
                } else $_SESSION['update_post_error'] = 'File Size Too Big! Max file size is 1mb.';
            } else $_SESSION['update_post_error'] = 'Image file extension must be a .png, .jpg or .jpeg.';
            //--//

            //2nd Error check
            if(isset($_SESSION['update_post_error'])) {
                http_response_code(500);
                rollback_exit($connection, $post_id);
            }
        }

        //Delete old thumbnail in the server if user provides new thumbnail
        if(isset($thumb_dest_client)) {
            #change URL root to file root
            $img_path = str_replace(DOMAIN_NAME,ROOT_PATH,$thumb_old);
            #replace URL's slash(/) with file path(DIRECTORY_SEPARATOR)
            $img_path = str_replace('/',$ds,$img_path);
            #Delete old post thumbnail
            if($img_path) unlink($img_path);
        }

        //Post title
        $title = $post_info['title'][0];

        $update_post = "UPDATE posts SET title='$title',content='{$post_info['description'][0]}',".
        "category_id=$category_id";

        if(isset($thumb_dest_client))
            $update_post .= ",thumbnail='$thumb_dest_client'";

        $update_post .= " WHERE id=$post_id";
        $connection->query($update_post);

        if($connection->errno) {
            http_response_code(500);
            $_SESSION['create_post_error'] = 'Can\'t update post. Please try again.';
            rollback_exit($connection, $post_id);
        }
        else {
            $_SESSION['dashboard_success_msg'] = "Post '".trim_text($title)."' has been updated!";
        }
        //--//

        $fetch_featured_post = "SELECT post_id FROM featured_post WHERE id=1";
        $result = $connection->query($fetch_featured_post);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            //Update Featured Post
            $update_fp = isset($post_info['featured_cbox'][0]);

            //If there's no existing featured post
            if(!isset($row['post_id']) && $update_fp) {
                update_featured_post($post_info, $connection, $post_id, $title);
            }

            // if post is not the featured post and
            // there's an existing featured post
            if(isset($row['post_id']) && $row['post_id'] !== $post_id && $update_fp) {
                update_featured_post($post_info, $connection, $post_id, $title);
            }

            // If post is the current featured post and
            // user want to 'unfeatured' the post
            if(isset($row['post_id']) && $row['post_id'] === $post_id && !$update_fp) {
                unset_featured_post($connection, $title);
            }

        } else {
            http_response_code(404);
            $_SESSION['update_post_error'] = 'Invalid Featured Post. Unexpected Error.';
            rollback_exit($connection, $post_id);
        }

        $connection->close();
        http_response_code(200);
        header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_posts.php');
    }
    else $abort_dashboard_op($abort_redirect);
?>