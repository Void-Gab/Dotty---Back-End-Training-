<?php
session_start();

$_SESSION = [];
$ses_params = session_get_cookie_params();

$options = array(
    'lifetime' => time()-60,
    'path'     => $ses_params['path'],
    'domain'   => $ses_params['domain'],
    'secure'   => $ses_params['secure'],
    'httponly' => $ses_params['httponly'],
    'samesite' => $ses_params['samesite']);

setcookie(session_name(), '', $options);

session_destroy();

header("Location: login.php");