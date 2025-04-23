<?php
$abort_dashboard_op = function(string $location, $connection = NULL, string $msg = NULL) {
    $message = isset($msg) ? $msg : "Operation Aborted. Unexpected Error.";

    $_SESSION['dashboard_abort_msg'] = $message;
    header('location:'.$location);

    if(isset($connection)) $connection->close();

    exit();
};

?>