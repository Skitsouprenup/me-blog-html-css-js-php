<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);

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
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

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

                    <?php if(isset($error_msg)):?>
                        <div class="failed_msg">
                            <p><?php echo $error_msg?></p>
                            <button type="button" <?php echo "onclick=\"closeMessagePanel("."'".FORM_ERROR_MSG_PANEL."'".")\""?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                                </svg>
                            </button>
                        </div>
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