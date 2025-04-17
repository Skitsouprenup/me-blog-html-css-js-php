<?php 

$rollback = NULL;
if(isset($_SESSION['post_data'])) {
    $rollback = $_SESSION['post_data'];
    unset($_SESSION['post_data']);
}

function filterCredentials(array &$credentials, string $key, string $value) {
    $error_msg = "'$key' field is empty!";
    $condition = empty($value);

    if($key === 'email') {
        $validated = filter_var($value, FILTER_VALIDATE_EMAIL);

        if($condition) 
            $credentials[$key] = [$validated, $condition, $error_msg];

        //If value is not empty and not a valid e-mail address.
        if(!$condition && $validated === false) {
            $credentials[$key] = ['', true, 'Invalid E-mail Address.'];
        } else $credentials[$key] = [$validated, $condition, $error_msg];

        return NULL;
    }

    $credentials[$key] = [
        filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        $condition,
        $error_msg
    ];

    //break reference if not needed anymore.
    unset($credentials);
}

// For page form
function fillInPreviousData(string $key) {
    $value = '';

    global $rollback;

    if($rollback !== NULL && array_key_exists($key, $rollback)) {
        $value = $rollback[$key];
    }
    
    return $value;
}

?>