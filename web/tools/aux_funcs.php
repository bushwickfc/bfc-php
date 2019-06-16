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

function send_query($con, $q) {
    $q->execute();
    $res = $q->get_result();
    if ($res === false) {
        $user_error = 'Wrong SQL: ' . $sql . 'Error: ' . $con->errno . ' ' .
            $con->error;
        trigger_error($user_error, E_USER_ERROR);
    }
    return($res);
}

function connect_owners(
    $owners_hostname,
    $owners_username,
    $owners_password,
    $owners_database
) {
    $con = pg_connect(
        "host={$owners_hostname} user={$owners_username} password={$owners_password} dbname={$owners_database} sslmode=require"
    );
    if (pg_last_error($con)) {
        trigger_error("Connection Failed: " . pg_last_error($con),
            E_USER_ERROR);
    }
    return($con);
}

function send_owners_query($con, $query, $params_array) {
    $res = pg_query_params($con, $query, $params_array);
    if ($res === false) {
        trigger_error("Query failed: " . pg_last_error($con),
            E_USER_ERROR);
    }
    return($res);
}

function snake_to_human($string) {
    return(str_replace("_", " ", $string));
}
?>
