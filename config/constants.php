<?php 
    /* Only include/require this file once in an PHP/HTML or you will see the
       'variable already defined' error.
    */
    session_start();


    //Use this to make your paths(not URL paths) compatible with multiple OS.
    $ds = DIRECTORY_SEPARATOR;
    define('DOMAIN_NAME', 'http://localhost/projects/blog-app/');
    define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].$ds.'projects'.$ds.'blog-app'.$ds);

    //Root directory where all your files are located.
    define('ROOT_DIR', 'blog-app');

    define('FORM_ERROR_MSG_PANEL', ".form_inputs > .failed_msg");
    define('DASHBOARD_ABORT_PANEL', ".dashboard_container > .failed_msg");
    define('DASHBOARD_SUCCESS_PANEL', ".dashboard_container > .success_msg");

    enum UserRoles:string {
        case Admin = 'admin';
        case Author = 'author';
    }
    
    function trim_text(string $text, int $threshold = 15, $trim_ln = 7) {
        //Abort operation if trim length is greater than max character length
        if($trim_ln > $threshold) return $text;
        //Abort operation if threshold is less than 15 which is the default
        //threshold
        if($threshold < 15) return $text;
        $ln = strlen($text);

       if($ln > $threshold) return substr($text, 0, $trim_ln)."...";

       return $text;
    }

?>