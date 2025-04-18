<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <div class="content_container">

            <div class="post_container">
                <div class="post_title">
                    <p>Title Here</p>
                </div>

                <div class="post_category">
                    <div class="blog__categories">
                        <div class="blog__categories_item">
                            <p>Technology</p>
                        </div>
                    </div>
                </div>

                <div class="post_data">
                    <img src="../../images/avatar/52685143.jpg" />
                    <div>
                        <p>By Test</p>
                        <p>January 01, 1970 - 00:00</p>
                    </div>
                </div>

                <div class="post_blog__image">
                    <img src="../../images/developer-wallpaper1.png" />
                </div>

                <div class="post_content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce mattis velit nec ipsum convallis imperdiet. Vestibulum eu magna convallis, rhoncus justo sed, posuere nisi. Ut dignissim libero vitae lorem rhoncus, ut pulvinar turpis consectetur. Sed nec urna eu augue consectetur lacinia eget vel neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla egestas dignissim lorem, laoreet dapibus nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse nec vestibulum eros. Phasellus feugiat leo quis bibendum efficitur. Ut iaculis et sem vel posuere. Quisque eros sem, varius a vulputate non, laoreet at arcu. Duis non volutpat enim, quis consectetur tellus.</p>
                </div>
            </div>

        </div>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>