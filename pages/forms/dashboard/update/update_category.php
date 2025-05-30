<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $update_category_script = DOMAIN_NAME."scripts/update/update_category.php";

    $error_msg = NULL;
    if(isset($_SESSION['update_category_error'])) {
        $error_msg = $_SESSION['update_category_error'];
        unset($_SESSION['update_category_error']);
    }

    $category_info = NULL;
    $update_page = DOMAIN_NAME.'scripts/update/update_category.php';
    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_category.php';

    #$rollback is in credentials.php
    #Get previous form value from previous session
    if(isset($rollback)) {
        $GLOBALS['category_info'] = $rollback;
        unset($rollback);
    }

    //Get info from database if there's no previous form value
    if(isset($_GET['title']) && !isset($category_info)) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $title = filter_var($_GET['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fetch_users = "SELECT title,description FROM categories WHERE title='$title'";
        $result = $connection->query($fetch_users);

        if ($result->num_rows > 0) {
            $GLOBALS['category_info'] = $result->fetch_assoc();
        } else $abort_dashboard_op($abort_redirect);

        $connection->close();
    }

    if(!isset($_GET['title'])){
        $abort_dashboard_op($abort_redirect);
    }
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <section class="form_section">
            <div class="form_container">
                <h2>Update Category</h2>
                <form 
                    class="form_inputs" action=<?php echo $update_page?>
                    method="post"
                >
                    <input 
                        type="text" name="title" 
                        placeholder="Title..." value="<?php echo $category_info['title'] ?? ''?>"
                    />
                    <textarea 
                        rows=4 name="description" 
                        placeholder="Description..."
                    ><?php echo $category_info['description'] ?? ''?></textarea>
                    <?php if(isset($error_msg)):?>
                        <div class="failed_msg">
                            <p><?php echo $error_msg?></p>
                            <button type="button" <?php echo "onclick=\"closeMessagePanel("."'".FORM_ERROR_MSG_PANEL."'".")\""?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                                </svg>
                            </button>
                        </div>
                    <?php endif?>
                    <input type="hidden" name="prev_title" value=<?php echo $_GET['title'] ?? ''?>/>
                    <button type="submit" name="submit">Update Category</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>