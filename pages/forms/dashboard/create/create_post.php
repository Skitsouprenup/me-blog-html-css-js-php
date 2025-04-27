<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/dashboard_post_utils.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $create_post_script = DOMAIN_NAME."scripts/create/create_post.php";

    $error_msg = NULL;
    if(isset($_SESSION['create_post_error'])) {
        $error_msg = $_SESSION['create_post_error'];
        unset($_SESSION['create_post_error']);
    }

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $fetch_categories = "SELECT title from categories ORDER BY title ASC";
    $result = $connection->query($fetch_categories);

    $categories = [];
    while($categories[] = $result->fetch_assoc());
    get_longest_category_name($categories);

    $connection->close();

?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <section class="form_section">
            <div class="form_container">
                <h2>Create Post</h2>
                <form 
                    class="form_inputs" action=<?php echo $create_post_script?> 
                    method="post" enctype="multipart/form-data"
                >
                    <input 
                        type="text" name="title" placeholder="Title..."
                        <?php echo 'value="'.fillInPreviousData('title').'"' ?>
                    />
                    <textarea rows=8 name="description" 
                        placeholder="Description..."
                    ><?php echo fillInPreviousData('description')?></textarea>

                    <div class="create_post_inputs">
                        <div class="post_category">
                            <p>Select Category</p>
                            <select name="category" 
                                <?php echo 'value="'.fillInPreviousData('category').'"' ?>
                            >
                                <?php foreach($categories as $list):?>
                                    <option value="<?php echo $list['title']?>">
                                        <?php echo $list['title']?>
                                    </option>
                                <?php endforeach?>
                                
                            </select>
                        </div>

                        <div class="file_upload">
                            <label for="thumb">Add Thumbnail</label>
                            <div class="file_input">
                                <input class="file_upload_box" type="file" name="thumb" id="thumb" />
                                <button type="button" onclick="removeFileUpload()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <?php if(UserRoles::Admin === UserRoles::from($_SESSION['user_session']['role'])):?>
                            <div class="featured">
                                <div>
                                    <input type="checkbox" id="featured_cbox" name="featured_cbox"/>
                                </div>
                                <label for="featured_cbox">Featured</label>
                            </div>
                        <?php endif?>
                    </div>

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

                    <button type="submit" name="submit">Create Post</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>