<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_constants.php";
    pageAccessControl(__FILE__);

    $select_sidebar_item_query = '.dashboard_side_bar > a > #manage_users_sidebar_item';
    $update_user_page = DOMAIN_NAME.'pages/blog_forms/update/update_user.php';

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

        <!-- navigation menu -->
            <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

            <div class="dashboard_container">

                <?php if(isset($success_msg)):?>
                    <div class="success_msg">
                        <p><?php echo $success_msg?></p>
                        <button type="button" <?php echo "onclick=\"closeMessagePanel("."'".DASHBOARD_SUCCESS_PANEL."'".")\""?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                            </svg>
                        </button>
                    </div>
                <?php endif?>
                <?php if(isset($failed_msg)):?>
                    <div class="failed_msg">
                        <p><?php echo $failed_msg?></p>
                        <button type="button" <?php echo "onclick=\"closeMessagePanel("."'".DASHBOARD_ABORT_PANEL."'".")\""?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                            </svg>
                        </button>
                    </div>
                <?php endif?>

                <div class="dashboard_wrapper">
                    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'sidebar.php'; ?>

                    <div class="dashboard_content">
                        <h2>Manage Users</h2>
                        <div class="data_list_content">
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
                                                <a href="#" class="delete">
                                                    <div>Delete</div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach?>
                                    
                                </div>
                            </div>
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
                                                <a href="#" class="delete">
                                                    <div>Delete</div>
                                                </a>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Footer  -->
            <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
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
        </div>

        
    </body>
</html>