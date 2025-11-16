<?php 
function write_log($log, $location = 'debug.log') {
    error_log(print_r($log, true)."\n\r", 3, $location);
}

function v_array($needle, $haystack) {
    if(is_array($haystack) && array_key_exists($needle, $haystack)) {
        return $haystack[$needle];
    }

    return false;
}

function set_connection_exception_handler($con, $e) {
    write_log($e->getMessage(), 'debug.log');
    write_log($con, 'debug.log');

    header('Location: 505_error_response_page_1.php');
}

function set_statement_exception_handler($stmt, $e) {
    write_log($e->getMessage(), 'debug.log');
    write_log($stmt->error, 'debug.log');
    write_log($stmt->error, 'debug.log');

    header('Location: 505_error_response_page_2.php');
}

function log_in($username, $password, $pdo = null) {
    if ($pdo == null) {
        require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';
        global $pdo;
    }

    $sql = "SELECT * 
            FROM event_user 
            WHERE event_user_name = :username 
              AND event_user_password = :password 
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['validUser'] = true;
        $_SESSION['username'] = $username;
        return true;
    } else {
        $_SESSION['validUser'] = false;
        return false;
    }
}
?>