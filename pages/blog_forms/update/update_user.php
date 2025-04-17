<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";
    pageAccessControl(__FILE__);

    $abort = function() {
        header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_users.php');
        exit();
    };

    $error_msg = NULL;
    if(isset($_SESSION['update_user_error'])) {
        $error_msg = $_SESSION['update_user_error'];
        unset($_SESSION['update_user_error']);
    }

    $user_info = NULL;
    $update_page = DOMAIN_NAME.'scripts/update/update_user.php';

    #$rollback is in credentials.php
    if(isset($rollback)) {
        $GLOBALS['user_info'] = $rollback;
    }

    if(isset($_GET['username']) && !isset($rollback)) {
        $username = filter_var($_GET['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $fetch_users = "SELECT firstname,lastname,username,role FROM users WHERE username='$username'";
        $result = $connection->query($fetch_users);

        if ($result->num_rows > 0) {
            $GLOBALS['user_info'] = $result->fetch_assoc();
        } else $abort();

        $connection->close();
    } else {
        $abort();
    }
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <section class="form_section">
            <div class="form_container">
                <h2>Update User</h2>
                <form class="form_inputs" action=<?php echo $update_page?> method="post">
                    <label for="firstname">First Name</label>
                    <input 
                        type="text" value=<?php echo $user_info['firstname']?> 
                        name="firstname" placeholder="First Name..."
                    />
                    <label for="lastname">Last Name</label>
                    <input 
                        type="text" value=<?php echo $user_info['lastname']?>  
                        name="lastname" placeholder="Last Name..."
                    />
                    <label for="role">Role</label>
                    <select name="role" value=<?php echo $user_info['role']?>>
                        <option value="admin">Admin</option>
                        <option value="author">Author</option>
                    </select>
                    <?php if(isset($error_msg)): ?>
                        <div class="form_error_message"><?php echo $error_msg ?></div>
                    <?php endif?>
                    <input type="hidden" name="username" value=<?php echo $user_info['username'] ?>/>
                    <button type="submit" name="submit">Update User</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>