<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/read/get_posts.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $uncategorized_desc = "Posts that don't have a proper category";

    $posts = NULL;
    $category = [];
    $title = '';
    if(isset($_GET['search'])) {
        $title = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $posts = get_posts_by_title($connection, $title);
    }
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php' ?>

        <!-- 
            Classes used here are classes for categories because
            the page layour for search is very similar to categories page.
        -->
        <div class="category__content_container">
            <div class="category_header">
                <p><?php echo 'Search For \''.trim_text($title,20, 15).'\'' ?></p>
                <p class="category_desc"><?php echo count($posts)." items found."?></p>
            </div>

            <?php if(isset($posts)):?>
                <section class="category_list__container">
                <!-- Blog List -->
                    <div class="blog_list">
                    <?php foreach($posts as $list):?>
                        <div class="blog-item">
                            <div class="blog_list__image">
                                <img src="<?php echo $list['thumbnail']?>" />
                            </div>

                            <div class="blog__info">
                                <div class="blog__info_content">
                                    <div class="blog__header">
                                        <a 
                                            href=<?php echo DOMAIN_NAME."pages/views/single_post.php?id={$list['id']}"?>
                                            class="blog__title"
                                        >
                                            <?php echo $list['post_title']?>
                                        </a>
                                        <div class="blog__categories">
                                            <div class="blog__categories_item_no_hover">
                                                <p><?php echo $list['cat_title'] ?? 'Uncategorized'?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p><?php echo trim_text($list['content'], 500, 450)?></p>
                                </div>

                                <div class="blog__info_meta">
                                    <img src="<?php echo $list['avatar']?>" />
                                    <div class="blog__info_author_date">
                                        <p>By <?php echo $list['firstname'].' '.$list['lastname']?></p>
                                        <p><?php echo date("M d, Y - H:i", strtotime($list['time_created']))?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach?>
                    </div>
                </section>
            <?php else:?>
                <div class="no_posts_high_vh no_posts_category_list">
                    <p>No Posts Found</p>
                </div>
            <?php endif?>
        </div>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>