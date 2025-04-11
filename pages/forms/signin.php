<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages/partials/head.php' ?>

    <body class="form-body">
        <section class="form_section">
            <div class="form_container">
                <h2>Sign In</h2>
                <form class="form_inputs" action="">
                    <input type="text" placeholder="Username"/>
                    <input type="password" placeholder="Password"/>

                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Sign In</button>

                    <div class="no_account">
                        <p class="no_account_text">No account yet? </p>
                        <a href="signup.php" class="register">Register.</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>