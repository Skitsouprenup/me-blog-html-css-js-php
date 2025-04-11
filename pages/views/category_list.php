<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages/partials/head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages/partials/nav.php'; ?>

        <div class="content_container">
            <div class="category_title">
                <p>Category Title</p>
            </div>

            <!-- Blog List -->
            <section class="category_list__container">
                <div class="blog_list">

                    <div class="blog-item">
                        <div class="blog_list__image">
                            <img src="../../images/developer-wallpaper1.png" />
                        </div>

                        <div class="blog__info">
                            <div class="blog__info_content">
                                <h3 class="blog__title">Title Here</h3>
                                <div class="blog__categories">
                                    <div class="blog__categories_item">
                                        <p>Technology</p>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce mattis velit nec ipsum convallis imperdiet. Vestibulum eu magna convallis, rhoncus justo sed, posuere nisi. Ut dignissim libero vitae lorem rhoncus, ut pulvinar turpis consectetur. Sed nec urna eu augue consectetur lacinia eget vel neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla egestas dignissim lorem, laoreet dapibus nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse nec vestibulum eros. Phasellus feugiat leo quis bibendum efficitur. Ut iaculis et sem vel posuere. Quisque eros sem, varius a vulputate non, laoreet at arcu. Duis non volutpat enim, quis consectetur tellus. 
                                </p>
                            </div>

                        <div class="blog__info_meta">
                            <img src="../../images/avatar/52685143.jpg" />
                            <div class="blog__info_author_date">
                                <p>By Test</p>
                                <p>January 01, 1970 - 00:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages/partials/footer.php'; ?>
    </body>
</html>