<?php

    $user_session = NULL;
    if(isset($_SESSION['user_session'])) {
        $status = $_SESSION['user_session'];

        if($status === 'login') {
            $user_session = $_SESSION['user_session'];
        }

        if($status === 'logout') {
            unset($_SESSION['user_session']);
        }
    }
?>