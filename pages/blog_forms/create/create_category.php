<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages/partials/head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages/partials/nav.php'; ?>

        <section class="form_section">
            <div class="form_container">
                <h2>Create Category</h2>
                <form class="form_inputs" action="">
                    <input type="text" placeholder="Title..."/>
                    <textarea rows=4 placeholder="Description..."></textarea>
                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Create Category</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages/partials/footer.php'; ?>
    </body>
</html>