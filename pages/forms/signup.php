<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    pageAccessControl(__FILE__);

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    $home_link = DOMAIN_NAME.'index.php';
    $form_action = DOMAIN_NAME.'scripts/create/signup.php';

    $error_msg = NULL;
    if(isset($_SESSION['signup_error'])) {
        $error_msg = $_SESSION['signup_error'];
        unset($_SESSION['signup_error']);
    }

?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head_content_only.php' ?>

    <body class="form_body signup_body">
        <div class="logo_for_credential_pages">
            <a href=<?php echo $home_link ?> class="nav__logo">Me Blog</a>
        </div>
        <section class="form_section">
            <div class="form_container">
                <h2>Sign Up</h2>
                <form 
                    class="form_inputs" 
                    action=<?php echo $form_action ?>
                    method="post" 
                    enctype="multipart/form-data"
                >
                    <!-- 
                        the values in 'name' attribute will be represented as keys
                        in php in $_POST superglobal  
                    -->
                    <input 
                        type="text" name="firstname" placeholder="First Name..."
                        <?php echo 'value="'.fillInPreviousData('firstname').'"' ?>
                    />
                    <input 
                        type="text" name="lastname" placeholder="Last Name..."
                        <?php echo 'value="'.fillInPreviousData('lastname').'"' ?>
                    />
                    <input 
                        type="text" name="username" placeholder="Username..."
                        <?php echo 'value="'.fillInPreviousData('username').'"' ?>
                    />
                    <input 
                        type="email" name="email" placeholder="E-mail..."
                        <?php echo 'value="'.fillInPreviousData('email').'"' ?>    
                    />
                    <input type="password" name="password" placeholder="Password..."/>
                    <input type="password" name="confirm_pass" placeholder="Confirm Password..."/>
                    <div class="file_upload">
                        <label for="avatar">Add Avatar</label>
                        <input type="file" name="avatar" id="avatar" />
                    </div>
                    <?php if(isset($error_msg)): ?>
                        <div class="form_error_message"><?php echo $error_msg ?></div>
                    <?php endif?>
                    <button type="submit" name="submit">Sign Up</button>

                    <div class="have_account">
                        <p class="have_account_text">Have an Account? </p>
                        <a href="signin.php" class="sign_in">Login.</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>