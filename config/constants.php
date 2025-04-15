<?php 
    /* Only include/require this file once in an PHP/HTML or you will see the
       'variable already defined' error.
    */
    session_start();

    define('DOMAIN_NAME', 'http://localhost/projects/blog-app/');
    define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/projects/blog-app/');

    enum PageAccess:string {
        case Public = 'public';
        case LoginRequired = 'login_required';
    }

    enum UserRoles:string {
        case Admin = 'admin';
        case Author = 'author';
    }

?>