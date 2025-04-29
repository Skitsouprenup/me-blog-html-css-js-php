<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/read/get_posts.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/pagination_utils.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $current_page = 1;
    if(isset($_GET['cp'])) {
        $val = filter_var($_GET['cp'], FILTER_SANITIZE_NUMBER_INT);
        $current_page = $val;
    }
    $page_offset = $item_per_page*($current_page-1);

    $featured_post = get_featured_post($connection);
    $posts = get_posts($connection, $featured_post, $item_per_page, $page_offset);

    $fetch_categories = "SELECT id,title FROM categories ORDER BY title ASC";
    $result = $connection->query($fetch_categories);
    $categories = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) 
            $categories[] = $row;
    }

    $fp_id = isset($featured_post) ? $featured_post['id'] : NULL;
    $page_item_count = get_posts_count($connection, $fp_id);
    $page_count = (int)($page_item_count/$item_per_page);

    resolve_page_count($page_count, $page_item_count);

    $connection->close();
?>

<!DOCTYPE html>
<html>
    
    <head>
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head_content_only.php' ?>
    </head>

    <body>

        <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <div class="content_container">

            <?php include '.'.$ds.'pages'.$ds.'partials'.$ds.'search.php'; ?>

         <!-- Featured Blog -->
            <section class="featured_blog__container">
                <h1>Featured Blog</h1>
                <?php if(isset($featured_post)):?>
                    <article class="featured_blog">
                        <div class="blog__image">
                            <img src="<?php echo $featured_post['thumbnail']?>" />
                        </div>

                        <div class="blog__info">
                            <div class="blog__info_content">
                                <div class="blog__header">
                                    <a 
                                        href=<?php echo DOMAIN_NAME."pages/views/single_post.php?id={$featured_post['id']}"?>
                                        class="blog__title"
                                    >
                                        <?php echo $featured_post['title']?>
                                    </a>
                                    <div class="blog__categories">
                                        <a class="blog__categories_item" href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id={$featured_post['category_id']}"?>">
                                            <p><?php echo $featured_post['category'] ?? 'Uncategorized'?></p>
                                        </a>
                                    </div>
                                </div>
                                <p><?php echo trim_text($featured_post['content'], 500, 450)?></p>
                            </div>

                            <div class="blog__info_meta">
                                <img src="<?php echo $featured_post['avatar']?>" />
                                <div class="blog__info_author_date">
                                    <p>by <?php echo $featured_post['name']?></p>
                                    <p><?php echo date("M d, Y - h:i", strtotime($featured_post['time_created']))?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php else:?>
                    <div class="no_posts">
                        <h2>No Featured Blog</h2>
                    </div>
                <?php endif?>
            </section>

         <!-- Blog List -->
            <section class="blog_list__container" id="blogposts">
                <h1>Blogs</h1>
                    <div class="blog_list">

                        <?php if(isset($posts)):?>
                            <?php foreach($posts as $list):?>

                                <div class="blog-item">
                                    <div class="blog_list__image">
                                        <img src=<?php echo $list['thumbnail']?> />
                                    </div>

                                    <div class="blog__info">
                                        <div class="blog__info_content">
                                            <div class="blog__header">
                                                <a 
                                                    class="blog__title"
                                                    href=<?php echo DOMAIN_NAME."pages/views/single_post.php?id={$list['id']}"?>
                                                >
                                                    <?php echo $list['post_title']?>
                                                </a>
                                                <div class="blog__categories">
                                                    <a class="blog__categories_item" href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id={$list['category_id']}"?>">
                                                        <p><?php echo $list['cat_title'] ?? 'Uncategorized'?></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <p><?php echo trim_text($list['content'], 500, 450)?></p>
                                        </div>

                                        <div class="blog__info_meta">
                                            <img src=<?php echo $list['avatar']?> />
                                            <div class="blog__info_author_date">
                                                <p>By <?php echo $list['firstname'].' '.$list['lastname']?></p>
                                                <p><?php echo date("M d, Y - H:i", strtotime($list['time_created']))?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach?>
                        <?php endif?>
                    </div>
                <?php if(!isset($posts)):?>
                    <div class="no_posts">
                        <h2>No Posts Found</h2>
                    </div>
                <?php endif?>
            </section>

            <!-- Pagination -->
            <?php if(isset($posts)):?>
                <?php include '.'.$ds.'pages'.$ds.'partials'.$ds.'pagination.php'; ?>
            <?php endif?>
        </div>

<!-- Category List -->
        <hr class="category_list__hr" />
        <div class="content_container">
            <?php if(count($categories) > 0):?>
            <div class="category_list__container_index">
                <div class="category_list">
                    <?php foreach($categories as $list):?>
                    <a href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id={$list['id']}"?>">
                        <p class="category_list__link">
                            <?php echo $list['title']?>
                        </p>
                    </a>
                    <?php endforeach?>

                    <!-- Uncategorized -->
                    <a href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id=-1"?>">
                        <p class="category_list__link">
                            Uncategorized
                        </p>
                    </a>
                </div>
            </div>
            <?php endif?>
            <?php if(count($categories) == 0):?>
                <div class="no_categories">
                    <p>No Categories</p>
                </div>
            <?php endif?>
        </div>

    <!-- Footer  -->
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
    
    <script src=<?php echo DOMAIN_NAME."js/pagination.js"; ?>></script>
    <script>
        togglePagBtnHighlights(<?php echo $current_page?>, <?php echo $page_count?>)
    </script>
</html>