<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $select_sidebar_item_query = '.dashboard_side_bar > a > #manage_posts_sidebar_item';

    $failed_msg = NULL;
    $success_msg = NULL;
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

                <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'message_panels.php'; ?>

                <div class="dashboard_wrapper">
                    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'sidebar.php'; ?>

                    <div class="dashboard_content">
                        <h2>Manage Posts</h2>
                        <div class="data_list_content">
                            <div class="data_view_small_screen">
                                <div class="data_container">
                                    <div class="data">
                                        <h3>Title</h3>
                                        <p>Title II</p>
                                    </div>
                                    <div class="data">
                                        <h3>Category</h3>
                                        <p>Category II</p>
                                    </div>
                                    <div class="actions">
                                        <h3>Actions</h3>
                                        <div class="dashboard_actions_mobile">
                                            <a href="#" class="edit">
                                                <div>Edit</div>
                                            </a>
                                            <a href="#" class="delete">
                                                <div>Delete</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="data_view_large_screen">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                    <td>Title II</td>
                                    <td>Category II</td>
                                    <td>
                                        <div class="dashboard_actions">
                                            <a href="#" class="edit">
                                                <div>Edit</div>
                                            </a>
                                            <button type="button" class="delete">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                    
                                </tr>
                                
                            </table>
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