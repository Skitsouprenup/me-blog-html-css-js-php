<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages/partials/head.php' ?>

    <body class="form-body">
        <section class="form_section">
            <div class="form_container">
                <h2>Sign Up</h2>
                <form class="form_inputs" action="" enctype="multipart/form-data">
                    <input type="text" placeholder="First Name..."/>
                    <input type="text" placeholder="Last Name..."/>
                    <input type="text" placeholder="Username..."/>
                    <input type="email" placeholder="E-mail..."/>
                    <input type="password" placeholder="Password..."/>
                    <input type="password" placeholder="Confirm Password..."/>
                    <div class="file_upload">
                        <label for="avatar">Add Avatar</label>
                        <input type="file" id="avatar" />
                    </div>
                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Sign Up</button>

                    <div class="have_account">
                        <p class="have_account_text">Have an Account? </p>
                        <a href="signin.php" class="sign_in">Login.</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>