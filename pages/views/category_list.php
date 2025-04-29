<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

    $uncategorized_desc = "Posts that don't have a proper category";

    $posts = [];
    $category = [];
    if(isset($_GET['id'])) {
        $id = (int)filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $get_cat_query = "SELECT title,description from categories WHERE id=$id";
        $result = $connection->query($get_cat_query);

        if($result->num_rows > 0) {
            $category = $result->fetch_assoc();
        }

        $get_posts_query = 
        "SELECT p.id as post_id,p.title,p.content,p.thumbnail,p.time_created,".
        "usr.firstname,usr.lastname,usr.avatar FROM posts as p ".
        "INNER JOIN users as usr ON p.author_id=usr.id ".
        "WHERE ".($id < 1 ? 'p.category_id IS NULL' : "p.category_id=$id");

        $result = $connection->query($get_posts_query);

        if($result->num_rows > 0) {
            //This while loop removes the NULL value
            //that is placed by fetch_assoc() as the last
            //item.
            while($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <div class="category__content_container">
            <div class="category_header">
                <p><?php echo $category['title'] ?? 'Uncategorized'?></p>
                <p class="category_desc"><?php echo $category['description'] ?? $uncategorized_desc?></p>
            </div>

            <?php if(count($posts) > 0):?>
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
                                            href=<?php echo DOMAIN_NAME."pages/views/single_post.php?id={$list['post_id']}"?>
                                            class="blog__title"
                                        >
                                            <?php echo $list['title']?>
                                        </a>
                                        <div class="blog__categories">
                                            <div class="blog__categories_item_no_hover">
                                                <p><?php echo $category['title'] ?? 'Uncategorized'?></p>
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