<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/dashboard_op_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/dashboard_post_utils.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $update_post_script = DOMAIN_NAME."scripts/update/update_post.php?id=";

    $error_msg = NULL;
    if(isset($_SESSION['update_post_error'])) {
        $error_msg = $_SESSION['update_post_error'];
        unset($_SESSION['update_post_error']);
    }

    $post_info = NULL;
    $categories = [];
    $featured_post_id = -1;
    $abort_redirect = DOMAIN_NAME.'pages/views/dashboard/manage_posts.php';

    if(!isset($_GET['id'])) {
        $abort_dashboard_op($abort_redirect);
    }

    #$rollback is in credentials.php
    #Get previous form value from previous session
    if(isset($rollback)) {
        $post_info = $rollback;
        unset($rollback);
    }

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    /*
        This query, at the time of this writing, returns 4 rows for the
        category table, 1 row from posts table and 1 row from featured_post table.
        The expected result is a jagged table. However, mysql doesn't allow
        that. Instead. some columns will become redundant in order to create
        a uniform table where all rows per column are equal in terms of length.
        This may be a good technique to improve performance on a small dataset. If
        the resultset is big, better create two queries in my opinion. In this case,
        better create a separate query to get all categories and combine the result
        of posts and featured_post since they both have a result of 1 row. I'll
        keep this query here for reference.
    */
    $fetch_data = 
    "SELECT cat.title as category_title, cat.id as category_id, ".
    "p.title as post_title, p.content,p.category_id as post_category_id, ".
    "fp.post_id as featured_post_id FROM (SELECT title,id FROM categories) as cat, ".
    "(SELECT title,content,category_id FROM posts WHERE id=$post_id) as p, ".
    "(SELECT post_id from featured_post WHERE id=1) as fp ORDER BY cat.title ASC";
    $result = $connection->query($fetch_data);

    if ($result->num_rows === 0) {
        $abort_dashboard_op($abort_redirect, $connection, "No record Found. Operation Aborted.");
    }

    while($row = $result->fetch_assoc()) {
        $categories[] = $row['category_title'];
        if(!isset($post_info)) {
            $post_info['title'] = $row['post_title'];
            $post_info['description'] = $row['content'];
        } 
        // This won't trigger if $row['post_category_id'] is null which can happen
        // if a post is uncategorized.
        if(!isset($post_info['category']) && $row['post_category_id'] === $row['category_id']) {
            $post_info['category'] = $row['category_title'];
        }
        if($featured_post_id === -1) $featured_post_id = $row['featured_post_id'];

    }

    //Sometimes, $post_info['category'] is unset because $row['post_category_id']
    //can be null if a post is 'uncategorized'.
    $cat_key_exists = array_key_exists('category',$post_info);

    $index = 0;
    # [0] = index, [1] = name-length
    # [2] = name
    $ln = [-1, 0, ''];
    foreach($categories as $item) {

        $str_len = strlen($item);
        if($ln[1] < $str_len) {
            $ln[0] = $index;
            $ln[1] = $str_len;
            $ln[2] = $item;
        }
        $index++;
    }
    //Add extra right space so that the red arrow in
    //select won't overlap the <select> content.
    $categories[$ln[0]] .= '&nbsp;&nbsp;&nbsp;&nbsp;';

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
                <h2>Update Post</h2>
                <form class="form_inputs" action="<?php echo $update_post_script.$post_id?>" 
                    method="post" enctype="multipart/form-data"
                >
                    <input 
                        type="text" name="title" placeholder="Title..."
                        value="<?php echo $post_info['title'] ?? '' ?>"
                    />
                    <textarea rows=8 name="description" placeholder="Description..."
                    ><?php echo $post_info['description'] ?? ''?></textarea>

                    <div class="post_category">
                        <p>Select Category</p>
                        <select name="category">
                            <?php foreach($categories as $category):?>
                                <option 
                                    value="<?php echo $category?>"
                                    <?php if($cat_key_exists):?>
                                        <?php echo $category === $post_info['category'] ? 'selected' : ''?>
                                    <?php endif?>
                                >
                                    <?php echo $category?>
                                </option>
                            <?php endforeach?>
                        </select>
                    </div>

                    <div class="file_upload">
                        <label for="thumb">Update Thumbnail</label>
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
                                <input type="checkbox" id="featured_cbox" 
                                    name="featured_cbox" 
                                    <?php echo $featured_post_id === $post_id ? 'checked' : ''?>
                                />
                            </div>
                            <label for="featured_cbox">Featured</label>
                        </div>
                    <?php endif?>

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
                    <button type="submit" name="submit">Update Post</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>