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

        <section class="form_section">
            <div class="form_container">
                <h2>Update Category</h2>
                <form class="form_inputs" action="">
                    <input type="text" placeholder="Title..."/>
                    <textarea rows=4 placeholder="Description..."></textarea>
                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Update Category</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>