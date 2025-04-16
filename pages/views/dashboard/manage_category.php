<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    pageAccessControl(__FILE__);

    $select_sidebar_item_query = '.dashboard_side_bar > a > #manage_categories_sidebar_item';
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
                <div class="dashboard_wrapper">
                    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'dashboard'.$ds.'sidebar.php'; ?>

                    <div class="dashboard_content">
                        <h2>Manage Categories</h2>
                        <div class="data_view_small_screen">
                            <div class="data_container">
                                <div class="data">
                                    <h3>Name</h3>
                                    <p>Test</p>
                                </div>
                                <div class="actions">
                                    <h3>Actions</h3>
                                    <button class="edit">Edit</button>
                                    <button class="delete">Delete</button>
                                </div>
                            </div>
                            <div class="data_container">
                                <div class="data">
                                    <h3>Name</h3>
                                    <p>Test</p>
                                </div>
                                <div class="actions">
                                    <h3>Actions</h3>
                                    <button class="edit">Edit</button>
                                    <button class="delete">Delete</button>
                                </div>
                            </div>
                        </div>
                        <table class="data_view_large_screen">
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <td>Test1</td>
                                <td>
                                    <div class="dashboard_actions">
                                        <button class="edit">Edit</button>
                                        <button class="delete">Delete</button>
                                    </div>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>Test1</td>
                                <td>
                                    <div class="dashboard_actions">
                                        <button class="edit">Edit</button>
                                        <button class="delete">Delete</button>
                                    </div>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>Test1</td>
                                <td>
                                    <div class="dashboard_actions">
                                        <button class="edit">Edit</button>
                                        <button class="delete">Delete</button>
                                    </div>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>Test1</td>
                                <td>
                                    <div class="dashboard_actions">
                                        <button class="edit">Edit</button>
                                        <button class="delete">Delete</button>
                                    </div>
                                </td>
                                
                            </tr>
                            
                        </table>
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