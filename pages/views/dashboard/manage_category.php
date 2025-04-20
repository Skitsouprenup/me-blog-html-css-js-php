<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $select_sidebar_item_query = '.dashboard_side_bar > a > #manage_categories_sidebar_item';
    $dialog_box_delete_btn = '.dashboard_dialog_box > .interface > .delete_category';

    $update_category_page = DOMAIN_NAME.'pages/forms/dashboard/update/update_category.php';
    $delete_category_script = DOMAIN_NAME."scripts/delete/delete_category.php?title=";

    $fetch_categories = "SELECT title from categories ORDER BY title ASC";
    $result = $connection->query($fetch_categories);

    $categories = [];
    while($categories[] = $result->fetch_assoc());

    if(count($categories) > 0) {
        /* 
            Check if the last element is null because fetch_assoc() always
            put null at the end of array.
        */
        $end = end($categories);
        if(!isset($end)) array_pop($categories);
    }
    $connection->close();

    $operation = 'category';
    $dialog_box_title = 'Delete Category';
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
                        <h2>Manage Categories</h2>
                        <div class="data_list_content">
                            <div class="data_view_small_screen">
                                <?php foreach($categories as $list):?>
                                    <div class="data_container">
                                        <div class="data">
                                            <h3>Name</h3>
                                            <p><?php echo $list['title']?></p>
                                        </div>
                                        <div class="actions">
                                            <h3>Actions</h3>
                                            <div class="dashboard_actions_mobile">
                                                <a 
                                                    href=<?php echo $update_category_page.'?title='.$list['title']?> 
                                                    class="edit"
                                                >
                                                    <div>Edit</div>
                                                </a>
                                                <button type="button" class="delete"
                                                    <?php 
                                                        echo "onclick=\"showDeleteDialogBox(".
                                                        "'".$list['title']."',".
                                                        "'".$delete_category_script.$list['title']."',".
                                                        "'".$dialog_box_delete_btn."')\""
                                                    ?>
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach?>  
                            </div>
                            <table class="data_view_large_screen">
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                <?php foreach($categories as $list):?>
                                    <tr>
                                        <td><?php echo $list['title']?></td>
                                        <td>
                                            <div class="dashboard_actions">
                                                <a 
                                                    href=<?php echo $update_category_page.'?title='.$list['title']?> 
                                                    class="edit"
                                                >
                                                    <div>Edit</div>
                                                </a>
                                                <button type="button" class="delete"
                                                    <?php 
                                                        echo "onclick=\"showDeleteDialogBox(".
                                                        "'".$list['title']."',".
                                                        "'".$delete_category_script.$list['title']."',".
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