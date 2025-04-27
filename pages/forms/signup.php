<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
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
                        <label for="thumb">Add Avatar</label>
                        <div class="file_input">
                            <input class="file_upload_box" type="file" name="avatar" id="avatar" />
                            <button type="button" onclick="removeFileUpload()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
                                </svg>
                            </button>
                        </div>
                    </div>
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