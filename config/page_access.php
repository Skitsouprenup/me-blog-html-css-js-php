<?php

    enum PageAccess:string {
        case Public = 'public';
        case LoginRequired = 'login_required';
        case AdminLoginRequired = 'admin_login_required';
    }

    class PageAccessList {
        private $ds = DIRECTORY_SEPARATOR;

        function get_page_access(string $page_path) {
            $page_access = NULL;
            // Can't use str_replace with variable declaration
            // in the top-level scope of class. That's why this
            // array is here. This is the error that will appear if you
            // use str_replace in top-level scope: 
            // Fatal error: Constant expression contains invalid operations
            $page_access_list = [
                'public' => [
                    str_replace('/',$this->ds,"/pages/forms/signin.php"),
                    str_replace('/',$this->ds,"/pages/forms/signup.php"),
                    str_replace('/',$this->ds,"/pages/views/category_list.php"),
                    str_replace('/',$this->ds,"/pages/views/single_post.php"),
                    $this->ds."/index.php",
                    $this->ds
                ],
                'login_required' => [
                    str_replace('/',$this->ds,"/pages/views/dashboard/manage_posts.php"),
                    str_replace('/',$this->ds,"/pages/blog_forms/create/create_post.php"),
                    str_replace('/',$this->ds,"/pages/blog_forms/create/update_post.php")
                ],
                'admin_login_required' => [
                    str_replace('/',$this->ds,"/pages/views/dashboard/manage_category.php"),
                    str_replace('/',$this->ds,"/pages/views/dashboard/manage_users.php"),
                    str_replace('/',$this->ds,"/pages/blog_forms/create/create_category.php"),
                    str_replace('/',$this->ds,"/pages/blog_forms/update/update_category.php"),
                    str_replace('/',$this->ds,"/pages/blog_forms/update/update_user.php")
                ]
            ];

            foreach($page_access_list as $list_key => $page_list) {
                foreach($page_list as $page) {
                    if($page_path === $page) {
                        $page_access = $list_key;
                        break;
                    }
                }
    
                if(isset($page_access)) break;
            }

            return $page_access;
        }
    }

    //Note: $full_path must be __FILE__
    //$_SERVER['SCRIPT_FILENAME'] has inconsistent separator.
    //On windows 10, the separator in $_SERVER['SCRIPT_FILENAME']
    //is forward slash(/). It should be backslash(\)
    function pageAccessControl(string $full_path) {
        $obj = new PageAccessList();
        $page_path = explode(ROOT_DIR, $full_path)[1];
        $page_access = $obj->get_page_access($page_path);

        $abort = function() {
            header('location:'.DOMAIN_NAME);
            exit();
        };

        if(isset($page_access)) {
            if($page_access === PageAccess::Public->value) {
                return;
            }

            if($page_access === PageAccess::LoginRequired->value) {
                $login = False;
                if(isset($_SESSION['user_session'])) {
                    $login = True;
                }

                if($login) {
                    return;
                }
                if(!$login) {
                    $abort();
                }
            }

            if($page_access === PageAccess::AdminLoginRequired->value) {
                $admin_login = False;
                $session = $_SESSION['user_session'];
                if(isset($session) && UserRoles::Admin === UserRoles::from($session['role'])) {
                    $admin_login = True;
                }

                if($admin_login) {
                    return;
                }
                if(!$admin_login) {
                    $abort();
                }
            }

        }
        else {
            var_dump("abort");
            $abort();
        }
    }
?>