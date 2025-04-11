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
                <h2>Update User</h2>
                <form class="form_inputs" action="" enctype="multipart/form-data">
                    <input type="text" placeholder="First Name..."/>
                    <input type="text" placeholder="Last Name..."/>
                    <div class="file_upload">
                        <label for="avatar">Update Avatar</label>
                        <input type="file" id="avatar" />
                    </div>
                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Update User</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages/partials/footer.php'; ?>
    </body>
</html>