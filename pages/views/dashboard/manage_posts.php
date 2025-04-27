<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $select_sidebar_item_query = '.dashboard_side_bar > a > #manage_posts_sidebar_item';
    $dialog_box_delete_btn = '.dashboard_dialog_box > .interface > .delete_post';

    $update_post_page = DOMAIN_NAME.'pages/forms/dashboard/update/update_post.php?id=';
    $delete_post_script = DOMAIN_NAME."scripts/delete/delete_post.php?id=";

    $fetch_user_posts = 
    "SELECT posts.title as post_title, posts.id as post_id, ".
    "categories.title as category_title FROM posts ".
    "INNER JOIN categories ON posts.category_id = categories.id ".
    "WHERE posts.author_id={$_SESSION['user_session']['id']} ".
    "ORDER BY posts.id DESC";
    $result = $connection->query($fetch_user_posts);

    $posts = [];
    while($posts[] = $result->fetch_assoc());
    
    if(count($posts) > 0) {
        /* 
            Check if the last element is null because fetch_assoc() always
            put null at the end of array.
        */
        $end = end($posts);
        if(!isset($end)) array_pop($posts);
    }
    $connection->close();

    $operation = 'post';
    $dialog_box_title = 'Delete Post';
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head_content_only.php' ?>
        <script src=<?php echo DOMAIN_NAME."js/dashboard.js"; ?> defer></script>
    </head>

    <body>

        <div class="dashboard_body_wrapper">
            <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'sidebar_items_mobile.php'; ?>
            <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'dialog_box.php'; ?>

         <!-- navigation menu -->
            <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

            <div class="dashboard_container">

                <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'message_panels.php'; ?>

                <div class="dashboard_wrapper">
                    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'sidebar.php'; ?>

                    <div class="dashboard_content">
                        <h2>Manage Posts</h2>

                        <div class="data_list_content">
                            <?php if(count($posts) > 0):?>
                                <div class="data_view_small_screen">
                                    <?php foreach($posts as $list):?>
                                        <div class="data_container">
                                            <div class="data">
                                                <h3>Title</h3>
                                                <p><?php echo $list['post_title']?></p>
                                            </div>
                                            <div class="data">
                                                <h3>Category</h3>
                                                <p><?php echo $list['category_title']?></p>
                                            </div>
                                            <div class="actions">
                                                <h3>Actions</h3>
                                                <div class="dashboard_actions_mobile">
                                                    <a 
                                                        href=<?php echo $update_post_page.$list['title']?> 
                                                        class="edit"
                                                    >
                                                        <div>Edit</div>
                                                    </a>
                                                    <a href="#" class="delete">
                                                        <div>Delete</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach?>  
                                </div>
                            <?php endif?>
                            
                            <table class="data_view_large_screen">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                <?php foreach($posts as $list):?>
                                    <tr>
                                        <td><?php echo $list['post_title']?></td>
                                        <td><?php echo $list['category_title']?></td>
                                        <td>
                                            <div class="dashboard_actions">
                                                <a 
                                                    href=<?php echo $update_post_page.$list['post_id']?> 
                                                    class="edit"
                                                >
                                                    <div>Edit</div>
                                                </a>
                                                <button type="button" class="delete"
                                                    <?php 
                                                        echo "onclick=\"showDeleteDialogBox(".
                                                        "'".$list['post_title']."',".
                                                        "'".$delete_post_script.$list['post_id']."',".
                                                        "'".$dialog_box_delete_btn."')\""
                                                    ?>
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach?>
                            </table>
                            <?php if(count($posts) === 0):?>
                                <div class="no_posts">No Posts Found</div>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            </div>

         <!-- Footer  -->
            <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
        </div>
        <!-- 
            This script is in the bottom because we want to load all
            html elements first before executing this script 
        -->
        <script>
            const select_sidebar_item = (query) => {
                document.querySelector(query).classList.add('selected')
            }

            select_sidebar_item("<?= $select_sidebar_item_query ?>")
        </script>
    </body>
</html>