<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/read/get_posts.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $post = NULL;
    if(isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $post = get_single_post($connection, $id);
    }

    $connection->close();
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <div class="content_container">

            <?php if(isset($post)):?>
                <div class="post_container">
                    <div class="post_header">
                        <div class="post_title">
                            <p><?php echo $post['post_title']?></p>
                        </div>

                        <div class="post_category">
                            <div class="blog__categories">
                                <a 
                                    class="blog__categories_item" 
                                    href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id={$post['category_id']}"?>"
                                >
                                    <p><?php echo $post['category'] ?? 'Uncategorized'?></p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="post_blog__image">
                        <img src=<?php echo $post['thumbnail']?> />
                    </div>

                    <div class="post_content">
                        <p><?php echo $post['content']?></p>
                    </div>

                    <div class="post_data">
                        <img src="<?php echo $post['avatar']?>" />
                        <div class="blog__info_author_date">
                            <p>by <?php echo $post['name']?></p>
                            <p><?php echo date("M d, Y - H:i", strtotime($post['time_created']))?></p>
                        </div>
                    </div>
                </div>
            <?php else:?>
                <div class="no_posts_high_vh">
                    <p>No Posts Found</p>
                </div>
            <?php endif?>

        </div>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>