<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $select_sidebar_item_query = '.dashboard_side_bar > a > #manage_users_sidebar_item';
    $dialog_box_delete_btn = '.dashboard_dialog_box > .interface > .delete_user';

    $update_user_page = DOMAIN_NAME.'pages/forms/dashboard/update/update_user.php';
    $delete_user_script = DOMAIN_NAME."scripts/delete/delete_user.php?username=";

    $fetch_users = "SELECT id,firstname,lastname,username,role from users";
    $result = $connection->query($fetch_users);

    $usernames = [];
    while($usernames[] = $result->fetch_assoc());

    if(count($usernames) > 0) {
        /* 
            Check if the last element is null because fetch_assoc() always
            put null at the end of array.
        */
        $end = end($usernames);
        if(!isset($end)) array_pop($usernames);
    }
    $connection->close();

    $operation = 'user';
    $dialog_box_title = 'Delete User';

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
                        <h2>Manage Users</h2>
                        <div class="data_list_content">
                            <?php if(count($usernames) > 0):?>
                                <div class="data_view_small_screen">
                                    <div class="data_container">
                                        <?php foreach($usernames as $list):?>
                                            <div class="data">
                                                <h3>Name</h3>
                                                <p><?php echo $list['firstname'].' '.$list['lastname']?></p>
                                            </div>
                                            <div class="data">
                                                <h3>Username</h3>
                                                <p><?php echo $list['username']?></p>
                                            </div>
                                            <div class="data">
                                                <h3>Role</h3>
                                                <p><?php echo $list['role']?></p>
                                            </div>
                                            <div class="actions">
                                                <h3>Actions</h3>
                                                <div class="dashboard_actions_mobile">
                                                    <a 
                                                        href=<?php echo $update_user_page.'?username='.$list['username']?>
                                                        class="edit"
                                                    >
                                                        <div>Edit</div>
                                                    </a>
                                                    <button type="button" class="delete"
                                                        <?php 
                                                            echo "onclick=\"showDeleteDialogBox(".
                                                            "'".$list['username']."',".
                                                            "'".$delete_user_script.$list['username']."',".
                                                            "'".$dialog_box_delete_btn."')\""
                                                        ?>
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach?>
                                        
                                    </div>
                                </div>
                            <?php endif?>
                            
                            <table class="data_view_large_screen">
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                                <?php foreach($usernames as $list):?>
                                    <tr>
                                        <td><?php echo $list['firstname'].' '.$list['lastname']?></td>
                                        <td><?php echo $list['username']?></td>
                                        <td><?php echo $list['role']?></td>
                                        <td>
                                            <div class="dashboard_actions">
                                                <a 
                                                    href=<?php echo $update_user_page.'?username='.$list['username']?> 
                                                    class="edit"
                                                >
                                                    <div>Edit</div>
                                                </a>
                                                <button type="button" class="delete"
                                                    <?php 
                                                        echo "onclick=\"showDeleteDialogBox(".
                                                        "'".$list['username']."',".
                                                        "'".$delete_user_script.$list['username']."',".
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
                            <?php if(count($usernames) === 0):?>
                                <div class="no_posts">No Users Found</div>
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