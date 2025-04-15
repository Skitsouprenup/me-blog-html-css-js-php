<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/scripts/utils/credentials.php";

    function rollback() {
        header('location: '.DOMAIN_NAME.'pages/forms/signup.php');

        //Remove password
        $_POST['password'] = '';
        $_POST['confirm_pass'] = '';

        unset($_POST['submit']);
        $_SESSION['post_data'] = $_POST;
    }

    //If 'submit' is set, it means that it has been clicked
    if(isset($_POST['submit'])) {
        require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/db_constants.php";

        //echo var_dump($_POST['submit']);
        $avatar = $_FILES['avatar'];
        $credentials = [];

        /* Validation criteria */

        foreach($_POST as $key => $value) {
            if($key === 'submit') continue;
            filterCredentials($credentials, $key, $value);
        }

        /* Extra Validation Criteria */
        $credentials['checkpassln'] = [
            '',
            strlen($credentials['password'][0]) < 4,
            "Password length must be greater than 4."
        ];
        $credentials['comparepasstoconfirm'] = [
            '',
            $credentials['password'][0] !== $credentials['confirm_pass'][0],
            "Can't confirm password. Re-type your password again."
        ];
        $credentials['avatar'] = [
            $avatar,
            !$avatar['name'],
            "Avatar is required. Please upload your avatar."
        ];

        /* ---- */

        $verified = true;
        foreach($credentials as $key => $value) {
            if($value[1]) {
                $_SESSION['signup_error'] = $value[2];
                $verified = false;
                break;
            }
        }

        //Upload Image if verified.
        if($verified) {
            $username = $credentials['username'][0];
            $email = $credentials['email'][0];
            
            $get_users = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $query_result = $connection->query($get_users);
            if($query_result->num_rows > 0) {
                $_SESSION['signup_error'] = "Username or e-mail already exists!";
            }
            else {

                //current time in seconds.
                $time = time();
                $avatar_name = $time.'_'.$avatar['name'];
                //Temporary file name. If file is not moved to a directory after the request,
                //The temporary image file will be discarded.
                $avatar_tmp_name = $avatar['tmp_name'];

                $avatar_dest = ROOT_PATH.'images/avatar/'.$avatar_name;
                global $avatar_dest_client;
                $avatar_dest_client = DOMAIN_NAME.'images/avatar/'.$avatar_name;

                //Check if file is an image
                $allowed_ext = ['png', 'jpg', 'jpeg'];
                $ext = explode('.', $avatar_name);
                $ext = end($ext);

                if(in_array($ext, $allowed_ext)) {
                    //file size less than 1mb
                    if($avatar['size'] < 1000000) {
                        // Move temp image file to a directory to make it
                        // permanent.
                        move_uploaded_file($avatar_tmp_name, $avatar_dest);
                    } else $_SESSION['signup_error'] = 'File Size Too Big! Max file size is 1mb.';
                } else $_SESSION['signup_error'] = 'Image file extension must be a .png, .jpg or .jpeg.';

            }
        }
        //If something is wrong
        if(isset($_SESSION['signup_error'])) {
            rollback();
        }
        //Save user data to database if there's no prior error.
        else {

            $hashed = password_hash($credentials['password'][0], PASSWORD_DEFAULT);

            $insert_statement = $connection->prepare(
                "INSERT INTO users(firstname, lastname, username, email, password, avatar)".
                " VALUES (?, ?, ?, ?, ?, ?)"
            );

            // The first parameter describes the data type of each column. 's' character means
            // string and all columns in the prepared statement are string that's why
            // there are six 's' in the first parameter. Remember, order matters. If for example,
            // username is int, then replace the third 's' with 'i' 
            // and the first parameter is now: "ssisss"
            $insert_statement->bind_param(
                "ssssss", 
                $credentials['firstname'][0], $credentials['lastname'][0],
                $credentials['username'][0], $credentials['email'][0],
                $hashed, $avatar_dest_client
            );
            $insert_statement->execute();
            $insert_statement->close();

            if(!$connection->errno) {
                
                unset($_SESSION['signup_error']);
                unset($_SESSION['post_data']);

                $fetch_user = 
                "SELECT avatar,id,role from users ".
                "WHERE username='".$credentials['username'][0]."'";
                $result = $connection->query($fetch_user);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

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
                    $_SESSION['signin_error'] = 'Can\'t find user. Please Try Again.';
                    header("location:".DOMAIN_NAME.'pages/forms/signin.php');
                }

            }
            else {
                rollback();
                $_SESSION['signup_error'] = "There's a problem with the server.".
                " Can't sign up. Contact Admin if possible.";
            }
        }
        //Unset global variable
        unset($GLOBALS['avatar_dest_client']);
        //Close Database Connection
        $connection->close();
    } else header("location:".DOMAIN_NAME.'pages/forms/signup.php');

?>