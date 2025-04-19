<?php

    enum ApiAccess:string {
        case Public = 'public';
        case LoginRequired = 'login_required';
        case AdminLoginRequired = 'admin_login_required';
    }

    class ApiAccessList {
        private $ds = DIRECTORY_SEPARATOR;

        function get_api_access(string $api_path) {
            $api_access = NULL;

            $api_access_list = [
                'public' => [
                    str_replace('/',$this->ds,"/scripts/create/signin.php"),
                    str_replace('/',$this->ds,"/scripts/create/signup.php"),
                    str_replace('/',$this->ds,"/scripts/delete/logout.php")
                ],
                'login_required' => [],
                'admin_login_required' => [
                    str_replace('/',$this->ds,"/scripts/delete/delete_user.php"),
                    str_replace('/',$this->ds,"/scripts/update/update_user.php")
                ]
            ];

            foreach($api_access_list as $list_key => $api_list) {
                foreach($api_list as $api) {
                    if($api_path === $api) {
                        $api_access = $list_key;
                        break;
                    }
                }
    
                if(isset($api_access)) break;
            }

            return $api_access;
        }
    }

    // Note: $full_path must be the value of __FILE__
    //$_SERVER['SCRIPT_FILENAME'] has inconsistent separator.
    //On windows 10, the separator in $_SERVER['SCRIPT_FILENAME']
    //is forward slash(/). It should be backslash(\)
    function apiAccessControl(string $full_path) {
        $obj = new ApiAccessList();
        $api_path = explode(ROOT_DIR, $full_path)[1];
        $api_access = $obj->get_api_access($api_path);

        $abort = function() {
            header('location:'.DOMAIN_NAME);
            exit();
        };

        if(isset($api_access)) {
            if($api_access === ApiAccess::Public->value) {
                return;
            }

            if($api_access === ApiAccess::LoginRequired->value) {
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

            if($api_access === ApiAccess::AdminLoginRequired->value) {
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
            $abort();
        }
    }
?>