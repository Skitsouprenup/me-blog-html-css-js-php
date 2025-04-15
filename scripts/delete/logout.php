<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";

    session_destroy();
    header('location:'.DOMAIN_NAME);
?>