<?php
    $failed_msg = NULL;
    $success_msg = NULL;

    if(isset($_SESSION['dashboard_success_msg'])) {
        $success_msg = $_SESSION['dashboard_success_msg'];
        unset($_SESSION['dashboard_success_msg']);
    }

    if(isset($_SESSION['dashboard_abort_msg'])) {
        $failed_msg = $_SESSION['dashboard_abort_msg'];
        unset($_SESSION['dashboard_abort_msg']);
    }
?>