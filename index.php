<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/read/get_posts.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    $featured_post = get_featured_post($connection);

    $posts = get_posts($connection, $featured_post);
?>

<!DOCTYPE html>
<html>
    
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

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
                                    <h3 class="blog__title"><?php echo $featured_post['title']?></h3>
                                    <div class="blog__categories">
                                    <a class="blog__categories_item" href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id={$featured_post['category_id']}"?>">
                                        <p><?php echo $featured_post['category']?></p>
                                    </a>
                                    </div>
                                </div>
                                <p><?php echo trim_text($featured_post['content'], 500, 450)?></p>
                            </div>

                            <div class="blog__info_meta">
                                <img src="<?php echo $featured_post['avatar']?>" />
                                <div class="blog__info_author_date">
                                    <p>by <?php echo $featured_post['name']?></p>
                                    <p><?php echo date("M d, Y - H:i", strtotime($featured_post['time_created']))?></p>
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
            <section class="blog_list__container">
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
                                                <h3 class="blog__title"><?php echo $list['post_title']?></h3>
                                                <div class="blog__categories">
                                                    <a class="blog__categories_item" href="<?php echo DOMAIN_NAME."pages/views/category_list.php?id={$list['category_id']}"?>">
                                                        <p><?php echo $list['cat_title']?></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php echo trim_text($featured_post['content'], 500, 450)?>
                                        </div>

                                        <div class="blog__info_meta">
                                            <img src=<?php echo $list['avatar']?> />
                                            <div class="blog__info_author_date">
                                                <p>By <?php echo $list['firstname'].' '.$list['lastname']?></p>
                                                <p><?php echo date("M d, Y - H:i", strtotime($featured_post['time_created']))?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach?>
                        <?php endif?>
                    </div>
                <?php if(!isset($posts)):?>
                    <div class="no_posts">
                        <h2>No Featured Blog</h2>
                    </div>
                <?php endif?>
            </section>
        </div>

<!-- Category List -->
        <hr class="category_list__hr" />
        <div class="content_container">
            <div class="category_list__container">
                <div class="category_list">
                    <a href="#">
                        <p class="category_list__link">
                            Gaming
                        </p>
                    </a>
                    <a href="#">
                        <p class="category_list__link">
                            Technology
                        </p>
                    </a>
                    <a href="#">
                        <p class="category_list__link">
                            Art
                        </p>
                    </a>
                    <a href="#">
                        <p class="category_list__link">
                            Travel
                        </p>
                    </a>
                </div>
            </div>
        </div>

    <!-- Footer  -->
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>

    </body>
</html>