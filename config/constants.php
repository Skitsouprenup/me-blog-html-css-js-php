<?php 
    /* Only include/require this file once in an PHP/HTML or you will see the
       'variable already defined' error.
    */
    session_start();

    //User this to make your paths(not URL paths) compatible with multiple OS.
    $ds = DIRECTORY_SEPARATOR;
    define('DOMAIN_NAME', 'http://localhost/projects/blog-app/');
    define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].$ds.'projects'.$ds.'blog-app'.$ds);

    enum PageAccess:string {
        case Public = 'public';
        case LoginRequired = 'login_required';
        case AdminLoginRequired = 'admin_login_required';
    }

    enum UserRoles:string {
        case Admin = 'admin';
        case Author = 'author';
    }

    $page_access_list = [
        'public' => [
            $ds.'pages'.$ds.'forms'.$ds.'signin.php',
            $ds.'pages'.$ds.'forms'.$ds.'signup.php',
            $ds.'pages'.$ds.'views'.$ds.'category_list.php',
            $ds.'pages'.$ds.'views'.$ds.'single_post.php',
            $ds.'index.php', #Root
            $ds, #Root
        ],
        'login_required' => [
            $ds.'pages'.$ds.'views'.$ds.'dashboard'.$ds.'manage_posts.php',
            $ds.'pages'.$ds.'blog_forms'.$ds.'create'.$ds.'create_post.php',
            $ds.'pages'.$ds.'blog_forms'.$ds.'update'.$ds.'update_post.php',
        ],
        'admin_login_required' => [
            $ds.'pages'.$ds.'views'.$ds.'dashboard'.$ds.'manage_category.php',
            $ds.'pages'.$ds.'views'.$ds.'dashboard'.$ds.'manage_users.php',
            $ds.'pages'.$ds.'blog_forms'.$ds.'create'.$ds.'create_category.php',
            $ds.'pages'.$ds.'blog_forms'.$ds.'update'.$ds.'update_category.php',
            $ds.'pages'.$ds.'blog_forms'.$ds.'update'.$ds.'update_user.php',
        ]
    ];

    function pageAccessControl(string $full_path) {
        $page_access = NULL;
        $page_path = explode('blog-app', $full_path)[1];

        foreach($GLOBALS['page_access_list'] as $list_key => $page_list) {
            foreach($page_list as $page) {
                if($page_path === $page) {
                    $page_access = $list_key;
                    break;
                }
            }

            if(isset($page_access)) break;
        }

        if(isset($page_access)) {
            if($page_access === PageAccess::Public->value) {
                unset($GLOBALS['$page_access_list']);
                return;
            }

            if($page_access === PageAccess::LoginRequired->value) {
                $login = False;
                if(isset($_SESSION['user_session'])) {
                    $login = True;
                }

                if($login) {
                    unset($GLOBALS['$page_access_list']);
                    return;
                }
                if(!$login) {
                    header('location:'.DOMAIN_NAME);
                    exit();
                }
            }

            if($page_access === PageAccess::AdminLoginRequired->value) {
                $admin_login = False;
                $session = $_SESSION['user_session'];
                if(isset($session) && UserRoles::Admin === UserRoles::from($session['role'])) {
                    $admin_login = True;
                }

                if($admin_login) {
                    unset($GLOBALS['$page_access_list']);
                    return;
                }
                if(!$admin_login) {
                    header('location:'.DOMAIN_NAME);
                    exit();
                }
            }

        }
    }
    
?>