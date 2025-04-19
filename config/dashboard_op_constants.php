<?php
$abort_dashboard_op = function(bool $close_db = false, string $msg = NULL) {
    $message = isset($msg) ? $msg : "Operation Aborted. Unexpected Error.";

    $_SESSION['dashboard_abort_msg'] = $message;
    header('location:'.DOMAIN_NAME.'pages/views/dashboard/manage_users.php');

    if($close_db) $connection->close();

    exit();
};
?>