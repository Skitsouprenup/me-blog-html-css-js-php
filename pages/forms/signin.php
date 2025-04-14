<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    $home_link = DOMAIN_NAME.'index.php';

    $error_msg = NULL;
    if(isset($_SESSION['signin_error'])) {
        $error_msg = $_SESSION['signin_error'];
        unset($_SESSION['signin_error']);
    }

    $form_action = DOMAIN_NAME.'scripts/create/signin.php';
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages/partials/head.php' ?>

    <body class="form_body signin_body">
        <div class="logo_for_credential_pages">
            <a href=<?php echo $home_link ?> class="nav__logo">Me Blog</a>
        </div>
        <section class="form_section">
            <div class="form_container">
                <h2>Sign In</h2>
                <form 
                    class="form_inputs"
                    action=<?php echo $form_action ?>
                    method="post"    
                >
                    <input 
                        type="text" name="username" placeholder="Username or E-mail"
                        <?php echo 'value="'.fillInPreviousData('username').'"' ?>
                    />
                    <input type="password" name="password" placeholder="Password"/>

                    <?php if(isset($error_msg)): ?>
                        <div class="form_error_message"><?php echo $error_msg ?></div>
                    <?php endif?>
                    <button type="submit" name="submit">Sign In</button>

                    <div class="no_account">
                        <p class="no_account_text">No account yet?</p>
                        <a href="signup.php" class="register">Register.</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>