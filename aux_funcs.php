<?php
function verify_ajax() {
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if (!$isAjax) {
      $user_error = 'Access denied - not an AJAX request...';
      trigger_error($user_error, E_USER_ERROR);
    }
}

function connect($hostname, $username, $password, $database) {
    $con = mysqli_connect($hostname, $username, $password, $database);
    if (mysqli_connect_errno()) {
        trigger_error("Connection Failed: " . mysqli_connect_errno(),
            E_USER_ERROR);
    }
    $con->set_charset('utf8');
    return($con);
}

function send_query($con, $sql) {
    $res = $con->query($sql);
    if ($res === false) {
        $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . $con->errno . ' ' .
            $con->error;
        trigger_error($user_error, E_USER_ERROR);
    }
    return($res);
} 
?>
