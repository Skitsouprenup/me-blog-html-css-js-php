<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";

    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/api_access.php";
    apiAccessControl(__FILE__);

    function rollback() {
        header('location: '.DOMAIN_NAME.'pages/forms/signin.php');
        //Remove password
        $_POST['password'] = '';

        unset($_POST['submit']);
        $_SESSION['post_data'] = $_POST;
    }

    //If 'submit' is set, it means that it has been clicked
    if(isset($_POST['submit'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        $credentials = [];

        /* Validation */
        foreach($_POST as $key => $value) {
            if($key === 'submit') continue;
            filterCredentials($credentials, $key, $value);
        }
        /* -- */

        $verified = true;
        foreach($credentials as $key => $value) {
            if($value[1]) {
                $_SESSION['signin_error'] = $value[2];
                $verified = false;
                break;
            }
        }

        if($verified) {
            $fetch_user = 
                "SELECT id,password,avatar,role from users ".
                "WHERE username='".$credentials['username'][0]."' ".
                "OR email='".$credentials['username'][0]."'";
            $result = $connection->query($fetch_user);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if(password_verify($credentials['password'][0], $row['password'])) {
                    //Create Session for user
                    $_SESSION['user_session'] = [
                        'id' => $row['id'],
                        'avatar' => $row['avatar'],
                        'role' => $row['role']
                    ];
                    //Head to landing page
                    header("location:".DOMAIN_NAME);
                } 
                else {
                    $_SESSION['signin_error'] = 'Incorrect Password. Please Try Again.';
                    rollback();
                } 
            }
            else {
                $_SESSION['signin_error'] = 'Can\'t find user. Check your username or email.';
                rollback();
            }
        } else rollback();

        //Close Database Connection
        $connection->close();

    } else header("location:".DOMAIN_NAME.'pages/forms/signin.php');
?>