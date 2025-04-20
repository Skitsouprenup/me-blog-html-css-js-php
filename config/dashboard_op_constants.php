<?php
$abort_dashboard_op = function(string $location, bool $close_db = false, string $msg = NULL) {
    $message = isset($msg) ? $msg : "Operation Aborted. Unexpected Error.";

    $_SESSION['dashboard_abort_msg'] = $message;
    header('location:'.$location);

    if($close_db) $connection->close();

    exit();
};
?>