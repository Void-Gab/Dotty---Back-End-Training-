<?php

// Initializing a session:

session_start();
$_SESSION['username'] = 'Anna';
echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Not Available';

echo "\n";

$_SESSION = [];
$ses_params = session_get_cookie_params();

$options = array(
    'expires' => time() + 60, //lifetime in php7
    'path'     => $ses_params['path'],
    'domain'   => $ses_params['domain'],
    'secure'   => $ses_params['secure'],
    'httponly' => $ses_params['httponly'],
    'samesite' => $ses_params['samesite']);

    foreach ($options as $option => $value) {
        setcookie(session_name(), '', [
            $option => $value
        ]);
    }

session_destroy();
echo "</br>". "After Session Destroy" . "</br>";
echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Not Available';
